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
        <h1 class="text-center" style="margin-bottom: 80px">Historial de Movimientos de Inventario</h1>

        <div class="mb-3 d-flex justify-content-between">
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

            <div>
                <span>
                    <b>Movimientos</b>
                </span>
                <select wire:model.live="selectedType" style="border-radius: 12px">
                    <option value="">Todos</option>
                    <option value="Entrada">Entrada</option>
                    <option value="Ajuste">Ajuste</option>
                    <option value="Salida">Salida</option>
                </select>
            </div>

            <div>
                <div class="row" style="margin-top: -33px">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Fecha de inicio:</label>
                            <input id="start_date" wire:model.live="startDate" type="date" class="form-control" style="border-radius:12px">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">Fecha de fin:</label>
                            <input id="end_date" wire:model.live="endDate" type="date" class="form-control" style="border-radius:12px">
                        </div>
                    </div>
                </div>
                
            </div>

            <div style="margin-top: -28px">
                <span><b>Buscar por:</b></span>
                <input id="inputArticulo" wire:model.live='search' autofocus type="text" class="form-control" placeholder="Producto, SKU" style="border-radius:12px">
            </div>
        </div>

        <div class="table-responsive">

            <table class="table text-center">
            
                
                <thead>
    
                    <th>Proveedor</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Movimiento</th>
                    <th>Había</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Hay</th>
                    <th>Usuario</th>
    
                </thead>
                    
                @forelse ($movimientos as $move)
                    
                
                <tr>
                    <td>
                        @if ($move->proveedor)
                            <span class="badge badge-info" style="font-size: 18px">{{ $move->proveedor->nombre }}</span>
                    
                        @else
                            <span class="badge badge-danger" style="font-size: 18px">Sin Registro</span>
                        @endif
                    </td>
                    <td>{{$move->created_at}}</td>
                    <td>{{$move->product->name}}</td>
                    <td>{{$move->motivo}}</td>
                    <td>{{$move->stockV}}</td>
                    {{-- Tipo de movimientos --}}
                    @if($move->type == 'Salida')
                        <td>
                            <span class="badge badge-secondary" style="font-size: 18px">Salida</span>
                        </td>
                    
                    @elseif($move->type == 'Entrada')
                        <td>
                            <span class="badge badge-success" style="font-size: 18px">Entrada</span>
                        </td>
    
                    @elseif($move->type == 'Ajuste')
                        <td>
                            <span class="badge bg-warning" style="font-size: 18px">Ajuste</span>
                        </td>
    
                    @else
                        <td>
                            {{$move->type}}
                        </td>
                    @endif
    
                    {{-- FIn del tipo de movimientos --}}
                    <td>{{$move->cantidad}}</td>
                    <td>{{$move->stockA}}</td>
                    <td><b>{{$move->user->admin ? 'Administrador' : 'Vendedor'}}:</b> {{$move->user->name}}</td>
                </tr>
    
                @empty
    
                <tr class="text-center">
                    <td colspan="9">Sin registros</td>
                </tr>
                    
                @endforelse
                    
    
    
            </table>

        </div>

        

        <div >
            {{$movimientos->links()}}
        </div>
        
    </div>
</div>
