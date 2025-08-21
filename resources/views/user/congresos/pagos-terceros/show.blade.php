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
                <h2 class="text-2xl font-bold text-white">Detalles del Pago - Congreso</h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Información del Congreso</h3>
                        <div class="space-y-3 text-white/90">
                            <p><span class="font-medium">Congreso:</span> {{ $pago->congreso->titulo }}</p>
                            <p><span class="font-medium">Estado del pago:</span>
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
                            <p><span class="font-medium">Fecha de registro:</span> {{ $pago->created_at->format('d/m/Y H:i') }}</p>
                            <p><span class="font-medium">Monto total:</span> ${{ number_format($pago->monto_total, 2) }}</p>
                        </div>
                    </div>

                    <div class="bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Información del Tercero</h3>
                        <div class="space-y-3 text-white/90">
                            <p><span class="font-medium">Tipo:</span> {{ ucfirst(str_replace('_', ' ', $pago->tipo_tercero)) }}</p>
                            <p><span class="font-medium">Nombre:</span> {{ $pago->nombre_tercero }}</p>
                            <p><span class="font-medium">RFC:</span> {{ $pago->rfc_tercero }}</p>
                            <p><span class="font-medium">Contacto:</span> {{ $pago->contacto_tercero }}</p>
                            <p><span class="font-medium">Correo:</span> {{ $pago->correo_tercero }}</p>
                        </div>
                    </div>

                    <div class="md:col-span-2 bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Detalles de Cobertura</h3>
                        <div class="space-y-3 text-white/90">
                            <p><span class="font-medium">Cubre inscripciones:</span> 
                                <span class="{{ $pago->cubre_inscripcion ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $pago->cubre_inscripcion ? 'Sí' : 'No' }}
                                </span>
                            </p>
                            <p><span class="font-medium">Cubre artículos:</span>
                                <span class="{{ $pago->cubre_articulos ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $pago->cubre_articulos ? 'Sí' : 'No' }}
                                </span>
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <div class="bg-green-900/20 p-4 rounded-lg border border-green-400/30">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium">Inscripciones</span>
                                        <span class="text-green-400 text-sm">{{ $usosDisponiblesIns }} / {{ $pago->numero_pagos }}</span>
                                    </div>
                                    <div class="h-2 bg-green-900/30 rounded-full">
                                        <div class="h-2 bg-green-400 rounded-full" style="width: {{ $pago->numero_pagos > 0 ? ($usosDisponiblesIns / $pago->numero_pagos) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                                <div class="bg-purple-900/20 p-4 rounded-lg border border-purple-400/30">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium">Artículos</span>
                                        <span class="text-purple-400 text-sm">{{ $usosDisponiblesArt }} / {{ $pago->numero_pagos }}</span>
                                    </div>
                                    <div class="h-2 bg-purple-900/30 rounded-full">
                                        <div class="h-2 bg-purple-400 rounded-full" style="width: {{ $pago->numero_pagos > 0 ? ($usosDisponiblesArt / $pago->numero_pagos) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-4"><span class="font-medium">Código de validación:</span> <code class="bg-white/5 px-2 py-1 rounded">{{ $pago->codigo_validacion_unico }}</code></p>
                        </div>
                    </div>

                    <div class="md:col-span-2 bg-white/5 rounded-xl p-6 border border-white/10">
                        <h3 class="text-lg font-semibold text-white mb-4">Comprobante de Pago</h3>
                        <div class="p-4 border border-white/10 rounded-lg bg-white/5">
                            @if($pago->estado_pago === 'validado' && $pago->comprobante_pago)
                                <a href="{{ asset($pago->comprobante_pago) }}" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors duration-200 flex items-center gap-2">
                                    <i class="fas fa-download"></i>
                                    <span>Ver comprobante</span>
                                </a>
                            @else
                                <p class="text-white/60">Comprobante no disponible</p>
                            @endif
                            
                            @if($pago->referencia_transferencia)
                                <p class="mt-2 text-white/90"><span class="font-medium">Referencia:</span> {{ $pago->referencia_transferencia }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection