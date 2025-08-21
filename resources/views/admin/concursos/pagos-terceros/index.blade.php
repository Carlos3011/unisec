@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent">Gestión de Pagos por Terceros</h1>
            <a href="{{ route('admin.concursos.pagos-terceros.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Generar Código
            </a>
        </div>

    <!-- Filtros -->
    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-lg p-6 mb-6">
        <form action="{{ route('admin.concursos.pagos-terceros.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                <label class="block text-sm font-medium text-gray-300 mb-2">Concurso</label>
                <select name="concurso" class="form-select w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos</option>
                    @foreach($concursos as $concurso)
                        <option value="{{ $concurso->id }}" {{ request('concurso') == $concurso->id ? 'selected' : '' }}>
                            {{ $concurso->nombre }}
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
        <div class="max-h-[600px] overflow-y-auto">
            <table class="w-full divide-y divide-gray-700">
                <thead class="bg-gray-800/80 sticky top-0 z-10">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-24">Fecha</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-32">Concurso</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-32">Responsable</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-28">Código</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-36">Usuarios</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-24">Monto</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-20">Estado</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider w-16">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($pagos as $pago)
                        @php
                            $usuariosPreRegistros = $pago->preRegistros->pluck('usuario')->unique('id');
                            $usuariosInscripciones = $pago->inscripciones->pluck('usuario')->unique('id');
                            $todosUsuarios = $usuariosPreRegistros->merge($usuariosInscripciones)->unique('id');
                            $totalUsos = $pago->preRegistros->count() + $pago->inscripciones->count();
                        @endphp
                        <tr class="hover:bg-gray-700/50 transition-colors">
                            <td class="px-3 py-3 text-xs text-gray-300 w-24">
                                <div class="text-xs leading-tight">
                                    <div>{{ $pago->created_at->format('d/m/Y') }}</div>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-xs text-gray-300 w-32">
                                <div class="truncate" title="{{ $pago->concurso->titulo }}">
                                    {{ Str::limit($pago->concurso->titulo, 25) }}
                                </div>
                            </td>
                            <td class="px-3 py-3 text-xs text-gray-300 w-32">
                                <div class="truncate" title="{{ $pago->nombre_tercero }}">
                                    {{ Str::limit($pago->nombre_tercero, 25) }}
                                </div>
                            </td>
                            <td class="px-3 py-3 text-xs w-28">
                                @if($pago->codigo_validacion_unico)
                                    <div class="bg-blue-900/50 text-blue-300 px-1 py-1 rounded text-xs font-mono border border-blue-700/50 truncate" title="{{ $pago->codigo_validacion_unico }}">
                                        {{ Str::limit($pago->codigo_validacion_unico, 25) }}
                                    </div>
                                @else
                                    <span class="text-gray-500 italic text-xs">Sin código</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-xs w-36">
                                @if($todosUsuarios->count() > 0)
                                    <div class="space-y-1">
                                        <span class="bg-green-900/50 text-green-300 px-1 py-1 rounded-full text-xs font-medium border border-green-700/50">
                                            {{ $totalUsos }}/{{ $pago->numero_pagos }}
                                        </span>
                                        @if($todosUsuarios->count() > 0)
                                            <div class="text-xs text-gray-400 truncate" title="{{ $todosUsuarios->first()->name }}">
                                                <i class="fas fa-user text-blue-400 mr-1"></i>
                                                {{ Str::limit($todosUsuarios->first()->name, 15) }}
                                            </div>
                                            @if($todosUsuarios->count() > 1)
                                                <div class="text-xs text-gray-500 italic">
                                                    +{{ $todosUsuarios->count() - 1 }} más
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @else
                                    <div class="space-y-1">
                                        <span class="bg-gray-700/50 text-gray-400 px-1 py-1 rounded-full text-xs border border-gray-600/50">
                                            0/{{ $pago->numero_pagos }}
                                        </span>
                                        <span class="text-gray-500 text-xs italic">Sin usar</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-xs text-gray-300 w-24">
                                <div class="font-medium">${{ number_format($pago->monto_total, 0) }}</div>
                                
                            </td>
                            <td class="px-3 py-3 w-20">
                                <span class="px-1 inline-flex text-xs leading-4 font-semibold rounded-full
                                    @if($pago->estado_pago == 'validado')
                                        bg-green-900/50 text-green-300 border border-green-700/50
                                    @elseif($pago->estado_pago == 'rechazado')
                                        bg-red-900/50 text-red-300 border border-red-700/50
                                    @else
                                        bg-yellow-900/50 text-yellow-300 border border-yellow-700/50
                                    @endif">
                                    {{ ucfirst($pago->estado_pago) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-xs font-medium w-16">
                                <a href="{{ route('admin.concursos.pagos-terceros.show', $pago->id) }}" 
                                   class="text-blue-400 hover:text-blue-300 transition-colors flex items-center justify-center bg-blue-900/20 hover:bg-blue-900/40 p-1 rounded border border-blue-700/50" title="Ver detalles">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection