@extends('layouts.user')

@section('titulo', $convocatoria->concurso->titulo)

@section('contenido')
    <div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-300 hover:border-white/20 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
                <!-- Navegación -->
                <div class="p-6">
                    <a href="{{route('user.concursos.index')}}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                        <i class="fas fa-arrow-left"></i>
                        <span>Volver a Convocatorias</span>
                    </a>
                </div>
                <!-- Encabezado de la Convocatoria -->
                <div class="relative overflow-hidden mb-6">
                    @if($convocatoria->imagen_portada)
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                        <img src="{{ asset($convocatoria->imagen_portada) }}" 
                            alt="{{ $convocatoria->concurso->titulo }}" 
                            class="w-full h-80 object-cover">
                    @endif

                    <div class="relative z-20 p-8">
                        <h1 class="text-5xl font-bold text-white mb-4 text-center drop-shadow-lg">{{ $convocatoria->concurso->titulo }}</h1>
                        
                        <!-- Nueva sección de costos destacada -->
                        <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-xl p-6 border border-blue-400/30 hover:border-blue-400/50 transition-all duration-300 transform hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <i class="fas fa-ticket-alt text-blue-400 text-4xl mb-3"></i>
                                    <h3 class="text-xl font-semibold text-white mb-2">Pre-registro</h3>
                                    <p class="text-3xl font-bold text-blue-400">{{ $convocatoria->costo_pre_registro > 0 ? '$' . number_format($convocatoria->costo_pre_registro, 2) : 'Gratuito' }}</p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-xl p-6 border border-purple-400/30 hover:border-purple-400/50 transition-all duration-300 transform hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <i class="fas fa-clipboard-check text-purple-400 text-4xl mb-3"></i>
                                    <h3 class="text-xl font-semibold text-white mb-2">Inscripción</h3>
                                    <p class="text-3xl font-bold text-purple-400">{{ $convocatoria->costo_inscripcion > 0 ? '$' . number_format($convocatoria->costo_inscripcion, 2) : 'Gratuito' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-4 text-sm text-white/90 justify-center">
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="fas fa-rocket text-blue-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $convocatoria->sede }}</span>
                            </div>
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="fas fa-users-gear text-blue-400 text-xl"></i>
                                <span class="text-lg font-medium">{{ $convocatoria->dirigido_a }}</span>
                            </div>
                            <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                <i class="fas fa-user-friends text-blue-400 text-xl"></i>
                                <span class="text-lg font-medium">Máximo {{ $convocatoria->max_integrantes }} integrantes</span>
                            </div>
                            @if($convocatoria->asesor_requerido)
                                <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                    <i class="fas fa-user-astronaut text-blue-400 text-xl"></i>
                                    <span class="text-lg font-medium">Requiere asesor</span>
                                </div>
                            @endif
                            @if($convocatoria->contacto_email)
                                <div class="flex items-center space-x-3 bg-white/5 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-white/10">
                                    <i class="fas fa-envelope text-blue-400 text-xl"></i>
                                    <span class="text-lg font-medium">{{ $convocatoria->contacto_email }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-8 p-8">
                    @if($convocatoria->contacto_email)
                        <div class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-xl p-6 border border-blue-400/30 hover:border-blue-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(59,130,246,0.2)]">
                            <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                                <i class="fas fa-envelope-open mr-3 text-blue-400 text-2xl"></i>Contáctanos
                            </h2>
                            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                                <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10 flex-1">
                                    <p class="mb-4">Para la generación de las ligas de pago, te pedimos que nos escribas desde tu cuenta institucional a este correo.</p>
                                    <a href="mailto:{{ $convocatoria->contacto_email }}" class="text-blue-400 hover:text-blue-300 transition-colors duration-300 flex items-center justify-center gap-2">
                                        <i class="fas fa-paper-plane"></i>
                                        {{ $convocatoria->contacto_email }}
                                    </a>
                                </div>
                                <a href="mailto:{{ $convocatoria->contacto_email }}" aria-label="Contactar por correo electrónico"
                                    class="group relative p-6 min-w-[220px] transition-all duration-500 hover:scale-[1.05] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-space-900 rounded-2xl">
                                    <div class="absolute inset-0 rounded-2xl xl:rounded-3xl overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/90 to-indigo-600/90"></div>
                                        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15"></div>
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400/30 to-indigo-500/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    </div>
                                    <div class="relative flex flex-col items-center space-y-4 z-10">
                                        <div class="p-4 bg-gradient-to-br from-white/15 to-white/25 rounded-full border-2 border-white/30 group-hover:border-blue-300/60 transition-all shadow-lg shadow-blue-500/10 group-hover:shadow-blue-500/30">
                                            <i class="fas fa-envelope text-3xl text-blue-300 group-hover:text-blue-200 transition-colors"></i>
                                        </div>
                                        <span class="text-xl font-bold text-white group-hover:text-blue-100 transition-colors">Enviar correo</span>
                                        <span class="text-sm text-white/90 font-medium text-center">Respuesta rápida</span>
                                        <div class="absolute -bottom-2 h-1 w-16 bg-blue-400 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-y-1"></div>
                                    </div>
                                    <div class="absolute inset-0 rounded-2xl border-2 border-white/20 group-hover:border-blue-300/40 transition-all duration-500"></div>
                                    <div class="absolute inset-0 rounded-2xl shadow-lg opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_30px_-5px_rgba(59,130,246,0.4)] transition-all duration-500"></div>
                                </a>
                            </div>
                        </div>
                    @endif
                    <!-- Fechas Importantes -->
                    <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-xl p-6 border border-blue-400/30 hover:border-blue-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(59,130,246,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-calendar-alt mr-3 text-blue-400 text-2xl"></i>Fechas Importantes
                        </h2>
                        <div class="grid gap-4">
                            @forelse($convocatoria->fechasImportantes as $fecha)
                                <div class="flex items-center justify-between text-white/90 bg-black/30 p-4 rounded-lg border border-white/10 hover:border-blue-400/30 transition-all duration-300">
                                    <span class="text-lg font-medium">{{ $fecha->titulo }}</span>
                                    <span class="text-blue-400 font-semibold">{{ $fecha->fecha->format('d/m/Y') }}</span>
                                </div>
                            @empty
                                <p class="text-white/60 text-center py-4">No hay fechas importantes registradas</p>
                            @endforelse
                        </div>
                    </div>

                    @if($convocatoria->requisitos)
                    <div class="bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-xl p-6 border border-green-400/30 hover:border-green-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(34,197,94,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-clipboard-list mr-3 text-green-400 text-2xl"></i>Requisitos
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->requisitos !!}
                        </div>
                    </div>
                    @endif

                    @if($convocatoria->etapas_mision)
                    <div class="bg-gradient-to-r from-yellow-500/10 to-orange-500/10 rounded-xl p-6 border border-yellow-400/30 hover:border-yellow-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(234,179,8,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-tasks mr-3 text-yellow-400 text-2xl"></i>Etapas de la Misión
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->etapas_mision !!}
                        </div>
                    </div>
                    @endif

                    @if($convocatoria->pruebas_requeridas)
                    <div class="bg-gradient-to-r from-red-500/10 to-pink-500/10 rounded-xl p-6 border border-red-400/30 hover:border-red-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(239,68,68,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-vial mr-3 text-red-400 text-2xl"></i>Pruebas Requeridas
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->pruebas_requeridas !!}
                        </div>
                    </div>
                    @endif

                    @if($convocatoria->documentacion_requerida)
                    <div class="bg-gradient-to-r from-purple-500/10 to-indigo-500/10 rounded-xl p-6 border border-purple-400/30 hover:border-purple-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(147,51,234,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-rocket mr-3 text-purple-400 text-2xl"></i>Documentación Requerida
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->documentacion_requerida !!}
                        </div>
                    </div>
                    @endif

                    @if($convocatoria->criterios_evaluacion)
                    <div class="bg-gradient-to-r from-cyan-500/10 to-blue-500/10 rounded-xl p-6 border border-cyan-400/30 hover:border-cyan-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(34,211,238,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-star mr-3 text-cyan-400 text-2xl"></i>Criterios de Evaluación
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->criterios_evaluacion !!}
                        </div>
                    </div>
                    @endif

                    @if($convocatoria->premiacion)
                    <div class="bg-gradient-to-r from-amber-500/10 to-yellow-500/10 rounded-xl p-6 border border-amber-400/30 hover:border-amber-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(251,191,36,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-trophy mr-3 text-amber-400 text-2xl"></i>Premiación
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->premiacion !!}
                        </div>
                    </div>
                    @endif

                    @if($convocatoria->penalizaciones)
                    <div class="bg-gradient-to-r from-rose-500/10 to-red-500/10 rounded-xl p-6 border border-rose-400/30 hover:border-rose-400/50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(251,113,133,0.2)]">
                        <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-3 text-rose-400 text-2xl"></i>Penalizaciones
                        </h2>
                        <div class="prose prose-lg prose-invert max-w-none text-white/90 text-justify bg-black/30 p-6 rounded-lg border border-white/10">
                            {!! $convocatoria->penalizaciones !!}
                        </div>
                    </div>
                    @endif

                    <!-- Documentos de la Convocatoria -->
                    <div class="bg-white/5 rounded-xl p-6 border border-white/10 transition-all duration-300 hover:bg-white/10 hover:border-white/20">
                        <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <i class="fas fa-file-pdf mr-2 text-blue-400"></i>Documentos de la Misión
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @if($convocatoria->archivo_convocatoria)
                                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-red-400/50 transition-all duration-300">
                                    <div class="flex flex-col items-center text-center space-y-3">
                                        <i class="fas fa-file-pdf text-red-400 text-3xl"></i>
                                        <span class="text-white/90 font-medium">Convocatoria</span>
                                        <a href="{{ asset($convocatoria->archivo_convocatoria) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>Visualizar
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($convocatoria->archivo_pdr)
                                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-blue-400/50 transition-all duration-300">
                                    <div class="flex flex-col items-center text-center space-y-3">
                                        <i class="fas fa-file-pdf text-blue-400 text-3xl"></i>
                                        <span class="text-white/90 font-medium">PDR</span>
                                        <a href="{{ asset($convocatoria->archivo_pdr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>Visualizar
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($convocatoria->archivo_cdr)
                                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-green-400/50 transition-all duration-300">
                                    <div class="flex flex-col items-center text-center space-y-3">
                                        <i class="fas fa-file-pdf text-green-400 text-3xl"></i>
                                        <span class="text-white/90 font-medium">CDR</span>
                                        <a href="{{ asset($convocatoria->archivo_cdr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>Visualizar
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($convocatoria->archivo_pfr)
                                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-purple-400/50 transition-all duration-300">
                                    <div class="flex flex-col items-center text-center space-y-3">
                                        <i class="fas fa-file-pdf text-purple-400 text-3xl"></i>
                                        <span class="text-white/90 font-medium">PFR</span>
                                        <a href="{{ asset($convocatoria->archivo_pfr) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-purple-500/20 text-purple-400 rounded-lg hover:bg-purple-500/30 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>Visualizar
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($convocatoria->archivo_articulo)
                                <div class="bg-black/30 p-4 rounded-xl border border-white/10 hover:border-yellow-400/50 transition-all duration-300">
                                    <div class="flex flex-col items-center text-center space-y-3">
                                        <i class="fas fa-file-pdf text-yellow-400 text-3xl"></i>
                                        <span class="text-white/90 font-medium">Artículo</span>
                                        <a href="{{ asset($convocatoria->archivo_articulo) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500/30 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>Visualizar
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Pre-registro con PayPal -->
        @auth
            @php
                $pagoConfirmado = \App\Models\PagoPaypalConcurso::where('usuario_id', Auth::id())
                            ->where('tipo_pago', \App\Models\PagoPaypalConcurso::TIPO_PRE_REGISTRO)
                    ->where('concurso_id', $convocatoria->concurso->id)
                    ->where('estado_pago', 'pagado')
                    ->exists();
            @endphp
            <div class="fixed bottom-8 right-8 z-50">
                @php
                    $preRegistro = \App\Models\PreRegistroConcurso::where('usuario_id', Auth::id())
                        ->where('concurso_id', $convocatoria->concurso->id)
                        ->first();
                @endphp

                @if($pagoConfirmado)
                    @if($preRegistro)
                        <a href="{{ route('user.concursos.pre-registros.show', $preRegistro->id) }}"
                           class="group flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 rounded-xl text-white font-semibold shadow-lg hover:shadow-emerald-500/25 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-eye text-2xl"></i>
                            <span>Ver Pre-registro</span>
                        </a>
                    @else
                        <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}"
                           class="group flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl text-white font-semibold shadow-lg hover:shadow-blue-500/25 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-user-plus text-2xl"></i>
                            <span>Completar Pre-registro</span>
                        </a>
                    @endif
                @else
                @endif
            </div>
        @else
            <div class="fixed bottom-8 right-8 z-50">
                <a href="{{ route('login') }}" 
                   class="group flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 rounded-xl text-white font-semibold shadow-lg hover:shadow-gray-500/25 transition-all duration-300 hover:scale-105">
                    <i class="fas fa-sign-in-alt text-2xl"></i>
                    <span>Iniciar Sesión para Pre-registrarse</span>
                </a>
            </div>
        @endauth
    </div>
@endsection