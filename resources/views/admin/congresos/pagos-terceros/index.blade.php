@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent">Gestión de Pagos por Terceros - Congresos</h1>
            <a href="{{ route('admin.congresos.pagos-terceros.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105 flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Generar Código</span>
            </a>
        </div>

    <!-- Filtros -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-lg p-6 mb-6">
        <form action="{{ route('admin.congresos.pagos-terceros.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tipo de Tercero</label>
                <select name="tipo" class="form-select w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="universidad" {{ request('tipo') == 'universidad' ? 'selected' : '' }}>Universidad</option>
                    <option value="empresa" {{ request('tipo') == 'empresa' ? 'selected' : '' }}>Empresa</option>
                    <option value="persona_fisica" {{ request('tipo') == 'persona_fisica' ? 'selected' : '' }}>Persona Física</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Estado</label>
                <select name="estado" class="form-select w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="validado" {{ request('estado') == 'validado' ? 'selected' : '' }}>Validado</option>
                    <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Congreso</label>
                <select name="congreso" class="form-select w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach($congresos as $congreso)
                        <option value="{{ $congreso->id }}" {{ request('congreso') == $congreso->id ? 'selected' : '' }}>
                            {{ $congreso->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition-all flex items-center space-x-2">
                    <i class="fas fa-filter"></i>
                    <span>Filtrar</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Pagos -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-800/80">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Congreso</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($pagos as $pago)
                    <tr class="hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $pago->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $pago->congreso->titulo }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $pago->nombre_tercero }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            ${{ number_format($pago->monto_total, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($pago->estado_pago == 'validado')
                                    bg-green-100 text-green-800
                                @elseif($pago->estado_pago == 'rechazado')
                                    bg-red-100 text-red-800
                                @else
                                    bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($pago->estado_pago) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.congresos.pagos-terceros.show', $pago->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors flex items-center space-x-1">
                                <i class="fas fa-eye"></i>
                                <span>Ver detalles</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($pagos->hasPages())
            <div class="bg-gray-800/30 px-6 py-4 border-t border-gray-700/50">
                {{ $pagos->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @if($pagos->isEmpty())
        <div class="text-center py-12">
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-xl p-8">
                <i class="fas fa-inbox text-4xl text-gray-500 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-300 mb-2">No hay pagos registrados</h3>
                <p class="text-gray-500">No se encontraron pagos de terceros que coincidan con los filtros aplicados.</p>
            </div>
        </div>
    @endif
</div>
@endsection