<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PagoTerceroTransferenciaConcurso;
use App\Models\Concurso;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AdminPagoTerceroController extends Controller
{
    public function index(Request $request)
    {
        $query = PagoTerceroTransferenciaConcurso::query()->with([
            'concurso', 
            'usuario',
            'preRegistros.usuario',
            'inscripciones.usuario'
        ]);

        // Aplicar filtros si existen
        if ($request->filled('tipo_tercero')) {
            $query->where('tipo_tercero', $request->tipo_tercero);
        }

        if ($request->filled('concurso')) {
            $query->where('concurso_id', $request->concurso);
        }

        if ($request->filled('estado')) {
            $query->where('estado_pago', $request->estado);
        }

        $pagos = $query->latest()->get();
        $concursos = Concurso::where('estado', 'activo')->get();
        return view('admin.concursos.pagos-terceros.index', compact('pagos', 'concursos'));
    }

    /**
     * Mostrar formulario para crear un nuevo pago de tercero
     */
    public function create()
    {
        $concursos = Concurso::where('estado', 'activo')->orderBy('titulo')->get();
        
        return view('admin.concursos.pagos-terceros.create', compact('concursos'));
    }

    /**
     * Almacenar un nuevo pago de tercero y generar código
     */
    public function store(Request $request)
    {
        $request->validate([
            'concurso_id' => 'required|exists:concursos,id',
            'tipo_tercero' => 'required|in:universidad,empresa,persona_fisica',
            'nombre' => 'required|string|max:255',
            'rfc' => 'required|string|max:13',
            'contacto' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'numero_pagos' => 'required|integer|min:1',
            'referencia_transferencia' => 'nullable|string|max:255',
            'fecha_pago' => 'nullable|date',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'cubre_pre_registro' => 'required|in:0,1',
            'cubre_inscripcion' => 'required|in:0,1'
        ]);

        try {
            // Obtener el concurso y calcular costos
            $concurso = Concurso::with('convocatorias')->findOrFail($request->concurso_id);
            $convocatoria = $concurso->convocatorias->first();

            if (!$convocatoria) {
                return response()->json(['message' => 'No hay convocatoria activa para este concurso'], 422);
            }

            // Calcular costos automáticamente
            $costoPreregistro = 0;
            $costoInscripcion = 0;
            
            if ($request->cubre_pre_registro == '1') {
                $costoPreregistro = $convocatoria->costo_pre_registro ?? 0;
            }
            
            if ($request->cubre_inscripcion == '1') {
                $costoInscripcion = $convocatoria->costo_inscripcion ?? 0;
            }

            $costoUnitario = $costoPreregistro + $costoInscripcion;
            $montoTotal = $costoUnitario * $request->numero_pagos;

            // Manejar archivo de comprobante
            $rutaComprobante = null;
            if ($request->hasFile('comprobante')) {
                $archivo = $request->file('comprobante');
                $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
                $rutaComprobante = $archivo->storeAs('comprobantes/concursos', $nombreArchivo, 'public');
            }

            // Crear el pago
            $pago = PagoTerceroTransferenciaConcurso::create([
                'usuario_id' => auth()->id(),
                'concurso_id' => $request->concurso_id,
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
                'cubre_pre_registro' => $request->cubre_pre_registro == '1',
                'cubre_inscripcion' => $request->cubre_inscripcion == '1',
                'estado_pago' => 'pendiente',
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

    public function show($id)
    {
        $pago = PagoTerceroTransferenciaConcurso::with([
            'concurso',
            'preRegistros.usuario',
            'inscripciones.usuario'
        ])->findOrFail($id);
        return view('admin.concursos.pagos-terceros.show', compact('pago'));
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => ['required', 'in:validado,rechazado'],
            'observacion' => ['nullable', 'string', 'max:255']
        ]);

        $pago = PagoTerceroTransferenciaConcurso::findOrFail($id);

        if ($pago->estado_pago !== 'pendiente') {
            return redirect()->back()->with('error', 'Este pago ya ha sido procesado anteriormente.');
        }

        $pago->update([
            'estado_pago' => $request->estado,
            'observacion' => $request->observacion,
            'fecha_validacion' => now()
        ]);

        $mensaje = $request->estado === 'validado' 
            ? 'Pago validado exitosamente.' 
            : 'Pago rechazado exitosamente.';

        return redirect()->route('admin.concursos.pagos-terceros.show', $pago)
            ->with('success', $mensaje);
    }

    /**
     * Generar código único para el pago
     */
    private function generarCodigoUnico()
    {
        do {
            $codigo = 'CONC-' . strtoupper(Str::random(8));
        } while (PagoTerceroTransferenciaConcurso::where('codigo_validacion_unico', $codigo)->exists());

        return $codigo;
    }

    /**
     * Obtener precios de un concurso específico
     */
    public function obtenerPrecios($concursoId)
    {
        try {
            $concurso = Concurso::with('convocatorias')->findOrFail($concursoId);
            $convocatoria = $concurso->convocatorias->first();

            if (!$convocatoria) {
                return response()->json(['error' => 'No hay convocatoria activa'], 404);
            }

            return response()->json([
                'costo_preregistro' => $convocatoria->costo_pre_registro ?? 0,
                'costo_inscripcion' => $convocatoria->costo_inscripcion ?? 0
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Concurso no encontrado'], 404);
        }
    }
}