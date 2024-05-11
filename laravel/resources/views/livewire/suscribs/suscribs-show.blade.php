<x-card cardTitle="Detalles Suscripción">
    <x-slot:cardTools>
        <a href="{{route('suscrib')}}" class="btn" style="border-radius:16px; background-color: #084d68; color: white">
            Volver
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-body box-profile">
                    <h2 class="profile-username text-center">{{$suscrib->name}}</h2>
                    <p class="text-muted text-center">
                        {!!$suscrib->activ!!}
                    </p>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <b>Código</b> <a class="float-right">{{$suscrib->codigo}}</a>
                        </li>
                        
                        <li class="list-group-item">
                            <b>Meses</b> <a class="float-right">{{$suscrib->meses}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Costo por mes</b> <a class="float-right">{!!$suscrib->precio!!}</a>
                        </li>
                    </ul>
                </div>
        
            </div>
        
        </div>

        <div class="col-md-8">
            <table class="table text-center">
                <h1 class="text-center" style="color: #084d68">Suscriptores</h1>
                <thead>
                    <tr>
                        <th>Rut</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        
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