@extends('layouts.admin')

@section('contenido')
<div class="relative z-10 min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl shadow-2xl p-8 mb-8 border border-gray-700">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4 rounded-xl shadow-lg">
                        <i class="fas fa-user-graduate text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-white mb-2">Detalles de la Inscripción</h1>
                        <p class="text-gray-300 text-lg">Información completa del participante y evaluación</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.congresos.inscripciones.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4 rounded-xl mb-6 shadow-lg border border-green-400" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl mb-6 shadow-lg border border-red-400" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Grid para Información Principal -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
            <!-- Información del Participante -->
            <div class="xl:col-span-2 bg-gray-800 rounded-2xl shadow-lg border border-gray-700 p-8 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-3 rounded-xl mr-4">
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Información del Participante</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-gray-700 rounded-xl p-6 border border-cyan-500">
                        <div class="flex items-center mb-3">
                            <div class="bg-cyan-500 p-2 rounded-lg mr-3">
                                <i class="fas fa-id-card text-white"></i>
                            </div>
                            <label class="text-cyan-300 text-xs font-bold uppercase tracking-wider">Nombre Completo</label>
                        </div>
                        <p class="text-white text-lg font-semibold">{{ $inscripcion->usuario->name }}</p>
                    </div>
                    <div class="bg-gray-700 rounded-xl p-6 border border-indigo-500">
                        <div class="flex items-center mb-3">
                            <div class="bg-indigo-500 p-2 rounded-lg mr-3">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <label class="text-indigo-300 text-xs font-bold uppercase tracking-wider">Correo Electrónico</label>
                        </div>
                        <p class="text-white text-lg font-semibold break-all">{{ $inscripcion->usuario->email }}</p>
                    </div>
                    <div class="bg-gray-700 rounded-xl p-6 border border-purple-500 lg:col-span-2">
                        <div class="flex items-center mb-3">
                            <div class="bg-purple-500 p-2 rounded-lg mr-3">
                                <i class="fas fa-user-tag text-white"></i>
                            </div>
                            <label class="text-purple-300 text-xs font-bold uppercase tracking-wider">Tipo de Participante</label>
                        </div>
                        <div class="flex items-center">
                            <span class="px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-graduation-cap mr-1"></i>{{ ucfirst($inscripcion->tipo_participante) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Congreso -->
            <div class="bg-gray-800 rounded-2xl shadow-lg border border-gray-700 p-8 hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-xl mr-4">
                        <i class="fas fa-calendar-alt text-white text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Información del Congreso</h2>
                </div>
                <div class="space-y-6">
                    <div class="bg-gray-700 rounded-xl p-6 border border-emerald-500">
                        <div class="flex items-center mb-3">
                            <div class="bg-emerald-500 p-2 rounded-lg mr-3">
                                <i class="fas fa-trophy text-white"></i>
                            </div>
                            <label class="text-emerald-300 text-xs font-bold uppercase tracking-wider">Congreso</label>
                        </div>
                        <p class="text-white text-lg font-semibold">{{ $inscripcion->congreso->nombre }}</p>
                    </div>
                    <div class="bg-gray-700 rounded-xl p-6 border border-teal-500">
                        <div class="flex items-center mb-3">
                            <div class="bg-teal-500 p-2 rounded-lg mr-3">
                                <i class="fas fa-calendar-plus text-white"></i>
                            </div>
                            <label class="text-teal-300 text-xs font-bold uppercase tracking-wider">Fecha de Inscripción</label>
                        </div>
                        <p class="text-white text-lg font-semibold">{{ $inscripcion->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Artículo y Evaluación -->
        @if($inscripcion->articulo)
        <div class="bg-gray-800 rounded-2xl shadow-lg border border-gray-700 p-8 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-rose-500 to-pink-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-file-alt text-white text-lg"></i>
                </div>
                <h2 class="text-2xl font-bold text-white">Información del Artículo y Evaluación</h2>
            </div>
            
            <!-- Estados del Artículo -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-700 rounded-xl p-6 border border-rose-500">
                    <div class="flex items-center mb-3">
                        <div class="bg-rose-500 p-2 rounded-lg mr-3">
                            <i class="fas fa-file-check text-white"></i>
                        </div>
                        <label class="text-rose-300 text-xs font-bold uppercase tracking-wider">Estado del Artículo</label>
                    </div>
                    <div class="flex items-center">
                        <span class="px-4 py-2 rounded-full text-sm font-medium inline-block
                            @switch($inscripcion->articulo->estado_articulo)
                                @case('aceptado')
                                    bg-green-100 text-green-800
                                    @break
                                @case('rechazado')
                                    bg-red-100 text-red-800
                                    @break
                                @case('en_revision')
                                    bg-yellow-100 text-yellow-800
                                    @break
                                @default
                                    bg-gray-100 text-gray-800
                            @endswitch">
                            @switch($inscripcion->articulo->estado_articulo)
                                @case('aceptado')
                                    <i class="fas fa-check mr-1"></i>Aceptado
                                    @break
                                @case('rechazado')
                                    <i class="fas fa-times mr-1"></i>Rechazado
                                    @break
                                @case('en_revision')
                                    <i class="fas fa-eye mr-1"></i>En Revisión
                                    @break
                                @default
                                    <i class="fas fa-clock mr-1"></i>Pendiente
                            @endswitch
                        </span>
                    </div>
                </div>
                <div class="bg-gray-700 rounded-xl p-6 border border-pink-500">
                    <div class="flex items-center mb-3">
                        <div class="bg-pink-500 p-2 rounded-lg mr-3">
                            <i class="fas fa-file-contract text-white"></i>
                        </div>
                        <label class="text-pink-300 text-xs font-bold uppercase tracking-wider">Estado del Extenso</label>
                    </div>
                    <div class="flex items-center">
                        <span class="px-4 py-2 rounded-full text-sm font-medium inline-block
                            @switch($inscripcion->articulo->estado_extenso)
                                @case('aceptado')
                                    bg-green-100 text-green-800
                                    @break
                                @case('rechazado')
                                    bg-red-100 text-red-800
                                    @break
                                @case('en_revision')
                                     bg-yellow-100 text-yellow-800
                                     @break
                                 @default
                                     bg-gray-100 text-gray-800
                             @endswitch">
                             @switch($inscripcion->articulo->estado_extenso)
                                 @case('aceptado')
                                     <i class="fas fa-check mr-1"></i>Aceptado
                                     @break
                                 @case('rechazado')
                                     <i class="fas fa-times mr-1"></i>Rechazado
                                     @break
                                 @case('en_revision')
                                     <i class="fas fa-eye mr-1"></i>En Revisión
                                     @break
                                 @default
                                     <i class="fas fa-clock mr-1"></i>Pendiente
                             @endswitch
                         </span>
                     </div>
                 </div>
             </div>
             
             <!-- Comentarios Actuales -->
             <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                 <div class="bg-gray-700 rounded-xl p-6 border border-orange-500">
                     <div class="flex items-center mb-3">
                         <div class="bg-orange-500 p-2 rounded-lg mr-3">
                             <i class="fas fa-comment-alt text-white"></i>
                         </div>
                         <label class="text-orange-300 text-xs font-bold uppercase tracking-wider">Comentarios del Artículo</label>
                     </div>
                     <div class="bg-gray-600 rounded-lg p-4 min-h-[100px]">
                         <p class="text-white text-sm leading-relaxed">{{ $inscripcion->articulo->comentarios_articulo ?: 'Sin comentarios disponibles' }}</p>
                     </div>
                 </div>
                 <div class="bg-gray-700 rounded-xl p-6 border border-amber-500">
                     <div class="flex items-center mb-3">
                         <div class="bg-amber-500 p-2 rounded-lg mr-3">
                             <i class="fas fa-comments text-white"></i>
                         </div>
                         <label class="text-amber-300 text-xs font-bold uppercase tracking-wider">Comentarios del Extenso</label>
                     </div>
                     <div class="bg-gray-600 rounded-lg p-4 min-h-[100px]">
                         <p class="text-white text-sm leading-relaxed">{{ $inscripcion->articulo->comentarios_extenso ?: 'Sin comentarios disponibles' }}</p>
                     </div>
                 </div>
             </div>

            <!-- Formularios de Evaluación -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Formulario de Evaluación de Artículo -->
                <div class="bg-gray-700 rounded-xl p-6 border border-blue-500">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-500 p-2 rounded-lg mr-3">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white">Evaluación del Artículo</h3>
                    </div>
                    <form action="{{ route('admin.congresos.inscripciones.evaluar-articulo', $inscripcion) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="estado_articulo" class="block text-blue-300 text-xs font-bold uppercase tracking-wider mb-2">Estado del Artículo</label>
                            <select name="estado_articulo" id="estado_articulo" class="w-full bg-gray-600 text-white rounded-lg px-4 py-3 border border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="pendiente" {{ $inscripcion->articulo->estado_articulo === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_revision" {{ $inscripcion->articulo->estado_articulo === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                                <option value="aceptado" {{ $inscripcion->articulo->estado_articulo === 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                                <option value="rechazado" {{ $inscripcion->articulo->estado_articulo === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        <div>
                            <label for="comentarios_articulo" class="block text-blue-300 text-xs font-bold uppercase tracking-wider mb-2">Comentarios del Artículo</label>
                            <textarea name="comentarios_articulo" id="comentarios_articulo" rows="4" 
                                      class="w-full bg-gray-600 text-white rounded-lg px-4 py-3 border border-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none" 
                                      placeholder="Ingrese sus comentarios sobre el artículo...">{{ $inscripcion->articulo->comentarios_articulo }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class="fas fa-save mr-2"></i>Actualizar Evaluación del Artículo
                        </button>
                    </form>
                </div>

                <!-- Formulario de Evaluación de Extenso -->
                <div class="bg-gray-700 rounded-xl p-6 border border-green-500">
                    <div class="flex items-center mb-6">
                        <div class="bg-green-500 p-2 rounded-lg mr-3">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white">Evaluación del Extenso</h3>
                    </div>
                    <form action="{{ route('admin.congresos.inscripciones.evaluar-extenso', $inscripcion) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="estado_extenso" class="block text-green-300 text-xs font-bold uppercase tracking-wider mb-2">Estado del Extenso</label>
                            <select name="estado_extenso" id="estado_extenso" class="w-full bg-gray-600 text-white rounded-lg px-4 py-3 border border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                <option value="pendiente" {{ $inscripcion->articulo->estado_extenso === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="en_revision" {{ $inscripcion->articulo->estado_extenso === 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                                <option value="aceptado" {{ $inscripcion->articulo->estado_extenso === 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                                <option value="rechazado" {{ $inscripcion->articulo->estado_extenso === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        <div>
                            <label for="comentarios_extenso" class="block text-green-300 text-xs font-bold uppercase tracking-wider mb-2">Comentarios del Extenso</label>
                            <textarea name="comentarios_extenso" id="comentarios_extenso" rows="4" 
                                      class="w-full bg-gray-600 text-white rounded-lg px-4 py-3 border border-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all resize-none" 
                                      placeholder="Ingrese sus comentarios sobre el extenso...">{{ $inscripcion->articulo->comentarios_extenso }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class="fas fa-save mr-2"></i>Actualizar Evaluación del Extenso
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection