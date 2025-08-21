@extends('layouts.admin')

@section('contenido')
<div class="relative z-10 min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <!-- Header con breadcrumb mejorado -->
    <div class="mb-8">
        <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
            <a href="{{ route('admin.concursos.pagos-terceros.index') }}" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                <i class="fas fa-home mr-1"></i>Pagos de Terceros
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-800 dark:text-gray-200 font-medium">Detalles del Pago</span>
        </nav>
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.concursos.pagos-terceros.index') }}" class="group flex items-center space-x-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                    <span>Volver a la lista</span>
                </a>
                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                    <i class="fas fa-trophy text-purple-500"></i>
                    <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pago #{{ $pago->id }}</span>
                </div>
            </div>
            @if($pago->estado_pago == 'pendiente')
                <div class="flex space-x-3">
                    <button onclick="validarPago('validado')" class="group flex items-center space-x-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-check group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Validar Pago</span>
                    </button>
                    <button onclick="validarPago('rechazado')" class="group flex items-center space-x-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-times group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Rechazar Pago</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Tarjeta principal con diseño mejorado -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Header de la tarjeta -->
        <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-pink-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-trophy text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Detalles del Pago - Concurso</h1>
                        <p class="text-purple-100 text-sm mt-1">Información completa del pago de terceros</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl">
                        <span class="text-white text-sm font-medium">ID: #{{ $pago->id }}</span>
                    </div>
                    @if($pago->estado_pago == 'validado')
                        <div class="bg-green-500/20 backdrop-blur-sm px-4 py-2 rounded-xl border border-green-400/30">
                            <i class="fas fa-check-circle text-green-300 mr-2"></i>
                            <span class="text-green-300 text-sm font-medium">Validado</span>
                        </div>
                    @elseif($pago->estado_pago == 'rechazado')
                        <div class="bg-red-500/20 backdrop-blur-sm px-4 py-2 rounded-xl border border-red-400/30">
                            <i class="fas fa-times-circle text-red-300 mr-2"></i>
                            <span class="text-red-300 text-sm font-medium">Rechazado</span>
                        </div>
                    @else
                        <div class="bg-yellow-500/20 backdrop-blur-sm px-4 py-2 rounded-xl border border-yellow-400/30">
                            <i class="fas fa-clock text-yellow-300 mr-2"></i>
                            <span class="text-yellow-300 text-sm font-medium">Pendiente</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="p-8 bg-gray-50 dark:bg-gray-900">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Información del Concurso -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-trophy text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Información del Concurso</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg">
                                <i class="fas fa-award text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Concurso</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pago->concurso->titulo }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg">
                                <i class="fas fa-calendar text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de registro</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pago->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="bg-yellow-100 dark:bg-yellow-900/30 p-2 rounded-lg">
                                <i class="fas fa-dollar-sign text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Monto total</p>
                                <p class="font-bold text-xl text-gray-900 dark:text-gray-100">${{ number_format($pago->monto_total, 2) }}</p>
                            </div>
                        </div>
                        
                        @if($pago->fecha_validacion)
                        <div class="flex items-start space-x-3">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                                <i class="fas fa-check-circle text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de validación</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pago->fecha_validacion->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($pago->codigo_validacion_unico)
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 p-4 rounded-xl border border-purple-200 dark:border-purple-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Código de validación</p>
                                    <p class="font-mono text-lg font-bold text-purple-800 dark:text-purple-300 mt-1">{{ $pago->codigo_validacion_unico }}</p>
                                </div>
                                <button onclick="copyToClipboard('{{ $pago->codigo_validacion_unico }}')" class="bg-purple-500 hover:bg-purple-600 text-white p-2 rounded-lg transition-colors duration-200" title="Copiar código">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                        
                        @if($pago->observacion)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Observación</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $pago->observacion }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Información del Tercero -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-building text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Información del Tercero</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg">
                                <i class="fas fa-user-tie text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tipo</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ ucfirst(str_replace('_', ' ', $pago->tipo_tercero)) }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg">
                                <i class="fas fa-signature text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pago->nombre_tercero }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                                <i class="fas fa-id-card text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">RFC</p>
                                <p class="font-mono font-semibold text-gray-900 dark:text-gray-100">{{ $pago->rfc_tercero }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="bg-yellow-100 dark:bg-yellow-900/30 p-2 rounded-lg">
                                <i class="fas fa-phone text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Contacto</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pago->contacto_tercero }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-lg">
                                <i class="fas fa-envelope text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Correo electrónico</p>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pago->correo_tercero }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles de Cobertura -->
            <div class="mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-shield-alt text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Detalles de Cobertura</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="mx-auto w-16 h-16 {{ $pago->cubre_pre_registro ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-full flex items-center justify-center mb-3">
                                    <i class="fas {{ $pago->cubre_pre_registro ? 'fa-check text-green-600 dark:text-green-400' : 'fa-times text-red-600 dark:text-red-400' }} text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Pre-registro</h4>
                                <p class="text-sm {{ $pago->cubre_pre_registro ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                                    {{ $pago->cubre_pre_registro ? 'Cubierto' : 'No cubierto' }}
                                </p>
                            </div>
                            
                            <div class="text-center">
                                <div class="mx-auto w-16 h-16 {{ $pago->cubre_inscripcion ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-full flex items-center justify-center mb-3">
                                    <i class="fas {{ $pago->cubre_inscripcion ? 'fa-check text-green-600 dark:text-green-400' : 'fa-times text-red-600 dark:text-red-400' }} text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Inscripción</h4>
                                <p class="text-sm {{ $pago->cubre_inscripcion ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                                    {{ $pago->cubre_inscripcion ? 'Cubierta' : 'No cubierta' }}
                                </p>
                            </div>
                            
                            <div class="text-center">
                                <div class="mx-auto w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-users text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Número de pagos</h4>
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $pago->numero_pagos }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($pago->codigo_validacion_unico)
            <!-- Usuarios que utilizaron el código -->
            <div class="mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 p-2 rounded-lg">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-white">Usuarios que utilizaron el código</h3>
                            </div>
                            @php
                                $usuariosPreRegistros = $pago->preRegistros->pluck('usuario')->filter();
                                $usuariosInscripciones = $pago->inscripciones->pluck('usuario')->filter();
                                $todosUsuarios = $usuariosPreRegistros->merge($usuariosInscripciones)->unique('id');
                                $totalUsos = $pago->preRegistros->count() + $pago->inscripciones->count();
                                $porcentajeUso = $pago->numero_pagos > 0 ? ($totalUsos / $pago->numero_pagos) * 100 : 0;
                            @endphp
                            <div class="bg-white/10 backdrop-blur-sm px-4 py-2 rounded-xl">
                                <span class="text-white text-sm font-medium">{{ $totalUsos }}/{{ $pago->numero_pagos }} usos</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Barra de progreso mejorada -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progreso de uso del código</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($porcentajeUso, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-3 rounded-full transition-all duration-500 ease-out" 
                                     style="width: {{ $porcentajeUso }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span>0 usos</span>
                                <span>{{ $pago->numero_pagos }} usos máximos</span>
                            </div>
                        </div>

                        @if($todosUsuarios->count() > 0)
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 text-lg mb-4 flex items-center">
                                    <i class="fas fa-list-ul text-purple-500 mr-2"></i>
                                    Lista de usuarios ({{ $todosUsuarios->count() }})
                                </h4>
                                <div class="grid gap-4">
                                    @foreach($todosUsuarios as $usuario)
                                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 p-4 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="bg-purple-100 dark:bg-purple-900/30 p-2 rounded-full">
                                                        <i class="fas fa-user text-purple-600 dark:text-purple-400"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $usuario->name }}</p>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                                            <i class="fas fa-envelope text-xs mr-1"></i>
                                                            {{ $usuario->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col space-y-1">
                                                    @php
                                                        $preRegistros = $pago->preRegistros->where('usuario_id', $usuario->id);
                                                        $inscripciones = $pago->inscripciones->where('usuario_id', $usuario->id);
                                                    @endphp
                                                    @if($preRegistros->count() > 0)
                                                        <span class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-medium px-3 py-1 rounded-full shadow-sm">
                                                            <i class="fas fa-user-plus mr-1"></i>
                                                            Pre-registro
                                                        </span>
                                                    @endif
                                                    @if($inscripciones->count() > 0)
                                                        <span class="inline-flex items-center bg-gradient-to-r from-green-400 to-emerald-500 text-white text-xs font-medium px-3 py-1 rounded-full shadow-sm">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            Inscripción
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-users text-3xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <h4 class="text-lg font-medium text-gray-600 dark:text-gray-400 mb-2">Sin usuarios registrados</h4>
                                <p class="text-gray-500 dark:text-gray-500">Aún no hay usuarios que hayan utilizado este código de validación</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Comprobante de Pago -->
            <div class="mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-file-invoice text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Comprobante de Pago</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($pago->comprobante_pago)
                            <div class="flex items-center justify-between bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 p-4 rounded-xl border border-blue-200 dark:border-blue-700">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg">
                                        <i class="fas fa-file-pdf text-blue-600 dark:text-blue-400 text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">Comprobante disponible</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Haz clic para ver el documento</p>
                                    </div>
                                </div>
                                <a href="{{ asset($pago->comprobante_pago) }}" target="_blank" class="group flex items-center space-x-2 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2.5 px-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-external-link-alt group-hover:scale-110 transition-transform duration-200"></i>
                                    <span>Ver comprobante</span>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-file-times text-2xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <h4 class="font-medium text-gray-600 dark:text-gray-400 mb-2">Sin comprobante</h4>
                                <p class="text-gray-500 dark:text-gray-500">No hay comprobante de pago disponible</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Validación -->
<div id="modalValidacion" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-gray-900 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-700/50">
            <form id="formValidacion" action="{{ route('admin.concursos.pagos-terceros.update-estado', $pago->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="estado" id="estadoValidacion">
                
                <div class="bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-gray-300">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-300" id="modal-title"></h3>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-700/50">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white sm:ml-3 sm:w-auto sm:text-sm" id="btnConfirmar"></button>
                    <button type="button" onclick="cerrarModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function validarPago(estado) {
        const modal = document.getElementById('modalValidacion');
        const titulo = document.getElementById('modal-title');
        const btnConfirmar = document.getElementById('btnConfirmar');
        const estadoInput = document.getElementById('estadoValidacion');

        estadoInput.value = estado;

        if (estado === 'validado') {
            titulo.textContent = '¿Confirmar validación del pago?';
            btnConfirmar.textContent = 'Validar';
            btnConfirmar.classList.add('bg-green-600', 'hover:bg-green-700');
            btnConfirmar.classList.remove('bg-red-600', 'hover:bg-red-700');
        } else {
            titulo.textContent = '¿Confirmar rechazo del pago?';
            btnConfirmar.textContent = 'Rechazar';
            btnConfirmar.classList.add('bg-red-600', 'hover:bg-red-700');
            btnConfirmar.classList.remove('bg-green-600', 'hover:bg-green-700');
        }

        modal.classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modalValidacion').classList.add('hidden');
    }
</script>
@endsection


