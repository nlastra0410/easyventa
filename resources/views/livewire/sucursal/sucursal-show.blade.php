<x-card cardTitle="Detalles Categoria">
    <x-slot:cardTools>
        <a href="{{route('sucursal')}}" class="btn " style="border-radius:16px; background-color: #084d68; color: white">
            Regresar
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-success card-outline" >
                <div class="card-body box-profile">
                    <h2 class="profile-username text-center">{{$category->name}}</h2>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <b>Usuarios</b> <a class="float-right">{{count($category->usuario)}}</a>
                        </li>
                    </ul>
                </div>
        
            </div>
        
        </div>

        <div class="col-md-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Perfil</th>
                        <th>Estado</th>
                        
                    </tr>
                </thead>
        
                <tbody>
                    @foreach ($category->usuario as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td >
                            <x-image :item="$product" size="100"/>
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->admin ? 'Administrador' : 'Vendedor'}}</td>
                        <td>{{$product->active ? 'Activo' : 'Inactivo'}}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</x-card>