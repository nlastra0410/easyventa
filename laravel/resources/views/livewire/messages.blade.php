<div>
    @if (session()->has('msg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Mensaje!</strong>{{ session('msg') }}


            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('scan-notfound'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Mensaje!</strong>{{ session('scan-notfound') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('no-stock'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Mensaje!</strong>{{ session('no-stock') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

</div>

<script>
    // Función para eliminar los mensajes después de 5 segundos
    function eliminarMensajes() {
        setTimeout(function() {
            var mensajes = document.querySelectorAll('.alert-dismissible');
            mensajes.forEach(function(mensaje) {
                mensaje.remove();
            });
        }, 5000);
    }

    // Ejecutar la función inicialmente
    eliminarMensajes();

    // Ejecutar la función cada vez que se agregue un nuevo mensaje
    Livewire.hook('message.sent', () => {
        eliminarMensajes();
    });
</script>
