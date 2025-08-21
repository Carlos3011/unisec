@extends('layouts.user')

@section('titulo', 'Inicio')

@section('contenido')
    <!-- Panel de Bienvenida -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div
            class="bg-gradient-to-br from-cosmic-900/80 to-space-900/80 backdrop-blur-lg rounded-3xl shadow-[0_0_30px_rgba(0,0,0,0.3)] p-8 border border-white/5 hover:border-white/10 transition-all duration-500 group">
            <div class="flex items-center justify-between">
                <div class="transform transition-all duration-500 group-hover:translate-x-2">
                    <h1 class="text-4xl font-light text-white mb-3 tracking-wider">Bienvenido, <span
                            class="font-semibold bg-clip-text text-transparent bg-gradient-to-r from-secondary to-primary">{{ Auth::user()->name }}</span>
                    </h1>
                    <div class="text-gray-300 text-lg">Tu portal para explorar el universo y la tecnología espacial</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Tarjeta de Validación de Código Concurso -->
            <a href="{{ route('user.concursos.pagos-terceros.validar') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-emerald-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(16,185,129,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-emerald-500/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-key text-2xl text-emerald-500/80 group-hover:text-emerald-500 transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Concurso</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Código Concurso</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Valida código de concurso</p>
            </a>

            <!-- Tarjeta de Validación de Código Congreso -->
            <a href="{{ route('user.congresos.pagos-terceros.validar') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-blue-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(59,130,246,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-500/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-key text-2xl text-blue-500/80 group-hover:text-blue-500 transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Congreso</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Código Congreso</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Valida código de congreso</p>
            </a>

            <!-- Tarjeta de Eventos -->
            <a href="{{ route('user.eventos') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-secondary/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(99,102,241,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-secondary/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i
                            class="fas fa-calendar-alt text-2xl text-secondary/80 group-hover:text-secondary transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Ver todos</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Mis Eventos</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Gestiona tus inscripciones
                    y horarios</p>
            </a>

            <!-- Tarjeta de Certificados -->
            <a href="{{ route('user.certificados') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-primary/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(59,130,246,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-primary/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i
                            class="fas fa-certificate text-2xl text-primary/80 group-hover:text-primary transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Ver todos</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Certificados</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Accede a tus
                    certificaciones</p>
            </a>

            <!-- Tarjeta de Pagos -->
            <a href="{{ route('user.concursos.pagos-terceros.index') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-accent-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(236,72,153,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-accent-500/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i
                            class="fas fa-credit-card text-2xl text-accent-500/80 group-hover:text-accent-500 transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Ver todos</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Pagos</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Revisa tu historial de
                    pagos</p>
            </a>

            <!-- Tarjeta de Soporte -->
            <a href="{{ route('user.soporte') }}"
                class="group bg-space-900/40 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-cyan-500/50 transition-all duration-500 hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(34,211,238,0.2)]">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-cyan-500/10 rounded-xl group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-headset text-2xl text-cyan-500/80 group-hover:text-cyan-500 transition-colors"></i>
                    </div>
                    <span class="text-gray-300 group-hover:text-white transition-colors duration-500">Ver todos</span>
                </div>
                <h3 class="text-xl font-light text-white mb-2 tracking-wide">Soporte</h3>
                <p class="text-gray-300 group-hover:text-gray-200 transition-colors duration-500">Accede a tus
                    certificaciones</p>
            </a>
        </div>
    </div>

    <!-- Sección de Concursos Activos -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div
            class="bg-gradient-to-br from-space-900/80 to-cosmic-900/80 backdrop-blur-lg rounded-3xl p-8 border border-cyan-500/10 hover:border-cyan-500/20 transition-all duration-500">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-cyan-500/10 rounded-xl">
                        <i class="fas fa-trophy text-2xl text-cyan-400"></i>
                    </div>
                    <h2 class="text-2xl font-light text-white tracking-wider">Concursos Disponibles</h2>
                </div>
                <a href="{{ route('user.concursos.index') }}"
                    class="text-cyan-400/90 hover:text-cyan-400 transition-colors duration-500 flex items-center group">
                    Ver todos
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($concursos as $concurso)
                    @if($concurso->estado === 'activo' && $concurso->convocatorias->count() > 0)
                        @foreach($concurso->convocatorias->take(2) as $convocatoria)
                            <div
                                class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-cyan-500/10 group hover:border-cyan-500/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(34,211,238,0.1)]">
                                <div class="flex items-start justify-between mb-4">
                                    <h3
                                        class="text-xl font-light text-white tracking-wide group-hover:text-cyan-400/90 transition-colors duration-500">
                                        {{ $concurso->titulo }}
                                    </h3>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-cyan-500/20 text-cyan-400">
                                        <i class="fas fa-check-circle mr-1"></i>Activo
                                    </span>
                                </div>
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-map-marker-alt w-5 text-cyan-400"></i>
                                        <span>{{ $convocatoria->sede }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-users w-5 text-cyan-400"></i>
                                        <span>{{ $convocatoria->dirigido_a }}</span>
                                    </div>
                                    @if($convocatoria->fechasImportantes->count() > 0)
                                        <div class="flex items-center text-sm text-gray-300">
                                            <i class="fas fa-calendar w-5 text-cyan-400"></i>
                                            <span>Próxima fecha: {{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->titulo }} -
                                                {{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->fecha->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-envelope w-5 text-cyan-400"></i>
                                        <a href="mailto:{{ $convocatoria->contacto_email }}" class="ml-2 text-cyan-400 hover:underline">
                                            {{ $convocatoria->contacto_email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('user.concursos.convocatorias.show', $convocatoria) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-cyan-500/10 text-cyan-400/90 rounded-xl hover:bg-cyan-500/20 transition-all duration-500">
                                        <i class="fas fa-info-circle mr-2"></i>Ver detalles
                                    </a>
                                    @php
                                        $pagoConfirmado = \App\Models\PagoPaypalConcurso::where('usuario_id', Auth::id())
                                    ->where('tipo_pago', \App\Models\PagoPaypalConcurso::TIPO_PRE_REGISTRO)
                                            ->where('concurso_id', $concurso->id)
                                            ->where('estado_pago', 'pagado')
                                            ->exists();
                                            
                                        // Verificar si el usuario tiene un pago de terceros validado para este concurso
                                        $pagoTercero = \App\Models\PagoTerceroTransferenciaConcurso::where('usuario_id', Auth::id())
                                            ->where('concurso_id', $concurso->id)
                                            ->where('estado_pago', 'validado')
                                            ->where('cubre_pre_registro', true)
                                            ->exists();
                                            
                                        // También verificar si el usuario tiene un pre-registro con código de pago de terceros
                                        $tienePreRegistroConCodigoTercero = \App\Models\PreRegistroConcurso::where('usuario_id', Auth::id())
                                            ->where('concurso_id', $concurso->id)
                                            ->whereNotNull('codigo_pago_terceros')
                                            ->exists();
                                            
                                        // Combinar ambas verificaciones
                                        $pagoTercero = $pagoTercero || $tienePreRegistroConCodigoTercero;
                                            
                                        // Solo mostrar pendiente si no tiene pre-registro con código de terceros
                                        $pagoTerceroPendiente = !$tienePreRegistroConCodigoTercero && \App\Models\PagoTerceroTransferenciaConcurso::where('usuario_id', Auth::id())
                                            ->where('concurso_id', $concurso->id)
                                            ->where('cubre_pre_registro', true)
                                            ->whereIn('estado_pago', ['pendiente', 'en_revision'])
                                            ->exists();
                                            
                                        $tienePreRegistro = \App\Models\PreRegistroConcurso::where('usuario_id', Auth::id())
                                            ->where('concurso_id', $concurso->id)
                                            ->first();
                                    @endphp

                                    @if($pagoTercero)
                                        @if($tienePreRegistro)
                                            <a href="{{ route('user.concursos.pre-registros.show', $tienePreRegistro->id) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-green-500/20 text-green-400 rounded-xl hover:bg-green-500/30 transition-all duration-500">
                                                <i class="fas fa-eye mr-2"></i>Ver Pre-registro
                                            </a>
                                        @else
                                            <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}" 
                                            class="inline-flex items-center justify-center px-4 py-2 bg-cyan-500/20 text-cyan-400 rounded-xl hover:bg-cyan-500/30 transition-all duration-500">
                                                <i class="fas fa-user-plus mr-2"></i>Pre-registrarse
                                            </a>
                                        @endif
                                    @elseif($pagoTerceroPendiente)
                                        <a href="{{ route('user.concursos.pagos-terceros.index') }}" 
                                           class="inline-flex items-center justify-center px-4 py-2 bg-orange-500/20 text-orange-400 rounded-xl hover:bg-orange-500/30 transition-all duration-500">
                                            <i class="fas fa-clock mr-2"></i>Pago en Revisión
                                        </a>
                                    @elseif($pagoConfirmado)
                                        @if($tienePreRegistro)
                                            <a href="{{ route('user.concursos.pre-registros.show', $tienePreRegistro->id) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-green-500/20 text-green-400 rounded-xl hover:bg-green-500/30 transition-all duration-500">
                                                <i class="fas fa-eye mr-2"></i>Ver Pre-registro
                                            </a>
                                        @else
                                            <a href="{{ route('user.concursos.pre-registros.create', ['convocatoria' => $convocatoria->id]) }}" 
                                            class="inline-flex items-center justify-center px-4 py-2 bg-cyan-500/20 text-cyan-400 rounded-xl hover:bg-cyan-500/30 transition-all duration-500">
                                                <i class="fas fa-user-plus mr-2"></i>Pre-registrarse
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('user.concursos.pagos.pre-registro', $convocatoria) }}" 
                                           class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500/20 text-yellow-400 rounded-xl hover:bg-yellow-500/30 transition-all duration-500">
                                            <i class="fas fa-credit-card mr-2"></i>Realizar Pago
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                @empty
                    <div class="col-span-full p-8 text-center">
                        <i class="fas fa-trophy text-4xl text-cyan-600 mb-4"></i>
                        <p class="text-gray-400">No hay concursos activos en este momento</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sección de Congresos Activos -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div
            class="bg-gradient-to-br from-space-900/80 to-cosmic-900/80 backdrop-blur-lg rounded-3xl p-8 border border-purple-400/20 hover:border-purple-400/30 transition-all duration-500">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-purple-400/20 rounded-xl">
                        <i class="fas fa-graduation-cap text-2xl text-purple-300"></i>
                    </div>
                    <h2 class="text-2xl font-light text-white tracking-wider">Congresos Disponibles</h2>
                </div>
                <a href="{{ route('user.congresos.index') }}"
                    class="text-purple-300/90 hover:text-purple-300 transition-colors duration-500 flex items-center group">
                    Ver todos
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($congresos as $congreso)
                    @if($congreso->estado === 'activo' && $congreso->convocatorias->count() > 0)
                        @foreach($congreso->convocatorias->take(2) as $convocatoria)
                            <div
                                class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-purple-400/20 group hover:border-purple-400/40 transition-all duration-500 hover:shadow-[0_0_30px_rgba(192,132,252,0.15)]">
                                <div class="flex items-start justify-between mb-4">
                                    <h3
                                        class="text-xl font-light text-white tracking-wide group-hover:text-purple-300/90 transition-colors duration-500">
                                        {{ $congreso->nombre }}
                                    </h3>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-400/20 text-purple-300">
                                        <i class="fas fa-check-circle mr-1"></i>Activo
                                    </span>
                                </div>
                                <div class="space-y-3 mb-6">
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-map-marker-alt w-5 text-purple-300"></i>
                                        <span>{{ $convocatoria->sede }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-calendar-alt w-5 text-purple-300"></i>
                                        <span>{{ \Carbon\Carbon::parse($congreso->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($congreso->fecha_fin)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-users w-5 text-purple-300"></i>
                                        <span>{{ $convocatoria->dirigido_a }}</span>
                                    </div>
                                    @if($convocatoria->fechasImportantes->count() > 0)
                                        <div class="flex items-center text-sm text-gray-300">
                                            <i class="fas fa-calendar w-5 text-purple-300"></i>
                                            <span>Próxima fecha: {{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->titulo }} -
                                                {{ $convocatoria->fechasImportantes->sortBy('fecha')->first()->fecha->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center text-sm text-gray-300">
                                        <i class="fas fa-envelope w-5 text-purple-300"></i>
                                        <a href="mailto:{{ $convocatoria->contacto_email }}" class="ml-2 text-purple-300 hover:underline">
                                            {{ $convocatoria->contacto_email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <a href="{{ route('user.congresos.convocatorias.show', $convocatoria) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-cyan-500/10 text-cyan-400/90 rounded-xl hover:bg-cyan-500/20 transition-all duration-500">
                                        <i class="fas fa-info-circle mr-2"></i>Ver detalles
                                    </a>
                                    @php
                                        // Verificar si existe una inscripción para este usuario y congreso
                                        $inscripcion = \App\Models\InscripcionCongreso::where('usuario_id', Auth::id())
                                            ->where('congreso_id', $congreso->id)
                                            ->first();
                                            
                                        // Verificar si tiene pago confirmado por PayPal
                                        $pagoPaypalConfirmado = \App\Models\PagoInscripcionCongreso::where('usuario_id', Auth::id())
                                            ->where('congreso_id', $congreso->id)
                                            ->where('estado_pago', 'pagado')
                                            ->exists();
                                            
                                        // Verificar si tiene pago validado por terceros
                                        $pagoTercerosValidado = \App\Models\PagoTerceroTransferenciaCongreso::where('usuario_id', Auth::id())
                                            ->where('congreso_id', $congreso->id)
                                            ->where('estado_pago', 'validado')
                                            ->exists();
                                            
                                        $tienePagoValido = $pagoPaypalConfirmado || $pagoTercerosValidado;
                                        $tieneInscripcion = $inscripcion ? true : false;
                                    @endphp

                                    @if($tieneInscripcion || $tienePagoValido)
                                        @if($tieneInscripcion)
                                            <a href="{{ route('user.congresos.inscripciones.show', $inscripcion->id) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-green-500/20 text-green-400 rounded-xl hover:bg-green-500/30 transition-all duration-500">
                                                <i class="fas fa-eye mr-2"></i>Ver Inscripción
                                            </a>
                                        @else
                                            <a href="{{ route('user.congresos.inscripciones.create', ['convocatoria' => $convocatoria->id]) }}" 
                                            class="inline-flex items-center justify-center px-4 py-2 bg-cyan-500/20 text-cyan-400 rounded-xl hover:bg-cyan-500/30 transition-all duration-500">
                                                <i class="fas fa-user-plus mr-2"></i>Inscribirse
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('user.congresos.pagos.inscripcion', $convocatoria) }}" 
                                           class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500/20 text-yellow-400 rounded-xl hover:bg-yellow-500/30 transition-all duration-500">
                                            <i class="fas fa-credit-card mr-2"></i>Realizar Pago
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                @empty
                    <div class="col-span-full p-8 text-center">
                        <i class="fas fa-graduation-cap text-4xl text-purple-400 mb-4"></i>
                        <p class="text-gray-400">No hay congresos activos en este momento</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sección de Códigos de Pago -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-gradient-to-br from-space-900/80 to-cosmic-900/80 backdrop-blur-lg rounded-3xl p-8 border border-white/5 hover:border-white/10 transition-all duration-500">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-light text-white tracking-wider">Usar Código de Pago</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Tarjeta para Validar Código de Concurso -->
                <div class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-purple-500/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(147,51,234,0.1)]">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-light text-white tracking-wide group-hover:text-purple-500/90 transition-colors duration-500">
                            Validar Código Concurso
                        </h3>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-500/20 text-purple-400">
                            <i class="fas fa-key mr-1"></i>Validar
                        </span>
                    </div>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-user-plus w-4 text-gray-400"></i>
                            <span>Pre-registro</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-clipboard-list w-4 text-gray-400"></i>
                            <span>Inscripción</span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('user.concursos.pagos-terceros.validar') }}" class="w-full inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-purple-600/80 to-blue-600/80 text-white rounded-xl hover:from-purple-600 hover:to-blue-600 transition-all duration-500 transform hover:scale-[1.02] hover:shadow-lg group text-sm">
                            <i class="fas fa-key mr-2 group-hover:scale-110 transition-transform"></i>
                            <span>Validar Código</span>
                        </a>
                    </div>
                </div>

                <!-- Tarjeta para Solicitar Código de Concurso -->
                <div class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-emerald-500/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(16,185,129,0.1)]">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-light text-white tracking-wide group-hover:text-emerald-500/90 transition-colors duration-500">
                            Solicitar Código Concurso
                        </h3>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-500/20 text-emerald-400">
                            <i class="fas fa-plus-circle mr-1"></i>Nuevo
                        </span>
                    </div>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-university w-4 text-gray-400"></i>
                            <span>Instituciones</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-users w-4 text-gray-400"></i>
                            <span>Múltiples usos</span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('user.concursos.pagos-terceros.create') }}" class="w-full inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-emerald-600/80 to-teal-600/80 text-white rounded-xl hover:from-emerald-600 hover:to-teal-600 transition-all duration-500 transform hover:scale-[1.02] hover:shadow-lg group text-sm">
                            <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform"></i>
                            <span>Solicitar Código</span>
                        </a>
                    </div>
                </div>

                <!-- Tarjeta para Validar Código de Congreso -->
                <div class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-blue-500/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(59,130,246,0.1)]">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-light text-white tracking-wide group-hover:text-blue-500/90 transition-colors duration-500">
                            Validar Código Congreso
                        </h3>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-500/20 text-blue-400">
                            <i class="fas fa-key mr-1"></i>Validar
                        </span>
                    </div>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-user-plus w-4 text-gray-400"></i>
                            <span>Inscripción</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-clipboard-list w-4 text-gray-400"></i>
                            <span>Artículos</span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('user.congresos.pagos-terceros.validar') }}" class="w-full inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-blue-600/80 to-cyan-600/80 text-white rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all duration-500 transform hover:scale-[1.02] hover:shadow-lg group text-sm">
                            <i class="fas fa-key mr-2 group-hover:scale-110 transition-transform"></i>
                            <span>Validar Código</span>
                        </a>
                    </div>
                </div>

                <!-- Tarjeta para Solicitar Código de Congreso -->
                <div class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-orange-500/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(249,115,22,0.1)]">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-light text-white tracking-wide group-hover:text-orange-500/90 transition-colors duration-500">
                            Solicitar Código Congreso
                        </h3>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-500/20 text-orange-400">
                            <i class="fas fa-plus-circle mr-1"></i>Nuevo
                        </span>
                    </div>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-university w-4 text-gray-400"></i>
                            <span>Instituciones</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-users w-4 text-gray-400"></i>
                            <span>Múltiples usos</span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('user.congresos.pagos-terceros.create') }}" class="w-full inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-orange-600/80 to-red-600/80 text-white rounded-xl hover:from-orange-600 hover:to-red-600 transition-all duration-500 transform hover:scale-[1.02] hover:shadow-lg group text-sm">
                            <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform"></i>
                            <span>Solicitar Código</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Exploración Espacial -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div
            class="bg-gradient-to-br from-space-900/80 to-cosmic-900/80 backdrop-blur-lg rounded-3xl p-8 border border-white/5 hover:border-white/10 transition-all duration-500">
            <h2 class="text-2xl font-light text-white mb-8 tracking-wider">Exploración Espacial</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Sistema Solar Interactivo -->
                <div
                    class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-secondary/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(99,102,241,0.1)]">
                    <h3
                        class="text-xl font-light text-white mb-4 tracking-wide group-hover:text-secondary/90 transition-colors duration-500">
                        Sistema Solar Interactivo</h3>
                    <p class="text-gray-300 mb-6 group-hover:text-gray-200 transition-colors duration-500">Explora nuestro
                        sistema solar en 3D y aprende sobre los planetas</p>
                    <a href="{{ route('user.espacio')  }}"
                        class="inline-flex items-center px-6 py-2.5 bg-secondary/10 hover:bg-secondary/20 text-secondary rounded-xl transition-all duration-500 group-hover:translate-x-1">
                        <i class="fas fa-globe-americas mr-2 group-hover:animate-pulse"></i>
                        Explorar ahora
                    </a>
                </div>

                <!-- Últimas Noticias Espaciales -->
                <div
                    class="bg-black/20 backdrop-blur-lg rounded-2xl p-6 border border-primary/30 transition-all duration-500 hover:shadow-[0_0_30px_rgba(59,130,246,0.1)]">
                    <h3
                        class="text-xl font-light text-white mb-4 tracking-wide group-hover:text-primary/90 transition-colors duration-500">
                        Últimas Noticias Espaciales</h3>
                    <div class="space-y-4">
                        @forelse($noticias as $noticia)
                            <a href="{{ route('noticias.show', $noticia->id) }}" class="block group/news">
                                <div
                                    class="flex items-center space-x-4 p-2 rounded-xl hover:bg-white/5 transition-colors duration-300">
                                    <div class="flex-shrink-0 w-16 h-16 bg-black/40 rounded-xl overflow-hidden">
                                        @if($noticia->imagen)
                                            <img src="{{ asset( $noticia->imagen) }}" alt="{{ $noticia->titulo }}"
                                                class="w-full h-full object-cover group-hover/news:scale-110 transition-transform duration-500">
                                        @else
                                            <img src="{{ asset('images/exoplanetas.jpg') }}" alt="Imagen por defecto"
                                                class="w-full h-full object-cover group-hover/news:scale-110 transition-transform duration-500">
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-white/90 group-hover/news:text-primary transition-colors duration-500">
                                            {{ Str::limit($noticia->titulo, 80) }}
                                        </h4>
                                        <p class="text-gray-300 text-sm">{{ $noticia->fecha_publicacion->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-300">No hay noticias disponibles</p>
                            </div>
                        @endforelse
                    </div>
                    <a href="{{ route('user.noticias') }}"
                        class="inline-flex items-center mt-6 text-primary/90 hover:text-primary transition-colors duration-500 group-hover:translate-x-1">
                        Ver todas las noticias
                        <i class="fas fa-arrow-right ml-2 group-hover:animate-pulse"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
        <script>
            function copiarCodigo(codigo) {
                navigator.clipboard.writeText(codigo).then(function() {
                    Swal.fire({
                        title: '¡Código Copiado!',
                        text: 'El código ha sido copiado al portapapeles',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#1a1a1a',
                        color: '#fff',
                        iconColor: '#10B981'
                    });
                }).catch(function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo copiar el código',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        background: '#1a1a1a',
                        color: '#fff',
                        iconColor: '#EF4444'
                    });
                });
            }
        </script>
@endsection