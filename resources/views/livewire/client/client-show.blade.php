<x-card cardTitle="Detalle cliente">
    <x-slot:cardTools>
        <a href="{{route('clients')}}" class="btn btn-primary" style="border-radius:16px; background-color: #084d68; color: white">
            Volver
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-body box-profile">
                    <h2 class="profile-username text-center">{{$client->name}}</h2>
                    <p class="text-muted text-center">
                        {{$client->rut}}
                    </p>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <b>Correo</b> <a class="float-right">{{$client->email}}</a>
                        </li>
                        
                        <li class="list-group-item">
                            <b>Teléfono</b> <a class="float-right">{{$client->telefono}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Creado</b> <a class="float-right">{{$client->created_at}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Suscripción</b> <a class="float-right"></a>
                        </li>
                    </ul>
                </div>
        
            </div>
        
        </div>

        <div class="col-md-8">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Precio Venta</th>
                        <th>Stock</th>
                        
                    </tr>
                </thead>
        
                <tbody>

                    {{-- @foreach ($category->products as $product)
                    <tr>
                        <td>{{$product->SKU}}</td>
                        <td >
                            <x-image :item="$product"/>
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{!!$product->precio!!}</td>
                        <td>{!!$product->stocks!!}</td>
                    </tr>
                    @endforeach --}}
                    

                </tbody>
            </table>
        </div>
    </div>

</x-card>