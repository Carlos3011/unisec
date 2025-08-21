@extends('layouts.admin')

@section('title', 'Generar Código de Pago - Concursos')

@section('contenido')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Generar Código de Pago</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Crear código único para pago de terceros - Concursos</p>
                    </div>
                </div>
                <a href="{{ route('admin.concursos.pagos-terceros.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-8">
                <form id="pagoForm" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Información del Concurso -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-trophy text-blue-500 mr-2"></i>
                            Información del Concurso
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="concurso_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Concurso *
                                </label>
                                <select id="concurso_id" name="concurso_id" required 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                                    <option value="">Seleccionar concurso...</option>
                                    @foreach($concursos as $concurso)
                                        <option value="{{ $concurso->id }}">{{ $concurso->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Tercero -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-users text-green-500 mr-2"></i>
                            Información del Tercero
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tipo_tercero" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tipo de Tercero *
                                </label>
                                <select id="tipo_tercero" name="tipo_tercero" required 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="universidad">Universidad</option>
                                    <option value="empresa">Empresa</option>
                                    <option value="persona_fisica">Persona Física</option>
                                </select>
                            </div>
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nombre/Razón Social *
                                </label>
                                <input type="text" id="nombre" name="nombre" required 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       placeholder="Ingrese el nombre o razón social">
                            </div>
                            <div>
                                <label for="rfc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    RFC *
                                </label>
                                <input type="text" id="rfc" name="rfc" required maxlength="13"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       placeholder="RFC del tercero">
                            </div>
                            <div>
                                <label for="contacto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Persona de Contacto *
                                </label>
                                <input type="text" id="contacto" name="contacto" required 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       placeholder="Nombre del contacto">
                            </div>
                            <div class="md:col-span-2">
                                <label for="correo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Correo Electrónico *
                                </label>
                                <input type="email" id="correo" name="correo" required 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       placeholder="correo@ejemplo.com">
                            </div>
                        </div>
                    </div>

                    <!-- Información de Cobertura -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-clipboard-list text-purple-500 mr-2"></i>
                            Tipo de Cobertura
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="cubre_pre_registro" name="cubre_pre_registro" value="1"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="cubre_pre_registro" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Pre-registro
                                    </label>
                                    <span id="precio_preregistro" class="ml-2 text-sm text-green-600 font-medium"></span>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="cubre_inscripcion" name="cubre_inscripcion" value="1"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="cubre_inscripcion" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Inscripción
                                    </label>
                                    <span id="precio_inscripcion" class="ml-2 text-sm text-green-600 font-medium"></span>
                                </div>
                            </div>
                            <div>
                                <label for="numero_pagos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Número de Pagos a Cubrir *
                                </label>
                                <input type="number" id="numero_pagos" name="numero_pagos" required min="1" value="1"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                            </div>
                        </div>
                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Monto Total:</span>
                                <span id="monto_total" class="text-lg font-bold text-blue-900 dark:text-blue-100">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Pago -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-credit-card text-orange-500 mr-2"></i>
                            Información de Pago
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="referencia_transferencia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Referencia de Transferencia
                                </label>
                                <input type="text" id="referencia_transferencia" name="referencia_transferencia" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200"
                                       placeholder="Número de referencia">
                            </div>
                            <div>
                                <label for="fecha_pago" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fecha de Pago
                                </label>
                                <input type="date" id="fecha_pago" name="fecha_pago" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                            </div>
                        </div>
                    </div>

                    <!-- Comprobante de Pago -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-file-upload text-red-500 mr-2"></i>
                            Comprobante de Pago
                        </h3>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-400 transition-colors duration-200" 
                             id="dropZone">
                            <input type="file" id="comprobante" name="comprobante" accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                            <div id="dropContent">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-600 dark:text-gray-400 mb-2">Arrastra y suelta tu archivo aquí o</p>
                                <button type="button" onclick="document.getElementById('comprobante').click()" 
                                        class="text-blue-600 hover:text-blue-700 font-medium">selecciona un archivo</button>
                                <p class="text-xs text-gray-500 mt-2">PDF, JPG, JPEG, PNG (máx. 2MB)</p>
                            </div>
                            <div id="filePreview" class="hidden">
                                <div class="flex items-center justify-center space-x-4">
                                    <i class="fas fa-file text-2xl text-blue-500"></i>
                                    <div>
                                        <p id="fileName" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                                        <p id="fileSize" class="text-xs text-gray-500"></p>
                                    </div>
                                    <button type="button" onclick="removeFile()" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.concursos.pagos-terceros.index') }}" 
                           class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors duration-200">
                            Cancelar
                        </a>
                        <button type="submit" id="submitBtn"
                                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-plus mr-2"></i>
                            Generar Código
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Variables globales
let precioPreregistro = 0;
let precioInscripcion = 0;

// Manejo de archivos
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('comprobante');
const dropContent = document.getElementById('dropContent');
const filePreview = document.getElementById('filePreview');

// Eventos de drag and drop
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-blue-400', 'bg-blue-50');
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        handleFile(files[0]);
    }
});

fileInput.addEventListener('change', (e) => {
    if (e.target.files.length > 0) {
        handleFile(e.target.files[0]);
    }
});

function handleFile(file) {
    // Validar tamaño (2MB)
    if (file.size > 2 * 1024 * 1024) {
        Swal.fire({
            icon: 'error',
            title: 'Archivo muy grande',
            text: 'El archivo no debe superar los 2MB'
        });
        return;
    }
    
    // Validar tipo
    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
    if (!allowedTypes.includes(file.type)) {
        Swal.fire({
            icon: 'error',
            title: 'Tipo de archivo no válido',
            text: 'Solo se permiten archivos PDF, JPG, JPEG y PNG'
        });
        return;
    }
    
    // Mostrar preview
    document.getElementById('fileName').textContent = file.name;
    document.getElementById('fileSize').textContent = formatFileSize(file.size);
    dropContent.classList.add('hidden');
    filePreview.classList.remove('hidden');
    
    // Asignar archivo al input
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    fileInput.files = dataTransfer.files;
}

function removeFile() {
    fileInput.value = '';
    dropContent.classList.remove('hidden');
    filePreview.classList.add('hidden');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Obtener precios del concurso
document.getElementById('concurso_id').addEventListener('change', function() {
    const concursoId = this.value;
    if (concursoId) {
        fetch(`/admin/concursos/pagos-terceros/precios/${concursoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error:', data.error);
                    return;
                }
                
                precioPreregistro = parseFloat(data.costo_preregistro) || 0;
                precioInscripcion = parseFloat(data.costo_inscripcion) || 0;
                
                document.getElementById('precio_preregistro').textContent = 
                    precioPreregistro > 0 ? `($${precioPreregistro.toFixed(2)})` : '(Gratis)';
                document.getElementById('precio_inscripcion').textContent = 
                    precioInscripcion > 0 ? `($${precioInscripcion.toFixed(2)})` : '(Gratis)';
                
                calcularMontoTotal();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        document.getElementById('precio_preregistro').textContent = '';
        document.getElementById('precio_inscripcion').textContent = '';
        calcularMontoTotal();
    }
});

// Calcular monto total
function calcularMontoTotal() {
    const cubrePreregistro = document.getElementById('cubre_pre_registro').checked;
    const cubreInscripcion = document.getElementById('cubre_inscripcion').checked;
    const numeroPagos = parseInt(document.getElementById('numero_pagos').value) || 0;
    
    let costoUnitario = 0;
    if (cubrePreregistro) costoUnitario += precioPreregistro;
    if (cubreInscripcion) costoUnitario += precioInscripcion;
    
    const montoTotal = costoUnitario * numeroPagos;
    document.getElementById('monto_total').textContent = `$${montoTotal.toFixed(2)}`;
}

// Event listeners para recalcular
document.getElementById('cubre_pre_registro').addEventListener('change', calcularMontoTotal);
document.getElementById('cubre_inscripcion').addEventListener('change', calcularMontoTotal);
document.getElementById('numero_pagos').addEventListener('input', calcularMontoTotal);

// Envío del formulario
document.getElementById('pagoForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validar que al menos una cobertura esté seleccionada
    const cubrePreregistro = document.getElementById('cubre_pre_registro').checked;
    const cubreInscripcion = document.getElementById('cubre_inscripcion').checked;
    
    if (!cubrePreregistro && !cubreInscripcion) {
        Swal.fire({
            icon: 'warning',
            title: 'Selecciona una cobertura',
            text: 'Debes seleccionar al menos un tipo de cobertura (Pre-registro o Inscripción)'
        });
        return;
    }
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    // Deshabilitar botón y mostrar loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generando...';
    
    const formData = new FormData(this);
    
    // Convertir checkboxes a valores 0/1
    formData.set('cubre_preregistro', cubrePreregistro ? '1' : '0');
    formData.set('cubre_inscripcion', cubreInscripcion ? '1' : '0');
    
    fetch('{{ route("admin.concursos.pagos-terceros.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Código generado exitosamente!',
                html: `<div class="text-center">
                        <p class="mb-4">El código de validación es:</p>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <code class="text-2xl font-bold text-blue-600">${data.codigo_validacion}</code>
                        </div>
                       </div>`,
                confirmButtonText: 'Continuar'
            }).then(() => {
                window.location.href = '{{ route("admin.concursos.pagos-terceros.index") }}';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Ocurrió un error al generar el código'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error inesperado'
        });
    })
    .finally(() => {
        // Restaurar botón
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
@endsection