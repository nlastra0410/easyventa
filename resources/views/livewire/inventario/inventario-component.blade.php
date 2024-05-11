<div>

    @if ($pro)
        <?php
        $rut = $pro->rut;
        
        // Separar el RUT en parte numérica y dígito verificador
        $rutNumerico = substr($rut, 0, -1);
        $digitoVerificador = substr($rut, -1);
        
        // Agregar los puntos al RUT
        $rutFormateado = number_format($rutNumerico, 0, '', '.');
        
        // Concatenar el dígito verificador y el guion
        $rutFormateado .= '-' . $digitoVerificador;
        ?>
    @endif

    <div class="content-header card">
        <div class="container">
            <div class="row ">
                <div class="col-2 botones_inicio">

                    <a href="{{ route('inventario') }}" class="nav-link indi text-center" data-route=""
                        style="text-decoration: none; margin-right: 50px;"><i class="fa-solid fa-circle-plus"></i>
                        Agregar</a>

                </div>

                <div class="col-2 botones_inicio">

                    <a href="{{ route('ajuste') }}" class="nav-link indi text-center" data-route=""
                        style="text-decoration: none; margin-right: 50px"><i class="fa-solid fa-pencil"></i> Ajustes</a>

                </div>

                <div class="col-3 botones_inicio">

                    <a href="{{ route('movimiento') }}" class="nav-link indi text-center" data-route="products"
                        style="text-decoration: none; margin-right: 50px"><i
                            class="fa-solid fa-arrow-right-arrow-left"></i>
                        Movimientos</a>

                </div>

                <div class="col-3 botones_inicio">

                    <a href="{{ route('reporteIn') }}" class="nav-link indi text-center" data-route="reporteIn"
                        style="text-decoration: none; margin-right: 50px"><i class="fa-solid fa-file-circle-plus"></i>
                        Reporte inventario</a>

                </div>

                <div class="col-2 botones_inicio">
                    <a href="{{ route('kardex') }}" style="text-decoration: none; margin-right: 50px"
                        class="nav-link indi text-center" data-route="kardex"><i
                            class="fa-solid fa-file-circle-exclamation"></i> Kardex</a>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

    </div>


    <div style="margin-top: 100px">

        <h1 class="text-center">Agregar nuevo stock</h1>
        <div class="input-group">
            <input autofocus wire:model.live="SKU" type="search" wire:keydown.enter="BuscaInventario"
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

                                @if ($pro)
                                    <div class="col-md-12">
                                        <div class="card card-body"
                                            style="border-radius: 40px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.302); ">
                                            <h1 class="profile-username text-center" style="font-size: 45px">
                                                {{ $pro->nombre }}</h1>
                                            <p class="text-muted text-center">
                                                {{ $rutFormateado }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <img src="{{ $product->imagen }}" class="product-image" alt="Product Image">
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
                                            <span class="info-box-icon bg-info">
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
                                            <span class="info-box-icon bg-info">
                                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                <lord-icon src="https://cdn.lordicon.com/pdsourfn.json" trigger="loop"
                                                    delay="1000" style="width:75px;height:75px">
                                                </lord-icon>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Agregar</span>
                                                <input type="text" placeholder="Agregar Stock" wire:model="newStock"
                                                    class="form-control"
                                                    style="border-radius: 10px; padding: 3px 5px; text-align: center; border-color:rgb(114, 114, 114);">
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box" style="border-radius: 16px;">
                                            <span class="info-box-icon bg-info">
                                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                <lord-icon src="https://cdn.lordicon.com/amfpjnmb.json" trigger="loop"
                                                    delay="1000"
                                                    colors="primary:#121331,secondary:#ebe6ef,tertiary:#3a3347,quaternary:#9cc2f4,quinary:#646e78"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Ingresar Rut del proveedor</span>
                                                <input type="text" placeholder="Ingresar Rut del Proveedor"
                                                    wire:model.live="rutProv" wire:keydown.enter="BuscaProvee"
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
                                                <lord-icon src="https://cdn.lordicon.com/qnstsxhd.json" trigger="loop"
                                                    delay="1000" state="in-oscillate"
                                                    colors="primary:#121331,secondary:#16c79e,tertiary:#ebe6ef,quaternary:#ffc738"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Precio compra</span>
                                                <input type="text" wire:model="salePrice" id="stock"
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
                                                    delay="1000" state="hover-spending"
                                                    style="width:75px;height:75px">
                                                </lord-icon>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Precio Venta</span>
                                                <input type="text" wire:model="costPrice" id="stock"
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
                                                    wire:keydown.enter="updateQuantity" id="stock"
                                                    class="form-control"
                                                    style="border-radius: 10px; padding: 3px 5px; text-align: center; border-color:rgb(114, 114, 114);">

                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                    </div>




                                </div>

                                <button class="btn col-md-12 mt-5" wire:click="updateQuantity"
                                    style="border-radius: 16px; background-color: #084d68; color: white; font-size:30px;">
                                    <i class="fa-solid fa-arrow-rotate-right"></i> Actualizar Cantidad</button>

                                <button class="btn btn-danger col-md-12 mt-2" wire:click="cancelSearch"
                                    style="border-radius: 16px; color: white; font-size:30px;">
                                    <i class="fa-solid fa-xmark"></i> Cancelar</button>

                                {{-- <div class="row justify-content-between">
                                    <div class="bg-success py-2 px-3 mt-4 col-md-6">
                                        <input wire:model="costPrice"
                                            class="mb-0 border-0 bg-transparent border-bottom border-dark"
                                            style="color:white; font-size: 35px; border-bottom: 5px">

                                        <h4 class="mt-0">
                                            <small>Precio venta </small>
                                        </h4>
                                    </div>


                                    <div class="bg-gray py-2 px-3 mt-4 col-md-6 ">
                                        <input class="mb-0 border-0 bg-transparent border-bottom border-dark"
                                            wire:model="salePrice"
                                            style="color:white; font-size: 35px; border-bottom: 5px">

                                        <h4 class="mt-0">
                                            <small>Precio compra</small>
                                        </h4>
                                    </div>

                                </div> --}}


                                {{-- <div class="row text-center ">

                                    <div class="bg-blue py-2 px-3 mt-4 col-md-12" style="border-radius: 20px">
                                        <input
                                            class="mb-0 border-0 bg-transparent border-bottom border-dark text-center"
                                            wire:model="salePL"
                                            style="color:white; font-size: 35px; border-bottom: 5px">

                                        <h4 class="mt-0">
                                            <small>Precio EasyFarma Plus</small>
                                        </h4>
                                    </div>

                                </div> --}}


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

        <x-modal modalId="modalProveedor" modalTitle="El proveedor no existe, registralo" modalSize="modal-lg">

            <form wire:submit="store">
                <div class="form-row">
                    {{-- Nombre de la empresa --}}
                    <div class="form-group col-6">
                        <label for="name">Nombre:</label>
                        <input type="text" wire:model='name' class="form-control" placeholder="Nombre Proveedor"
                            id="name" style="border-radius: 14px">
                        @error('name')
                            <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                        @enderror


                    </div>

                    {{-- Rut de la empresa --}}
                    <div class="form-group col-6">
                        <label for="rut">Rut:</label>
                        <input type="text" wire:model='rut' class="form-control" placeholder="Rut Proveedor"
                            id="rut" style="border-radius: 14px">
                        @error('rut')
                            <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                        @enderror


                    </div>

                    <div class="form-group col-12">
                        <label for="email">Correo:</label>
                        <input type="text" wire:model='email' class="form-control" placeholder="Correo Proveedor"
                            id="email" style="border-radius: 14px">
                        @error('email')
                            <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                        @enderror


                    </div>

                    <div class="form-group col-6">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" wire:model='telefono' class="form-control"
                            placeholder="Teléfono Proveedor" id="telefono" style="border-radius: 14px">
                        @error('telefono')
                            <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                        @enderror


                    </div>

                    <div class="form-group col-6">
                        <label for="info_contacto">Segundo contacto:</label>
                        <input type="text" wire:model='info_contacto' class="form-control"
                            placeholder="Segunda contacto (opcional)" id="info_contacto" style="border-radius: 14px">
                        @error('info_contacto')
                            <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                        @enderror


                    </div>

                    <div class="form-group col-12">
                        <label for="direccion">Dirección:</label>
                        <input type="text" wire:model='direccion' class="form-control"
                            placeholder="Dirección Proveedor" id="direccion" style="border-radius: 14px">
                        @error('direccion')
                            <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                        @enderror


                    </div>

                    <div class="form-group col-12">
                        <label for="nota">Información:</label>
                        <input type="text" wire:model='nota' class="form-control"
                            placeholder="Información adicional (opcional)" id="nota"
                            style="border-radius: 14px">
                        @error('nota')
                            <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                        @enderror


                    </div>
                </div>


                <hr>
                <button class="btn float-right"
                    style="background-color: #0D7685; border-radius: 16px; color: white">{{ $Id == 0 ? 'Guardar' : 'Editar' }}</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                    style="border-radius: 16px;">Cancelar</button>
            </form>

        </x-modal>





    </div>

    @section('styles')
        <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    @endsection

    @section('js')
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

        <script>
            Livewire.on('reinitializeSelect2', function() {
                $("#select2").select2({
                    theme: "bootstrap4"
                });
            });

            $("#select2").on('change', function() {
                Livewire.dispatch('provee_id', {
                    id: $(this).val()
                })
            });
        </script>
    @endsection

</div>
