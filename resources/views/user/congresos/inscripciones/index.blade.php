@extends('layouts.user')

@section('titulo', 'Mis Inscripciones al Congreso')

@section('contenido')
<div class="min-h-screen py-8 sm:py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <!-- Efectos de fondo decorativos -->
    <div class="absolute inset-0 overflow-hidden opacity-10">
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-purple-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute top-1/3 -right-20 w-80 h-80 bg-blue-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/3 w-72 h-72 bg-indigo-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Tarjeta principal -->
        <div class="max-w-7xl mx-auto bg-gradient-to-br from-gray-900/80 to-gray-800/90 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 shadow-xl transition-all duration-500 hover:shadow-[0_10px_40px_-15px_rgba(124,58,237,0.5)]">
            <!-- Header con título y botón -->
            <div class="px-6 sm:px-8 pt-6 pb-4 border-b border-white/10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-purple-900/20 to-blue-900/20">
                <div class="flex items-center space-x-3">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-purple-600/20 to-violet-600/20 border border-purple-500/30">
                        <i class="fas fa-clipboard-list text-purple-300"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Mis Inscripciones</h2>
                        <p class="text-sm text-purple-200/70">Gestiona todas tus participaciones en congresos</p>
                    </div>
                </div>
                
                @if ($convocatoria && $convocatoria->estaActiva())
                <a href="{{ route('user.congresos.inscripciones.create', ['convocatoria' => $convocatoria->id]) }}"
                   class="group inline-flex items-center px-5 py-2.5 rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 transform hover:scale-[1.03] hover:shadow-[0_0_20px_rgba(124,58,237,0.5)]">
                    <i class="fas fa-user-plus mr-2 group-hover:rotate-[15deg] transition-transform duration-300"></i>
                    Nueva Inscripción
                </a>
                @endif
            </div>

            <!-- Mensaje de éxito -->
            @if (session('success'))
            <div class="mx-6 mt-6 bg-green-600/20 border border-green-500/30 text-green-300 px-4 py-3 rounded-xl backdrop-blur-sm flex items-center animate-fade-in">
                <i class="fas fa-check-circle mr-3 text-green-400"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <!-- Contenido principal -->
            <div class="p-4 sm:p-6">
                @if ($inscripciones->isEmpty())
                <!-- Estado vacío -->
                <div class="text-center py-16 px-6">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-gray-800/50 to-gray-900/50 border border-white/10 mb-6">
                        <i class="fas fa-clipboard text-4xl text-gray-500/50"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-300 mb-2">No tienes inscripciones</h3>
                    <p class="text-gray-500 mb-6">Actualmente no estás inscrito en ningún congreso.</p>
                    @if ($convocatoria && $convocatoria->estaActiva())
                    <a href="{{ route('user.congresos.inscripciones.create', ['convocatoria' => $convocatoria->id]) }}"
                       class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 transition-all duration-300">
                        <i class="fas fa-user-plus mr-2"></i>
                        Crear primera inscripción
                    </a>
                    @endif
                </div>
                @else
                <!-- Vista de tabla para pantallas medianas y grandes -->
                @php
                    $tieneArticulos = $inscripciones->contains(function($inscripcion) {
                        return $inscripcion->articulo !== null;
                    });
                @endphp
                
                <div class="hidden md:block overflow-x-auto rounded-lg border border-white/10">
                    <table class="min-w-full divide-y divide-white/10">
                        <thead class="bg-white/5">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Congreso
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Tipo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Institución
                                </th>
                                @if($tieneArticulos)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Artículo
                                </th>
                                @endif
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Pago
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-purple-300 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($inscripciones as $inscripcion)
                            <tr class="group transition-colors hover:bg-white/5">
                                <!-- Congreso -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-gradient-to-br from-purple-600/20 to-blue-600/20 border border-purple-500/30 flex items-center justify-center">
                                            <i class="fas fa-university text-purple-300"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-white">{{ $inscripcion->congreso->nombre }}</div>
                                            <div class="text-xs text-gray-400">{{ $inscripcion->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Tipo de participante -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-white/90 capitalize">{{ str_replace('_', ' ', $inscripcion->tipo_participante) }}</div>
                                </td>
                                
                                <!-- Institución -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-white/90">{{ Str::limit($inscripcion->institucion, 20) }}</div>
                                </td>
                                
                                <!-- Estado del artículo (solo si hay artículos en la lista) -->
                                @if($tieneArticulos)
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($inscripcion->articulo)
                                    <div class="flex flex-col space-y-1">
                                        <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                            @if($inscripcion->articulo->estado_articulo === 'aceptado') bg-green-500/20 text-green-300 border border-green-500/30
                                            @elseif($inscripcion->articulo->estado_articulo === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                            @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                            @endif">
                                            <span class="w-1.5 h-1.5 rounded-full
                                                @if($inscripcion->articulo->estado_articulo === 'aceptado') bg-green-400
                                                @elseif($inscripcion->articulo->estado_articulo === 'rechazado') bg-red-400
                                                @else bg-yellow-400
                                                @endif"></span>
                                            {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_articulo)) }}
                                        </span>
                                        <div class="text-xs text-gray-400 truncate" title="{{ $inscripcion->articulo->titulo }}">
                                            <i class="fas fa-file-alt mr-1"></i>{{ Str::limit($inscripcion->articulo->titulo, 25) }}
                                        </div>
                                    </div>
                                    @else
                                    <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full bg-gray-500/20 text-gray-300 border border-gray-500/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Sin artículo
                                    </span>
                                    @endif
                                </td>
                                @endif
                                
                                <!-- Estado de inscripción -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        // Si el usuario ya pagó pero no envió artículo, consideramos la inscripción como validada
                                        $estadoMostrar = $inscripcion->estado;
                                        if ($inscripcion->tienePagoValido() && !$inscripcion->articulo && $inscripcion->estado === 'pendiente') {
                                            $estadoMostrar = 'validado';
                                        }
                                    @endphp
                                    <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                        @if($estadoMostrar === 'validado') bg-green-500/20 text-green-300 border border-green-500/30
                                        @elseif($estadoMostrar === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                        @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                        @endif">
                                        <span class="w-1.5 h-1.5 rounded-full
                                            @if($estadoMostrar === 'validado') bg-green-400
                                            @elseif($estadoMostrar === 'rechazado') bg-red-400
                                            @else bg-yellow-400
                                            @endif"></span>
                                        {{ ucfirst($estadoMostrar) }}
                                    </span>
                                </td>
                                
                                <!-- Estado de pago -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $tienePagoValido = $inscripcion->tienePagoValido();
                                        $tipoPago = $inscripcion->tipo_pago;
                                        $estadoPago = $tienePagoValido ? 'pagado' : ($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente');
                                    @endphp
                                    
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                                @if($tienePagoValido) bg-green-500/20 text-green-300 border border-green-500/30
                                                @elseif($estadoPago === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                                @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                                @endif">
                                                <span class="w-1.5 h-1.5 rounded-full
                                                    @if($tienePagoValido) bg-green-400
                                                    @elseif($estadoPago === 'rechazado') bg-red-400
                                                    @else bg-yellow-400
                                                    @endif"></span>
                                                {{ $tienePagoValido ? 'Pagado' : ucfirst($estadoPago) }}
                                            </span>
                                            
                                        </div>
                                        
                                    
                                        
                                        @if(!$tienePagoValido)
                                        <div class="flex space-x-1">
                                            <a href="{{ route('user.congresos.pagos.inscripcion', $inscripcion->convocatoria) }}" 
                                               class="text-xs px-2 py-1 rounded bg-blue-500/10 hover:bg-blue-500/20 text-blue-300 hover:text-blue-200 border border-blue-500/20 transition-all"
                                               title="Pagar con PayPal">
                                                <i class="fab fa-paypal"></i>
                                            </a>
                                            <a href="{{ route('user.congresos.pagos-terceros.validar') }}" 
                                               class="text-xs px-2 py-1 rounded bg-green-500/10 hover:bg-green-500/20 text-green-300 hover:text-green-200 border border-green-500/20 transition-all"
                                               title="Validar código de terceros">
                                                <i class="fas fa-users"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Acciones -->
                                <td class="px-3 py-3 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-1">
                                        <a href="{{ route('user.congresos.inscripciones.show', $inscripcion) }}"
                                           class="text-blue-400 hover:text-blue-300 transition-colors inline-flex items-center group"
                                           title="Ver detalles">
                                            <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-500/10 group-hover:bg-blue-500/20 border border-blue-500/20 group-hover:border-blue-500/30 transition-all">
                                                <i class="fas fa-eye text-xs"></i>
                                            </span>
                                        </a>
                                        
                                        @if($inscripcion->estado === 'pendiente')
                                        <a href="{{ route('user.congresos.inscripciones.edit', $inscripcion) }}"
                                           class="text-yellow-400 hover:text-yellow-300 transition-colors inline-flex items-center group"
                                           title="Editar">
                                            <span class="w-7 h-7 flex items-center justify-center rounded-full bg-yellow-500/10 group-hover:bg-yellow-500/20 border border-yellow-500/20 group-hover:border-yellow-500/30 transition-all">
                                                <i class="fas fa-edit text-xs"></i>
                                            </span>
                                        </a>
                                        @endif
                                        
                                        @if($inscripcion->pagoInscripcion)
                                        <a href="{{ route('user.congresos.inscripciones.factura', $inscripcion) }}"
                                           class="text-green-400 hover:text-green-300 transition-colors inline-flex items-center group"
                                           title="Descargar ticket">
                                            <span class="w-7 h-7 flex items-center justify-center rounded-full bg-green-500/10 group-hover:bg-green-500/20 border border-green-500/20 group-hover:border-green-500/30 transition-all">
                                                <i class="fas fa-file-invoice text-xs"></i>
                                            </span>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Vista de tarjetas para dispositivos móviles -->
                <div class="md:hidden space-y-4">
                    @foreach ($inscripciones as $inscripcion)
                    <div class="bg-white/5 rounded-xl p-5 space-y-4 hover:bg-white/10 transition-colors duration-200 border border-white/10">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 h-12 w-12 rounded-lg bg-gradient-to-br from-purple-600/20 to-blue-600/20 border border-purple-500/30 flex items-center justify-center">
                                    <i class="fas fa-university text-purple-300"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-white">{{ Str::limit($inscripcion->congreso->nombre, 30) }}</h3>
                                    <p class="text-xs text-gray-400 mt-1">{{ $inscripcion->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            @php
                                // Si el usuario ya pagó pero no envió artículo, consideramos la inscripción como validada
                                $estadoMostrarMobile = $inscripcion->estado;
                                if ($inscripcion->tienePagoValido() && !$inscripcion->articulo && $inscripcion->estado === 'pendiente') {
                                    $estadoMostrarMobile = 'validado';
                                }
                            @endphp
                            <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                @if($estadoMostrarMobile === 'validado') bg-green-500/20 text-green-300 border border-green-500/30
                                @elseif($estadoMostrarMobile === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full
                                    @if($estadoMostrarMobile === 'validado') bg-green-400
                                    @elseif($estadoMostrarMobile === 'rechazado') bg-red-400
                                    @else bg-yellow-400
                                    @endif"></span>
                                {{ ucfirst($estadoMostrarMobile) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="bg-black/20 p-3 rounded-lg border border-white/5">
                                <p class="text-gray-400 mb-1">Tipo</p>
                                <p class="text-white/90 capitalize">{{ str_replace('_', ' ', $inscripcion->tipo_participante) }}</p>
                            </div>
                            <div class="bg-black/20 p-3 rounded-lg border border-white/5">
                                <p class="text-gray-400 mb-1">Institución</p>
                                <p class="text-white/90">{{ Str::limit($inscripcion->institucion, 15) }}</p>
                            </div>
                        </div>

                        @if($inscripcion->articulo)
                        <div class="bg-black/20 p-3 rounded-lg border border-white/5 col-span-2">
                            <p class="text-gray-400 mb-2">Artículo</p>
                            <div class="space-y-2">
                                <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                    @if($inscripcion->articulo->estado_articulo === 'aceptado') bg-green-500/20 text-green-300 border border-green-500/30
                                    @elseif($inscripcion->articulo->estado_articulo === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                    @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                    @endif">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        @if($inscripcion->articulo->estado_articulo === 'aceptado') bg-green-400
                                        @elseif($inscripcion->articulo->estado_articulo === 'rechazado') bg-red-400
                                        @else bg-yellow-400
                                        @endif"></span>
                                    {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_articulo)) }}
                                </span>
                                <div class="text-sm text-white/90 font-medium" title="{{ $inscripcion->articulo->titulo }}">
                                    <i class="fas fa-file-alt mr-2 text-blue-400"></i>{{ Str::limit($inscripcion->articulo->titulo, 40) }}
                                </div>
                                @if($inscripcion->articulo->autores)
                                <div class="text-xs text-gray-400">
                                    <i class="fas fa-users mr-1"></i>{{ Str::limit($inscripcion->articulo->autores, 35) }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 gap-3">
                            <div class="bg-black/20 p-3 rounded-lg border border-white/5">
                                @php
                                    $tienePagoValido = $inscripcion->tienePagoValido();
                                    $tipoPago = $inscripcion->tipo_pago;
                                    $estadoPago = $tienePagoValido ? 'pagado' : ($inscripcion->pagoInscripcion->estado_pago ?? 'pendiente');
                                @endphp
                                
                                <p class="text-gray-400 mb-2">Pago</p>
                                
                                <div class="flex flex-col space-y-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="px-3 py-1 inline-flex items-center gap-1.5 text-xs font-medium rounded-full
                                            @if($tienePagoValido) bg-green-500/20 text-green-300 border border-green-500/30
                                            @elseif($estadoPago === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                            @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                            @endif">
                                            <span class="w-1.5 h-1.5 rounded-full
                                                @if($tienePagoValido) bg-green-400
                                                @elseif($estadoPago === 'rechazado') bg-red-400
                                                @else bg-yellow-400
                                                @endif"></span>
                                            {{ $tienePagoValido ? 'Pagado' : ucfirst($estadoPago) }}
                                        </span>
                                        
                                        @if($tienePagoValido)
                                            <span class="px-2 py-1 text-xs rounded-md bg-blue-500/10 text-blue-300 border border-blue-500/20"
                                                  title="Tipo de pago utilizado">
                                                @switch($tipoPago)
                                                    @case('paypal')
                                                        <i class="fab fa-paypal mr-1"></i>PayPal
                                                        @break
                                                    @case('terceros')
                                                        <i class="fas fa-users mr-1"></i>Terceros
                                                        @break
                                                    @case('inscripcion_legacy')
                                                        <i class="fas fa-credit-card mr-1"></i>Legacy
                                                        @break
                                                    @default
                                                        <i class="fas fa-question mr-1"></i>Otro
                                                @endswitch
                                            </span>
                                        @endif
                                    </div>
                                    
                                    
                                    
                                    @if(!$tienePagoValido)
                                    <div class="flex space-x-1 mt-2">
                                        <a href="{{ route('user.congresos.pagos.inscripcion', $inscripcion->convocatoria) }}" 
                                           class="text-xs px-2 py-1 rounded bg-blue-500/10 hover:bg-blue-500/20 text-blue-300 hover:text-blue-200 border border-blue-500/20 transition-all"
                                           title="Pagar con PayPal">
                                            <i class="fab fa-paypal"></i>
                                        </a>
                                        <a href="{{ route('user.congresos.pagos-terceros.validar') }}" 
                                           class="text-xs px-2 py-1 rounded bg-green-500/10 hover:bg-green-500/20 text-green-300 hover:text-green-200 border border-green-500/20 transition-all"
                                           title="Validar código de terceros">
                                            <i class="fas fa-users"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between space-x-3 pt-3 border-t border-white/10">
                            <a href="{{ route('user.congresos.inscripciones.show', $inscripcion) }}"
                               class="flex-1 flex items-center justify-center space-x-2 px-3 py-2 rounded-lg bg-blue-500/10 hover:bg-blue-500/20 border border-blue-500/20 hover:border-blue-500/30 text-blue-300 hover:text-blue-200 transition-all">
                                <i class="fas fa-eye text-sm"></i>
                                <span>Ver</span>
                            </a>
                            
                            @if($inscripcion->estado === 'pendiente')
                            <a href="{{ route('user.congresos.inscripciones.edit', $inscripcion) }}"
                               class="flex-1 flex items-center justify-center space-x-2 px-3 py-2 rounded-lg bg-yellow-500/10 hover:bg-yellow-500/20 border border-yellow-500/20 hover:border-yellow-500/30 text-yellow-300 hover:text-yellow-200 transition-all">
                                <i class="fas fa-edit text-sm"></i>
                                <span>Editar</span>
                            </a>
                            @endif
                            
                            @if($inscripcion->pagoInscripcion)
                            <a href="{{ route('user.congresos.inscripciones.factura', $inscripcion) }}"
                               class="flex-1 flex items-center justify-center space-x-2 px-3 py-2 rounded-lg bg-green-500/10 hover:bg-green-500/20 border border-green-500/20 hover:border-green-500/30 text-green-300 hover:text-green-200 transition-all">
                                <i class="fas fa-file-invoice text-sm"></i>
                                <span>Ticket</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-6 px-4 text-gray-300">
                    {{ $inscripciones->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .animate-blob {
        animation: blob 7s infinite ease-in-out;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(20px, 30px) scale(1.1); }
        50% { transform: translate(0, 20px) scale(1); }
        75% { transform: translate(30px, 0) scale(0.9); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection