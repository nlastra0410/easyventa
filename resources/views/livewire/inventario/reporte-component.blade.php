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

                <a href="{{ route('movimiento') }}" class="nav-link indi text-center" data-route="movimiento"
                    style="text-decoration: none; margin-right: 50px"><i class="fa-solid fa-arrow-right-arrow-left"></i>
                    Movimientos</a>

            </div>

            <div class="col-3 botones_inicio">

                <a href="{{ route('reporteIn') }}" class="nav-link indi text-center" data-route="reporteIn"
                    style="text-decoration: none; margin-right: 50px"><i class="fa-solid fa-file-circle-plus"></i>
                    Reporte inventario</a>

            </div>

            <div class="col-2 botones_inicio">
                <a href="{{route('kardex')}}" style="text-decoration: none; margin-right: 50px"
                    class="nav-link indi text-center" data-route="kardex"><i
                        class="fa-solid fa-file-circle-exclamation"></i> Kardex</a>
            </div>
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->

    </div>

    <div>
        <h1 class="text-center" style="margin-bottom: 80px">Reporte de Inventario</h1>

        <div class="row justify-content-center text-center">
            <div class="col-md-6">
                <span style="color: #084d68">
                    <b>Costo del Inventario</b>
                </span>

                <h4 style="color: rgb(121, 121, 121)">{{money($costoInventario)}}</h4>
            </div>

            <div class="col-md-6">
                <span style="color: #084d68">
                    <b>Cantidad de productos en Inventario</b>
                </span>

                <h4 style="color: rgb(121, 121, 121)">{{ nume($cantidadTotalStock) }}</h4>
            </div>
        </div>

        <div class="mb-3 d-flex justify-content-between"  style="margin-top: 80px">
            <div>
                <span>Mostrar</span>
                <select wire:model.live='cant' style="border-radius: 12px">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>Entradas</span>
            </div>

            <div class="d-flex flex-column align-items-center" style="margin-top: -25px">
                <span><b>Buscar por:</b></span>
                <input id="inputArticulo" wire:model.live='search' autofocus type="text" class="form-control" placeholder="Producto, SKU o Categoria" style="border-radius:12px;">
            </div>
    
            <div>
                <button wire:click="exportarExcel" class="btn" style="border-radius: 16px; background-color: #217346; color: white">
                    <i class="fa-regular fa-file-excel"></i> Exportar
                </button>
            </div>
        </div>
    </div>

    <div class="table-responsive">

        <table class="table text-center">  

            <thead>
    
                <th>SKU</th>
                <th>Producto</th>
                <th>Costo</th>
                <th>Precio Venta</th>
                <th>Existencia</th>
                <th>Stock mínimo</th>

            </thead>

            <tbody>
                @forelse ($sales as $sale)
                <tr>
                    <td>{{ $sale->SKU }}</td>
                    <td>{{ $sale->name }}</td>
                    <td>{{ money($sale->precio_compra) }}</td>
                    <td>{{ money($sale->precio_venta) }}</td>
                    <td>{!! $sale->stocks !!}</td>
                    <td>{{ $sale->stock_minimo }}</td>
                </tr>

                @empty
    
                <tr class="text-center">
                    <td colspan="6">Sin registros</td>
                </tr>
                @endforelse
            </tbody>

        </table>
        
        <div style="margin-top: 80px">{{ $sales->links() }}</div>

    </div>
</div>
