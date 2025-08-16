@extends('layouts.user')

@section('titulo', 'Crear Pre-registro')

@section('contenido')
<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 bg-gradient-to-b from-space-950 to-black">
    <!-- Efectos de fondo -->
    <div class="absolute inset-0 overflow-hidden opacity-20">
        <div class="absolute -top-1/4 -left-1/4 w-[150%] h-[150%] bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-primary-500/10 via-transparent to-transparent animate-pulse-slow"></div>
        <div class="absolute top-1/2 left-1/2 w-96 h-96 rounded-full bg-cyan-500/10 blur-3xl animate-blob-slow transform -translate-x-1/2 -translate-y-1/2"></div>
    </div>

    <div class="w-full max-w-2xl mx-auto z-10">
        <!-- Tarjeta principal -->
        <div class="bg-gradient-to-br from-gray-900/80 to-black/90 backdrop-blur-lg border border-white/10 rounded-xl overflow-hidden shadow-2xl transition-all duration-500 hover:shadow-[0_0_30px_rgba(139,92,246,0.3)] hover:border-purple-400/50">
            <!-- Encabezado -->
            <div class="bg-gradient-to-r from-purple-900/30 to-blue-900/30 border-b border-white/10 p-6">
                <h2 class="text-2xl font-bold text-center text-white">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-cyan-400">Pre-registro para Concurso</span>
                </h2>
            </div>

            <!-- Contenido -->
            <div class="p-6 sm:p-8">
                @if ($errors->any())
                    <div class="bg-red-500/20 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-500/20 border border-green-500/30 text-green-300 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.concursos.pre-registros.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Campo Concurso -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">Concurso</label>
                        <input type="hidden" name="concurso_id" value="{{ $concursos->first()->id }}">
                        <input type="hidden" name="comentarios" value="">
                        <div class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-3 text-white font-medium backdrop-blur-sm">
                            {{ $concursos->first()->titulo }}
                        </div>
                    </div>

                    <!-- Nombre del Equipo -->
                    <div class="space-y-2">
                        <label for="nombre_equipo" class="block text-sm font-medium text-gray-300">Nombre del Equipo</label>
                        <input type="text" name="nombre_equipo" id="nombre_equipo" value="{{ old('nombre_equipo') }}" required
                            class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500">
                    </div>

                    <!-- Número de Integrantes -->
                    <div class="space-y-2">
                        <label for="integrantes" class="block text-sm font-medium text-gray-300">Número de Integrantes</label>
                        <input type="number" name="integrantes" id="integrantes" value="{{ old('integrantes', 1) }}" required min="1" max="5"
                            class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500"
                            onchange="actualizarIntegrantes(this.value)">
                    </div>

                    <!-- Contenedor de Integrantes -->
                    <div id="integrantes-container" class="space-y-4">
                        <!-- Los campos de los integrantes se generarán aquí dinámicamente -->
                    </div>

                    <!-- Asesor -->
                    <div class="space-y-2">
                        <label for="asesor" class="block text-sm font-medium text-gray-300">Asesor</label>
                        <input type="text" name="asesor" id="asesor" value="{{ old('asesor') }}" required
                            class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-orange-500 focus:ring-orange-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-orange-500">
                    </div>

                    <!-- Institución -->
                    <div class="space-y-2">
                        <label for="institucion" class="block text-sm font-medium text-gray-300">Institución</label>
                        <input type="text" name="institucion" id="institucion" value="{{ old('institucion') }}" required
                            class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-orange-500 focus:ring-orange-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-orange-500">
                    </div>

                    <!-- Código de Pago de Terceros -->
                    <div class="space-y-2">
                        <label for="codigo_pago_terceros" class="block text-sm font-medium text-gray-300">Código de Pago de Terceros (Opcional)</label>
                        <input type="text" name="codigo_pago_terceros" id="codigo_pago_terceros" value="{{ old('codigo_pago_terceros') }}"
                            class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-blue-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-blue-500"
                            placeholder="Ingrese el código si realizó pago por transferencia">
                        <p class="text-sm text-gray-400">Solo necesario si realizó el pago por transferencia bancaria</p>
                    </div>

                    <!-- Archivo PDR -->
                    <div class="space-y-2">
                        <label for="archivo_pdr" class="block text-sm font-medium text-gray-300">Archivo PDR (PDF, DOC, DOCX - Max 10MB)</label>
                        <div class="relative">
                            <input type="file" name="archivo_pdr" id="archivo_pdr" accept=".pdf,.doc,.docx" required
                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-orange-500 focus:ring-orange-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-orange-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-orange-500/20 file:text-orange-300 hover:file:bg-orange-500/30">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('user.concursos.pre-registros.index') }}"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 rounded-xl text-sm font-medium text-white bg-gray-800/50 border border-gray-700/50 hover:bg-gray-700/70 hover:border-gray-600/70 transition-all duration-300 hover:shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Cancelar
                        </a>
                        <button type="submit"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 rounded-xl text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 transition-all duration-300 hover:shadow-[0_0_20px_rgba(124,58,237,0.5)]">
                            <i class="fas fa-save mr-2"></i>
                            Crear Pre-registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function actualizarIntegrantes(cantidad) {
        cantidad = Math.min(Math.max(parseInt(cantidad) || 1, 1), 5);
        document.getElementById('integrantes').value = cantidad;
        const container = document.getElementById('integrantes-container');
        container.innerHTML = '';
        
        for (let i = 0; i < cantidad; i++) {
            const integranteHtml = `
                <div class="bg-gray-800/30 p-5 rounded-xl border border-gray-700/50 space-y-4 shadow-lg hover:border-purple-500/50 transition-all duration-300 backdrop-blur-sm">
                    <div class="flex justify-between items-center cursor-pointer p-2 rounded-lg hover:bg-gray-700/30 transition-all duration-300" onclick="toggleIntegrante(${i})">
                        <h3 class="text-white font-medium flex items-center">
                            <span class="w-6 h-6 bg-gradient-to-br from-purple-500/30 to-blue-500/30 rounded-full flex items-center justify-center mr-3">
                                <span class="text-xs">${i+1}</span>
                            </span>
                            Integrante ${i + 1}
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-purple-400 transition-colors">
                            <i id="icon-${i}" class="fas fa-chevron-down transform transition-transform duration-300"></i>
                        </button>
                    </div>
                    
                    <div id="content-${i}" class="space-y-4 transition-all duration-300 overflow-hidden" style="max-height: ${i === 0 ? '500px' : '0px'}">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">Nombre Completo</label>
                            <input type="text" name="integrantes_data[${i}][nombre_completo]" required
                                value="${i === 0 ? '{{ ($user->name) }}' : ''}"
                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-2.5 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">Matrícula</label>
                            <input type="text" name="integrantes_data[${i}][matricula]" required
                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-2.5 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">Carrera</label>
                            <input type="text" name="integrantes_data[${i}][carrera]" required
                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-2.5 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-400">Correo Institucional</label>
                            <input type="email" name="integrantes_data[${i}][correo_institucional]" required
                                value="${i === 0 ? '{{ ($user->email) }}' : ''}"
                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-2.5 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-400">Periodo Académico</label>
                                <input type="number" name="integrantes_data[${i}][periodo_academico]" required min="1"
                                    class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-2.5 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-400">Tipo de Periodo</label>
                                <select name="integrantes_data[${i}][tipo_periodo]" required
                                    class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-2.5 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70">
                                    <option value="semestre">Semestre</option>
                                    <option value="cuatrimestre">Cuatrimestre</option>
                                    <option value="trimestre">Trimestre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', integranteHtml);
            
            // Establecer la rotación inicial del icono
            const icon = document.getElementById(`icon-${i}`);
            icon.style.transform = i === 0 ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    }

    function toggleIntegrante(index) {
        const content = document.getElementById(`content-${index}`);
        const icon = document.getElementById(`icon-${index}`);
        
        if (content.style.maxHeight === '0px') {
            content.style.maxHeight = '500px';
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.style.maxHeight = '0px';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // Inicializar con un integrante al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        actualizarIntegrantes(1);
    });
</script>

<style>
    @keyframes pulse-slow {
        0%, 100% { opacity: 0.1; }
        50% { opacity: 0.3; }
    }
    
    @keyframes blob-slow {
        0%, 100% { transform: translate(-50%, -50%) scale(1); }
        50% { transform: translate(-50%, -50%) scale(1.2); }
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 8s infinite ease-in-out;
    }
    
    .animate-blob-slow {
        animation: blob-slow 12s infinite ease-in-out;
    }
</style>
@endsection