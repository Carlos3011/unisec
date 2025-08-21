<?php

namespace App\Http\Controllers\User\Concurso;

use App\Http\Controllers\Controller;
use App\Models\PreRegistroConcurso;
use App\Models\Concurso;
use App\Models\ConvocatoriaConcurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use App\Models\PagoPaypalConcurso;
use App\Models\PagoTerceroTransferenciaConcurso;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PreRegistroUserController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $preRegistros = PreRegistroConcurso::with('concurso')
            ->where('usuario_id', Auth::id())
            ->latest()
            ->paginate(10);

        $convocatoria = ConvocatoriaConcurso::whereHas('concurso', function($query) {
            $query->where('estado', 'activo');
        })->first();
        
        // Los pre-registros ya incluyen el estado_pdr por defecto
        return view('user.concursos.pre-registros.index', compact('preRegistros', 'convocatoria'));
    }

    public function create($convocatoria)
    {
       
        $convocatoria = ConvocatoriaConcurso::findOrFail($convocatoria);
        $concurso = $convocatoria->concurso;
        $concursos = collect([$concurso]);
        
        // Obtener el usuario autenticado para pre-llenar el formulario
        $user = Auth::user();

        return view('user.concursos.pre-registros.create', compact('concursos', 'convocatoria', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'concurso_id' => 'required|exists:concursos,id',
            'nombre_equipo' => 'required|string|max:255',
            'asesor' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'estado_pdr' => 'nullable|string',
            'archivo_pdr' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'codigo_pago_terceros' => 'nullable|string|max:100',
            'integrantes_data' => 'required|array|min:1|max:5',
            'integrantes_data.*.nombre_completo' => 'required|string|max:255',
            'integrantes_data.*.matricula' => 'required|string|max:50',
            'integrantes_data.*.carrera' => 'required|string|max:255',
            'integrantes_data.*.correo_institucional' => 'required|email|max:255',
            'integrantes_data.*.periodo_academico' => 'required|integer|min:1',
            'integrantes_data.*.tipo_periodo' => 'required|in:semestre,cuatrimestre,trimestre'
        ]);

        // Verificar si el usuario ya tiene un pre-registro activo para este concurso
        $existingPreRegistro = PreRegistroConcurso::where('usuario_id', Auth::id())
            ->where('concurso_id', $request->concurso_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingPreRegistro) {
            return redirect()->route('user.concursos.pre-registros.index')
                ->with('error', 'Ya tienes un pre-registro para este concurso.');
        }

        // Validar pago confirmado (PayPal) o pago de terceros validado
        $pagoConfirmado = null;
        $pagoTerceroValidado = null;
        
        // Verificar pago PayPal confirmado
        $pagoConfirmado = PagoPaypalConcurso::where('usuario_id', Auth::id())
            ->where('concurso_id', $request->concurso_id)
            ->where('tipo_pago', PagoPaypalConcurso::TIPO_PRE_REGISTRO)
            ->where('estado_pago', 'pagado')
            ->first();
        
        // Verificar pago de terceros validado si se proporciona código
        if ($request->codigo_pago_terceros) {
            $pagoTerceroValidado = PagoTerceroTransferenciaConcurso::where('codigo_validacion_unico', $request->codigo_pago_terceros)
                ->where('concurso_id', $request->concurso_id)
                ->where('estado_pago', 'validado')
                ->where('cubre_pre_registro', true)
                ->first();
        }

        if (!$pagoConfirmado && !$pagoTerceroValidado) {
            return redirect()->back()
                ->with('error', 'Debe tener un pago confirmado (PayPal) o un código de pago de terceros validado para realizar el pre-registro');
        }

        // Crear el pre-registro
        $preRegistroData = [
            'usuario_id' => Auth::id(),
            'concurso_id' => $request->concurso_id,
            'nombre_equipo' => $request->nombre_equipo,
            'integrantes' => count($request->integrantes_data),
            'asesor' => $request->asesor,
            'institucion' => $request->institucion,
            'comentarios' => $request->comentarios,
            'estado_pdr' => 'pendiente',
            'archivo_pdr' => $this->storeFile($request->file('archivo_pdr')),
            'integrantes_data' => $request->integrantes_data
        ];
        
        // Asignar el tipo de pago correspondiente
        if ($pagoConfirmado) {
            $preRegistroData['pago_paypal_id'] = $pagoConfirmado->id;
        }
        
        if ($pagoTerceroValidado) {
            $preRegistroData['pagos_terceros_transferencia_concurso_id'] = $pagoTerceroValidado->id;
            $preRegistroData['codigo_pago_terceros'] = $request->codigo_pago_terceros;
        }
        
        $preRegistro = PreRegistroConcurso::create($preRegistroData);

        return redirect()->route('user.concursos.pre-registros.index')
            ->with('success', 'Pre-registro creado exitosamente');
    }

    public function show(PreRegistroConcurso $preRegistro)
    {
        $preRegistro->load('concurso');
        
        // El estado_pdr ya está disponible en el modelo PreRegistroConcurso
        return view('user.concursos.pre-registros.show', compact('preRegistro'));
    }


    public function edit(PreRegistroConcurso $preRegistro)
    {
        $preRegistro->load('concurso');
        
        return view('user.concursos.pre-registros.edit', compact('preRegistro'));
    }

    public function factura(PreRegistroConcurso $preRegistro)
    {
        // Verificar si es un pago PayPal o pago de terceros
        if ($preRegistro->pago_paypal_id) {
            // Pago PayPal
            $pago = PagoPaypalConcurso::with(['usuario', 'concurso'])
                ->findOrFail($preRegistro->pago_paypal_id);
            return $this->generarFacturaPayPal($pago);
        } elseif ($preRegistro->pagos_terceros_transferencia_concurso_id) {
            // Pago de terceros
            $pagoTercero = PagoTerceroTransferenciaConcurso::with(['usuario', 'concurso'])
                ->findOrFail($preRegistro->pagos_terceros_transferencia_concurso_id);
            return $this->generarFacturaTerceros($pagoTercero);
        }
        
        return redirect()->back()->with('error', 'No se encontró información de pago para generar la factura.');
    }
    
    private function generarFacturaPayPal($pago)
    {

        $detalles = json_decode($pago->detalles_transaccion, true);

        $datosFactura = [
            'id' => $pago->id,
            'usuario' => $pago->usuario->name,
            'email' => $pago->usuario->email, 
            'concurso' => $pago->concurso->titulo,
            'monto' => $pago->monto,
            'metodo_pago' => $pago->metodo_pago,
            'referencia_paypal' => $pago->referencia_paypal,
            'estado_pago' => $pago->estado_pago,
            'fecha_pago' => $pago->fecha_pago ? Carbon::parse($pago->fecha_pago)->format('Y-m-d H:i:s') : null,
            'paypal_order_id' => $detalles['id'] ?? null,
            'paypal_status' => $detalles['status'] ?? null,
            'paypal_intent' => $detalles['intent'] ?? null,
            'payee' => [
                'email_address' => $detalles['purchase_units'][0]['payee']['email_address'] ?? null,
                'merchant_id' => $detalles['purchase_units'][0]['payee']['merchant_id'] ?? null
            ],
            'description' => $detalles['purchase_units'][0]['description'] ?? null,
            'soft_descriptor' => $detalles['purchase_units'][0]['soft_descriptor'] ?? null,
            'shipping' => [
                'name' => $detalles['purchase_units'][0]['shipping']['name']['full_name'] ?? null,
                'address' => [
                    'address_line_1' => $detalles['purchase_units'][0]['shipping']['address']['address_line_1'] ?? null,
                    'address_line_2' => $detalles['purchase_units'][0]['shipping']['address']['address_line_2'] ?? null,
                    'admin_area_2' => $detalles['purchase_units'][0]['shipping']['address']['admin_area_2'] ?? null,
                    'admin_area_1' => $detalles['purchase_units'][0]['shipping']['address']['admin_area_1'] ?? null,
                    'postal_code' => $detalles['purchase_units'][0]['shipping']['address']['postal_code'] ?? null,
                    'country_code' => $detalles['purchase_units'][0]['shipping']['address']['country_code'] ?? null
                ]
            ],
            'payer' => [
                'name' => [
                    'given_name' => $detalles['payer']['name']['given_name'] ?? null,
                    'surname' => $detalles['payer']['name']['surname'] ?? null
                ],
                'email_address' => $detalles['payer']['email_address'] ?? null,
                'payer_id' => $detalles['payer']['payer_id'] ?? null,
                'country_code' => $detalles['payer']['address']['country_code'] ?? null
            ],
            'payment_capture' => [
                'id' => $detalles['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                'status' => $detalles['purchase_units'][0]['payments']['captures'][0]['status'] ?? null,
                'amount' => [
                    'currency_code' => $detalles['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? null,
                    'value' => $detalles['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? null
                ],
                'create_time' => $detalles['purchase_units'][0]['payments']['captures'][0]['create_time'] ?? null,
                'update_time' => $detalles['purchase_units'][0]['payments']['captures'][0]['update_time'] ?? null
            ],
            'create_time' => $detalles['create_time'] ?? null,
            'update_time' => $detalles['update_time'] ?? null
        ];

        $pdf = PDF::loadView('factura', ['datos' => $datosFactura]);
        return $pdf->download('ticket_'.$pago->id.'.pdf');
    }
    
    private function generarFacturaTerceros($pagoTercero)
    {
        $datosFactura = [
            'id' => $pagoTercero->id,
            'usuario' => $pagoTercero->usuario->name,
            'email' => $pagoTercero->usuario->email,
            'concurso' => $pagoTercero->concurso->titulo,
            'monto' => $pagoTercero->monto_total,
            'metodo_pago' => 'Transferencia Bancaria',
            'referencia_transferencia' => $pagoTercero->referencia_transferencia,
            'estado_pago' => $pagoTercero->estado_pago,
            'fecha_pago' => $pagoTercero->fecha_pago ? Carbon::parse($pagoTercero->fecha_pago)->format('Y-m-d H:i:s') : null,
            'tipo_tercero' => $pagoTercero->tipo_tercero,
            'nombre_tercero' => $pagoTercero->nombre_tercero,
            'rfc_tercero' => $pagoTercero->rfc_tercero,
            'contacto_tercero' => $pagoTercero->contacto_tercero,
            'correo_tercero' => $pagoTercero->correo_tercero,
            'codigo_validacion' => $pagoTercero->codigo_validacion_unico,
            'cubre_pre_registro' => $pagoTercero->cubre_pre_registro,
            'cubre_inscripcion' => $pagoTercero->cubre_inscripcion
        ];

        $pdf = PDF::loadView('factura', ['datos' => $datosFactura]);
        return $pdf->download('ticket_tercero_'.$pagoTercero->id.'.pdf');
    }

    public function update(Request $request, PreRegistroConcurso $preRegistro)
    {
        $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'integrantes' => 'required|integer|min:1|max:5',
            'asesor' => 'nullable|string|max:255',
            'institucion' => 'nullable|string|max:255',
            'comentarios' => 'nullable|string',
            'estado_pdr' => 'nullable|string',
            'archivo_pdr' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'codigo_pago_terceros' => 'nullable|string|max:100',
            'integrantes_data' => 'required|array|min:1',
            'integrantes_data.*.nombre_completo' => 'required|string|max:255',
            'integrantes_data.*.matricula' => 'required|string|max:50',
            'integrantes_data.*.carrera' => 'required|string|max:255',
            'integrantes_data.*.correo_institucional' => 'required|email|max:255',
            'integrantes_data.*.periodo_academico' => 'required|integer|min:1',
            'integrantes_data.*.tipo_periodo' => 'required|in:semestre,cuatrimestre,trimestre'
        ]);

        $updateData = [
            'nombre_equipo' => $request->nombre_equipo,
            'integrantes' => count($request->integrantes_data),
            'asesor' => $request->asesor,
            'institucion' => $request->institucion,
            'integrantes_data' => $request->integrantes_data
        ];

        // Mantener el estado_pdr actual si no se proporciona uno nuevo
        if ($request->has('estado_pdr')) {
            $updateData['estado_pdr'] = $request->estado_pdr;
        }
        
        // Actualizar código de pago de terceros si se proporciona
        if ($request->has('codigo_pago_terceros')) {
            $updateData['codigo_pago_terceros'] = $request->codigo_pago_terceros;
        }

        // Manejar la actualización del archivo PDR
        if ($request->hasFile('archivo_pdr')) {
            // Eliminar el archivo anterior si existe
            if ($preRegistro->archivo_pdr) {
                unlink(public_path($preRegistro->archivo_pdr));
            }
            // Almacenar el nuevo archivo
            $updateData['archivo_pdr'] = $this->storeFile($request->file('archivo_pdr'));
        }

        $preRegistro->update($updateData);

        return redirect()->route('user.concursos.pre-registros.show', $preRegistro)
            ->with('success', 'Pre-registro actualizado exitosamente');
    }

    /**
     * Almacena un archivo en el sistema de archivos.
     *
     * @param \Illuminate\Http\UploadedFile|null $file
     * @return string|null
     */
    private function storeFile($file)
    {
        if (!$file) {
            return null;
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/comprobantes_pago'), $fileName);
        return 'images/comprobantes_pago/' . $fileName;
    }

    /**
     * Descarga el archivo PDR.
     */
    public function downloadPDR(PreRegistroConcurso $preRegistro)
    {

        if (!$preRegistro->archivo_pdr) {
            return back()->with('error', 'No hay archivo PDR disponible.');
        }

        return response()->download(public_path($preRegistro->archivo_pdr));
    }
}