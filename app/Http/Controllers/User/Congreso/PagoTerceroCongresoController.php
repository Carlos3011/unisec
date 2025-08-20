<?php

namespace App\Http\Controllers\User\Congreso;

use App\Http\Controllers\Controller;
use App\Models\Congreso;
use App\Models\EventoCongreso;
use App\Models\PagoTerceroTransferenciaCongreso;
use App\Models\InscripcionCongreso;
use App\Models\ArticuloCongreso;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PagoTerceroCongresoController extends Controller
{
    public function index()
    {
        $pagos = PagoTerceroTransferenciaCongreso::where('usuario_id', Auth::id())
            ->with('congreso')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.congresos.pagos-terceros.index', compact('pagos'));
    }

    public function show($id)
    {
        $pago = PagoTerceroTransferenciaCongreso::where('usuario_id', Auth::id())
            ->with('congreso')
            ->findOrFail($id);

        $usosTotales = $pago->numero_pagos;
        $usosRealizadosIns = InscripcionCongreso::where('codigo_pago_terceros', $pago->codigo_validacion_unico)->count();
        $usosRealizadosArt = ArticuloCongreso::where('codigo_pago_terceros', $pago->codigo_validacion_unico)->count();

        // Calcular usos disponibles por tipo por separado
        $usosDisponiblesIns = $pago->cubre_inscripcion ? max(0, $usosTotales - $usosRealizadosIns) : 0;
        $usosDisponiblesArt = $pago->cubre_articulo ? max(0, $usosTotales - $usosRealizadosArt) : 0;
        
        // Calcular usos disponibles totales (para mostrar información general)
        $usosDisponibles = $usosDisponiblesIns + $usosDisponiblesArt;

        return view('user.congresos.pagos-terceros.show', compact('pago', 'usosDisponibles', 'usosDisponiblesIns', 'usosDisponiblesArt'));
    }

    public function create()
    {
        $congresos = Congreso::with('eventos')
            ->where('estado', 'activo')
            ->get();
        return view('user.congresos.pagos-terceros.create', compact('congresos'));
    }

    public function validar()
    {
        $congresos = Congreso::where('estado', 'activo')->get();
        return view('user.congresos.pagos-terceros.validar', compact('congresos'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tipo_tercero' => 'required|in:universidad,empresa,persona_fisica',
                'nombre' => 'required|string|max:255',
                'rfc' => 'required|string|max:13',
                'contacto' => 'required|string|max:255',
                'correo' => 'required|email',
                'congreso_id' => 'required|exists:congresos,id',
                'cubre_inscripcion' => 'required|in:0,1',
                'cubre_articulos' => 'required|in:0,1',
                'numero_pagos' => 'required|integer|min:1',
                'comprobante' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            $congreso = Congreso::with('convocatorias')->findOrFail($request->congreso_id);
            $convocatoria = $congreso->convocatorias->first();

            if (!$convocatoria) {
                return response()->json(['message' => 'No hay convocatoria activa para este congreso'], 422);
            }

            // Obtener costos desde cuotas_inscripcion o costo_inscripcion
            $costoInscripcion = 0;
            $costoArticulo = 0;
            
            if ($convocatoria->cuotas_inscripcion && is_array($convocatoria->cuotas_inscripcion)) {
                // Si hay cuotas definidas, usar la primera como costo base
                $costoInscripcion = floatval($convocatoria->cuotas_inscripcion[0]['monto'] ?? 0);
                $costoArticulo = $costoInscripcion * 0.3; // Artículo cuesta 30% de la inscripción
            } elseif ($convocatoria->costo_inscripcion) {
                // Si hay un costo fijo definido
                $costoInscripcion = $convocatoria->costo_inscripcion;
                $costoArticulo = $convocatoria->costo_inscripcion * 0.3;
            } else {
                // Valores por defecto si no hay costos definidos
                $costoInscripcion = 1200; // Costo base estudiante
                $costoArticulo = 360; // 30% del costo base
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

            $codigoValidacion = Str::uuid();
            
            $comprobanteFile = $request->file('comprobante');
            $filename = uniqid() . '_' . $comprobanteFile->getClientOriginalName();
            $destinationPath = public_path('comprobantes_pago_terceros_congreso');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $comprobanteFile->move($destinationPath, $filename);
            $comprobantePath = 'comprobantes_pago_terceros_congreso/' . $filename;

            $pagoTercero = new PagoTerceroTransferenciaCongreso([
                'usuario_id' => Auth::id(),
                'tipo_tercero' => $request->tipo_tercero,
                'nombre_tercero' => $request->nombre,
                'rfc_tercero' => $request->rfc,
                'contacto_tercero' => $request->contacto,
                'correo_tercero' => $request->correo,
                'congreso_id' => $request->congreso_id,
                'cubre_inscripcion' => $request->cubre_inscripcion == '1',
                'cubre_articulo' => $request->cubre_articulos == '1',
                'numero_pagos' => $request->numero_pagos,
                'monto_total' => $montoTotal,
                'codigo_validacion_unico' => $codigoValidacion,
                'comprobante_pago' => $comprobantePath,
                'estado_pago' => 'pendiente'
            ]);

            $pagoTercero->save();

            return response()->json([
                'message' => 'Pago registrado exitosamente',
                'codigo_validacion' => $codigoValidacion
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al procesar el pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function validarCodigo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string',
            'congreso_id' => 'required|exists:congresos,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pagoTercero = PagoTerceroTransferenciaCongreso::where('codigo_validacion_unico', $request->codigo)
            ->where('congreso_id', $request->congreso_id)
            ->where('estado_pago', 'validado')
            ->first();

        if (!$pagoTercero) {
            return response()->json(['error' => 'Código inválido o no encontrado'], 404);
        }

        // Contar usos por separado para cada tipo
        $usosInscripcion = InscripcionCongreso::where('codigo_pago_terceros', $pagoTercero->codigo_validacion_unico)->count();
        $usosArticulo = ArticuloCongreso::where('codigo_pago_terceros', $pagoTercero->codigo_validacion_unico)->count();

        // Calcular usos disponibles por tipo
        $usosDisponiblesIns = 0;
        $usosDisponiblesArt = 0;

        if ($pagoTercero->cubre_inscripcion) {
            $usosDisponiblesIns = max(0, $pagoTercero->numero_pagos - $usosInscripcion);
        }

        if ($pagoTercero->cubre_articulo) {
            $usosDisponiblesArt = max(0, $pagoTercero->numero_pagos - $usosArticulo);
        }

        // Verificar si hay al menos un uso disponible para algún tipo
        if ($usosDisponiblesIns == 0 && $usosDisponiblesArt == 0) {
            return response()->json(['error' => 'El código ha alcanzado el límite de usos permitidos para todos los tipos'], 400);
        }

        // Obtener la convocatoria correspondiente al congreso
        $congreso = Congreso::with('convocatorias')->find($pagoTercero->congreso_id);
        $convocatoria = $congreso ? $congreso->convocatorias->first() : null;

        return response()->json([
            'valid' => true,
            'congreso_id' => $pagoTercero->congreso_id,
            'convocatoria_id' => $convocatoria ? $convocatoria->id : null,
            'usosDisponiblesIns' => $usosDisponiblesIns,
            'usosDisponiblesArt' => $usosDisponiblesArt,
            'message' => 'Validación exitosa. ' .
                ($usosDisponiblesIns > 0 ? "Disponible para {$usosDisponiblesIns} inscripciones. " : '') .
                ($usosDisponiblesArt > 0 ? "Disponible para {$usosDisponiblesArt} artículos." : '')
        ]);
    }

    public function usarCodigoEnInscripcion($codigo, $inscripcionId)
    {
        $inscripcion = InscripcionCongreso::findOrFail($inscripcionId);
        $pagoTercero = PagoTerceroTransferenciaCongreso::where('codigo_validacion_unico', $codigo)
            ->where('congreso_id', $inscripcion->congreso_id)
            ->where('estado_pago', 'validado')
            ->first();

        if (!$pagoTercero || !$pagoTercero->cubre_inscripcion) {
            return false;
        }

        // Contar solo los usos de inscripción para este código
        $usosInscripcion = InscripcionCongreso::where('codigo_pago_terceros', $pagoTercero->codigo_validacion_unico)->count();
        if ($usosInscripcion >= $pagoTercero->numero_pagos) {
            return false;
        }

        $inscripcion->update(['codigo_pago_terceros' => $codigo]);
        return true;
    }

    public function usarCodigoEnArticulo($codigo, $articuloId)
    {
        $articulo = ArticuloCongreso::findOrFail($articuloId);
        $pagoTercero = PagoTerceroTransferenciaCongreso::where('codigo_validacion_unico', $codigo)
            ->where('congreso_id', $articulo->congreso_id)
            ->where('estado_pago', 'validado')
            ->first();

        if (!$pagoTercero || !$pagoTercero->cubre_articulo) {
            return false;
        }

        // Contar solo los usos de artículo para este código
        $usosArticulo = ArticuloCongreso::where('codigo_pago_terceros', $pagoTercero->codigo_validacion_unico)->count();
        if ($usosArticulo >= $pagoTercero->numero_pagos) {
            return false;
        }

        $articulo->update(['codigo_pago_terceros' => $codigo]);
        return true;
    }

    private function calcularMontoTotal($congreso, $cubreInscripcion, $cubreArticulo, $numeroPagos)
    {
        $montoTotal = 0;
        $evento = $congreso->eventos->first();
        
        if ($cubreInscripcion && $evento) {
            $montoTotal += $evento->costo_inscripcion * $numeroPagos;
        }
        if ($cubreArticulo && $evento) {
            $montoTotal += $evento->costo_articulo * $numeroPagos;
        }
        return $montoTotal;
    }

    private function contarUsosCodigo($codigoValidacion)
    {
        $usosInscripcion = InscripcionCongreso::where('codigo_pago_terceros', $codigoValidacion)->count();
        $usosArticulo = ArticuloCongreso::where('codigo_pago_terceros', $codigoValidacion)->count();
        return $usosInscripcion + $usosArticulo;
    }
}