@extends('layouts.user')

@section('titulo', 'Congresos Activos')

@section('contenido')
<div class="container mx-auto px-4 sm:px-6 py-16 min-h-screen" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    <div class="relative mb-12 text-center">
        <h1 class="text-5xl font-black bg-gradient-to-r from-orange-400 to-amber-300 bg-clip-text text-transparent mb-2 relative z-10 tracking-tight">Congresos Activos</h1>
        <p class="text-orange-200 text-lg">Participa en Nuestro Primer Congreso</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($congresos as $congreso)
            @if($congreso->estado === 'activo' && $congreso->convocatorias->count() > 0)
                @foreach($congreso->convocatorias as $convocatoria)
                    <div class="bg-gradient-to-br from-gray-900/90 via-gray-800/95 to-gray-900/90 backdrop-blur-xl rounded-2xl overflow-hidden hover:shadow-[0_8px_30px_rgb(251,146,60,0.15)] border border-orange-500/20 transition-all duration-500 ease-out relative group hover:-translate-y-1 hover:border-orange-400/30"
                         x-show="loaded"
                         x-transition:enter="transition-opacity duration-500 ease-out delay-100"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                        <div class="absolute top-4 right-4 z-20">
                            <span class="bg-gradient-to-r from-orange-400/90 to-amber-500/90 text-white text-xs px-4 py-1.5 rounded-full backdrop-blur-sm shadow-lg font-medium">
                                <i class="fas fa-graduation-cap mr-2"></i>Activo
                            </span>
                        </div>

                        @if($convocatoria->imagen_portada)
                            <div class="relative h-56 overflow-hidden" x-data="{ imageLoaded: false }" x-init="setTimeout(() => imageLoaded = true, 500)">
                                <div class="absolute inset-0 bg-gradient-to-br from-gray-700 to-gray-800/60 animate-pulse" x-show="!imageLoaded"></div>
                                <img src="{{ asset($convocatoria->imagen_portada) }}" 
                                     alt="{{ $congreso->nombre }}" 
                                     class="w-full h-56 object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent opacity-90"></div>
                            </div>
                        @else
                            <div class="w-full h-56 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-5xl text-orange-400/40 group-hover:text-orange-400/60 transition-all duration-300 transform group-hover:scale-110"></i>
                            </div>
                        @endif

                        <div class="p-8 text-white space-y-6">
                            <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-400">{{ $congreso->nombre }}</h2>
                            
                            <div class="space-y-3">
                                <div class="flex items-center text-sm text-gray-300 bg-white/5 rounded-lg p-3 backdrop-blur-sm hover:bg-white/10 transition-colors duration-300">
                                    <i class="fas fa-map-marker-alt text-orange-400 mr-3 text-base"></i>
                                    <span>{{ $convocatoria->sede }}</span>
                                </div>

                                <div class="flex items-center text-sm text-gray-300 bg-white/5 rounded-lg p-3 backdrop-blur-sm hover:bg-white/10 transition-colors duration-300">
                                    <i class="fas fa-users text-orange-400 mr-3 text-base"></i>
                                    <span>{{ $convocatoria->dirigido_a }}</span>
                                </div>

                                <div class="flex items-center text-sm text-gray-300 bg-white/5 rounded-lg p-3 backdrop-blur-sm hover:bg-white/10 transition-colors duration-300">
                                    <i class="fas fa-calendar-alt text-orange-400 mr-3 text-base"></i>
                                    <span>{{ \Carbon\Carbon::parse($congreso->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($congreso->fecha_fin)->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            @if($convocatoria->fechasImportantes->isNotEmpty())
                                <div class="border-t border-orange-500/20 pt-4 mt-4">
                                    <h3 class="text-lg font-semibold text-orange-300 mb-4 flex items-center">
                                        <i class="fas fa-calendar-check text-orange-400 mr-2"></i>Fechas Importantes
                                    </h3>
                                    <div class="space-y-3 max-h-32 overflow-y-auto scrollbar-thin scrollbar-thumb-orange-500/20 scrollbar-track-orange-500/5 pr-2">
                                        @foreach($convocatoria->fechasImportantes->take(3) as $fecha)
                                            <div class="flex items-center text-sm text-gray-300 bg-white/5 rounded-lg p-3 backdrop-blur-sm hover:bg-white/10 transition-colors duration-300 border border-transparent hover:border-orange-500/20">
                                                <i class="fas fa-calendar-alt mr-3 text-orange-400"></i>
                                                <span class="font-medium text-orange-200">{{ $fecha->titulo }}:</span>
                                                <span class="ml-2">{{ \Carbon\Carbon::parse($fecha->fecha)->format('d/m/Y') }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-3 mt-6">
                                <a href="{{ route('user.congresos.convocatorias.show', $convocatoria) }}" 
                                   class="inline-flex items-center w-full justify-center px-6 py-3 bg-gradient-to-r from-orange-600/90 to-amber-600/90 text-white rounded-lg hover:from-orange-500/90 hover:to-amber-500/90 transform transition-all duration-300 backdrop-blur-sm font-medium shadow-lg shadow-orange-500/20 group">
                                    <i class="fas fa-info-circle mr-2 group-hover:rotate-12 transition-transform duration-300"></i>Ver Detalles
                                </a>

                                @if($convocatoria->archivo_convocatoria)
                                    <a href="{{ asset($convocatoria->archivo_convocatoria) }}" 
                                       target="_blank"
                                       class="inline-flex items-center w-full justify-center px-6 py-3 bg-red-600/90 text-white rounded-lg hover:bg-red-500/90 transform transition-all duration-200 backdrop-blur-sm font-medium shadow-lg shadow-red-500/20">
                                        <i class="fas fa-file-pdf mr-2"></i>Descargar Convocatoria
                                    </a>
                                @endif

                                <a href="mailto:{{ $convocatoria->contacto_email }}" 
                                    class="mt-4 inline-flex items-center w-full justify-center px-4 py-2 bg-gradient-to-r from-amber-400/90 to-orange-500/90 text-white rounded-lg hover:from-amber-300/90 hover:to-orange-400/90 transform transition-all duration-300 backdrop-blur-sm font-medium shadow-lg shadow-amber-400/20 group">
                                    <i class="fas fa-envelope mr-2 group-hover:rotate-12 transition-transform duration-300"></i>Contáctanos
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @empty
            <div class="col-span-full p-8 text-center">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-8 max-w-2xl mx-auto border border-orange-500/30">
                    <i class="fas fa-graduation-cap text-5xl text-gray-400 mb-4"></i>
                    <h2 class="text-2xl font-semibold text-orange-300 mb-2">No hay congresos activos disponibles</h2>
                    <p class="text-gray-300">En este momento no hay congresos abiertos. Por favor, vuelve a consultar más tarde.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection