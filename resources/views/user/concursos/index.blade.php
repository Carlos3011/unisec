@extends('layouts.user')

@section('titulo', 'Concursos Activos')

@section('contenido')
<div class="container mx-auto px-4 sm:px-6 py-16 min-h-screen" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
    <div class="relative mb-12 text-center">
        <h1 class="text-5xl font-black bg-gradient-to-r from-blue-400 to-purple-300 bg-clip-text text-transparent mb-2 relative z-10 tracking-tight">Concursos Activos</h1>
        <p class="text-blue-200 text-lg">Participa en nuestros concursos de ingeniería aeroespacial</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($concursos as $concurso)
            @if($concurso->estado === 'activo' && $concurso->convocatorias->count() > 0)
                @foreach($concurso->convocatorias as $convocatoria)
                    <div class="bg-gradient-to-br from-gray-800/80 to-gray-900/90 backdrop-blur-lg rounded-2xl overflow-hidden hover:shadow-md hover:border-purple-400/60 transition-all duration-500 ease-out border border-purple-500/40 relative group group-hover:-translate-y-0.5"
                         x-show="loaded"
                         x-transition:enter="transition-opacity duration-500 ease-out delay-100"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                        <div class="absolute top-4 right-4 z-20">
                            <span class="bg-gradient-to-r from-green-500/90 to-emerald-500/90 text-white text-xs px-3 py-1.5 rounded-full backdrop-blur-sm shadow-lg">
                                <i class="fas fa-check-circle mr-1.5"></i>Activo
                            </span>
                        </div>

                        <div class="w-full h-56 relative overflow-hidden">
                            @if($convocatoria->imagen_portada)
                                <img src="{{ asset($convocatoria->imagen_portada) }}" 
                                     alt="{{ $concurso->titulo }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                                    <i class="fas fa-trophy text-4xl text-gray-400/60 group-hover:text-blue-400 transition-transform duration-300"></i>
                                </div>
                            @endif
                        </div>

                        <div class="p-8 text-white">
                            <h2 class="text-2xl font-bold text-white-300 mb-3">{{ $concurso->titulo }}</h2>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-sm text-gray-300 bg-gray-800/30 rounded-md p-2">
                                    <i class="fas fa-map-marker-alt text-blue-400 mr-3 text-base"></i>
                                    <span>{{ $convocatoria->sede }}</span>
                                </div>

                                <div class="flex items-center text-sm text-gray-300 bg-gray-800/30 rounded-md p-2">
                                    <i class="fas fa-users text-blue-400 mr-3 text-base"></i>
                                    <span>{{ $convocatoria->dirigido_a }}</span>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="text-sm text-blue-200 bg-blue-500/10 px-3 py-2 rounded-lg backdrop-blur-sm">
                                            <i class="fas fa-users-cog mr-2"></i>
                                            <span>Máx. {{ $convocatoria->max_integrantes }} integrantes</span>
                                        </div>
                                        @if($convocatoria->archivo_convocatoria)
                                            <a href="{{ asset($convocatoria->archivo_convocatoria) }}" target="_blank" class="text-sm text-red-300 bg-red-500/10 px-3 py-2 rounded-lg backdrop-blur-sm hover:bg-red-500/20 transition-all duration-200">
                                                <i class="fas fa-file-pdf mr-2"></i>
                                                <span>Convocatoria Completa</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($convocatoria->fechasImportantes->count() > 0)
                                <div class="border-t border-blue-500/30 pt-4 mt-4">
                                    <h3 class="text-lg font-semibold text-blue-200 mb-3 flex items-center">
                                        <i class="fas fa-calendar-check text-blue-400 mr-2"></i>Próxima Fecha
                                    </h3>
                                    <div class="flex items-center text-sm text-gray-300 bg-gray-800/20 rounded-md p-2 hover:border-purple-400/30 border border-transparent transition-colors duration-200">
                                        <i class="fas fa-calendar-alt mr-3 text-blue-400"></i>
                                        <span class="font-medium text-blue-200">{{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->titulo }}:</span>
                                        <span class="ml-2">{{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->fecha->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-3 mt-4">
                                <a href="{{ route('user.concursos.convocatorias.show', $convocatoria) }}" 
                                   class="inline-flex items-center w-full justify-center px-6 py-3 bg-blue-600/90 text-white rounded-lg hover:bg-blue-500/90 transform transition-all duration-200 backdrop-blur-sm font-medium shadow-lg shadow-blue-500/20">
                                    <i class="fas fa-info-circle mr-2"></i>Ver Detalles
                                </a>

                                @if($convocatoria->pdf_convocatoria)
                                    <a href="{{ asset($convocatoria->pdf_convocatoria) }}" 
                                       target="_blank"
                                       class="inline-flex items-center w-full justify-center px-6 py-3 bg-red-600/90 text-white rounded-lg hover:bg-red-500/90 transform transition-all duration-200 backdrop-blur-sm font-medium shadow-lg shadow-red-500/20">
                                        <i class="fas fa-file-pdf mr-2"></i>Descargar Convocatoria
                                    </a>
                                @endif

                                @php
                                    $existingPreRegistro = \App\Models\PreRegistroConcurso::where('usuario_id', Auth::id())
                                        ->where('concurso_id', $concurso->id)
                                        ->whereNull('deleted_at')
                                        ->first();
                                @endphp

                                @if($existingPreRegistro)
                                    <a href="{{ route('user.concursos.pre-registros.show', $existingPreRegistro) }}" 
                                       class="inline-flex items-center w-full justify-center px-6 py-3 bg-blue-600/90 text-white rounded-lg hover:bg-blue-500/90 transform transition-all duration-200 backdrop-blur-sm font-medium shadow-lg shadow-purple-500/20">
                                        <i class="fas fa-eye mr-2"></i>Ver Pre-registro
                                    </a>
                                @else
                                    @php
                                        $pagoConfirmado = \App\Models\PagoPaypalConcurso::where('usuario_id', Auth::id())
                                    ->where('tipo_pago', \App\Models\PagoPaypalConcurso::TIPO_PRE_REGISTRO)
                                            ->where('concurso_id', $concurso->id)
                                            ->where('estado_pago', 'pagado')
                                            ->exists();
                                    @endphp
                                    @if($pagoConfirmado)
                                        <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}" 
                                           class="inline-flex items-center w-full justify-center px-6 py-3 bg-blue-600/90 text-white rounded-lg hover:bg-blue-500/90 transform transition-all duration-200 backdrop-blur-sm font-medium shadow-lg shadow-purple-500/20">
                                            <i class="fas fa-user-plus mr-2"></i>Pre-registrarse
                                        </a>
                                    @else
                                        <a href="{{ route('user.concursos.pagos.pre-registro', $convocatoria) }}" 
                                           class="inline-flex items-center w-full justify-center px-6 py-3 bg-yellow-600/90 text-white rounded-lg hover:bg-yellow-500/90 transform transition-all duration-200 backdrop-blur-sm font-medium shadow-lg shadow-purple-500/20">
                                            <i class="fas fa-credit-card mr-2"></i>Realizar Pago
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @empty
            <div class="col-span-full p-8 text-center">
                <i class="fas fa-folder-open text-4xl text-gray-600 mb-4"></i>
                <p class="text-gray-400">No hay concursos activos en este momento</p>
            </div>
        @endforelse
    </div>
</div>
@endsection