<?php

namespace App\Http\Controllers;

use App\Models\PagoPaypalCongreso;
use App\Models\PagoInscripcionCongreso;
use App\Models\InscripcionCongreso;
use App\Models\ArticuloCongreso;
use App\Models\ConvocatoriaCongreso;
use App\Models\EventoCongreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayPalInscripcionController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            Log::info('Iniciando creación de orden PayPal', [
                'request_data' => $request->all(),
                'user_id' => auth()->id()
            ]);

            // Validar parámetros requeridos
            if (!$request->congreso_id) {
                Log::warning('Falta congreso_id en la petición');
                return response()->json([
                    'error' => 'El ID del congreso es requerido'
                ], 422);
            }

            if (!$request->tipo_pago || !in_array($request->tipo_pago, ['inscripcion', 'articulo'])) {
                Log::warning('Tipo de pago inválido', ['tipo_pago' => $request->tipo_pago]);
                return response()->json([
                    'error' => 'El tipo de pago debe ser "inscripcion" o "articulo"'
                ], 422);
            }

            $congreso = \App\Models\Congreso::findOrFail($request->congreso_id);
            $evento = $congreso->eventos->first();
            
            if (!$evento) {
                Log::warning('No hay evento activo para el congreso', ['congreso_id' => $request->congreso_id]);
                return response()->json([
                    'error' => 'No hay evento activo para este congreso'
                ], 422);
            }

            // Determinar el monto según el tipo de pago
            $monto = 0;
            if ($request->tipo_pago === 'inscripcion') {
                if ($request->tipo_participante === null || $request->tipo_participante === '') {
                    Log::warning('Falta tipo_participante para inscripción');
                    return response()->json([
                        'error' => 'El tipo de participante es requerido para inscripciones'
                    ], 422);
                }
                
                // Obtener cuotas de inscripción del evento
                $cuotas = is_array($evento->cuotas_inscripcion)
                    ? $evento->cuotas_inscripcion
                    : json_decode($evento->cuotas_inscripcion, true);
                
                if (!isset($cuotas[$request->tipo_participante])) {
                    Log::warning('Tipo de participante no válido', [
                        'tipo_participante' => $request->tipo_participante,
                        'cuotas_disponibles' => array_keys($cuotas)
                    ]);
                    return response()->json([
                        'error' => 'El tipo de participante seleccionado no es válido'
                    ], 422);
                }
                
                $monto = $cuotas[$request->tipo_participante]['monto'];
            } elseif ($request->tipo_pago === 'articulo') {
                $monto = $evento->costo_articulo ?? 0;
                if ($monto <= 0) {
                    return response()->json([
                        'error' => 'No hay costo configurado para artículos en este congreso'
                    ], 422);
                }
            }

            // Crear registro de pago inicial usando el nuevo modelo unificado
            $pago = PagoPaypalCongreso::create([
                'usuario_id' => auth()->id(),
                'congreso_id' => $request->congreso_id,
                'tipo_pago' => $request->tipo_pago,
                'monto' => $monto,
                'metodo_pago' => 'paypal',
                'estado_pago' => 'pendiente'
            ]);

            Log::info('Pago creado exitosamente', ['pago' => $pago->toArray()]);

            return response()->json([
                'id' => $pago->id,
                'amount' => $pago->monto,
                'tipo_pago' => $pago->tipo_pago
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear orden de PayPal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'error' => 'Error al crear la orden: ' . $e->getMessage()
            ], 500);
        }
    }

    public function captureOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            Log::info('Iniciando captura de orden PayPal', [
                'request_data' => $request->all()
            ]);

            if (!$request->pago_id) {
                Log::warning('Falta pago_id en la petición');
                return response()->json([
                    'error' => 'El ID del pago es requerido'
                ], 422);
            }

            $pago = PagoPaypalCongreso::findOrFail($request->pago_id);
            
            // Actualizar el registro con la información de PayPal
            $pago->update([
                'paypal_order_id' => $request->orderID,
                'referencia_paypal' => $request->paymentID,
                'estado_pago' => 'pagado',
                'fecha_pago' => now(),
                'detalles_transaccion' => json_encode($request->details)
            ]);

            DB::commit();
            Log::info('Pago actualizado exitosamente', ['pago' => $pago->toArray()]);

            return response()->json([
                'success' => true,
                'congreso_id' => $pago->congreso_id,
                'tipo_pago' => $pago->tipo_pago,
                'pago_id' => $pago->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al capturar pago de PayPal', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Método para crear orden de inscripción (compatibilidad con método anterior)
     */
    public function createInscripcionOrder(Request $request)
    {
        $request->merge(['tipo_pago' => 'inscripcion']);
        return $this->createOrder($request);
    }

    /**
     * Método para crear orden de artículo
     */
    public function createArticuloOrder(Request $request)
    {
        $request->merge(['tipo_pago' => 'articulo']);
        return $this->createOrder($request);
    }
}