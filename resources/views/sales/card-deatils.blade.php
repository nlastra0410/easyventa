<style>
    .card {
        overflow: hidden;
    }

    .azul {
        background-color: #213869;
        color: white;
    }

    /* Estilos para hacer que el botón se parezca a un enlace */
    .btn-like {
        background: none;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        color: inherit;
        text-decoration: underline;
    }

    /* Estilos para eliminar el contorno del botón al hacer clic */
    .btn-like:focus {
        outline: none;
    }

    #linkCorte {
        font-size: 0;
    }

    #linkCorte i,
    #linkCorte span {
        font-size: 26px;
        /* Restablece el tamaño de fuente a lo deseado */
        vertical-align: middle;
        /* Ajusta la alineación vertical si es necesario */
    }

    #linkCorte i {
        margin-right: 15px;
        /* Ajusta este valor según sea necesario */
    }
</style>
<h2 class="text-center mb-3 mt-3 header">
    Detalles venta <i class="fas fa-cart-plus"></i>
    <!-- Conteo de productos -->
    <i class="fa-solid fa-pills" title="Numero productos" style="margin-left: 300px"></i>
    <span class="badge badge-pill bg-purple">{{ $cart->count() }}</span>
    <!-- Conteo de articulos -->
    <i class="fas fa-shopping-basket ml-2" title="Numero items"></i>
    <span class="badge badge-pill bg-purple">{{ $totalQy }}</span>
    {{-- abrir corte de caja --}}
    <button href="" id="linkCorte" wire:click="newCorte" class="btn-like">
        <i class="fa-solid fa-lock" title="corte de caja" style="margin-left: 60px; color: black"></i>
        <span class="badge bg-purple" style="border-radius: 16px;">F3Corte</span>
    </button>
