<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Cerrar sesión') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Haz clic en el botón de abajo para cerrar sesión en tu cuenta.') }}
        </p>
    </header>

    <form id="logout-form" method="POST" action="{{ route('logout') }}">
        @csrf

        <x-danger-button>
            {{ __('Cerrar sesión') }}
        </x-danger-button>
    </form>
</section>

<!-- Incluye SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Asegúrate de que el DOM esté completamente cargado antes de añadir el listener
    document.addEventListener('DOMContentLoaded', function () {
        const logoutForm = document.getElementById('logout-form');
        
        // Escucha el evento de clic en el botón de cerrar sesión
        logoutForm.addEventListener('submit', function (event) {
            event.preventDefault();  // Prevenir el envío inmediato del formulario

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres cerrar sesión en tu cuenta?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'No, cancelar',
                confirmButtonColor: '#FCD34D',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, envía el formulario
                    logoutForm.submit();
                } else {
                    // Si el usuario cancela, no hace nada
                    Swal.fire(
                        'Cancelado',
                        'No se ha cerrado sesión.',
                        'error'
                    );
                }
            });
        });
    });
</script>
