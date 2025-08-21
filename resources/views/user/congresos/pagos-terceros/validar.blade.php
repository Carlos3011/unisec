@extends('layouts.user')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <a href="{{ route('user.congresos.pagos-terceros.index') }}" class="text-white/90 hover:text-white flex items-center gap-2 bg-white/5 px-4 py-2 rounded-lg w-fit transition-all duration-300 hover:bg-white/10">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a la lista</span>
            </a>
        </div>

        <div class="bg-black/30 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 hover:border-white/20 transition-all duration-300 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <div class="px-6 py-4 border-b border-white/10">
                <h2 class="text-2xl font-bold text-white">Validar Código de Pago - Congreso</h2>
                <p class="text-white/70 mt-2">Ingresa el código de validación para verificar un pago de terceros</p>
            </div>

            <div class="p-6">
                <form id="validarForm" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="codigo" class="block text-sm font-medium text-white mb-2">
                                Código de Validación *
                            </label>
                            <input type="text" 
                                   id="codigo" 
                                   name="codigo" 
                                   value="{{ old('codigo') }}"
                                   class="w-full px-4 py-3 bg-white/5 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                   placeholder="Ingresa el código de validación"
                                   required>
                            @error('codigo')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="congreso_id" class="block text-sm font-medium text-white mb-2">
                                Congreso *
                            </label>
                            <select id="congreso_id" 
                                    name="congreso_id" 
                                    class="w-full px-4 py-3 bg-white/5 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                    required>
                                <option value="">Selecciona un congreso</option>
                                @foreach($congresos as $congreso)
                                    <option value="{{ $congreso->id }}" 
                                            {{ old('congreso_id') == $congreso->id ? 'selected' : '' }}
                                            class="bg-gray-800 text-white">
                                        {{ $congreso->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('congreso_id')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                            <i class="fas fa-search mr-2"></i>
                            Validar Código
                        </button>
                    </div>
                </form>

                @if(session('success'))
                    <div class="mt-6 bg-green-900/20 border border-green-400/30 text-green-400 px-4 py-3 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mt-6 bg-red-900/20 border border-red-400/30 text-red-400 px-4 py-3 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if(isset($pago) && $pago)
                    <div class="mt-6 bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Información del Pago Validado</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2 text-white/90">
                                <p><span class="font-medium">Congreso:</span> {{ $pago->congreso->nombre }}</p>
                                <p><span class="font-medium">Tercero:</span> {{ $pago->nombre_tercero }}</p>
                                <p><span class="font-medium">RFC:</span> {{ $pago->rfc_tercero }}</p>
                                <p><span class="font-medium">Tipo:</span> {{ ucfirst(str_replace('_', ' ', $pago->tipo_tercero)) }}</p>
                            </div>
                            <div class="space-y-2 text-white/90">
                                <p><span class="font-medium">Estado:</span>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($pago->estado_pago == 'validado')
                                            bg-green-400/10 text-green-400
                                        @elseif($pago->estado_pago == 'rechazado')
                                            bg-red-400/10 text-red-400
                                        @else
                                            bg-yellow-400/10 text-yellow-400
                                        @endif">
                                        {{ ucfirst($pago->estado_pago) }}
                                    </span>
                                </p>
                                <p><span class="font-medium">Monto total:</span> ${{ number_format($pago->monto_total, 2) }}</p>
                                <p><span class="font-medium">Número de pagos:</span> {{ $pago->numero_pagos }}</p>
                                <p><span class="font-medium">Fecha:</span> {{ $pago->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-green-900/20 p-4 rounded-lg border border-green-400/30">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-white">Inscripciones Disponibles</span>
                                    <span class="text-green-400 text-sm">{{ $usosDisponiblesIns ?? 0 }} / {{ $pago->numero_pagos }}</span>
                                </div>
                                <div class="h-2 bg-green-900/30 rounded-full">
                                    <div class="h-2 bg-green-400 rounded-full" style="width: {{ $pago->numero_pagos > 0 ? (($usosDisponiblesIns ?? 0) / $pago->numero_pagos) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="bg-purple-900/20 p-4 rounded-lg border border-purple-400/30">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-white">Artículos Disponibles</span>
                                    <span class="text-purple-400 text-sm">{{ $usosDisponiblesArt ?? 0 }} / {{ $pago->numero_pagos }}</span>
                                </div>
                                <div class="h-2 bg-purple-900/30 rounded-full">
                                    <div class="h-2 bg-purple-400 rounded-full" style="width: {{ $pago->numero_pagos > 0 ? (($usosDisponiblesArt ?? 0) / $pago->numero_pagos) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('user.congresos.pagos-terceros.show', $pago->id) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                                <i class="fas fa-eye mr-2"></i>
                                Ver Detalles Completos
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('validarForm');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch('{{ route("user.congresos.pagos-terceros.validar-codigo") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                let message = result.message;
                
                Swal.fire({
                    title: '¡Código Válido!',
                    html: `${message}<br><br>¿Deseas continuar con la inscripción al congreso?`,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No, cancelar'
                }).then((swalResult) => {
                    if (swalResult.isConfirmed && result.convocatoria_id) {
                        window.location.href = '{{ route("user.congresos.inscripciones.create", "") }}/' + result.convocatoria_id;
                    }
                });
            } else {
                throw new Error(result.error || 'Error al validar el código');
            }
        } catch (error) {
            Swal.fire({
                title: 'Error',
                text: error.message,
                icon: 'error',
                confirmButtonText: 'Cerrar'
            });
        }
    });
});
</script>

@endsection