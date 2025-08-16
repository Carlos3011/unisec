@extends('layouts.public')

@section('titulo', 'Inicio')

@section('contenido')

    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-space-900 via-cosmic-900 to-black py-20 px-6 sm:px-10">

        <div class="max-w-7xl w-full z-10" data-aos="zoom-in-up" data-aos-duration="1000">
            <div class="space-y-10 text-center">
                <!-- Título principal -->
                <h1
                    class="text-5xl sm:text-6xl md:text-7xl font-black bg-gradient-to-r from-primary-400 to-cyan-400 bg-clip-text text-transparent">
                    <span id="typed-text-hover-title"
                        class="inline-block text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-600">
                        Innovación
                    </span>
                </h1>
                <!-- Subtítulo con efecto typed -->
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight">
                    Revolucionando la
                    <span id="typed-text-hover"
                        class="inline-block text-transparent bg-clip-text bg-gradient-to-r from-primary to-cyan-600">
                        <!-- Aquí se inyectará el texto dinámico -->
                    </span>
                </h2>

                <!-- Texto fijo + botones -->
                <div class="space-y-8">
                    <p class="text-lg sm:text-xl text-gray-300/90 max-w-2xl mx-auto text-center leading-relaxed">
                        Convocatorias abiertas: Participa en nuestro Concurso de Innovación y asiste al Congreso Científico.
                    </p>

                    <!-- Card de Anuncio de Cambios de Fechas -->
                    <div class="mb-12 max-w-4xl mx-auto" data-aos="fade-down" data-aos-delay="100">
                        <a href="{{ route("convocatorias.index") }}" class="block group cursor-pointer">
                            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-cyan-400/90 via-cyan-400/70 to-cyan-400/50 p-8 shadow-2xl border-2 border-cyan-400/40 attention-blink transition-all duration-300 group-hover:scale-105 group-hover:shadow-3xl group-hover:border-cyan-300/60">
                            <!-- Efectos de fondo -->
                            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
                            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-400/20 rounded-full blur-3xl transform translate-x-8 -translate-y-8"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-red-400/20 rounded-full blur-2xl transform -translate-x-4 translate-y-4"></div>
                            
                            <!-- Contenido del anuncio -->
                            <div class="relative z-10 text-center">
                                <div class="flex justify-center mb-6">
                                    <div class="p-4 bg-white/20 rounded-full border-2 border-white/40 shadow-lg">
                                        <i class="fas fa-exclamation-triangle text-4xl text-white animate-pulse"></i>
                                    </div>
                                </div>
                                
                                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 drop-shadow-lg">
                                    ¡Atención! Cambios de Fechas
                                </h2>
                                
                                <p class="text-xl text-white/95 mb-6 font-medium leading-relaxed">
                                    Se han actualizado las fechas importantes para concursos y congresos.
                                    <br class="hidden md:block">
                                    Revisa las nuevas fechas en cada convocatoria.
                                </p>
                                
                                <div class="flex flex-col sm:flex-row justify-center gap-4">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-6 py-3 border border-white/30">
                                        <span class="text-white font-semibold text-lg">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            Fechas Actualizadas
                                        </span>
                                    </div>
                                    <div class="bg-white/20 backdrop-blur-sm rounded-xl px-6 py-3 border border-white/30">
                                        <span class="text-white font-semibold text-lg">
                                            <i class="fas fa-bell mr-2"></i>
                                            Revisa tu Convocatoria
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Borde animado -->
                            <div class="absolute inset-0 rounded-3xl border-2 border-white/30 animate-pulse group-hover:border-white/50"></div>
                        </div>
                        </a>
                    </div>

                    <!-- Estilos para el efecto de parpadeo -->
                    <style>
                        @keyframes attention-blink {
                            0%, 5%, 10%, 15%, 100% {
                                opacity: 1;
                                transform: scale(1);
                            }
                            2.5%, 7.5%, 12.5% {
                                opacity: 0.7;
                                transform: scale(0.98);
                            }
                        }
                        
                        .attention-blink {
                            animation: attention-blink 30s infinite;
                        }
                    </style>

                    <div class="flex flex-col sm:flex-row justify-center gap-8 pt-4">
                        <!-- Botón Concurso -->
                        @if($convocatorias->count() > 0)
                            @foreach($convocatorias as $convocatoria)
                                <a href="{{ route('convocatorias.show', $convocatoria) }}" aria-label="Ver detalles del concurso {{ $convocatoria->concurso->titulo }}"
                                    class="group relative p-6 sm:p-8 min-w-[300px] transition-all duration-500 hover:scale-[1.05] focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-space-900 rounded-2xl">
                                    <div class="absolute inset-0 rounded-2xl xl:rounded-3xl overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-600/90 to-accent-600/90"></div>
                                        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15"></div>
                                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-400/30 to-accent-500/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    </div>
                                    <div class="relative flex flex-col items-center space-y-5 z-10">
                                        <div class="p-5 bg-gradient-to-br from-white/15 to-white/25 rounded-full border-2 border-white/30 group-hover:border-cyan-300/60 transition-all shadow-lg shadow-cyan-500/10 group-hover:shadow-cyan-500/30">
                                            <i class="fas fa-microscope text-3xl text-cyan-300 group-hover:text-cyan-200 transition-colors"></i>
                                        </div>
                                        <span class="text-2xl font-bold text-white group-hover:text-cyan-100 transition-colors">{{ $convocatoria->concurso->titulo }}</span>
                                        <span class="text-sm text-white/90 font-medium">Demuestra tu ingenio</span>
                                        <span class="text-base text-white bg-cyan-500/20 px-4 py-1 rounded-full border border-cyan-400/30">Participar ahora</span>
                                        <div class="absolute -bottom-4 h-1.5 w-24 bg-cyan-400 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-y-2"></div>
                                    </div>
                                    <div class="absolute inset-0 rounded-2xl border-2 border-white/20 group-hover:border-cyan-300/40 transition-all duration-500"></div>
                                    <div class="absolute inset-0 rounded-2xl shadow-lg opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_35px_-5px_rgba(34,211,238,0.4)] transition-all duration-500"></div>
                                </a>
                            @endforeach
                        @else
                            <div class="group relative p-6 sm:p-8 min-w-[300px] transition-all duration-500 hover:scale-[1.03]">
                                <div class="absolute inset-0 rounded-2xl xl:rounded-3xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-700/90 to-gray-800/90"></div>
                                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15"></div>
                                </div>
                                <div class="relative flex flex-col items-center space-y-5 z-10">
                                    <div class="p-5 bg-gradient-to-br from-white/10 to-white/15 rounded-full border-2 border-white/15 shadow-lg">
                                        <i class="fas fa-clock text-3xl text-gray-300"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-white">No hay concursos activos</span>
                                    <span class="text-sm text-white/80 font-medium">Próximamente</span>
                                    <span class="text-base text-white/60 bg-gray-500/20 px-4 py-1 rounded-full border border-gray-400/20">Mantente atento</span>
                                </div>
                                <div class="absolute inset-0 rounded-2xl border-2 border-white/15 transition-all duration-500"></div>
                            </div>
                        @endif

                        <!-- Botón de Contacto (Naranja) -->
                        <a href="mailto:unisecmx@unisecmexico.mx" aria-label="Contactar por correo electrónico"
                            class="group relative p-6 sm:p-8 min-w-[300px] transition-all duration-500 hover:scale-[1.05] focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 focus:ring-offset-space-900 rounded-2xl">
                            <div class="absolute inset-0 rounded-2xl xl:rounded-3xl overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/90 to-amber-600/90"></div>
                                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15"></div>
                                <div class="absolute inset-0 bg-gradient-to-br from-orange-400/30 to-amber-500/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>
                            <div class="relative flex flex-col items-center space-y-5 z-10">
                                <div class="p-5 bg-gradient-to-br from-white/15 to-white/25 rounded-full border-2 border-white/30 group-hover:border-orange-300/60 transition-all shadow-lg shadow-orange-500/10 group-hover:shadow-orange-500/30">
                                    <i class="fas fa-envelope text-3xl text-orange-300 group-hover:text-orange-200 transition-colors"></i>
                                </div>
                                <span class="text-2xl font-bold text-white group-hover:text-orange-100 transition-colors">Contáctanos</span>
                                <div class="text-sm text-white/90 font-medium text-center max-w-[220px]">
                                    Para generar las ligas de pago escríbenos desde tu cuenta institucional.
                                </div>
                                <span class="text-base text-white bg-orange-500/20 px-4 py-1 rounded-full border border-orange-400/30">unisecmx@unisecmexico.mx</span>
                                <div class="absolute -bottom-4 h-1.5 w-24 bg-orange-400 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-y-2"></div>
                            </div>
                            <div class="absolute inset-0 rounded-2xl border-2 border-white/20 group-hover:border-orange-300/40 transition-all duration-500"></div>
                            <div class="absolute inset-0 rounded-2xl shadow-lg opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_35px_-5px_rgba(249,115,22,0.4)] transition-all duration-500"></div>
                        </a>

                        <!-- Botón Congreso -->
                        @if($convocatoriasCongreso->count() > 0)
                            @foreach($convocatoriasCongreso as $convocatoriaCongreso)
                                <a href="{{ route('convocatorias.congreso.show', $convocatoriaCongreso) }}" aria-label="Ver detalles del congreso {{ $convocatoriaCongreso->congreso ? $convocatoriaCongreso->congreso->nombre : 'Congreso' }}"
                                    class="group relative p-6 sm:p-8 min-w-[300px] transition-all duration-500 hover:scale-[1.05] focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 focus:ring-offset-space-900 rounded-2xl">
                                    <div class="absolute inset-0 rounded-2xl xl:rounded-3xl overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-purple-600/90 via-indigo-600/90 to-violet-600/90"></div>
                                        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15"></div>
                                        <div class="absolute inset-0 bg-gradient-to-br from-purple-400/30 to-violet-500/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    </div>
                                    <div class="relative flex flex-col items-center space-y-5 z-10">
                                        <div class="p-5 bg-gradient-to-br from-white/15 to-white/25 rounded-full border-2 border-white/30 group-hover:border-purple-300/60 transition-all shadow-lg shadow-purple-500/10 group-hover:shadow-purple-500/30">
                                            <i class="fas fa-atom text-3xl text-purple-300 group-hover:text-purple-200 transition-colors"></i>
                                        </div>
                                        <span class="text-2xl font-bold text-white group-hover:text-purple-100 transition-colors">{{ $convocatoriaCongreso->congreso ? $convocatoriaCongreso->congreso->nombre : 'Congreso no disponible' }}</span>
                                        <span class="text-sm text-white/90 font-medium">Reserva tu participación</span>
                                        <span class="text-base text-white bg-purple-500/20 px-4 py-1 rounded-full border border-purple-400/30">Inscríbete ahora</span>
                                        <div class="absolute -bottom-4 h-1.5 w-24 bg-purple-400 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-y-2"></div>
                                    </div>
                                    <div class="absolute inset-0 rounded-2xl border-2 border-white/20 group-hover:border-purple-300/40 transition-all duration-500"></div>
                                    <div class="absolute inset-0 rounded-2xl shadow-lg opacity-0 group-hover:opacity-100 group-hover:shadow-[0_0_35px_-5px_rgba(147,51,234,0.4)] transition-all duration-500"></div>
                                </a>
                            @endforeach
                        @else
                            <div class="group relative p-6 sm:p-8 min-w-[300px] transition-all duration-500 hover:scale-[1.03]">
                                <div class="absolute inset-0 rounded-2xl xl:rounded-3xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-700/90 to-gray-800/90"></div>
                                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-15"></div>
                                </div>
                                <div class="relative flex flex-col items-center space-y-5 z-10">
                                    <div class="p-5 bg-gradient-to-br from-white/10 to-white/15 rounded-full border-2 border-white/15 shadow-lg">
                                        <i class="fas fa-clock text-3xl text-gray-300"></i>
                                    </div>
                                    <span class="text-2xl font-bold text-white">No hay congresos activos</span>
                                    <span class="text-sm text-white/80 font-medium">Próximamente</span>
                                    <span class="text-base text-white/60 bg-gray-500/20 px-4 py-1 rounded-full border border-gray-400/20">Mantente atento</span>
                                </div>
                                <div class="absolute inset-0 rounded-2xl border-2 border-white/15 transition-all duration-500"></div>
                            </div>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
    </section>



    <!-- SEPARADOR ORGÁNICO -->
    <div class="h-2 bg-space-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
        <div class="absolute inset-0 animate-orbital-movement">
            <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- PROXIMOS EVENTOS -->
    <section id="proximos-eventos" class="py-20 " data-aos="fade-in">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Encabezado de la Sección -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-16">
                <div class="md:w-1/2 mb-8 md:mb-0" data-aos="fade-right">
                    <h2
                        class="text-5xl font-extrabold bg-gradient-to-r from-secondary to-primary bg-clip-text text-transparent mb-6">
                        Próximos Eventos</h2>
                </div>
            </div>

            <!-- Tarjetas de Eventos -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-white mb-6 border-b border-cosmic-600 pb-2">
                    Convocatorias de Concursos
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @if($convocatorias->count() > 0)
                        @foreach($convocatorias as $convocatoria)
                            <div class="relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 200 }}">
                                <div class="bg-cosmic-800/90 backdrop-blur-lg rounded-2xl p-8 border-2 border-cosmic-600 shadow-xl">
                                    <!-- Información Principal -->
                                    <div class="flex items-center justify-between mb-8">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-16 h-16 bg-gradient-to-br from-cosmic-600 to-cosmic-400 rounded-2xl flex items-center justify-center shadow-lg">
                                                <span
                                                    class="text-white font-bold text-2xl">{{ strtoupper(substr($convocatoria->concurso->titulo, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-white mb-1">{{ $convocatoria->concurso->titulo }}
                                                </h3>
                                                <p class="text-white">{{ $convocatoria->sede }}</p>
                                            </div>
                                        </div>
                                        <span
                                            class="text-sm text-white px-4 py-2 rounded-xl font-medium">{{ $convocatoria->dirigido_a }}</span>
                                    </div>

                                    <!-- Información Adicional -->
                                    @if($convocatoria->fechasImportantes->isNotEmpty())
                                        <div class="space-y-3 mb-8">
                                            <h4 class="text-white font-semibold mb-4">Fechas Importantes</h4>
                                            @foreach($convocatoria->fechasImportantes->take(2) as $fecha)
                                                <div class="flex items-center text-sm bg-cosmic-700/50 rounded-xl p-4 border border-cosmic-500">
                                                    <i class="fas fa-calendar-alt text-secondary mr-4 text-lg"></i>
                                                    <div>
                                                        <span class="font-medium text-white">{{ $fecha->titulo }}</span>
                                                        <span
                                                            class="ml-2 text-white">{{ \Carbon\Carbon::parse($fecha->fecha)->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex justify-end">
                                        <a href="{{ route('convocatorias.show', $convocatoria) }}"
                                            class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-400 text-white rounded-xl font-medium shadow-lg transition-colors duration-300">
                                            <i class="fas fa-info-circle mr-2"></i>Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-2 text-center py-12">
                            <div
                                class="bg-cosmic-800/50 backdrop-blur-lg rounded-2xl p-8 max-w-2xl mx-auto border-2 border-cosmic-600">
                                <i class="fas fa-calendar-times text-6xl text-cosmic-400 mb-6"></i>
                                <h2 class="text-2xl font-bold text-white mb-4">No hay eventos próximos</h2>
                                <p class="text-cosmic-200">En este momento no hay eventos programados. Por favor, vuelve a consultar
                                    más tarde.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full border-t border-white-700 my-12"></div>
            
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-white mb-6 border-b border-cosmic-600 pb-2">
                    Convocatorias de Congresos
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @if($convocatoriasCongreso->count() > 0)
                        @foreach($convocatoriasCongreso as $convocatoriaCongreso)
                            <div class="relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 200 }}">
                                <div class="bg-cosmic-800/90 backdrop-blur-lg rounded-2xl p-8 border-2 border-cosmic-600 shadow-xl">
                                    <!-- Información Principal -->
                                    <div class="flex items-center justify-between mb-8">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-16 h-16 bg-gradient-to-br from-cosmic-600 to-cosmic-400 rounded-2xl flex items-center justify-center shadow-lg">
                                                <span
                                                    class="text-white font-bold text-2xl">{{ strtoupper(substr($convocatoriaCongreso->congreso->nombre, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-white mb-1">{{ $convocatoriaCongreso->congreso->nombre }}
                                                </h3>
                                                <p class="text-white">{{ $convocatoriaCongreso->sede }}</p>
                                            </div>
                                        </div>
                                        <span
                                            class="text-sm text-white px-4 py-2 rounded-xl font-medium">{{ $convocatoriaCongreso->dirigido_a }}</span>
                                    </div>

                                    <!-- Información Adicional -->
                                    @if($convocatoriaCongreso->fechasImportantes->isNotEmpty())
                                        <div class="space-y-3 mb-8">
                                            <h4 class="text-white font-semibold mb-4">Fechas Importantes</h4>
                                            @foreach($convocatoriaCongreso->fechasImportantes->take(2) as $fecha)
                                                <div class="flex items-center text-sm bg-cosmic-700/50 rounded-xl p-4 border border-cosmic-500">
                                                    <i class="fas fa-calendar-alt text-secondary mr-4 text-lg"></i>
                                                    <div>
                                                        <span class="font-medium text-white">{{ $fecha->titulo }}</span>
                                                        <span
                                                            class="ml-2 text-white">{{ \Carbon\Carbon::parse($fecha->fecha)->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex justify-end">
                                        <a href="{{ route('convocatorias.congreso.show', $convocatoriaCongreso) }}"
                                            class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-400 text-white rounded-xl font-medium shadow-lg transition-colors duration-300">
                                            <i class="fas fa-info-circle mr-2"></i>Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-2 text-center py-12">
                            <div
                                class="bg-cosmic-800/50 backdrop-blur-lg rounded-2xl p-8 max-w-2xl mx-auto border-2 border-cosmic-600">
                                <i class="fas fa-calendar-times text-6xl text-cosmic-400 mb-6"></i>
                                <h2 class="text-2xl font-bold text-white mb-4">No hay eventos próximos</h2>
                                <p class="text-cosmic-200">En este momento no hay eventos programados. Por favor, vuelve a consultar
                                    más tarde.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full border-t border-white-700 my-12"></div>
            
        </div>
    </section>
    

    <!-- SEPARADOR ORGÁNICO -->
    <div class="h-2 bg-space-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
        <div class="absolute inset-0 animate-orbital-movement">
            <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
        </div>
    </div>



    <!-- Galería de Imágenes -->
    <!-- <section class="py-24 bg-space-700" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <div class="inline-flex relative">
                    <span class="absolute -inset-4 bg-galactic-500/30 blur-3xl rounded-full"></span>
                    <h2 id="typed-text-gallery-title"
                        class="text-5xl sm:text-6xl md:text-7xl bg-gradient-to-r from-secondary to-primary bg-clip-text text-transparent font-bold mb-6 relative">
                        Exploración Visual
                    </h2>
                </div>
                <p class="text-white text-lg max-w-2xl mx-auto">
                    Instantáneas de nuestros logros espaciales y avances tecnológicos
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                @php
                    $imagenes = [
                        [
                            'nombre' => 'Lanzamiento Histórico',
                            'archivo' => 'spacex-rocket.jpg',
                            'descripcion' => 'El despegue que cambió la historia',
                        ],
                        [
                            'nombre' => 'Telescopio James Webb',
                            'archivo' => 'nebulosa-morada.jpg',
                            'descripcion' => 'Explorando el universo con nuevas imágenes',
                        ],
                        [
                            'nombre' => 'Satélite en órbita',
                            'archivo' => 'satelite.jpg',
                            'descripcion' => 'Tecnología avanzada en el espacio',
                        ],
                        [
                            'nombre' => 'La Tierra desde el espacio',
                            'archivo' => 'earth.jpg',
                            'descripcion' => 'Vista única de nuestro planeta',
                        ],
                        [
                            'nombre' => 'Anillos de Saturno',
                            'archivo' => 'saturno.jpg',
                            'descripcion' => 'Impresionante visión del cosmos',
                        ],
                        [
                            'nombre' => 'El sol',
                            'archivo' => 'sol.jpg',
                            'descripcion' => 'Una maravilla del universo profundo',
                        ],
                    ];
                @endphp

                @foreach ($imagenes as $index => $img)
                            @php
                                $rutaImagen = asset('images/space/' . $img['archivo']);

                                
                                $spanClass = match ($index % 6) {
                                    0 => 'lg:col-span-2 lg:row-span-2', 
                                    2, 4 => 'md:col-span-2', 
                                    default => 'col-span-1', 
                                };
                            @endphp

                            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 ease-in-out 
                                                                                    {{ $spanClass }} hover:z-10" data-aos="zoom-in-up"
                                data-aos-delay="{{ $loop->index * 150 }}" data-aos-anchor-placement="top-center">
                                <div class="relative h-full w-full">

                                    
                                    <img src="{{ $rutaImagen }}" alt="{{ $img['nombre'] }}"
                                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500 rounded-xl">

                                    
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div
                                            class="absolute bottom-0 left-0 right-0 p-4 space-y-2 translate-y-6 group-hover:translate-y-0 transition-all duration-500 delay-100">
                                            <h3 class="text-lg md:text-xl font-bold text-white">
                                                {{ $img['nombre'] }}
                                            </h3>
                                            <div class="bg-space-800/80 backdrop-blur-md p-3 rounded-lg">
                                                <p class="text-white text-sm md:text-base">
                                                    {{ $img['descripcion'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                @endforeach
            </div>
        </div>
    </section> -->


    <!-- SECCIÓN NOTICIAS -->
    <section class="relative py-24 bg-gradient-to-br from-cosmic-500 via-cosmic-700 to-black overflow-hidden"
        data-aos="fade-up">
        <div class="container mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-white mb-4">Últimas Noticias</h2>
                <p class="text-xl text-gray-300">Mantente informado sobre las últimas novedades en el sector espacial</p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($noticias as $noticia)
                    <article
                        class="bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-[0_0_30px_rgba(59,130,246,0.5)] hover:ring-2 hover:ring-blue-500/50">
                        @if($noticia->imagen)
                            <img src="{{ asset($noticia->imagen) }}" alt="{{ $noticia->titulo }}" class="w-full h-48 object-cover">
                        @else
                            <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Imagen por defecto"
                                class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ $noticia->titulo }}</h3>
                            <p class="text-gray-300 mb-4 line-clamp-3">
                                {{ Str::limit($noticia->descripcion, 150) }}
                            </p>
                            <div class="flex justify-between items-center text-sm text-gray-400 mb-4">
                                <span>{{ $noticia->fecha_publicacion->format('d/m/Y') }}</span>
                                <span
                                    class="bg-primary/80 px-2 py-1 rounded text-white">{{ $noticia->seccionNoticia->titulo }}</span>
                            </div>
                            <a href="{{ route('noticias.show', $noticia->id) }}"
                                class="inline-block text-primary font-semibold hover:text-primary-light transition-colors duration-200">Leer
                                más →</a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-300 text-xl">No hay noticias disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('blog') }}"
                    class="inline-block px-8 py-3 bg-primary text-white rounded-full hover:bg-primary-dark transition-colors duration-300 transform hover:scale-105">
                    Ver todas las noticias
                </a>
            </div>
        </div>
    </section>


    <!-- SEPARADOR ORGÁNICO -->
    <div class="h-2 bg-space-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
        <div class="absolute inset-0 animate-orbital-movement">
            <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- SECCIÓN DE COLABORACIONES -->
    <section class="py-20  relative overflow-hidden">
        <style>
            .logo-slider {
                background: transparent;
                margin: auto;
                overflow: hidden;
                position: relative;
                width: 100%;
            }

            .logo-slider::before,
            .logo-slider::after {
                background: linear-gradient(to right, rgb(31 41 55 / 0.9) 0%, rgba(31, 41, 55, 0) 100%);
                content: "";
                height: 100%;
                position: absolute;
                width: 200px;
                z-index: 2;
            }

            .logo-slider::after {
                right: 0;
                top: 0;
                transform: rotateZ(180deg);
            }

            .logo-slider::before {
                left: 0;
                top: 0;
            }

            .logo-slide-track {
                animation: logo-scroll 30s linear infinite;
                display: flex;
                width: calc(250px * 26);
            }

            .slide {
                height: 150px;
                width: 250px;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            @keyframes logo-scroll {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(calc(-250px * 8));
                }
            }

            .logo-animation {
                transition: all 0.3s ease;
            }

            .logo-animation:hover {
                filter: brightness(100%);
            }
        </style>
        <!-- Background pattern for depth -->
        <div class="absolute inset-0 bg-[url('/svg/grid.svg')] opacity-10 animate-pulse"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-bold text-white mb-6 relative inline-block">
                    <span class="relative z-10">Nuestra Red Nacional</span>
                    <span
                        class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-cyan-500 to-secondary transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100"></span>
                </h2>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">Colaborando con líderes nacionales en la nueva era
                    espacial</p>
            </div>

            <div class="logo-slider rounded-xl shadow-2xl overflow-hidden">
                <div class="logo-slide-track">
                    <!-- Duplicamos los logos para crear el efecto infinito -->
                    @foreach (array_merge(['buap', 'ECITEC', 'FM', 'iest', 'IPN', 'ITESCA', 'ITPuebla', 'TecNM', 'tecm', 'uac', 'uanl', 'UNAM', 'unisec'], ['buap', 'ECITEC', 'FM', 'iest', 'IPN', 'ITESCA', 'ITPuebla', 'TecNM', 'tecm', 'uac', 'uanl', 'UNAM', 'unisec']) as $logo)
                        <div class="slide">
                            <div class="group h-full w-full">
                                <div
                                    class="relative transform transition-all duration-500 h-full w-full flex items-center justify-center">
                                    <div class="absolute inset-0 bg-white rounded-lg"></div>
                                    <img src="/images/logos/{{ $logo }}.png" alt="{{ strtoupper($logo) }}"
                                        class="h-28 w-auto object-contain relative z-10 filter brightness-90 group-hover:brightness-100 transition-all duration-500 logo-animation mx-auto">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- SEPARADOR ORGÁNICO -->
    <div class="h-2 bg-space-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
        <div class="absolute inset-0 animate-orbital-movement">
            <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    <section class="relative py-24 overflow-hidden " data-aos="fade-up">
        <!-- Efecto de fondo -->
        <div class="absolute inset-0 opacity-20">
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-secondary-500/10 via-galactic-700/20 to-transparent">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-16 relative z-10">
            <!-- Contenedor de texto -->
            <div class="lg:w-1/2" data-aos="fade-right" data-aos-delay="200">
                <div class="relative group">
                    <h2
                        class="text-5xl font-bold bg-gradient-to-r from-accent-300 to-primary bg-clip-text text-transparent mb-8">
                        Consultoría Especializada
                        <span
                            class="absolute -bottom-2 left-0 w-32 h-1 bg-gradient-to-r from-secondary/80 to-transparent rounded-full"></span>
                    </h2>
                </div>

                <p class="text-white text-xl mb-10 leading-relaxed">
                    Apoyamos tu proyecto con la mejor asesoría espacial en el sector cosmonáutico en México.
                </p>

                <ul class="space-y-8 border-l-4 border-secondary/80 pl-8">
                    @foreach ([['title' => 'Planificación Estratégica', 'text' => 'Diseñamos estrategias para alcanzar tus metas espaciales'], ['title' => 'Innovación Tecnológica', 'text' => 'Te ayudamos a implementar tecnología de vanguardia en tus proyectos'], ['title' => 'Formación Profesional', 'text' => 'Capacitamos a tu equipo en las últimas tendencias en ingeniería espacial'], ['title' => 'Colaboración Internacional', 'text' => 'Facilitamos alianzas estratégicas a nivel global para potenciar tu proyecto']] as $index => $item)
                        <li class="relative pl-4 group" data-aos="fade-up" data-aos-delay="{{ 300 + $index * 100 }}">
                            <div
                                class="absolute -left-4 top-0 h-full w-1 bg-secondary-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div class="flex items-start space-x-4 hover:translate-x-4 transition-transform duration-300">
                                <div class="relative mt-1">
                                    <div
                                        class="absolute inset-0 bg-accent-700 rounded-full blur group-hover:blur-lg transition-all duration-300">
                                    </div>
                                    <svg class="w-8 h-8 text-accent-300 p-1.5 relative" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-tech-100 mb-2">{{ $item['title'] }}</h3>
                                    <p class="text-tech-300 leading-relaxed">{{ $item['text'] }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contenedor de imagen -->
            <div class="lg:w-1/2" data-aos="fade-left" data-aos-delay="300">
                <div
                    class="relative rounded-2xl overflow-hidden shadow-2xl hover:shadow-secondary-500/20 transition-all duration-500 group">
                    <!-- Efecto de brillo dinámico -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div
                            class="absolute -inset-24 bg-[conic-gradient(from_90deg_at_50%_50%,#FF580030_0%,#00B4D840_50%,#FF580030_100%)] animate-spin-slow">
                        </div>
                    </div>

                    <div class="relative z-10">
                        <img src="{{ asset('images/space/spacex-rocket.jpg') }}" alt="Lanzamiento de cohete"
                            class="w-full h-[600px] object-cover rounded-2xl transform transition-transform duration-700 group-hover:scale-105">

                        <!-- Superposición y badge -->
                        <div class="absolute inset-0 bg-gradient-to-t from-secondary-100/70 to-transparent"></div>
                        <div class="absolute bottom-8 left-8">
                            <div class="bg-secondary-500/90 px-4 py-2 rounded-full backdrop-blur-sm">
                                <span class="text-sm font-semibold text-galactic-700">+15 años de experiencia</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elemento decorativo flotante -->
        <div class="absolute right-24 top-1/4 opacity-10 animate-float">
            <svg class="w-48 h-48 text-accent-300/20" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 4.75L19.25 9L12 13.25L4.75 9L12 4.75Z" />
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9.25 12L4.75 15L12 19.25L19.25 15L14.75 12" />
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9.25 12L12 13.25L14.75 12" />
            </svg>
        </div>
    </section>

    <!-- SEPARADOR ORGÁNICO -->
    <div class="h-2 bg-space-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 opacity-50"></div>
        <div class="absolute inset-0 animate-orbital-movement">
            <div class="w-48 h-48 bg-secondary/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    <!-- Galería de Videos Mejorada y Responsiva -->
    <section class="py-16 bg-gradient-to-br relative overflow-hidden" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <!-- Encabezado con animación -->
            <div class="text-center mb-12">
                <div class="inline-flex relative">
                    <span class="absolute -inset-4 bg-galactic-500/50 blur-3xl rounded-full"></span>
                    <h2 id="typed-text-gallery-title"
                        class="text-4xl sm:text-5xl md:text-6xl bg-gradient-to-r from-cyan-500 to-secondary bg-clip-text text-transparent font-bold mb-6 relative">
                        Galería de Videos
                    </h2>
                </div>
                <p class="text-base sm:text-lg text-tech-300 max-w-2xl mx-auto">
                    Descubre nuestros contenidos destacados y sumérgete en el universo
                </p>
            </div>

            <!-- Video Principal -->
            <div class="mb-8 relative group">
                <div
                    class="aspect-video bg-gray-800 rounded-xl overflow-hidden shadow-xl transition-transform duration-300 hover:scale-[1.02]">
                    <iframe id="main-video-player" class="w-full h-full"
                        src="https://www.youtube.com/embed/hI9HQfCAw64?modestbranding=1&rel=0" frameborder="0"
                        allowfullscreen loading="lazy"></iframe>
                </div>
            </div>

            <!-- Carrusel de Videos -->
            <div class="flex overflow-x-auto pb-6 space-x-4 scrollbar-hide" id="video-carousel">
                @foreach ([['id' => '3g8i7fFp5bc', 'title' => 'Long March-6A launches SpaceSail Polar Orbit 01'], ['id' => 'gmA1Gr_JNio', 'title' => 'Una vista de satelites orbitando desde un órbita baja'], ['id' => 'px31OjiqoNM', 'title' => 'Comunicaciones Satelitales Avanzadas'], ['id' => '5voQfQOTem8', 'title' => '¿Cómo construir un satélite?']] as $video)
                    <div class="flex-shrink-0 w-52 sm:w-64 cursor-pointer video-carousel-item transition-all duration-300 border border-tech-500 rounded-lg overflow-hidden bg-tech-700 hover:scale-105"
                        data-video-id="{{ $video['id'] }}">
                        <div class="aspect-video bg-gray-800 relative">
                            <img src="https://img.youtube.com/vi/{{ $video['id'] }}/hqdefault.jpg" alt="{{ $video['title'] }}"
                                class="w-full h-full object-cover opacity-90 hover:opacity-100 transition-opacity">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <button class="text-white bg-black/50 rounded-full p-3 hover:bg-black/70 transition-all">
                                    <i class="fas fa-play text-xl"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-3 bg-cosmic-500">
                            <h3 class="text-sm sm:text-md font-semibold text-primary line-clamp-2">
                                {{ $video['title'] }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Efecto Nebulosa -->
        <div class="absolute inset-0 bg-gradient-to-br from-galactic-700 to-cosmic-500 opacity-20 pointer-events-none">
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carouselItems = document.querySelectorAll('.video-carousel-item');
            const mainVideo = document.getElementById('main-video-player');

            carouselItems.forEach(item => {
                item.addEventListener('click', function () {
                    const videoId = this.dataset.videoId;
                    mainVideo.src =
                        `https://www.youtube.com/embed/${videoId}?autoplay=1&modestbranding=1&rel=0`;
                });
            });
        });
        </script>

        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }

            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .video-carousel-item:hover {
                transform: translateY(-3px);
                box-shadow: 0 0 10px rgba(0, 180, 216, 0.5);
            }

            #video-carousel {
                scroll-behavior: smooth;
            }
        </style>
    </section>
    
@endsection