@extends('layouts.user')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <a href="{{ route('user.inicio') }}" class="text-blue-400 hover:text-blue-300 transition-colors flex items-center space-x-2 bg-black/30 backdrop-blur-sm rounded-xl px-4 py-2 w-fit mb-4">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a Congresos</span>
            </a>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white">Mis Pagos por Terceros - Congresos</h2>
                <a href="{{ route('user.congresos.pagos-terceros.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-2 px-4 rounded-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Nuevo Pago</span>
                </a>
            </div>
        </div>

        @if($pagos->isEmpty())
            <div class="bg-black/30 backdrop-blur-xl rounded-2xl p-8 text-center border border-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
                <i class="fas fa-file-invoice-dollar text-4xl text-purple-400 mb-4"></i>
                <p class="text-white/90">No tienes pagos registrados aún.</p>
            </div>
        @else
            <div class="bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10">
                        <thead>
                            <tr class="bg-white/5">
                                <th class="px-6 py-3 text-left text-xs font-medium text-white/60 uppercase tracking-wider">Congreso</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white/60 uppercase tracking-wider">Tercero</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white/60 uppercase tracking-wider">Monto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white/60 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white/60 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white/60 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach($pagos as $pago)
                                <tr class="hover:bg-white/5 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white/90">
                                        {{ $pago->congreso->titulo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white/90">
                                        {{ $pago->nombre_tercero }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white/90">
                                        ${{ number_format($pago->monto_total, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($pago->estado_pago == 'validado')
                                                bg-green-400/10 text-green-400
                                            @elseif($pago->estado_pago == 'rechazado')
                                                bg-red-400/10 text-red-400
                                            @else
                                                bg-yellow-400/10 text-yellow-400
                                            @endif">
                                            {{ ucfirst($pago->estado_pago) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white/90">
                                        {{ $pago->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('user.congresos.pagos-terceros.show', $pago->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-200">Ver detalles</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection