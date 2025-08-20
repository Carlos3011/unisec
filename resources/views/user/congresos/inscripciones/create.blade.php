@extends('layouts.user')

@section('titulo', 'Inscripción a Congreso')

@section('contenido')
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 bg-gradient-to-b from-space-950 to-black">
        <!-- Efectos de fondo -->
        <div class="absolute inset-0 overflow-hidden opacity-20">
            <div
                class="absolute -top-1/4 -left-1/4 w-[150%] h-[150%] bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-primary-500/10 via-transparent to-transparent animate-pulse-slow">
            </div>
            <div
                class="absolute top-1/2 left-1/2 w-96 h-96 rounded-full bg-cyan-500/10 blur-3xl animate-blob-slow transform -translate-x-1/2 -translate-y-1/2">
            </div>
        </div>

        <div class="w-full max-w-4xl mx-auto z-10">
            <div
                class="bg-gradient-to-br from-gray-900/80 to-black/90 backdrop-blur-lg border border-white/10 rounded-xl overflow-hidden shadow-2xl transition-all duration-500 hover:shadow-[0_0_30px_rgba(139,92,246,0.3)] hover:border-purple-400/50">
                <!-- Encabezado -->
                <div class="bg-gradient-to-r from-purple-900/30 to-blue-900/30 border-b border-white/10 p-6">
                    <h2 class="text-2xl font-bold text-center text-white">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-cyan-400">Inscripción
                            a Congreso</span>
                    </h2>
                </div>

                <!-- Contenido -->
                <div class="p-6 sm:p-8">

                    @if(session('error'))
                        <div
                            class="bg-red-500/20 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div
                            class="bg-green-500/20 border border-green-500/30 text-green-300 px-4 py-3 rounded-lg mb-6 backdrop-blur-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="inscripcionForm" action="{{ route('user.congresos.inscripciones.store') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="convocatoria_id" value="{{ $convocatoria->id }}">
                        <input type="hidden" name="congreso_id" value="{{ $convocatoria->congreso_id }}">

                        <div
                            class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl shadow-2xl hover:bg-white/15 transition-all duration-300">
                            <h3
                                class="text-2xl font-bold text-white mb-4 bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                                {{ $convocatoria->congreso->nombre }}</h3>
                            <p class="text-gray-200 mb-4 leading-relaxed">{{ $convocatoria->congreso->descripcion }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tipo_participante" class="block text-sm font-medium text-gray-300">
                                    Tipo de Participante
                                </label>
                                <select name="tipo_participante" id="tipo_participante" required
                                    class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500">
                                    <option value="">Seleccione un tipo</option>
                                    <option value="estudiante" {{ old('tipo_participante') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                                    <option value="docente" {{ old('tipo_participante') == 'docente' ? 'selected' : '' }}>
                                        Docente</option>
                                    <option value="investigador" {{ old('tipo_participante') == 'investigador' ? 'selected' : '' }}>Investigador</option>
                                    <option value="profesional" {{ old('tipo_participante') == 'profesional' ? 'selected' : '' }}>Profesional</option>
                                </select>
                                @error('tipo_participante')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="institucion" class="block text-sm font-medium text-gray-300">
                                    Institución
                                </label>
                                <input type="text" name="institucion" id="institucion" required
                                    value="{{ old('institucion') }}"
                                    class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500">
                                @error('institucion')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="comprobante_estudiante_container" class="hidden">
                            <label for="comprobante_estudiante" class="block text-sm font-medium text-gray-300">
                                Comprobante de Estudiante (Kardex o Credencial)
                            </label>
                            <input type="file" name="comprobante_estudiante" id="comprobante_estudiante"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-purple-500/20 file:text-purple-300 hover:file:bg-purple-500/30">
                            <p class="mt-1 text-sm text-gray-400">Formatos permitidos: PDF, JPG, JPEG, PNG. Máximo 2MB</p>
                            @error('comprobante_estudiante')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Código de Pago de Terceros -->
                        <div>
                            <label for="codigo_pago_terceros" class="block text-sm font-medium text-gray-300">
                                Código de Pago de Terceros (Opcional)
                            </label>
                            <input type="text" name="codigo_pago_terceros" id="codigo_pago_terceros" 
                                value="{{ old('codigo_pago_terceros') }}"
                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-blue-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-blue-500"
                                placeholder="Ingrese el código si realizó pago por transferencia">
                            <p class="mt-1 text-sm text-gray-400">Solo necesario si realizó el pago por transferencia bancaria</p>
                            @error('codigo_pago_terceros')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="archivo_articulo" class="block text-sm font-medium text-gray-300">
                                Artículo (Opcional)
                            </label>
                            <input type="file" name="archivo_articulo" id="archivo_articulo" accept=".pdf"
                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-purple-500/20 file:text-purple-300 hover:file:bg-purple-500/30">
                            <p class="mt-1 text-sm text-gray-400">Solo PDF. Máximo 10MB</p>
                            @error('archivo_articulo')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="articulo_fields" class="hidden space-y-4">
                            <div>
                                <label for="titulo_articulo" class="block text-sm font-medium text-gray-300">
                                    Título del Artículo
                                </label>
                                <input type="text" name="titulo_articulo" id="titulo_articulo"
                                    value="{{ old('titulo_articulo') }}"
                                    class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500">
                                @error('titulo_articulo')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Autores del Artículo
                                </label>
                                <div id="autores_container" class="space-y-4">
                                    <div class="autor-item space-y-4 p-4 bg-gray-800/50 rounded-lg">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300">Nombre</label>
                                            <input type="text" name="autores[0][nombre]" required
                                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300">Correo</label>
                                            <input type="email" name="autores[0][correo]" required
                                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-300">Institución</label>
                                            <input type="text" name="autores[0][institucion]" required
                                                class="w-full bg-gray-800/50 border border-gray-700/50 text-white rounded-lg px-4 py-3 focus:border-purple-500 focus:ring-purple-500/50 backdrop-blur-sm transition-all duration-300 hover:border-gray-600/70 focus:hover:border-purple-500">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="agregar_autor"
                                    class="mt-4 px-6 py-3 bg-purple-500/20 border border-purple-500/50 text-purple-300 rounded-lg hover:bg-purple-500/30 hover:border-purple-400 backdrop-blur-sm transition-all duration-300 font-medium">
                                    Agregar Autor
                                </button>
                                @error('autores')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('user.congresos.inscripciones.index') }}"
                                class="px-6 py-3 bg-gray-500/20 border border-gray-500/50 text-gray-300 rounded-lg hover:bg-gray-500/30 hover:border-gray-400 backdrop-blur-sm transition-all duration-300 font-medium">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-purple-500/20 border border-purple-500/50 text-purple-300 rounded-lg hover:bg-purple-500/30 hover:border-purple-400 backdrop-blur-sm transition-all duration-300 font-medium">
                                Crear Inscripción
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const tipoParticipante = document.getElementById('tipo_participante');
                    const comprobanteContainer = document.getElementById('comprobante_estudiante_container');
                    const comprobanteInput = document.getElementById('comprobante_estudiante');
                    const archivoArticulo = document.getElementById('archivo_articulo');
                    const articuloFields = document.getElementById('articulo_fields');
                    const agregarAutorBtn = document.getElementById('agregar_autor');
                    const autoresContainer = document.getElementById('autores_container');
                    const inscripcionForm = document.getElementById('inscripcionForm');
                    let autorCount = 1;

                    // Función para manejar el envío del formulario
                    inscripcionForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        // Mostrar alerta de confirmación
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¿Deseas crear la inscripción?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#9333ea',
                            cancelButtonColor: '#4b5563',
                            confirmButtonText: 'Sí, crear inscripción',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Mostrar alerta de carga
                                Swal.fire({
                                    title: 'Procesando inscripción',
                                    text: 'Por favor espere...',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                // Enviar el formulario vía AJAX
                                const formData = new FormData(inscripcionForm);
                                
                                // Si no hay archivo de artículo, eliminar campos relacionados
                                if (!archivoArticulo.files.length) {
                                    formData.delete('titulo_articulo');
                                    // Eliminar todos los campos de autores
                                    const keys = Array.from(formData.keys());
                                    keys.forEach(key => {
                                        if (key.startsWith('autores[')) {
                                            formData.delete(key);
                                        }
                                    });
                                }

                                fetch(inscripcionForm.action, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                title: '¡Éxito!',
                                                text: data.message,
                                                icon: 'success',
                                                confirmButtonColor: '#9333ea'
                                            }).then(() => {
                                                window.location.href = data.redirect;
                                            });
                                        } else {
                                            Swal.fire({
                                                title: 'Error',
                                                text: 'Hubo un error al crear la inscripción',
                                                icon: 'error',
                                                confirmButtonColor: '#9333ea'
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'Hubo un error al procesar la solicitud',
                                            icon: 'error',
                                            confirmButtonColor: '#9333ea'
                                        });
                                    });
                            }
                        });
                    });

                    function toggleComprobante() {
                        if (tipoParticipante.value === 'estudiante') {
                            comprobanteContainer.classList.remove('hidden');
                            comprobanteInput.required = true;
                        } else {
                            comprobanteContainer.classList.add('hidden');
                            comprobanteInput.required = false;
                            comprobanteInput.value = '';
                        }
                    }

                    function toggleArticuloFields() {
                        if (archivoArticulo.files.length > 0) {
                            articuloFields.classList.remove('hidden');
                            document.getElementById('titulo_articulo').required = true;
                            document.querySelectorAll('[name^="autores"][name$="[nombre]"]').forEach(input => input.required = true);
                            document.querySelectorAll('[name^="autores"][name$="[correo]"]').forEach(input => input.required = true);
                            document.querySelectorAll('[name^="autores"][name$="[institucion]"]').forEach(input => input.required = true);
                        } else {
                            articuloFields.classList.add('hidden');
                            document.getElementById('titulo_articulo').required = false;
                            document.querySelectorAll('[name^="autores"][name$="[nombre]"]').forEach(input => input.required = false);
                            document.querySelectorAll('[name^="autores"][name$="[correo]"]').forEach(input => input.required = false);
                            document.querySelectorAll('[name^="autores"][name$="[institucion]"]').forEach(input => input.required = false);
                        }
                    }

                    function agregarAutor() {
                        const autorItem = document.createElement('div');
                        autorItem.className = 'autor-item space-y-4 p-4 bg-gray-800/50 rounded-lg mt-4';
                        autorItem.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-300">Nombre</label>
                    <input type="text" name="autores[${autorCount}][nombre]" required
                        class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Correo</label>
                    <input type="email" name="autores[${autorCount}][correo]" required
                        class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Institución</label>
                    <input type="text" name="autores[${autorCount}][institucion]" required
                        class="mt-1 block w-full rounded-lg border-gray-600 bg-gray-800/50 text-white shadow-sm focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:bg-gray-700/50">
                </div>
                <button type="button" class="eliminar-autor px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-300">
                    Eliminar Autor
                </button>
            `;

                        autoresContainer.appendChild(autorItem);
                        autorCount++;

                        // Agregar evento para eliminar autor
                        autorItem.querySelector('.eliminar-autor').addEventListener('click', function () {
                            autorItem.remove();
                        });
                    }

                    tipoParticipante.addEventListener('change', toggleComprobante);
                    archivoArticulo.addEventListener('change', toggleArticuloFields);
                    agregarAutorBtn.addEventListener('click', agregarAutor);

                    // Ejecutar al cargar la página
                    toggleComprobante();
                    toggleArticuloFields();
                });
            </script>

            <style>
                @keyframes pulse-slow {

                    0%,
                    100% {
                        opacity: 1;
                    }

                    50% {
                        opacity: 0.5;
                    }
                }

                @keyframes blob-slow {
                    0% {
                        transform: translate(0px, 0px) scale(1);
                    }

                    33% {
                        transform: translate(30px, -50px) scale(1.1);
                    }

                    66% {
                        transform: translate(-20px, 20px) scale(0.9);
                    }

                    100% {
                        transform: translate(0px, 0px) scale(1);
                    }
                }

                .pulse-slow {
                    animation: pulse-slow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
                }

                .blob-slow {
                    animation: blob-slow 7s ease-in-out infinite;
                }
            </style>
@endsection