</h2>
<div class="card" style="border-radius: 40px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.302); ">

    <!-- card-body -->
    <div class="">
        <div class="table-responsive">
            <table class="table table-sm text-center" id="listaCarrito">
                <thead>
                    <tr class="tr-deshabilitado azul">
                        <th scope="col">Sku</th>
                        <th scope="col">Nombre</th>
                        <th scope="col"><i class="fas fa-image"></i></th>
                        <th scope="col">Precio.vt</th>
                        <th scope="col" width="15%">Qty</th>
                        <th scope="col">Sub total</th>
                        <th scope="col">...</th>
                    </tr>

                </thead>
                <tbody>
                    {{ $totalConSuscripcion = 0 }}
                    {{ $pagoConSuscripcion = 0 }}



                    @forelse ($cart as $product)
                        <tr>
                            <td>{{ $product->associatedModel->SKU }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <x-image :item="$product->associatedModel" size="100" />
                            </td>
                            <td> <b>{{ money($product->price) }}</b> </td>

                            <td>
                                <!-- Botones para aumentar o disminuir la cantidad del producto en el carrito -->
                                <button data-action="disminuir" wire:click='dismin({{ $product->id }})'
                                    class="btn btn-primary btn-s" style="border-radius: 10px"
                                    wire:loading.attr='disabled' wire:target='dismin'>
                                    -
                                </button>

                                <span class="mx-1">{{ $product->quantity }}</span>

                                <button data-action="aumentar" wire:click='aumentar({{ $product->id }})'
                                    class="btn btn-primary btn-s" style="border-radius: 10px"
                                    {{ $product->quantity >= $product->associatedModel->stock ? 'disabled' : '' }}
                                    wire:loading.attr='disabled' wire:target='aumentar'>
                                    +
                                </button>

                            </td>

                            {{-- <td>{!! $stockLabel !!}</td> --}}
                            <td>{{ money(floatval($product->quantity) * floatval($product->price)) }}</td>

                            <td>
                                <!-- Boton para eliminar el producto del carrito -->
                                <button data-action="eliminar"
                                    wire:click='remove({{ $product->id }},{{ $product->quantity }})'
                                    class="btn btn-danger btn-s" style="border-radius: 10px" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="10">Sin Registros</td>
                        </tr>
                    @endforelse







                    <tr class="tr-deshabilitado">
                        <td colspan="4"></td>
                        <td>
                            <h5>Total:</h5>
                        </td>
                        <td>
                            <h5>
                                <span class="badge badge-pill badge-secondary">
                                    {{ money($total) }}
                                </span>




                            </h5>
                        </td>
                        <td></td>
                    </tr>
                    <tr class="tr-deshabilitado">

                        <td colspan="8">
                            <strong>Total en letras:</strong>
                            {{ numerosLetras($total) }}
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>


    </div>
    {{-- Crear venta --}}

    <button id="cobrarButton" class="btn bg-purple" wire:click='createSale' data-action="paga" style="font-size: 30px">
        <i class="fa-solid fa-cart-plus"></i>
        F12 - Cobrar
    </button>

    <x-modal modalId="modalPago" modalSize="modal-lg" modalTitle="Cobrar">

        @include('sales.card-pago')

        <button data-action="cancelar" type="button" class="btn btn-danger redondo" data-dismiss="modal">ESC -
            Cancelar</button>



    </x-modal>



    <!-- Modal -->



    <!-- end-card-body -->
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.key === 'F12') {
                event
                    .preventDefault(); // Evitar el comportamiento predeterminado de abrir las herramientas de desarrollo
                document.getElementById('cobrarButton').click(); // Simular un clic en el botón
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            var tabla = document.getElementById("listaCarrito");
            var filaSeleccionada = 0;
            var inputActivo = false;
            var modalAbierto = false;





            document.addEventListener("keydown", function(event) {
                if (inputActivo || document.getElementById('modalProducto').classList.contains('show')) {
                    // No ejecutar acciones de aumentar o disminuir si el input está activo o el modal está abierto
                    return;
                }

                if (event.key === "ArrowUp") {
                    filaSeleccionada = Math.max(0, filaSeleccionada - 1);
                } else if (event.key === "ArrowDown") {
                    filaSeleccionada = Math.min(tabla.rows.length - 1, filaSeleccionada + 1);
                } else if (event.key === "+" || event.key === "-") {
                    event
                        .preventDefault(); // Evitar el comportamiento por defecto (como escribir en el input)
                    aumentarOdisminuirCantidad(event.key === "+");
                }

                resaltarFilaSeleccionada();
            });

            document.addEventListener("keydown", function(event) {
                if (event.key === "Control") {
                    event.preventDefault();
                    Pago();
                }
            })

            document.addEventListener("keyup", function(event) {
                if (event.key === "Delete") {
                    event
                        .preventDefault(); // Evitar el comportamiento por defecto (como borrar contenido de un input)
                    eliminarProducto();
                }
            });

            function Pago() {
                var paga = querySelector('[data-action="paga"]');

                // Simula un clic en el botón de eliminar
                if (paga) {
                    paga.click();
                }
            }

            function resaltarFilaSeleccionada() {
                for (var i = 0; i < tabla.rows.length; i++) {
                    tabla.rows[i].classList.remove("fila-seleccionada");
                }

                if (!tabla.rows[filaSeleccionada].classList.contains("tr-deshabilitado")) {
                    tabla.rows[filaSeleccionada].classList.add("fila-seleccionada");
                }
            }


            function aumentarOdisminuirCantidad(esAumento) {
                // Obtén el botón correspondiente de la fila seleccionada
                var boton = esAumento ?
                    tabla.rows[filaSeleccionada].querySelector('[data-action="aumentar"]') :
                    tabla.rows[filaSeleccionada].querySelector('[data-action="disminuir"]');

                if (boton && !boton.disabled) { // Asegurarse de que el botón no esté deshabilitado
                    setTimeout(function() {
                        boton.click();
                    }, 100); // Agregar un retraso de 100 milisegundos (ajustable según sea necesario)
                }
            }

            function eliminarProducto() {
                // Obtén el botón de eliminar de la fila seleccionada
                var botonEliminar = tabla.rows[filaSeleccionada].querySelector('[data-action="eliminar"]');

                // Simula un clic en el botón de eliminar
                if (botonEliminar) {
                    botonEliminar.click();
                }
            }

            // Manejar eventos de enfoque y desenfoque en el input
            var input = document.querySelector("#tuInputId"); // Reemplaza "tuInputId" con el ID de tu input real
            input.addEventListener("focus", function() {
                inputActivo = true;
            });

            input.addEventListener("blur", function() {
                inputActivo = false;
            });

            $('#modalProducto').on('show.bs.modal', function() {
                modalAbierto = true;
            });

            $('#modalProducto').on('hidden.bs.modal', function() {
                modalAbierto = false;
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('actualizarPrecios', precioExclusivo => {
                // Lógica para actualizar los precios en la interfaz
                if (precioExclusivo !== null) {
                    // Lógica para mostrar los precios de suscripción
                } else {
                    // Lógica para mostrar los precios normales
                }
            });
        });

        document.getElementById('linkCorte').addEventListener('mouseover', function() {
            document.querySelector('#linkCorte i').classList.remove('fa-lock');
            document.querySelector('#linkCorte i').classList.add('fa-unlock');
        });

        document.getElementById('linkCorte').addEventListener('mouseout', function() {
            document.querySelector('#linkCorte i').classList.remove('fa-unlock');
            document.querySelector('#linkCorte i').classList.add('fa-lock');
        });
    </script>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Livewire.on('preciosActualizados', function() {
                    Livewire.emit('refreshComponent');
                });
            });
        </script>
    @endpush
</div>
