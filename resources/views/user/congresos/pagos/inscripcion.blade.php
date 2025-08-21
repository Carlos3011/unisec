@extends('layouts.user')

@section('titulo', 'Pago de Inscripción')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto bg-white/60 rounded-2xl overflow-hidden shadow-xl relative">
            <!-- Header con logo y navegación -->
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <a href="{{ route('user.congresos.convocatorias.show', $convocatoria) }}" class="text-white hover:text-gray-800 flex items-center gap-2 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver a la Convocatoria</span>
                </a>
                <img src="{{ asset('images/logo.png') }}" alt="UNISEC-MX" class="h-8">
            </div>

            <div class="p-8">
                <!-- Información del comerciante -->
                <div class="flex items-center mb-8 bg-gray-50 p-4 rounded-lg">
                    <div class="flex-shrink-0 mr-4">
                        <i class="fas fa-shield-check text-4xl text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">UNISEC-MX</h2>
                        <p class="text-gray-600">CHIHUAHUA, CHIH, MÉXICO</p>
                    </div>
                </div>

                <!-- Detalles del pago -->
                <div class="bg-white/60 border border-gray-200 rounded-xl p-6 mb-8 shadow-sm">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pago de Inscripción</h1>
                    
                    <!-- Selección de tipo de participante -->
                    <div class="mb-6">
                        <label for="tipo_participante" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Participante
                        </label>
                        <select id="tipo_participante" name="tipo_participante" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Seleccione el tipo de participante</option>
                            @foreach($convocatoria->cuotas_inscripcion as $key => $cuota)
                                <option value="{{ $key }}" data-monto="{{ $cuota['monto'] }}">
                                    {{ $cuota['rol'] }} - ${{ number_format($cuota['monto'], 2) }} MXN
                                </option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600">Concepto</span>
                            <span class="text-gray-800 font-medium">{{ $convocatoria->congreso->titulo }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-600">Total a pagar</span>
                            <span id="monto_total" class="text-2xl font-bold text-blue-600">$0.00 MXN</span>
                        </div>
                    </div>

                    <!-- Opciones de pago -->
                    <div class="space-y-4">
                        <div id="paypal-button-container" class="w-full"></div>
                        
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white/60 text-gray-500">o paga mediante</span>
                            </div>
                        </div>

                        <a href="{{ route('user.congresos.pagos-terceros.create') }}" 
                           class="w-full py-3 px-4 bg-white/60 border border-gray-300 text-gray-700 font-semibold rounded-lg text-center hover:bg-gray-50 transition-all duration-300 flex items-center justify-center gap-2 shadow-sm">
                            <i class="fas fa-university text-blue-600"></i>
                            <span>Transferencia Bancaria</span>
                        </a>
                    </div>
                </div>

                <!-- Información de seguridad y términos -->
                <div class="flex items-center justify-center gap-6 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-lock text-green-500"></i>
                        <span>Pago Seguro</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shield-alt text-blue-500"></i>
                        <span>Protección al Comprador</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.sandbox.client_id') }}&currency={{ config('paypal.currency') }}"></script>
<script>
    // Variables globales
    let selectedTipoParticipante = '';
    let selectedMonto = '';

    // Función para actualizar el monto total
    function actualizarMontoTotal() {
        const select = document.getElementById('tipo_participante');
        const montoTotal = document.getElementById('monto_total');
        const option = select.options[select.selectedIndex];
        
        if (option.value !== '') {
            const monto = option.getAttribute('data-monto');
            montoTotal.textContent = `$${parseFloat(monto).toFixed(2)} MXN`;
            selectedTipoParticipante = option.value;
            selectedMonto = monto;
            console.log('Tipo participante seleccionado:', selectedTipoParticipante, 'Monto:', selectedMonto);
        } else {
            montoTotal.textContent = '$0.00 MXN';
            selectedTipoParticipante = '';
            selectedMonto = '';
        }
    }

    // Event listeners
    document.getElementById('tipo_participante').addEventListener('change', function() {
        actualizarMontoTotal();
    });

    // Configuración de PayPal
    paypal.Buttons({
        createOrder: async function(data, actions) {
            if (!selectedTipoParticipante) {
                alert('Por favor, seleccione el tipo de participante');
                return;
            }

            const requestData = {
                convocatoria_id: {{ $convocatoria->id }},
                tipo_participante: selectedTipoParticipante
            };

            console.log('Enviando datos:', requestData);

            try {
                const response = await fetch('{{ route("user.congresos.pagos.create-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                });

                const responseData = await response.json();
                console.log('Respuesta del servidor:', responseData);

                if (!response.ok) {
                    throw new Error(responseData.error || 'Error al crear la orden');
                }

                if (responseData.error) {
                    throw new Error(responseData.error);
                }

                window.pagoId = responseData.id;
                
                // Usar el monto que viene del backend para PayPal
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: responseData.amount,
                            currency_code: '{{ config('paypal.currency') }}'
                        },
                        description: 'Inscripción para {{ $convocatoria->congreso->titulo }}'
                    }]
                });
            } catch (error) {
                console.error('Error al crear la orden:', error);
                alert('Error al iniciar el proceso de pago: ' + error.message);
                throw error;
            }
        },
        onApprove: async function(data, actions) {
            try {
                const details = await actions.order.capture();
                const response = await fetch('{{ route("user.congresos.pagos.capture-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        pago_id: window.pagoId,
                        orderID: data.orderID,
                        paymentID: details.id,
                        details: details
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: 'Error al procesar la respuesta del servidor' }));
                    throw new Error(errorData.message || 'Error al procesar el pago');
                }

                const result = await response.json();
                if (result.success) {
                    // Mostrar alerta de éxito
                    Swal.fire({
                        title: '¡Pago Exitoso!',
                        text: 'Tu pago ha sido procesado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        confirmButtonColor: '#3085d6',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirigir a la página de inscripción usando el ID de la convocatoria actual
                            window.location.href = `{{ route('user.congresos.inscripciones.create', ['convocatoria' => $convocatoria->id]) }}`;
                        }
                    });
                } else {
                    throw new Error(result.message || 'Error al procesar el pago');
                }
            } catch (error) {
                console.error('Error al capturar el pago:', error);
                // Mostrar alerta de error
                Swal.fire({
                    title: 'Error en el Pago',
                    text: error.message || 'Hubo un error al procesar tu pago',
                    icon: 'error',
                    confirmButtonText: 'Intentar de nuevo',
                    confirmButtonColor: '#d33'
                });
            }
        },
        onError: function(err) {
            console.error('Error en el pago:', err);
            // Mostrar alerta de error
            Swal.fire({
                title: 'Error en el Pago',
                text: err.message || 'Hubo un error al procesar el pago. Por favor, inténtalo de nuevo.',
                icon: 'error',
                confirmButtonText: 'Intentar de nuevo',
                confirmButtonColor: '#d33'
            });
        }
    }).render('#paypal-button-container');
</script>

@endsection