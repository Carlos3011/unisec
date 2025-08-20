@extends('layouts.admin')

@section('contenido')
<div class="relative z-10">
    <div class="mb-6">
        <a href="{{ route('admin.congresos.pagos-terceros.index') }}" class="text-blue-400 hover:text-blue-300 transition-colors flex items-center space-x-2 bg-gray-800/50 backdrop-blur-sm rounded-xl px-4 py-2 w-fit">
            <i class="fas fa-arrow-left"></i>
            <span>Volver a la lista</span>
        </a>
    </div>

    <div class="bg-gradient-to-br from-gray-900 to-black rounded-xl shadow-xl overflow-hidden border border-gray-700/50">
        <div class="px-6 py-4 border-b border-gray-700/50 flex justify-between items-center bg-gray-800/30">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent">Detalles del Pago - Congreso</h2>
            @if($pago->estado_pago == 'pendiente')
                <div class="flex space-x-4">
                    <button onclick="validarPago('validado')" class="bg-green-500/80 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 flex items-center space-x-2 backdrop-blur-sm">
                        <i class="fas fa-check"></i>
                        <span>Validar Pago</span>
                    </button>
                    <button onclick="validarPago('rechazado')" class="bg-red-500/80 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-200 flex items-center space-x-2 backdrop-blur-sm">
                        Rechazar Pago
                    </button>
                </div>
            @endif
        </div>

        <div class="p-6 text-gray-300">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-blue-400">Información del Congreso</h3>
                    <div class="space-y-3 bg-gray-800/30 p-4 rounded-xl border border-gray-700/50">
                        <p><span class="font-medium text-gray-400">Congreso:</span> {{ $pago->congreso->titulo }}</p>
                        <p><span class="font-medium">Estado del pago:</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($pago->estado_pago == 'validado')
                                    bg-green-100 text-green-800
                                @elseif($pago->estado_pago == 'rechazado')
                                    bg-red-100 text-red-800
                                @else
                                    bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($pago->estado_pago) }}
                            </span>
                        </p>
                        <p><span class="font-medium">Fecha de registro:</span> {{ $pago->created_at->format('d/m/Y H:i') }}</p>
                        <p><span class="font-medium">Monto total:</span> ${{ number_format($pago->monto_total, 2) }}</p>
                        @if($pago->fecha_validacion)
                            <p><span class="font-medium">Fecha de validación:</span> {{ $pago->fecha_validacion->format('d/m/Y H:i') }}</p>
                        @endif
                        @if($pago->codigo_unico)
                            <p><span class="font-medium">Código único:</span> 
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded font-mono text-sm">{{ $pago->codigo_unico }}</span>
                            </p>
                        @endif
                        @if($pago->observacion)
                            <p><span class="font-medium">Observación:</span> {{ $pago->observacion }}</p>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4 text-blue-400">Información del Tercero</h3>
                    <div class="space-y-3 bg-gray-800/30 p-4 rounded-xl border border-gray-700/50">
                        <p><span class="font-medium">Tipo:</span> {{ ucfirst(str_replace('_', ' ', $pago->tipo_tercero)) }}</p>
                        <p><span class="font-medium">Nombre:</span> {{ $pago->nombre_tercero }}</p>
                        <p><span class="font-medium">RFC:</span> {{ $pago->rfc_tercero }}</p>
                        <p><span class="font-medium">Contacto:</span> {{ $pago->contacto_tercero }}</p>
                        <p><span class="font-medium">Correo:</span> {{ $pago->correo_tercero }}</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4 text-blue-400">Detalles de Cobertura</h3>
                    <div class="space-y-3 bg-gray-800/30 p-4 rounded-xl border border-gray-700/50">
                        <p><span class="font-medium">Cubre inscripción:</span>
                            <span class="{{ $pago->cubre_inscripcion ? 'text-green-600' : 'text-red-600' }}">
                                {{ $pago->cubre_inscripcion ? 'Sí' : 'No' }}
                            </span>
                        </p>
                        <p><span class="font-medium">Cubre artículos:</span>
                            <span class="{{ $pago->cubre_articulos ? 'text-green-600' : 'text-red-600' }}">
                                {{ $pago->cubre_articulos ? 'Sí' : 'No' }}
                            </span>
                        </p>
                        <p><span class="font-medium text-gray-400">Número de pagos:</span> {{ $pago->numero_pagos }}</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold mb-4 text-blue-400">Comprobante de Pago</h3>
                    <div class="bg-gray-800/30 p-4 rounded-xl border border-gray-700/50">
                        @if($pago->comprobante_pago)
                            <a href="{{ asset($pago->comprobante_pago) }}" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors flex items-center space-x-2">
                                <i class="fas fa-download mr-2"></i>Ver comprobante
                            </a>
                        @else
                            <p class="text-gray-500">No hay comprobante disponible</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Validación -->
<div id="modalValidacion" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-gray-900 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-700/50">
            <form id="formValidacion" action="{{ route('admin.congresos.pagos-terceros.update-estado', $pago->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="estado" id="estadoValidacion">
                
                <div class="bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-gray-300">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-300" id="modal-title"></h3>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-700/50">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white sm:ml-3 sm:w-auto sm:text-sm" id="btnConfirmar"></button>
                    <button type="button" onclick="cerrarModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function validarPago(estado) {
        const modal = document.getElementById('modalValidacion');
        const titulo = document.getElementById('modal-title');
        const btnConfirmar = document.getElementById('btnConfirmar');
        const estadoInput = document.getElementById('estadoValidacion');

        estadoInput.value = estado;

        if (estado === 'validado') {
            titulo.textContent = '¿Confirmar validación del pago?';
            btnConfirmar.textContent = 'Validar';
            btnConfirmar.classList.add('bg-green-600', 'hover:bg-green-700');
            btnConfirmar.classList.remove('bg-red-600', 'hover:bg-red-700');
        } else {
            titulo.textContent = '¿Confirmar rechazo del pago?';
            btnConfirmar.textContent = 'Rechazar';
            btnConfirmar.classList.add('bg-red-600', 'hover:bg-red-700');
            btnConfirmar.classList.remove('bg-green-600', 'hover:bg-green-700');
        }

        modal.classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modalValidacion').classList.add('hidden');
    }
</script>
@endpush