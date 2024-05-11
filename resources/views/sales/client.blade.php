<div>
    @if ($tieneSuscripcion===true)
    <h2 class="text-center mb-3 header">
        Cliente: <span class="badge text-bg-primary">{{ $nameCliente }}</span>
    </h2>
    @else
    <h2 class="text-center mb-3 header">
        Cliente: <span class="badge text-bg-primary">Generico</span>
    </h2>
    @endif
    
    <div class="card card-info" style="border-radius: 40px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.302); ">
        <div class="card-header">
            
            @if ($tieneSuscripcion===true)
                <h3 class="card-title bg-gradient-green" style="padding: 5px 10px; border-radius: 20px">
                    <i class="fa-solid fa-tags"></i>
                    <b>
                        Beneficio: {{$detallesSuscripcion['plan'] }}
                    </b> 
                </h3>
            @else
                <h3 class="card-title bg-gradient-red" style="padding: 5px 10px; border-radius: 20px">
                    <i class="fa-solid fa-tags"></i>
                    <b>
                        Beneficio: Sin Beneficio
                    </b>
                </h3>
            @endif

            
            <div class="card-tools">
                <button wire:click="openModal" class="btn bg-purple btn-sm" style="border-radius: 26px">Crear
                    cliente</button>
            </div>
        </div>
        <div class="card-body">

            <div class="form-group">
                <label class="">Rut del cliente:</label>

                <!--input group -->
                <div class="input-group" wire:ignore>
                    <div class="input-group-prepend">
                        <span class="input-group-text text-center">
                            <i class="fa-solid fa-id-card"></i>
                        </span>
                        <span class="input-group-text text-center">
                            <input wire:keydown.enter="verificarSuscripcion"  wire:model.live="rut" id="rutInput" class="form-control text-center" placeholder="Ingresar Rut" style="padding: 15px 95px">
                        </span>
                    </div>

                </div>
                <!-- /.input group -->
                
            </div>
        </div>

        <button class="btn bg-green" style="font-size: 30px" wire:click="verificarSuscripcion">
            <i class="fa-solid fa-check-double"></i>
            Confirmar
        </button>
    </div>
    <!-- Modal Cliente -->

    @if ($showModal)
        <x-modal modalId="modalRut" modalTitle="Cliente EasyFarma Plus">
            <form>
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="name">Rut:</label>
                        <input wire:model.live="rut" wire:keydown.enter.prevent="BuscaRut('{{ $rut }}')"
                            type="search" class="form-control" placeholder="Rut Cliente" id="name"
                            style="border-radius: 14px">


                        <div class="aletr alert-danger w-100 mt-3"></div>



                    </div>
                </div>


                <hr>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                    style="border-radius: 16px;">Cancelar</button>
            </form>
        </x-modal>
    @endif

    <x-modal modalId="modalClient" modalTitle="Clientes">
        <form wire:submit={{ $Id == 0 ? 'store' : "update($Id)" }}>
            <div class="form-row">

                <!-- name-->
                <div class="form-group col-6">
                    <label for="name">Nombre:</label>
                    <input autofocus wire:model='name' type="text" class="form-control" placeholder="Nombre Cliente"
                        id="name" style="border-radius: 16px">
                    @error('name')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- rut-->
                <div class="form-group col-6">
                    <label for="rut">Rut:</label>
                    <input wire:model='rut' type="text" class="form-control" placeholder="Rut Cliente" id="rut"
                        style="border-radius: 16px">
                    @error('rut')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- telefono-->
                <div class="form-group col-12">
                    <label for="telefono">Teléfono:</label>
                    <input wire:model='telefono' type="text" class="form-control" placeholder="Telefono Cliente"
                        id="telefono" style="border-radius: 16px">
                    @error('telefono')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- email-->
                <div class="form-group col-12">
                    <label for="email">Correo:</label>
                    <input wire:model='email' type="text" class="form-control" placeholder="Correo" id="email"
                        style="border-radius: 16px">
                    @error('email')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- password-->
                <div class="form-group col-6">
                    <label for="password">Contraseña:</label>
                    <input wire:model='password' type="password" class="form-control" placeholder="Contraseña"
                        id="password" style="border-radius: 16px">
                    @error('password')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror


                </div>

                <!-- re_password-->
                <div class="form-group col-6">
                    <label for="re_password">Repetir Contraseña:</label>
                    <input wire:model='re_password' type="password" class="form-control"
                        placeholder="Repetir Contraseña" id="re_password" style="border-radius: 16px">
                    @error('re_password')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror


                </div>

                <div class="form-group col-12">
                    <p class="text-muted text-center mt-2">
                        Los campos de correo y contraseña son opcionales
                    </p>
                </div>

            </div>

            <hr>
            <button class="btn float-right"
                style="background-color: #0D7685; border-radius: 16px; color: white">{{ $Id == 0 ? 'Guardar' : 'Editar' }}</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                style="border-radius: 16px;">Cancelar</button>
        </form>
    </x-modal>

    <!-- Al final del cuerpo del documento HTML -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Verificar el estado del modal en el almacenamiento local
            const modalState = localStorage.getItem('modalRutShown');

            // Si el modal no se ha mostrado, abrirlo
            if (modalState !== 'shown') {
                $('#modalRut').modal('show');

                // Almacenar en el almacenamiento local que el modal se ha mostrado
                localStorage.setItem('modalRutShown', 'shown');
            }
        });
    </script>

    @section('styles')
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endsection

    @section('js')
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

        <script>
            $("#select2").select2({
                theme: "bootstrap4"
            });

            $("#select2").on('change', function() {
                Livewire.dispatch('client_id', {
                    id: $(this).val()
                })
            });
        </script>

        <script>
            function updateRut() {
                var select = document.getElementById('select2');
                var rutInput = document.getElementById('rutInput');

                // Obtener el valor del rut del atributo 'data-rut' del option seleccionado
                var rut = select.options[select.selectedIndex].getAttribute('data-rut');

                // Actualizar el valor del input oculto
                rutInput.value = rut;

                console.log('Rut actualizado:', rut);
            }
        </script>
    @endsection


</div>
