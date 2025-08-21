@extends('layouts.user')

@section('titulo', 'Validar Código de Pago')

@section('contenido')
<div class="min-h-screen py-12 relative overflow-hidden bg-gradient-to-b from-space-950 to-cosmic-900">
    <!-- Efecto de partículas en el fondo -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-tr from-purple-500/5 to-blue-500/5 animate-pulse"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-2xl mx-auto bg-black/40 backdrop-blur-xl rounded-2xl overflow-hidden border border-white/10 relative transition-all duration-500 hover:border-white/20 hover:shadow-[0_0_40px_rgba(147,51,234,0.4)] transform hover:-translate-y-1">
            <div class="p-6 border-b border-white/5">
                <a href="{{ route('user.concursos.pagos-terceros.index') }}" 
                   class="text-white/90 hover:text-white flex items-center gap-3 bg-white/5 px-5 py-2.5 rounded-xl w-fit transition-all duration-300 hover:bg-white/10 group">
                    <i class="fas fa-arrow-left transform transition-transform group-hover:-translate-x-1"></i>
                    <span>Volver a Pagos</span>
                </a>
            </div>

            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="inline-block p-4 rounded-full bg-gradient-to-br from-purple-500/10 to-blue-500/10 mb-4">
                        <i class="fas fa-key text-3xl text-purple-400"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">Validar Código de Pago</h1>
                </div>
                
                <form id="validarForm" class="space-y-8">
                    @csrf
                    <div class="space-y-2">
                        <label for="concurso_id" class="block text-sm font-medium text-white/90 flex items-center gap-2">
                            <i class="fas fa-trophy text-purple-400"></i>
                            <span>Seleccionar Concurso</span>
                        </label>
                        <select id="concurso_id" name="concurso_id" required 
                            class="mt-1 block w-full rounded-xl bg-white text-black border border-white/10 
                                focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 
                                hover:border-purple-500/50 py-3 px-4 dark:bg-gray-800 dark:text-white">
                            <option value="">Seleccione un concurso</option>
                            @foreach($concursos as $concurso)
                                <option value="{{ $concurso->id }}">{{ $concurso->titulo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="codigo" class="block text-sm font-medium text-white/90 flex items-center gap-2">
                            <i class="fas fa-fingerprint text-purple-400"></i>
                            <span>Código de Validación</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="codigo" name="codigo" required 
                                   class="mt-1 block w-full rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/30 focus:border-purple-500 focus:ring-purple-500 transition-all duration-300 hover:border-purple-500/50 py-3 px-4 pl-10"
                                   placeholder="Ingresa el código proporcionado">
                            <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-purple-400/50"></i>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" 
                                class="w-full flex justify-center items-center gap-3 py-4 px-6 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg group">
                            <i class="fas fa-check-circle text-lg transition-transform group-hover:scale-110"></i>
                            <span>Validar Código</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('validarForm');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        try {
            const response = await fetch('{{ route("user.concursos.pagos-terceros.validar-codigo") }}', {
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
                    html: `${message}<br><br>¿Deseas continuar con el pre-registro?`,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No, cancelar'
                }).then((swalResult) => {
                    if (swalResult.isConfirmed && result.convocatoria_id) {
                        window.location.href = '{{ route("user.concursos.pre-registros.create", "") }}/' + result.convocatoria_id;
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