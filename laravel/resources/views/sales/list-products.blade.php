<style>
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
<div class="" wire:ignore>
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-pills"></i> Productos</h3>
    </div>

    <div class="card-body">

        <table class="table text-center">
            <thead>
                <th>Agregar</th>
                <th>Nombre</th>
                <th><i class="fa-solid fa-image"></i></th>
                <th>Precio Venta</th>
                <th>Inventario</th>
            </thead>

            @if ($products->count() > 0)
                @foreach ($products as $product)
                <tr wire:click='addProduct({{$product->id}})'
                    wire:loading.attr='disabled' wire:target='addProduct'>
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
                    <td>{!!$stockLabel!!}</td>
                </tr>
                @endforeach
            @endif
        </table>



    </div>






    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tabla = document.getElementById("listaProducto");
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
    </script>

</div>
