@extends('layouts.user')

@section('titulo', 'Detalles de la Inscripción')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <!-- Efectos de fondo decorativos -->
    <div class="absolute inset-0 overflow-hidden opacity-20">
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-purple-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute top-1/3 -right-20 w-80 h-80 bg-blue-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/3 w-72 h-72 bg-indigo-500 rounded-full mix-blend-overlay filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Tarjeta principal -->
        <div class="max-w-5xl mx-auto bg-gradient-to-br from-gray-900/80 to-gray-800/90 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 shadow-2xl transition-all duration-500 hover:shadow-[0_10px_40px_-15px_rgba(124,58,237,0.5)]">
            <!-- Header con navegación -->
            <div class="px-8 pt-6 pb-4 border-b border-white/10 flex justify-between items-center bg-gradient-to-r from-purple-900/20 to-blue-900/20">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('user.congresos.inscripciones.index') }}" class="group flex items-center space-x-2 text-white/80 hover:text-white transition-colors duration-300">
                        <span class="w-8 h-8 flex items-center justify-center bg-white/5 rounded-lg group-hover:bg-white/10 border border-white/10 group-hover:border-white/20 transition-all">
                            <i class="fas fa-arrow-left text-sm"></i>
                        </span>
                        <span class="font-medium">Mis Inscripciones</span>
                    </a>
                </div>
                
                @can('update', $inscripcion)
                <a href="{{ route('user.congresos.inscripciones.edit', $inscripcion) }}" 
                   class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600/20 to-indigo-600/20 hover:from-blue-600/30 hover:to-indigo-600/30 text-blue-300 hover:text-blue-200 border border-blue-500/30 hover:border-blue-400/50 transition-all duration-300 shadow-sm">
                    <i class="fas fa-pencil-alt text-sm"></i>
                    <span>Editar Inscripción</span>
                </a>
                @endcan
            </div>

            <!-- Encabezado informativo -->
            <div class="px-8 py-6 border-b border-white/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNwYXR0ZXJuKSIvPjwvc3ZnPg==')] opacity-30"></div>
                
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">
                                <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-300 to-blue-300">Detalles de Inscripción</span>
                            </h1>
                            <p class="text-white/70">Información completa de tu participación en el congreso</p>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <div class="px-4 py-2 rounded-lg bg-white/5 border border-white/10 backdrop-blur-sm flex items-center space-x-2">
                                <i class="far fa-calendar text-blue-300"></i>
                                <span class="text-white/90">{{ $inscripcion->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            
                            <div class="px-4 py-2 rounded-lg bg-white/5 border border-white/10 backdrop-blur-sm flex items-center space-x-2">
                                <i class="far fa-flag text-purple-300"></i>
                                <span class="text-white/90">{{ $inscripcion->congreso->nombre }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-center">
                        <span class="px-6 py-2 rounded-full text-sm font-semibold flex items-center space-x-2
                            @switch($inscripcion->estado)
                                @case('validado')
                                    bg-green-500/20 text-green-300 border border-green-500/30 shadow-[0_0_15px_rgba(74,222,128,0.2)]
                                    @break
                                @case('pendiente')
                                    bg-yellow-500/20 text-yellow-300 border border-yellow-500/30 shadow-[0_0_15px_rgba(234,179,8,0.2)]
                                    @break
                                @case('rechazado')
                                    bg-red-500/20 text-red-300 border border-red-500/30 shadow-[0_0_15px_rgba(248,113,113,0.2)]
                                    @break
                            @endswitch">
                            <span class="w-2 h-2 rounded-full 
                                @switch($inscripcion->estado)
                                    @case('validado') bg-green-400 @break
                                    @case('pendiente') bg-yellow-400 @break
                                    @case('rechazado') bg-red-400 @break
                                @endswitch"></span>
                            <span>{{ ucfirst($inscripcion->estado) }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Columna izquierda - Información del participante -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Sección de información personal -->
                    <div class="bg-gray-800/50 rounded-xl p-6 border border-white/10 backdrop-blur-sm">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-3 rounded-lg bg-gradient-to-br from-purple-500/10 to-violet-500/10 border border-purple-500/20">
                                <i class="fas fa-user text-purple-300"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-white">Información del Participante</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white/5 p-4 rounded-lg border border-white/5 hover:border-purple-500/30 transition-all duration-300">
                                <p class="text-sm text-gray-400 mb-1">Nombre completo</p>
                                <p class="text-white font-medium">{{ $inscripcion->usuario->name }}</p>
                            </div>
                            
                            <div class="bg-white/5 p-4 rounded-lg border border-white/5 hover:border-purple-500/30 transition-all duration-300">
                                <p class="text-sm text-gray-400 mb-1">Tipo de participación</p>
                                <p class="text-white font-medium capitalize">{{ str_replace('_', ' ', $inscripcion->tipo_participante) }}</p>
                            </div>
                            
                            <div class="bg-white/5 p-4 rounded-lg border border-white/5 hover:border-purple-500/30 transition-all duration-300">
                                <p class="text-sm text-gray-400 mb-1">Institución</p>
                                <p class="text-white font-medium">{{ $inscripcion->institucion }}</p>
                            </div>
                            
                            <div class="bg-white/5 p-4 rounded-lg border border-white/5 hover:border-purple-500/30 transition-all duration-300">
                                <p class="text-sm text-gray-400 mb-1">Congreso</p>
                                <p class="text-white font-medium">{{ $inscripcion->congreso->nombre }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de artículo (si existe) -->
                    @if($inscripcion->articulo)
                    <div class="bg-gray-800/50 rounded-xl p-6 border border-white/10 backdrop-blur-sm">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-3 rounded-lg bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20">
                                <i class="fas fa-file-alt text-green-300"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-white">Información del Artículo</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Título y estados -->
                            <div class="bg-white/5 p-5 rounded-lg border border-white/5 hover:border-green-500/30 transition-all duration-300">
                                <p class="text-sm text-gray-400 mb-1">Título del artículo</p>
                                <p class="text-white font-medium text-lg mb-4">{{ $inscripcion->articulo->titulo }}</p>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <p class="text-sm text-gray-400 mb-1">Estado del artículo</p>
                                        <div class="flex items-center gap-4">
                                            @if($inscripcion->articulo->archivo_articulo)
                                                <a href="{{ asset($inscripcion->articulo->archivo_articulo) }}" 
                                                   target="_blank"
                                                   class="text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="text-sm">Ver</span>
                                                </a>
                                            @endif
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                @if($inscripcion->articulo->estado_articulo === 'aceptado') bg-green-500/20 text-green-300 border border-green-500/30
                                                @elseif($inscripcion->articulo->estado_articulo === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                                @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_articulo)) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-400 mb-1">Estado del extenso</p>
                                        <div class="flex items-center gap-4">
                                            @if($inscripcion->articulo->archivo_extenso)
                                                <a href="{{ asset($inscripcion->articulo->archivo_extenso) }}" 
                                                   target="_blank"
                                                   class="text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="text-sm">Ver</span>
                                                </a>
                                            @endif
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                @if($inscripcion->articulo->estado_extenso === 'aceptado') bg-green-500/20 text-green-300 border border-green-500/30
                                                @elseif($inscripcion->articulo->estado_extenso === 'rechazado') bg-red-500/20 text-red-300 border border-red-500/30
                                                @elseif($inscripcion->articulo->estado_extenso === 'en_revision') bg-blue-500/20 text-blue-300 border border-blue-500/30
                                                @else bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_extenso)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Autores -->
                            <div class="bg-white/5 p-5 rounded-lg border border-white/5 hover:border-green-500/30 transition-all duration-300">
                                <h3 class="text-sm font-medium text-gray-400 mb-3">Autores del artículo</h3>
                                <div class="space-y-3">
                                    @foreach(json_decode($inscripcion->articulo->autores_data, true) as $autor)
                                    <div class="bg-black/20 p-3 rounded-lg border border-white/5 flex items-start space-x-3">
                                        <div class="mt-1 w-6 h-6 rounded-full bg-gradient-to-br from-green-500/20 to-emerald-500/20 border border-green-500/30 flex items-center justify-center">
                                            <i class="fas fa-user text-xs text-green-300"></i>
                                        </div>
                                        <div>
                                            <p class="text-white font-medium">{{ $autor['nombre'] }}</p>
                                            <p class="text-gray-400 text-sm">{{ $autor['correo'] }}</p>
                                            <p class="text-gray-400 text-xs">{{ $autor['institucion'] }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Archivos -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white/5 p-5 rounded-lg border border-white/5 hover:border-green-500/30 transition-all duration-300">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-3 rounded-lg bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20">
                                            <i class="fas fa-file-pdf text-green-300"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-400 mb-1">Artículo</p>
                                            @if($inscripcion->articulo->archivo_articulo)
                                                <a href="{{ asset($inscripcion->articulo->archivo_articulo) }}" 
                                                   target="_blank"
                                                   class="text-green-300 hover:text-green-200 inline-flex items-center space-x-1 transition-colors">
                                                    <i class="fas fa-eye text-sm"></i>
                                                    <span>Ver documento</span>
                                                </a>
                                            @else
                                                <p class="text-gray-400 text-sm">No disponible</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white/5 p-5 rounded-lg border border-white/5 hover:border-green-500/30 transition-all duration-300">
                                    <div class="flex items-center space-x-3">
                                        <div class="p-3 rounded-lg bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20">
                                            <i class="fas fa-file-pdf text-green-300"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-400 mb-1">Artículo extenso</p>
                                            @if($inscripcion->articulo->archivo_extenso)
                                                <a href="{{ asset($inscripcion->articulo->archivo_extenso) }}" 
                                                   target="_blank"
                                                   class="text-green-300 hover:text-green-200 inline-flex items-center space-x-1 transition-colors">
                                                    <i class="fas fa-eye text-sm"></i>
                                                    <span>Ver documento</span>
                                                </a>
                                            @else
                                                <p class="text-gray-400 text-sm">No disponible</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Comentarios -->
                            @if($inscripcion->articulo->comentarios_articulo || $inscripcion->articulo->comentarios_extenso)
                            <div class="space-y-4">
                                @if($inscripcion->articulo->comentarios_articulo)
                                <div class="bg-white/5 p-5 rounded-lg border border-white/5 hover:border-green-500/30 transition-all duration-300">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="p-2 rounded-lg bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20">
                                            <i class="fas fa-comment-alt text-sm text-green-300"></i>
                                        </div>
                                        <h4 class="text-sm font-medium text-gray-400">Comentarios sobre el artículo</h4>
                                    </div>
                                    <div class="text-white/80 text-sm bg-black/20 p-3 rounded border border-white/5">
                                        {{ $inscripcion->articulo->comentarios_articulo }}
                                    </div>
                                </div>
                                @endif
                                
                                @if($inscripcion->articulo->comentarios_extenso)
                                <div class="bg-white/5 p-5 rounded-lg border border-white/5 hover:border-green-500/30 transition-all duration-300">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <div class="p-2 rounded-lg bg-gradient-to-br from-green-500/10 to-emerald-500/10 border border-green-500/20">
                                            <i class="fas fa-comment-alt text-sm text-green-300"></i>
                                        </div>
                                        <h4 class="text-sm font-medium text-gray-400">Comentarios sobre el extenso</h4>
                                    </div>
                                    <div class="text-white/80 text-sm bg-black/20 p-3 rounded border border-white/5">
                                        {{ $inscripcion->articulo->comentarios_extenso }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Columna derecha - Estados y acciones -->
                <div class="space-y-8">
                    <!-- Estado del pago -->
                    <div class="bg-gray-800/50 rounded-xl p-6 border border-white/10 backdrop-blur-sm">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-3 rounded-lg bg-gradient-to-br from-blue-500/10 to-indigo-500/10 border border-blue-500/20">
                                <i class="fas fa-credit-card text-blue-300"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-white">Estado del Pago</h2>
                        </div>
                        
                        <div class="flex flex-col items-center space-y-4">
                            @php
                        // Determinar el estado del pago considerando pagos de terceros
                        $estadoPago = 'pendiente';
                        $textoEstado = 'Pendiente';
                        
                        if ($inscripcion->pagoInscripcion && $inscripcion->pagoInscripcion->estado_pago === 'pagado') {
                            $estadoPago = 'pagado';
                            $textoEstado = 'Pagado';
                        } elseif ($inscripcion->pagoInscripcion && $inscripcion->pagoInscripcion->estado_pago === 'rechazado') {
                            $estadoPago = 'rechazado';
                            $textoEstado = 'Rechazado';
                        } elseif ($inscripcion->codigo_pago_terceros && $inscripcion->pagoTercero && $inscripcion->pagoTercero->estado_pago === 'validado') {
                            $estadoPago = 'validado';
                            $textoEstado = 'Validado (Pago de Terceros)';
                        }
                        
                        // Calcular progreso basado en estado de inscripción y pago
                        $estadoInscripcion = $inscripcion->estado ?? 'pendiente';
                        $estadoPagoProgress = 'pendiente';
                        
                        if ($inscripcion->pagoInscripcion && $inscripcion->pagoInscripcion->estado_pago === 'pagado') {
                            $estadoPagoProgress = 'pagado';
                        } elseif ($inscripcion->codigo_pago_terceros && $inscripcion->pagoTercero && $inscripcion->pagoTercero->estado_pago === 'validado') {
                            $estadoPagoProgress = 'pagado'; // Tratamos el pago validado de terceros como pagado
                        }
                        
                        $progreso = 25; // Por defecto
                        if ($estadoInscripcion === 'validado' && $estadoPagoProgress === 'pagado') {
                            $progreso = 100;
                        } elseif ($estadoInscripcion === 'validado' || $estadoPagoProgress === 'pagado') {
                            $progreso = 75;
                        } elseif ($estadoInscripcion === 'pendiente' && $estadoPagoProgress === 'pendiente') {
                            $progreso = 50;
                        }
                    @endphp
                            
                            <span class="px-5 py-2 rounded-full text-sm font-semibold flex items-center space-x-2
                                @switch($estadoPago)
                                    @case('pagado')
                                    @case('validado')
                                        bg-green-500/20 text-green-300 border border-green-500/30 shadow-[0_0_15px_rgba(74,222,128,0.2)]
                                        @break
                                    @case('rechazado')
                                        bg-red-500/20 text-red-300 border border-red-500/30 shadow-[0_0_15px_rgba(248,113,113,0.2)]
                                        @break
                                    @default
                                        bg-yellow-500/20 text-yellow-300 border border-yellow-500/30 shadow-[0_0_15px_rgba(234,179,8,0.2)]
                                @endswitch">
                                <span class="w-2 h-2 rounded-full 
                                    @switch($estadoPago)
                                        @case('pagado')
                                        @case('validado') bg-green-400 @break
                                        @case('rechazado') bg-red-400 @break
                                        @default bg-yellow-400
                                    @endswitch"></span>
                                <span>{{ $textoEstado }}</span>
                            </span>
                            
                            @if(($inscripcion->pagoInscripcion && $inscripcion->pagoInscripcion->estado_pago === 'pagado') || ($inscripcion->codigo_pago_terceros && $inscripcion->pagoTercero && $inscripcion->pagoTercero->estado_pago === 'validado'))
                            <a href="{{ route('user.congresos.inscripciones.factura', $inscripcion) }}" 
                               class="w-full flex items-center justify-center space-x-2 px-4 py-2 rounded-lg bg-gradient-to-r from-blue-600/20 to-indigo-600/20 hover:from-blue-600/30 hover:to-indigo-600/30 text-blue-300 hover:text-blue-200 border border-blue-500/30 hover:border-blue-400/50 transition-all duration-300">
                                <i class="fas fa-file-invoice text-sm"></i>
                                <span>Descargar comprobante</span>
                            </a>
                            @elseif((!$inscripcion->pagoInscripcion || $inscripcion->pagoInscripcion->estado_pago === 'pendiente') && !($inscripcion->codigo_pago_terceros && $inscripcion->pagoTercero && $inscripcion->pagoTercero->estado_pago === 'validado'))
                            <div class="space-y-3">
                                <div class="p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                                    <p class="text-yellow-200 text-sm text-center">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Pago pendiente. Selecciona un método de pago:
                                    </p>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-2">
                                    <a href="{{ route('user.congresos.pagos.inscripcion', $inscripcion->convocatoria) }}" 
                                       class="w-full flex items-center justify-center space-x-2 px-3 py-2 rounded-lg bg-gradient-to-r from-blue-600/20 to-blue-700/20 hover:from-blue-600/30 hover:to-blue-700/30 text-blue-300 hover:text-blue-200 border border-blue-500/30 hover:border-blue-400/50 transition-all duration-300">
                                        <i class="fab fa-paypal text-sm"></i>
                                        <span class="text-sm">Pagar con PayPal</span>
                                    </a>
                                    
                                    <a href="{{ route('user.congresos.pagos-terceros.validar') }}" 
                                       class="w-full flex items-center justify-center space-x-2 px-3 py-2 rounded-lg bg-gradient-to-r from-green-600/20 to-green-700/20 hover:from-green-600/30 hover:to-green-700/30 text-green-300 hover:text-green-200 border border-green-500/30 hover:border-green-400/50 transition-all duration-300">
                                        <i class="fas fa-users text-sm"></i>
                                        <span class="text-sm">Validar Código de Terceros</span>
                                    </a>
                                </div>
                            </div>
                            @elseif($inscripcion->pagoInscripcion && $inscripcion->pagoInscripcion->estado_pago === 'rechazado')
                            <div class="p-3 bg-red-500/10 border border-red-500/20 rounded-lg">
                                <p class="text-red-200 text-sm text-center">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Pago rechazado. Contacta al administrador para más información.
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Resumen de estados -->
                    <div class="bg-gray-800/50 rounded-xl p-6 border border-white/10 backdrop-blur-sm">
                        <h3 class="text-lg font-semibold text-white mb-4">Resumen de Estados</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Inscripción</span>
                                <span class="text-sm font-medium
                                    @switch($inscripcion->estado)
                                        @case('validado') text-green-400 @break
                                        @case('pendiente') text-yellow-400 @break
                                        @case('rechazado') text-red-400 @break
                                    @endswitch">
                                    {{ ucfirst($inscripcion->estado) }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Pago</span>
                                <span class="text-sm font-medium
                                    @switch($estadoPago)
                                        @case('pagado')
                                        @case('validado') text-green-400 @break
                                        @case('rechazado') text-red-400 @break
                                        @default text-yellow-400
                                    @endswitch">
                                    {{ $textoEstado }}
                                </span>
                            </div>
                            
                            @if($inscripcion->articulo)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Artículo</span>
                                <div class="flex items-center gap-4">
                                    @if($inscripcion->articulo->archivo_articulo)
                                        <a href="{{ asset($inscripcion->articulo->archivo_articulo) }}" 
                                           target="_blank"
                                           class="text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            <span class="text-sm">Ver</span>
                                        </a>
                                    @endif
                                    <span class="text-sm font-medium
                                        @if($inscripcion->articulo->estado_articulo === 'aceptado') text-green-400
                                        @elseif($inscripcion->articulo->estado_articulo === 'rechazado') text-red-400
                                        @else text-yellow-400
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_articulo)) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-400">Extenso</span>
                                <div class="flex items-center gap-4">
                                    @if($inscripcion->articulo->archivo_extenso)
                                        <a href="{{ asset($inscripcion->articulo->archivo_extenso) }}" 
                                           target="_blank"
                                           class="text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            <span class="text-sm">Ver</span>
                                        </a>
                                    @endif
                                    <span class="text-sm font-medium
                                        @if($inscripcion->articulo->estado_extenso === 'aceptado') text-green-400
                                        @elseif($inscripcion->articulo->estado_extenso === 'rechazado') text-red-400
                                        @elseif($inscripcion->articulo->estado_extenso === 'en_revision') text-blue-400
                                        @else text-yellow-400
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $inscripcion->articulo->estado_extenso)) }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Acciones rápidas -->
                    <div class="bg-gray-800/50 rounded-xl p-6 border border-white/10 backdrop-blur-sm">
                        <h3 class="text-lg font-semibold text-white mb-4">Acciones</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('user.congresos.inscripciones.index') }}" class="block w-full text-left px-4 py-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 text-white/90 hover:text-white transition-all duration-300 flex items-center space-x-3">
                                <i class="fas fa-list text-gray-300"></i>
                                <span>Ver todas mis inscripciones</span>
                            </a>
                        </div>
                    </div>
                </div>
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
</style>
@endsection