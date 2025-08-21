@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent">Generar Código de Pago por Terceros - Congreso</h1>
            <a href="{{ route('admin.congresos.pagos-terceros.index') }}" class="text-gray-300 hover:text-white flex items-center gap-2 bg-gray-700/50 px-4 py-2 rounded-lg transition-all duration-300 hover:bg-gray-600/50">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a Lista</span>
            </a>
        </div>

        <!-- Formulario de Generación de Código -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-lg p-8">
            <form id="codigoForm" class="space-y-6" enctype="multipart/form-data">
                @csrf
                
                <!-- Seleccionar Congreso -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Seleccionar Congreso</label>
                    <select name="congreso_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2.5 text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                        <option value="" class="text-gray-800">Seleccione un congreso</option>
                        @foreach($congresos as $congreso)
                            <option value="{{ $congreso->id }}" class="text-gray-800">{{ $congreso->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tipo de Tercero -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-300">Tipo de Tercero</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <label class="relative flex items-center justify-center p-4 cursor-pointer bg-gray-700/30 rounded-lg border border-gray-600/50 hover:bg-gray-600/30 transition-all">
                            <input type="radio" name="tipo_tercero" value="universidad" class="sr-only peer" required>
                            <div class="peer-checked:text-blue-400 text-gray-400 text-center">
                                <i class="fas fa-university text-2xl mb-2"></i>
                                <p>Universidad</p>
                            </div>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-400 rounded-lg pointer-events-none"></div>
                        </label>
                        <label class="relative flex items-center justify-center p-4 cursor-pointer bg-gray-700/30 rounded-lg border border-gray-600/50 hover:bg-gray-600/30 transition-all">
                            <input type="radio" name="tipo_tercero" value="empresa" class="sr-only peer" required>
                            <div class="peer-checked:text-blue-400 text-gray-400 text-center">
                                <i class="fas fa-building text-2xl mb-2"></i>
                                <p>Empresa</p>
                            </div>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-400 rounded-lg pointer-events-none"></div>
                        </label>
                        <label class="relative flex items-center justify-center p-4 cursor-pointer bg-gray-700/30 rounded-lg border border-gray-600/50 hover:bg-gray-600/30 transition-all">
                            <input type="radio" name="tipo_tercero" value="persona_fisica" class="sr-only peer" required>
                            <div class="peer-checked:text-blue-400 text-gray-400 text-center">
                                <i class="fas fa-user text-2xl mb-2"></i>
                                <p>Persona Física</p>
                            </div>
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-400 rounded-lg pointer-events-none"></div>
                        </label>
                    </div>
                </div>

                <!-- Información del Tercero -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-300 mb-2">Nombre o Razón Social</label>
                        <input type="text" id="nombre" name="nombre" required class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="rfc" class="block text-sm font-medium text-gray-300 mb-2">RFC</label>
                        <input type="text" id="rfc" name="rfc" required maxlength="13" class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="contacto" class="block text-sm font-medium text-gray-300 mb-2">Nombre del Contacto</label>
                        <input type="text" id="contacto" name="contacto" required class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="correo" class="block text-sm font-medium text-gray-300 mb-2">Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" required class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Tipo de Cobertura -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-300">Tipo de Cobertura</label>
                    <div class="bg-gray-700/30 border border-gray-600/50 rounded-lg p-4 space-y-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="cubre_inscripcion" value="1" checked class="form-checkbox rounded bg-gray-700 border-gray-600 text-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-gray-300 font-medium">Inscripción Completa al Congreso</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-2 ml-6">Incluye acceso completo al congreso y todos los beneficios de participación</p>
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="cubre_articulos" value="1" class="form-checkbox rounded bg-gray-700 border-gray-600 text-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-gray-300 font-medium">Envío de Artículos</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-2 ml-6">Incluye el costo de envío de artículos científicos</p>
                    </div>
                </div>

                <!-- Número de Pagos y Monto -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="numero_pagos" class="block text-sm font-medium text-gray-300 mb-2">Número de Pagos a Cubrir</label>
                        <input type="number" id="numero_pagos" name="numero_pagos" min="1" required class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Indica cuántos participantes cubrirá este pago</p>
                    </div>

                    <div>
                        <label for="monto_total" class="block text-sm font-medium text-gray-300 mb-2">Monto Total</label>
                        <div class="relative">
                            <input type="number" id="monto_total" name="monto_total" min="0" step="0.01" required readonly class="w-full rounded-lg bg-gray-600 border-gray-600 text-gray-300 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm">MXN</span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Monto calculado automáticamente</p>
                    </div>
                </div>

                <!-- Información de Transferencia -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="referencia_transferencia" class="block text-sm font-medium text-gray-300 mb-2">Referencia de Transferencia</label>
                        <input type="text" id="referencia_transferencia" name="referencia_transferencia" class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="fecha_pago" class="block text-sm font-medium text-gray-300 mb-2">Fecha de Pago</label>
                        <input type="date" id="fecha_pago" name="fecha_pago" class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Comprobante de Pago -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Comprobante de Pago</label>
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-600/50 border-dashed rounded-lg hover:border-blue-500/50 transition-all relative">
                        <div class="space-y-1 text-center" id="dropzone-container">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-500"></i>
                            <div class="flex text-sm text-gray-400">
                                <label for="comprobante" class="relative cursor-pointer rounded-md font-medium text-blue-400 hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Subir archivo</span>
                                    <input id="comprobante" name="comprobante" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF hasta 2MB</p>
                        </div>
                        <!-- Previsualización del archivo -->
                        <div id="file-preview" class="hidden w-full">
                            <div class="flex items-center justify-between bg-gray-700/50 p-4 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <i class="fas fa-file text-blue-400 text-2xl"></i>
                                    <div>
                                        <p id="file-name" class="text-gray-300 font-medium"></p>
                                        <p id="file-size" class="text-gray-500 text-sm"></p>
                                    </div>
                                </div>
                                <button type="button" id="remove-file" class="text-red-400 hover:text-red-300 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <!-- Contenedor para la vista previa de imagen -->
                            <div id="image-preview" class="hidden mt-4 rounded-lg overflow-hidden">
                                <img id="preview-img" src="" alt="Vista previa" class="w-full h-auto">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2">
                        <i class="fas fa-code"></i>
                        <span>Generar Código</span>
                    </button>
                    <a href="{{ route('admin.congresos.pagos-terceros.index') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 flex items-center justify-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>Cancelar</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzoneContainer = document.getElementById('dropzone-container');
    const fileInput = document.getElementById('comprobante');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const removeFile = document.getElementById('remove-file');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const form = document.getElementById('codigoForm');

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function handleFile(file) {
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    title: 'Error',
                    text: 'El archivo no debe superar los 2MB',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
                fileInput.value = '';
                return;
            }

            dropzoneContainer.classList.add('hidden');
            filePreview.classList.remove('hidden');
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);

            // Mostrar vista previa para imágenes
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('hidden');
            }
        }
    }

    fileInput.addEventListener('change', function(e) {
        handleFile(this.files[0]);
    });

    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        dropzoneContainer.classList.remove('hidden');
        filePreview.classList.add('hidden');
        imagePreview.classList.add('hidden');
        previewImg.src = '';
    });

    // Soporte para arrastrar y soltar
    const dropZone = document.querySelector('.border-dashed');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-blue-500');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-blue-500');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        fileInput.files = dt.files;
        handleFile(file);
    }

    // Función para calcular el monto total
    function calcularMontoTotal() {
        const congresoSelect = document.querySelector('select[name="congreso_id"]');
        const numeroPagos = document.getElementById('numero_pagos');
        const cubreInscripcion = document.querySelector('input[name="cubre_inscripcion"]');
        const cubreArticulos = document.querySelector('input[name="cubre_articulos"]');
        const montoTotal = document.getElementById('monto_total');
        
        if (!congresoSelect.value || !numeroPagos.value) {
            montoTotal.value = '';
            return;
        }
        
        // Obtener precios del congreso seleccionado
        const congresoId = congresoSelect.value;
        fetch(`/admin/congresos/${congresoId}/precios`)
            .then(response => response.json())
            .then(data => {
                let costoUnitario = 0;
                
                if (cubreInscripcion.checked) {
                    costoUnitario += parseFloat(data.costo_inscripcion || 0);
                }
                
                if (cubreArticulos.checked) {
                    costoUnitario += parseFloat(data.costo_articulos || 0);
                }
                
                const total = costoUnitario * parseInt(numeroPagos.value);
                montoTotal.value = total.toFixed(2);
            })
            .catch(error => {
                console.error('Error al obtener precios:', error);
                montoTotal.value = '';
            });
    }
    
    // Event listeners para recalcular el monto
    document.querySelector('select[name="congreso_id"]').addEventListener('change', calcularMontoTotal);
    document.getElementById('numero_pagos').addEventListener('input', calcularMontoTotal);
    document.querySelector('input[name="cubre_inscripcion"]').addEventListener('change', calcularMontoTotal);
    document.querySelector('input[name="cubre_articulos"]').addEventListener('change', calcularMontoTotal);

    // Envío del formulario
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        try {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Generando código...';
            
            const formData = new FormData(form);
            
            // Manejar checkboxes como en la vista de usuario
            const cubreInscripcion = document.querySelector('input[name="cubre_inscripcion"]');
            const cubreArticulos = document.querySelector('input[name="cubre_articulos"]');
            
            // Eliminar los valores existentes de los checkboxes
            formData.delete('cubre_inscripcion');
            formData.delete('cubre_articulos');
            
            // Agregar valores explícitos
            formData.append('cubre_inscripcion', cubreInscripcion.checked ? '1' : '0');
            formData.append('cubre_articulos', cubreArticulos.checked ? '1' : '0');
            
            const response = await fetch('{{ route("admin.congresos.pagos-terceros.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Código generado exitosamente!',
                    text: `Código de validación: ${data.codigo_validacion}`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = '{{ route("admin.congresos.pagos-terceros.index") }}';
                });
            } else {
                throw new Error(data.message || 'Error al generar el código');
            }
            
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Ocurrió un error al generar el código'
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});
</script>
@endsection