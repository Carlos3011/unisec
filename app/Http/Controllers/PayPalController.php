<?php

namespace App\Http\Controllers;

use App\Models\PagoPaypalConcurso;
use App\Models\PreRegistroConcurso;
use App\Models\ConvocatoriaConcurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PayPalController extends Controller
{
    public function createOrder(Request $request)
    {
        $convocatoria = ConvocatoriaConcurso::findOrFail($request->convocatoria_id);
        
        // Crear registro de pago inicial
        $pago = PagoPaypalConcurso::create([
            'usuario_id' => auth()->id(),
            'concurso_id' => $convocatoria->concurso_id,
            'tipo_pago' => PagoPaypalConcurso::TIPO_PRE_REGISTRO,
            'monto' => $convocatoria->costo_pre_registro,
            'metodo_pago' => 'paypal',
            'estado_pago' => 'pendiente'
        ]);
        
        // Almacenar el ID de la convocatoria para uso posterior
        $pago->convocatoria_id = $convocatoria->id;

        return response()->json([
            'id' => $pago->id,
            'amount' => $convocatoria->costo_pre_registro
        ]);
    }

    public function captureOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $pago = PagoPaypalConcurso::findOrFail($request->pago_id);
            
            // Actualizar el registro con la información de PayPal
            $pago->update([
                'paypal_order_id' => $request->orderID,
                'referencia_paypal' => $request->paymentID,
                'estado_pago' => 'pagado',
                'fecha_pago' => now(),
                'detalles_transaccion' => json_encode($request->details)
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'convocatoria_id' => $pago->convocatoria_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago: ' . $e->getMessage()
            ], 500);
        }
    }
}