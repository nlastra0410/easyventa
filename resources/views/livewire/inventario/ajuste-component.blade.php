<div>

    <div class="content-header card">
        <div class="container">
            <div class="row ">
                <div class="col-2 botones_inicio">

                    <a href="{{ route('inventario') }}" class="nav-link indi text-center" data-route=""
                        style="text-decoration: none; margin-right: 50px;"><i class="fa-solid fa-circle-plus"></i>
                        Agregar</a>

                </div>

                <div class="col-2 botones_inicio">

                    <a href="{{ route('ajuste') }}" class="nav-link indi text-center" data-route="ajuste"
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


    <div style=" margin-top: 80px">

        <h1 class="text-center">Ajustar Inventario</h1>
        <div class="input-group">

            <input autofocus wire:model.live="SKU" type="search" type="search" wire:keydown.enter="BuscaInventario"
                placeholder="Ingresar producto" class="form-control mb-4" placeholder="Ingresar producto"
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
                                    <img src="{{ $product->imagen }}" class="product-image" alt="Product Image">
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
                                        <div class="info-box">
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
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info">
                                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                <lord-icon src="https://cdn.lordicon.com/pdsourfn.json" trigger="loop"
                                                    delay="1000" style="width:75px;height:75px">
                                                </lord-icon>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Agregar/Disminuir</span>
                                                <input type="number" placeholder="0" wire:model.live="difference"
                                                    style="border-radius: 10px; padding: 3px 50px; text-align: center; border-color:rgb(114, 114, 114);">
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info">
                                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                <lord-icon src="https://cdn.lordicon.com/sxrnyajs.json" trigger="loop"
                                                    delay="1000" style="width:75px;height:75px">
                                                </lord-icon>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Nueva Cantidad</span>
                                                <input type="number" placeholder="0" wire:model.live="newStock"
                                                    style="border-radius: 10px; padding: 3px 50px; text-align: center; border-color:rgb(114, 114, 114);">
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                    </div>






                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-info">
                                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                <lord-icon src="https://cdn.lordicon.com/ujxzdfjx.json" trigger="loop"
                                                    delay="1000" state="in-unfold" style="width:75px;height:75px">
                                                </lord-icon>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Motivo del ajuste</span>
                                                <textarea class="form-control" rows="1" wire:model="motivo"></textarea>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                    </div>

                                </div>

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

                                <button class="btn col-md-12 mt-5" wire:click="updateQuantity"
                                    style="border-radius: 16px; background-color: #084d68; color: white; font-size:30px;">
                                    <i class="fa-solid fa-arrow-rotate-right"></i> Realizar Ajuste</button>

                                <button class="btn btn-danger col-md-12 mt-2" wire:click="cancelSearch"
                                    style="border-radius: 16px; color: white; font-size:30px;">
                                    <i class="fa-solid fa-xmark"></i> Cancelar</button>
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





    </div>

</div>
