<div>
    <style>
        .table-kardex {
            width: 100%;
            border-collapse: collapse;
        }

        .table-kardex th,
        .table-kardex td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .section-header {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* Estilo para las secciones de la tabla */
        .table-kardex tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
    </style>
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

                    <a href="{{ route('movimiento') }}" class="nav-link indi text-center" data-route="movimiento"
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

    <div style="margin-top: 80px">
        <h1 class="text-center">Kardex de Inventario</h1>

        <div class="input-group">

            <input autofocus wire:model.live="SKU" type="search" wire:keydown.enter="buscarProducto"
                placeholder="Ingresar producto" class="form-control mb-4" placeholder="Ingresar producto"
                style="align-items: center; border-radius: 20px; margin-top:20px; padding: 25px 510px; text-align: center; border-color:rgb(114, 114, 114);">
        </div>

        @if ($product)
            <div>
                <h1 class="text-center"><b>Nombre del Producto: </b> {{ $product->name }}</h1>

                <div class="d-flex justify-content-center" style="margin-top: 50px">
                    <p class="mr-3"><b>Categoría: </b>{{ $product->category->name }}</p>
                    <p class="mr-3" style="font-size: 18px"><b>Existencia Actual: </b>{!! $product->stocks !!}</p>
                    <p><b>Inventario Mínimo: </b>{{ $product->stock_minimo }}</p>
                </div>
            </div>

            @if ($adjustments->count() > 0)
                <table class="table-kardex">
                    <thead>
                        <tr>
                            <th colspan="3">Información</th>
                            <th colspan="3">Entradas</th>
                            <th colspan="3">Salidas</th>
                            <th colspan="3">Existencia</th>
                        </tr>
                        <tr>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            <th>Cantidad</th>
                            <th>Precio Costo</th>
                            <th>Total Entrada</th>
                            <th>Cantidad</th>
                            <th>Precio Costo</th>
                            <th>Total Salida</th>
                            <th>Cantidad</th>
                            <th>Precio Costo</th>
                            <th>Total Existencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adjustments as $adjustment)
                            <tr>
                                <!-- Información del producto -->
                                <td>{{ $adjustment->user->name }}</td>
                                <td>{{ $adjustment->created_at->format('d-m-Y') }}</td>
                                <td class="text-center">{{ $adjustment->motivo }}
                                    @if ($adjustment->proveedor)
                                        @php
                                            // Generar un código hexadecimal de color único basado en el nombre del proveedor
                                            $color = '#' . substr(md5($adjustment->proveedor->nombre), 0, 6);
                                        @endphp
                                        <span class="badge rounded-pill"
                                            style="margin-left: 8px; font-size: 15px; background-color: {{ $color }}">{{ $adjustment->proveedor->nombre }}</span>
                                    @else
                                        <span class="badge rounded-pill badge-secondary"
                                            style="margin-left: 8px; font-size: 15px"></span>
                                    @endif
                                </td>

                                <!-- Verificar si el ajuste representa una salida o una entrada -->
                                @if ($adjustment->stockA < $adjustment->stockV)
                                    <!-- Información de las salidas -->
                                    <td></td> <!-- Opcional: puedes agregar más información aquí si es necesario -->
                                    <td></td>
                                    <td></td>
                                    <td>{{ $adjustment->cantidad }}</td> <!-- Cantidad como valor absoluto -->
                                    <td>{{ money($product->precio_compra) }}</td>
                                    <td>{{ moneyN($adjustment->cantidad * $product->precio_compra) }}</td>
                                @else
                                    <!-- Información de las entradas -->
                                    <td>{{ $adjustment->cantidad }}</td>
                                    @if ($adjustment->motivo == 'Recepción de inventario')
                                        <td>{{ money($adjustment->precio) }}</td>
                                        <td>{{ money($adjustment->cantidad * $adjustment->precio) }}</td>
                                    @else
                                        <td>{{ money($product->precio_compra) }}</td>
                                        <td>{{ money($adjustment->cantidad * $product->precio_compra) }}</td>
                                    @endif
                                    <td></td> <!-- Opcional: puedes agregar más información aquí si es necesario -->
                                    <td></td>
                                    <td></td>
                                @endif

                                <!-- Información de la existencia -->
                                <td>{{ $adjustment->stockA }}</td>
                                <td>{{ money($product->precio_compra) }}</td>
                                <td>{{ money($adjustment->stockA * $product->precio_compra) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            @else
                <p>No se encontraron ajustes para este producto.</p>
            @endif
        @endif
    </div>
</div>
