<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagoTerceroTransferenciaCongreso;
use App\Models\Congreso;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminPagoTerceroCongresoController extends Controller
{
    /**
     * Mostrar lista de pagos de terceros para congresos
     */
    public function index(Request $request)
    {
        $query = PagoTerceroTransferenciaCongreso::with([
            'congreso',
            'inscripcionesCongreso.usuario',
            'articulosCongreso.usuario'
        ]);

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo_tercero', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado_pago', $request->estado);
        }

        if ($request->filled('congreso')) {
            $query->where('congreso_id', $request->congreso);
        }

        $pagos = $query->orderBy('created_at', 'desc')->paginate(15);
        $congresos = Congreso::all();

        return view('admin.congresos.pagos-terceros.index', compact('pagos', 'congresos'));
    }

    /**
     * Mostrar formulario para crear un nuevo pago de tercero
     */
    public function create()
    {
        $congresos = Congreso::where('estado', 'activo')->orderBy('nombre')->get();
        
        return view('admin.congresos.pagos-terceros.create', compact('congresos'));
    }

    /**
     * Almacenar un nuevo pago de tercero y generar código
     */
    public function store(Request $request)
    {
        $request->validate([
            'congreso_id' => 'required|exists:congresos,id',
            'tipo_tercero' => 'required|in:universidad,empresa,persona_fisica',
            'nombre' => 'required|string|max:255',
            'rfc' => 'required|string|max:13',
            'contacto' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'numero_pagos' => 'required|integer|min:1',
            'referencia_transferencia' => 'nullable|string|max:255',
            'fecha_pago' => 'nullable|date',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'cubre_inscripcion' => 'required|in:0,1',
            'cubre_articulos' => 'required|in:0,1'
        ]);

        try {
            // Obtener el congreso y calcular costos como en el controlador de usuario
            $congreso = Congreso::with('convocatorias')->findOrFail($request->congreso_id);
            $convocatoria = $congreso->convocatorias->first();

            if (!$convocatoria) {
                return response()->json(['message' => 'No hay convocatoria activa para este congreso'], 422);
            }

            // Calcular costos automáticamente
            $costoInscripcion = 0;
            $costoArticulo = 0;
            
            if ($convocatoria->cuotas_inscripcion && is_array($convocatoria->cuotas_inscripcion)) {
                $costoInscripcion = floatval($convocatoria->cuotas_inscripcion[0]['monto'] ?? 0);
                $costoArticulo = $costoInscripcion * 0.3;
            } elseif ($convocatoria->costo_inscripcion) {
                $costoInscripcion = $convocatoria->costo_inscripcion;
                $costoArticulo = $convocatoria->costo_inscripcion * 0.3;
            } else {
                $costoInscripcion = 1200;
                $costoArticulo = 360;
            }

            $montoTotal = 0;
            if ($request->cubre_inscripcion == '1') {
                $montoTotal += $costoInscripcion * $request->numero_pagos;
            }
            if ($request->cubre_articulos == '1') {
                $montoTotal += $costoArticulo * $request->numero_pagos;
            }

            if ($request->cubre_inscripcion != '1') {
                return response()->json(['message' => 'La inscripción completa al congreso es obligatoria'], 422);
            }

            // Manejar subida de archivo como en el controlador de usuario
            $rutaComprobante = null;
            if ($request->hasFile('comprobante')) {
                $comprobanteFile = $request->file('comprobante');
                $filename = uniqid() . '_' . $comprobanteFile->getClientOriginalName();
                $destinationPath = public_path('comprobantes_pago_terceros_congreso');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $comprobanteFile->move($destinationPath, $filename);
                $rutaComprobante = 'comprobantes_pago_terceros_congreso/' . $filename;
            }

            // Crear el registro de pago
            $pago = PagoTerceroTransferenciaCongreso::create([
                'usuario_id' => auth()->id(),
                'congreso_id' => $request->congreso_id,
                'tipo_tercero' => $request->tipo_tercero,
                'nombre_tercero' => $request->nombre,
                'rfc_tercero' => $request->rfc,
                'contacto_tercero' => $request->contacto,
                'correo_tercero' => $request->correo,
                'numero_pagos' => $request->numero_pagos,
                'monto_total' => $montoTotal,
                'referencia_transferencia' => $request->referencia_transferencia,
                'fecha_pago' => $request->fecha_pago,
                'comprobante_pago' => $rutaComprobante,
                'cubre_inscripcion' => $request->cubre_inscripcion == '1',
                'cubre_articulo' => $request->cubre_articulos == '1',
                'estado_pago' => 'validado',
                'codigo_validacion_unico' => $this->generarCodigoUnico()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Código generado exitosamente',
                'codigo_validacion' => $pago->codigo_validacion_unico,
                'pago_id' => $pago->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el código: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar detalles de un pago específico
     */
    public function show($id)
    {
        $pago = PagoTerceroTransferenciaCongreso::with([
            'congreso',
            'inscripcionesCongreso.usuario',
            'articulosCongreso.usuario'
        ])->findOrFail($id);
        
        return view('admin.congresos.pagos-terceros.show', compact('pago'));
    }

    /**
     * Actualizar el estado de un pago
     */
    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:validado,rechazado'
        ]);

        $pago = PagoTerceroTransferenciaCongreso::findOrFail($id);
        
        $pago->estado_pago = $request->estado;
        
        // Si se valida el pago, generar código único si no existe
        if ($request->estado === 'validado' && !$pago->codigo_validacion_unico) {
            $pago->codigo_validacion_unico = $this->generarCodigoUnico();
        }
        
        $pago->save();

        return redirect()->route('admin.congresos.pagos-terceros.show', $pago->id)
                        ->with('success', 'Estado del pago actualizado correctamente.');
    }

    /**
     * Generar código único para el pago
     */
    private function generarCodigoUnico()
    {
        do {
            $codigo = 'CONG-' . strtoupper(Str::random(8));
        } while (PagoTerceroTransferenciaCongreso::where('codigo_validacion_unico', $codigo)->exists());

        return $codigo;
    }
}