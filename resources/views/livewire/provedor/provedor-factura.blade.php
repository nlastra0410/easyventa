<!-- Dentro de tu vista de blade -->
<?php
$rut = $proveedor->rut;

// Separar el RUT en parte numérica y dígito verificador
$rutNumerico = substr($rut, 0, -1);
$digitoVerificador = substr($rut, -1);

// Convertir la parte numérica del RUT a un número entero
$rutNumerico = (int) $rutNumerico;

// Agregar los puntos al RUT formateado
$rutFormateado = number_format($rutNumerico, 0, '', '.');

// Concatenar el dígito verificador y el guion
$rutFormateado .= '-' . $digitoVerificador;

?>

<div>

    <style>
        /* Estilos adicionales si es necesario */
        .notification {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
        }

        #proveedor:hover+.notification {
            display: block;
        }

        .alert {
            position: relative;
            z-index: 1;
        }

        input.focus {
            border-color: #084d68;
            /* Cambiar color del borde cuando está enfocado */
            box-shadow: 0 0 0 0.2rem rgba(8, 77, 104, 0.25);
            /* Agregar una sombra cuando está enfocado */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inputFirst').on('keyup', function() {
                // Espera 500ms después de que se deja de escribir
                setTimeout(function() {
                    // Cambia el enfoque al siguiente input
                    $('#agrega').focus();
                }, 100);
            });
        });

        $('#agrega').on('keyup', function(event) {
        if (event.keyCode === 13) { // 13 es el código de tecla para "Enter"
            document.getElementById('salePrice').focus();
        }
    });
    </script>



    <div>
        <h1 class="text-center mt-5"><b>Nuevo Ingreso de productos</b></h1>
        <p id="proveedor" class="text-muted text-center" style="font-size: 25px">
            <a href="{{ route('proveedor.show', $proveedor) }}"
                style="text-decoration: none; color:rgb(120, 120, 120)">{{ $proveedor->nombre }}</a>

        </p>
    </div>

    <div class="input-group">
        <input autofocus wire:model.live="SKU" type="search" wire:keydown.enter="BuscaInventario" id="inputFirst"
            placeholder="Ingresar producto" class="form-control mb-4"
            style="align-items: center; border-radius: 20px; margin-top:20px; padding: 25px 510px; text-align: center; border-color:rgb(114, 114, 114);">


    </div>

    @if ($product)
        <div>
            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-5">
                            <div class="col-12">
                                <img src="{{ $product->imagen }}" class="product-image" alt="Product Image"
                                    style="width: 75%;">
                            </div>
                            <div class="col-12 product-image-thumbs">
                                <div class="product-image-thumb">
                                    <!--<img src="../../dist/img/prod-1.jpg" alt="Product Image">-->
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-sm-7">
                            <h3 class="my-3">{{ $product->name }}</h3>
                            <p>{{ $product->descripcion }}</p>

                            <hr>

                            <div class="row">
                                <!-- Caja stock -->
                                <div class="col-md-6">
                                    <div class="info-box" style="border-radius: 16px;">
                                        <span class="info-box-icon bg-info" style="border-radius: 12px">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon src="https://cdn.lordicon.com/zkhgauna.json" trigger="loop"
                                                delay="1000" style="width:75px;height:75px">
                                            </lord-icon>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Stock</span>
                                            <span class="info-box-number"
                                                style="font-size: 20px">{!! $product->stocks !!}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box" style="border-radius: 16px;">
                                        <span class="info-box-icon bg-info" style="border-radius: 12px">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon src="https://cdn.lordicon.com/pcllgpqm.json" trigger="loop"
                                                delay="1000" state="hover-squeeze" style="width:75px;height:75px">
                                            </lord-icon>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Categoría</span>
                                            <span class="info-box-number"
                                                style="font-size: 20px">{{ $product->category->name }}</span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box" style="border-radius: 16px;">
                                        <span class="info-box-icon bg-info" style="border-radius: 12px">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon src="https://cdn.lordicon.com/pdsourfn.json" trigger="loop"
                                                delay="1000" style="width:75px;height:75px">
                                            </lord-icon>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Agregar</span>
                                            <input type="text" placeholder="Agregar Stock" wire:model="newStock"
                                                id="agrega" class="form-control"
                                                style="border-radius: 10px; padding: 3px 5px; text-align: center; border-color:rgb(114, 114, 114);">

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="info-box" style="border-radius: 16px;">
                                        <span class="info-box-icon bg-info" style="border-radius: 12px">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon src="https://cdn.lordicon.com/qnstsxhd.json" trigger="loop"
                                                delay="1000" state="in-oscillate"
                                                colors="primary:#121331,secondary:#16c79e,tertiary:#ebe6ef,quaternary:#ffc738"
                                                style="width:75px;height:75px">
                                            </lord-icon>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Precio compra</span>
                                            <input type="text" wire:model="salePrice" id="salePrice"
                                                class="form-control"
                                                style="border-radius: 10px; padding: 3px 5px; text-align: center; border-color:rgb(114, 114, 114);">

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-box" style="border-radius: 16px;">
                                        <span class="info-box-icon bg-info" style="border-radius: 12px">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon src="https://cdn.lordicon.com/jtiihjyw.json" trigger="loop"
                                                delay="1000" state="hover-spending" style="width:75px;height:75px">
                                            </lord-icon>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Precio Venta</span>
                                            <input type="text" wire:model="costPrice" id="input4"
                                                class="form-control"
                                                style="border-radius: 10px; padding: 3px 5px; text-align: center; border-color:rgb(114, 114, 114);">

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box" style="border-radius: 16px;">
                                        <span class="info-box-icon bg-info" style="border-radius: 12px">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon src="https://cdn.lordicon.com/dhuliaty.json" trigger="loop"
                                                delay="1000" state="hover-rotate"
                                                colors="primary:#121331,secondary:#bcee66"
                                                style="width:75px;height:75px">
                                            </lord-icon>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Precio EasyFarma</span>
                                            <input type="text" wire:model="salePL"
                                                wire:keydown.enter="updateQuantity" id="input5"
                                                class="form-control"
                                                style="border-radius: 10px; padding: 3px 5px; text-align: center; border-color:rgb(114, 114, 114);">

                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>

                                <button class="btn col-md-12 mt-5" wire:click="updateQuantity"
                                    style="border-radius: 16px; background-color: #084d68; color: white; font-size:30px;">
                                    <i class="fa-solid fa-arrow-rotate-right"></i> Actualizar Cantidad</button>

                                <button class="btn btn-danger col-md-12 mt-2" wire:click="cancelSearch"
                                    style="border-radius: 16px; color: white; font-size:30px;">
                                    <i class="fa-solid fa-xmark"></i> Cancelar</button>


                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        @else
            <div>
                <h1 class="text-center" style="margin-top: 300px; color:rgb(139, 139, 139)">No hay resultados</h1>
            </div>
    @endif


    <div id="notification" class="notification" style="z-index: 1050; display: none;">
        <div class="card w-95"
            style="border-radius: 40px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.302); margin-bottom: 80px;margin-right: 100px;">
            <div class="card-body">
                <h5 class="card-title text-center" style="font-size: 50px"><b>{{ $proveedor->nombre }}</b></h5>
                <p class="card-text text-center"><b>Rut:</b> {{ $rutFormateado }}</p>
                <p class="card-text text-center"><b>Teléfono:</b> {{ $proveedor->telefono }}</p>
                <p class="card-text text-center"><b>Nota:</b> <span class="badge badge-success"
                        style="font-size: 18px">{{ $proveedor->nota }}</span></p>
            </div>
        </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Espera a que el DOM esté listo
        $(document).ready(function() {
            // Selecciona el párrafo con el id "proveedor"
            $('#proveedor').mouseover(function() {
                // Muestra la notificación cuando el mouse pasa sobre el párrafo
                $('#notification').show();
            }).mouseout(function() {
                // Oculta la notificación cuando el mouse deja el párrafo
                $('#notification').hide();
            });
        });
    </script>
</div>
