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
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800/80">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Congreso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Responsable</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Usuarios</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($pagos as $pago)
                        @php
                            $usuariosInscripciones = $pago->inscripcionesCongreso->pluck('usuario')->unique('id');
                            $usuariosArticulos = $pago->articulosCongreso->pluck('usuario')->unique('id');
                            $todosUsuarios = $usuariosInscripciones->merge($usuariosArticulos)->unique('id');
                            $totalUsos = $pago->inscripcionesCongreso->count() + $pago->articulosCongreso->count();
                        @endphp
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $pago->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300">
                                <div class="max-w-xs truncate" title="{{ $pago->congreso->nombre }}">
                                    {{ Str::limit($pago->congreso->nombre, 25) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300">
                                <div class="max-w-xs truncate" title="{{ $pago->nombre_tercero }}">
                                    {{ Str::limit($pago->nombre_tercero, 25) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($pago->codigo_validacion_unico)
                                    <div class="bg-blue-900/50 text-blue-300 px-2 py-1 rounded-md font-mono text-xs border border-blue-700/50">
                                        {{ Str::limit($pago->codigo_validacion_unico, 25) }}
                                    </div>
                                @else
                                    <span class="text-gray-500 italic">Sin código</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($todosUsuarios->count() > 0)
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="bg-green-900/50 text-green-300 px-2 py-1 rounded-full text-xs font-medium border border-green-700/50">
                                                {{ $totalUsos }}/{{ $pago->numero_pagos }} usos
                                            </span>
                                        </div>
                                        <div class="max-w-xs">
                                            @foreach($todosUsuarios->take(2) as $usuario)
                                                <div class="text-xs text-gray-400 truncate" title="{{ $usuario->name }} ({{ $usuario->email }})">
                                                    <i class="fas fa-user text-blue-400 mr-1"></i>
                                                    {{ $usuario->name }}
                                                </div>
                                            @endforeach
                                            @if($todosUsuarios->count() > 2)
                                                <div class="text-xs text-gray-500 italic">
                                                    +{{ $todosUsuarios->count() - 2 }} más
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2">
                                        <span class="bg-gray-700/50 text-gray-400 px-2 py-1 rounded-full text-xs border border-gray-600/50">
                                            0/{{ $pago->numero_pagos }} usos
                                        </span>
                                        <span class="text-gray-500 text-xs italic">Sin usar</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <div class="font-medium">${{ number_format($pago->monto_total, 2) }}</div>
                                <div class="text-xs text-gray-500">
                                    @if($pago->cubre_inscripcion && $pago->cubre_articulo)
                                        Inscripción + Artículo
                                    @elseif($pago->cubre_inscripcion)
                                        Solo Inscripción
                                    @elseif($pago->cubre_articulo)
                                        Solo Artículo
                                    @endif
                                </div>
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
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.congresos.pagos-terceros.show', $pago->id) }}" 
                                       class="text-blue-400 hover:text-blue-300 transition-colors flex items-center space-x-1 bg-blue-900/20 hover:bg-blue-900/40 px-2 py-1 rounded-md border border-blue-700/50">
                                        <i class="fas fa-eye text-xs"></i>
                                        <span class="text-xs">Ver</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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