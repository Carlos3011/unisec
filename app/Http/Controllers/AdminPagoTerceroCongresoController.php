<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PagoTerceroTransferenciaCongreso;
use App\Models\Congreso;
use Illuminate\Support\Str;

class AdminPagoTerceroCongresoController extends Controller
{
    /**
     * Mostrar lista de pagos de terceros para congresos
     */
    public function index(Request $request)
    {
        $query = PagoTerceroTransferenciaCongreso::with(['congreso']);

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
     * Mostrar detalles de un pago específico
     */
    public function show($id)
    {
        $pago = PagoTerceroTransferenciaCongreso::with(['congreso'])->findOrFail($id);
        
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