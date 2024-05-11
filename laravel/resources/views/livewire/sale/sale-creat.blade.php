<div>

    <style>
        .fondo {
            background-color: #084d68;
        }

        h1 {
            color: white;
            style="background-color: #084d68; border-radius:40px"
        }

        .selected-row {
            background-color: #000000;
            /* Cambia el color de fondo según tu preferencia */
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
            /* Ajusta la duración y la curva de la animación según tus preferencias */
            opacity: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .redondo {
            border-radius: 16px;
        }
        /* Ajusta el estilo de la fila seleccionada según tus preferencias */
    .fila-seleccionada {
        background-color: #213869bb;
        color: white;
    }

    tr:hover {
        background-color: #213869bb;
        color: white;
    }
    </style>

    <div class="row fondo">
        <div class="col-3">
            <h1>Venta tiket-{{ $numeroVentasUsuario }}</h1>
        </div>

        @livewire('sale.date-time')

        <div class="col-3">
            <h1>Sucursal: {{ auth()->user()->sucursal->name }}</h1>
        </div>
    </div>

    <div style="margin-top: 30px">
        <div>
            <div class="card-header">
                <div class="card-tools">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">

                        <div style="margin-left: 50px">
                            <form>

                                <div class="input-group">
                                    <input id="inputSku" autofocus wire:model.live="SKU" type="search"
                                        wire:keydown.enter="ScanCode" placeholder="Ingresar producto"
                                        class="form-control mb-4"
                                        style=" border-radius: 20px; margin-top:20px; padding: 25px 510px; text-align: center; border-color:rgb(114, 114, 114); margin-right: 20px">

                                </div>
                            </form>



                        </div>
                        <div>
                            <a href="#" class="btn btn-danger mr-3" wire:click='clear'
                                style="border-radius: 16px">
                                <i class="fas fa-trash"></i> Cancelar venta
                            </a>
                        </div>
                        <div>
                            <a href="" class="btn" data-toggle="modal" data-target="#modalProducto"
                                style="border-radius: 16px;background-color: #084d68; color: white">
                                Lista productos F1
                                <i class="fa-solid fa-pills"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- Contenido principal --}}
                <div class="row">



                    <div class="col-md-8">
                        {{-- Detalles de la venta --}}


                        @include('sales.card-deatils')
                        <p class=" text-center text-muted">Presiona los botones <b>+ o -</b> para aumentar o disminuir
                            la cantidad y el botón <b>Surp</b> para eliminar el producto</p>




                        {{-- Pago --}}
                        {{-- @include('sales.') --}}

                        {{-- cliente --}}

                    </div>

                    <div class="col-md-4 mt-4 card-pago-container fadeIn">
                        @include('sales.client')


                    </div>

                </div>



            </div>
        </div>

        @if ($ultimaVentaUsuario)
            <div class="card mt-4" style="border-radius:20px">
                <div class="card-header">
                    <h2> <b>Última Venta</b> </h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-center">
                            <thead>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Productos</th>
                                <th>Articulos</th>
                                <th>Fecha</th>
                                <th width="3%">...</th>
                                <th width="3%">...</th>
                                <th width="3%">...</th>

                            </thead>

                            <tbody>
                                <tr>
                                    <td>
                                        <span class="badge badge-primary">
                                            FV-{{ $ultimaVentaUsuario->id }}
                                        </span>
                                    </td>
                                    <td>{{ $ultimaVentaUsuario->client->name }}</td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ money($ultimaVentaUsuario->total) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill bg-purple">
                                            {{ $ultimaVentaUsuario->items->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill bg-purple">
                                            {{ $ultimaVentaUsuario->items->sum('pivot.qty') }}
                                        </span>
                                    </td>
                                    <td>{{ $ultimaVentaUsuario->fecha }}</td>

                                    <td>
                                        <a href="{{ route('sales.invoice', $ultimaVentaUsuario) }}" class="btn bg-navy btn-sm"
                                            title="Generar PDF" target="_blank">
                                            <i class="far fa-file-pdf"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('sales.show', $ultimaVentaUsuario) }}" class="btn btn-success btn-sm"
                                            title="Ver">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('sales.print', $ultimaVentaUsuario) }}" class="btn btn-success btn-sm"
                                            title="imprimir">
                                            <i class="fa-solid fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        @endif
    </div>

    <x-modal modalId="modalProducto" modalSize="modal-lg" modalTitle="Búsqueda de Productos">
        <p class="text-muted text-center" style="font-size: 20px">
            Teclea las primeras letras del producto
        </p>
        <div>
            <input id="inputArticulo" wire:model.live='searchTerm' autofocus type="text" class="form-control mb-5"
                placeholder="Buscar..." style="border-radius:12px">
        </div>
        <div id="productList" tabindex="0" wire:key="productList">
            <table class="table text-center">
                <thead>
                    <th>Agregar</th>
                    <th>Nombre</th>
                    <th><i class="fa-solid fa-image"></i></th>
                    <th>Precio Venta</th>
                    <th>Inventario</th>
                </thead>
                @if ($products->count() > 0)
                    @foreach ($products as $index => $product)
                    <tr wire:click='addProduct({{$product->id}})'
                        wire:loading.attr='disabled' wire:target='addProduct' class="{{ $index === $selectedIndex ? 'selected' : '' }}">
                        <td>
                            <button data-action="seleccionar"
                                class="btn btn-primary btn-xs visually-hidden" style="border-radius: 10px"
                                wire:loading.attr='disabled' wire:target='aumentar'>
                                +
                            </button>
                        </td>
                        
                        <td>{{$product->name}}</td>
                        <td>
                            <x-image :item="$product" size="50" /> 
                        </td>
                        <td>{!!$product->precio!!}</td>
                        <td>{{$product->stock}}</td>
                    </tr>
                    @endforeach
                @endif
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn" style="border-radius: 16px; background-color: #69C181; color:white"><i class="fa-solid fa-check"></i>  Enter-Aceptar</button>
            <button type="button" class="btn btn-danger" style="border-radius: 16px" data-dismiss="modal">ESC-Cancelar</button>
        </div>
    </x-modal>

    <x-modal modalId="modalCaja" modalSize="modal-lg" modalTitle="Corte de caja">
        <p class="text-muted text-center" style="font-size: 20px">
            Debe de ingresar el monto inicial de la caja antes de iniciar una venta

            <form wire:submit="registro">
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="monto">Monto Inicial:</label>
                        <input type="text" wire:model='monto' class="form-control" placeholder="Monto inicial de la caja" id="monto" style="border-radius: 14px">
                        @error('monto')
    
                        <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>
    
                        @enderror
                        
                        
                    </div>
                </div>
                
            
                <hr>
                <button class="btn float-right" style="background-color: #0D7685; border-radius: 16px; color: white">Guardar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius: 16px;">Cancelar</button>
            </form>
        </p>
    </x-modal>




</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    var tabla = document.getElementById("productList");
    var filaSeleccionada = 0;

    document.addEventListener("keydown", function(event) {
        if (event.key === "ArrowUp") {
            filaSeleccionada = Math.max(0, filaSeleccionada - 1);
        } else if (event.key === "ArrowDown") {
            filaSeleccionada = Math.min(tabla.rows.length - 1, filaSeleccionada + 1);
        }

        resaltarFilaSeleccionada();
    });

    document.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            ingresarProducto();
        }
    });

    function ingresarProducto() {
        var botonIngresar = tabla.rows[filaSeleccionada].querySelector('[data-action="seleccionar"]');

        if (botonIngresar) {
            botonIngresar.click();
        }
    }

    function resaltarFilaSeleccionada() {
        for (var i = 0; i < tabla.rows.length; i++) {
            tabla.rows[i].classList.remove("fila-seleccionada");
        }
        tabla.rows[filaSeleccionada].classList.add("fila-seleccionada");
    }
});



    document.addEventListener('livewire:load', function () {
        Livewire.on('ventaRealizada', () => {
            location.reload();
        });
    });
</script>


</div>
