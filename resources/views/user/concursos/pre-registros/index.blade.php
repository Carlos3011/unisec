@extends('layouts.user')

@section('titulo', 'Mis Pre-registro')

@section('contenido')
    <div class="min-h-screen py-6 sm:py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
        <div class="container mx-auto px-2 sm:px-4">
            <div
                class="max-w-7xl mx-auto bg-black/30 backdrop-blur-xl rounded-xl sm:rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
                <div class="p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h2 class="text-3xl font-bold text-white/90 flex items-center gap-3">
                        <i class="fas fa-clipboard-list text-purple-400"></i>
                        Mis Pre-registros
                    </h2>
                    @if ($convocatoria && !$preRegistros->where('concurso_id', $convocatoria->id)->where('usuario_id', auth()->id())->where('estado_pdr', '!=', 'rechazado')->count())
                        <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}"
                            class="group inline-flex items-center px-4 py-2 rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                            Nuevo Pre-registro
                        </a>
                    @endif
                </div>

                @if (session('success'))
                    <div
                        class="mx-6 bg-green-600/20 border border-green-500/30 text-green-300 px-4 py-3 rounded-xl mb-6 backdrop-blur-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if ($preRegistros->isEmpty())
                    <div class="text-center py-16 px-6">
                        <div class="text-6xl mb-4 text-gray-500/50">
                            <i class="fas fa-clipboard"></i>
                        </div>
                        <p class="text-gray-400 text-lg mb-2">No tienes pre-registros actualmente.</p>
                        <p class="text-gray-500">¡Comienza creando uno nuevo!</p>
                    </div>
                @else
                    <div class="px-2 sm:px-6 pb-6">
                        <!-- Vista de tabla para pantallas medianas y grandes -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-white/10 table-auto">
                                <thead>
                                    <tr class="bg-white/5">
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                            Concurso</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                            Equipo</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                            Integrantes</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                            Estado</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/10">
                                    @foreach ($preRegistros as $preRegistro)
                                        <tr class="group transition-colors hover:bg-white/5">
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-white/80 group-hover:text-white transition-colors">
                                                    {{ $preRegistro->concurso->titulo }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-white/80 group-hover:text-white transition-colors">
                                                    {{ $preRegistro->nombre_equipo }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-white/80 group-hover:text-white transition-colors">
                                                    {{ $preRegistro->integrantes }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                                            @if($preRegistro->estado_pdr === 'aprobado') bg-green-500/20 text-green-300 border border-green-500/30
                                                            @elseif($preRegistro->estado_pdr === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                                                @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                                            @endif">
                                                    <span class="w-1.5 h-1.5 rounded-full
                                                                @if($preRegistro->estado_pdr === 'aprobado') bg-green-400
                                                                @elseif($preRegistro->estado_pdr === 'rechazado') bg-red-400
                                                                    @else bg-yellow-400
                                                                @endif"></span>
                                                    {{ ucfirst($preRegistro->estado_pdr) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium space-x-3">
                                                <a href="{{ route('user.concursos.pre-registros.show', $preRegistro) }}"
                                                    class="text-blue-400 hover:text-blue-300 transition-colors inline-flex items-center gap-1.5">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Ver</span>
                                                </a>
                                                @if($preRegistro->estado_pdr === 'pendiente')
                                                    <a href="{{ route('user.concursos.pre-registros.edit', $preRegistro) }}"
                                                        class="text-yellow-400 hover:text-yellow-300 transition-colors inline-flex items-center gap-1.5">
                                                        <i class="fas fa-edit"></i>
                                                        <span>Editar</span>
                                                    </a>
                                                @endif
                                                @if($preRegistro->pago_paypal_id)
                                                    <a href="{{ route('user.concursos.pre-registros.factura', ['preRegistro' => $preRegistro->id]) }}"
                                                        class="text-green-400 hover:text-green-300 transition-colors inline-flex items-center gap-1.5">
                                                        <i class="fas fa-file-invoice"></i>
                                                        <span>Ticket</span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Vista de tarjetas para dispositivos móviles -->
                        <div class="md:hidden space-y-4">
                            @foreach ($preRegistros as $preRegistro)
                                <div class="bg-white/5 rounded-xl p-4 space-y-4 hover:bg-white/10 transition-colors duration-200">
                                    <div class="flex justify-between items-start">
                                        <div class="space-y-1">
                                            <h3 class="text-sm font-medium text-white">{{ $preRegistro->concurso->titulo }}</h3>
                                            <p class="text-sm text-white/70">{{ $preRegistro->nombre_equipo }}</p>
                                        </div>
                                        <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                                    @if($preRegistro->estado_pdr === 'aprobado') bg-green-500/20 text-green-300 border border-green-500/30
                                                    @elseif($preRegistro->estado_pdr === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                                        @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                                    @endif">
                                            <span class="w-1.5 h-1.5 rounded-full
                                                        @if($preRegistro->estado_pdr === 'aprobado') bg-green-400
                                                        @elseif($preRegistro->estado_pdr === 'rechazado') bg-red-400
                                                            @else bg-yellow-400
                                                        @endif"></span>
                                            {{ ucfirst($preRegistro->estado_pdr) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center text-sm text-white/70">
                                        <i class="fas fa-users mr-2 text-purple-400"></i>
                                        <span>{{ $preRegistro->integrantes }} integrantes</span>
                                    </div>

                                    <div class="flex justify-end space-x-3 pt-2 border-t border-white/10">
                                        <a href="{{ route('user.concursos.pre-registros.show', $preRegistro) }}"
                                            class="text-blue-400 hover:text-blue-300 transition-colors inline-flex items-center gap-1.5">
                                            <i class="fas fa-eye"></i>
                                            <span>Ver</span>
                                        </a>
                                        @if($preRegistro->estado_pdr === 'pendiente')
                                            <a href="{{ route('user.concursos.pre-registros.edit', $preRegistro) }}"
                                                class="text-yellow-400 hover:text-yellow-300 transition-colors inline-flex items-center gap-1.5">
                                                <i class="fas fa-edit"></i>
                                                <span>Editar</span>
                                            </a>
                                        @endif
                                        @if($preRegistro->pago_id)
                                            <a href="{{ route('user.concursos.pre-registros.factura', $preRegistro) }}"
                                                class="text-green-400 hover:text-green-300 transition-colors inline-flex items-center gap-1.5">
                                                <i class="fas fa-file-invoice"></i>
                                                <span>Ticket</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="px-6 pb-6 text-gray-300">
                        {{ $preRegistros->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection