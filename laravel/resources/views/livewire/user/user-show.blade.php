<x-card cardTitle="Detalles Usuario">
    <x-slot:cardTools>
        <a href="{{route('users')}}" class="btn" style="border-radius:16px; background-color: #084d68; color: white">
            Volver
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <x-image :item="$user" size="250" />
                    </div>
                    <h2 class="profile-username text-center">{{$user->name}}</h2>
                    <p class="text-muted text-center">
                        {{$user->admin ? 'Administrador' : 'Vendedor'}}
                    </p>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <b>Correo</b> <a class="float-right">{{$user->email}}</a>
                        </li>
                        
                        <li class="list-group-item">
                            <b>Estado</b> <a class="float-right">{!!$user->activ!!}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Creado</b> <a class="float-right">{{$user->created_at}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Sucursal</b> <a class="float-right">{{$user->sucursal->name}}</a>
                        </li>
                        <a id="cobrarButton" class="btn bg-purple mt-4" style="font-size: 30px; border-radius:16px" wire:click='edit({{$user->id}})'>
                            <i class="fa-solid fa-pen"></i>
                            Editar
                        </a>
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

        <x-modal modalId="modalUser" modalTitle="Usuarios">
            <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
                <div class="form-row">
        
                    <!--Nombre-->
                    <div class="form-group col-12 col-md-6">
                        <label for="name">Nombre:</label>
                        <input wire:model='name' type="text" class="form-control" placeholder="Nombre" id="name" style="border-radius: 16px">
                        @error('name')
                            <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                        @enderror
                    </div>
        
                    <!--Email-->
                    <div class="form-group col-12 col-md-6">
                        <label for="email">Correo:</label>
                        <input wire:model='email' type="text" class="form-control" placeholder="Correo" id="email" style="border-radius: 16px">
                        @error('email')
                            <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                        @enderror
                    </div>
        
                    <!--password-->
                    <div class="form-group col-12 col-md-6">
                        <label for="password">Contraseña:</label>
                        <input wire:model='password' type="password" class="form-control" placeholder="Contraseña" id="password" style="border-radius: 16px">
                        @error('password')
                            <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                        @enderror
                    </div>
        
                    <!--password-->
                    <div class="form-group col-12 col-md-6">
                        <label for="re_password">Repetir Contraseña:</label>
                        <input wire:model='re_password' type="password" class="form-control" placeholder="Repetir Contraseña" id="re_password" style="border-radius: 16px">
                        @error('re_password')
                            <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                        @enderror
                    </div>
        
                    @if ($user->admin === 1)
                        <!--Check admin-->
                    <div class="form-group form-check col-md-6">
                        <div class="icheck-primary">
                            <input wire:model='admin' type="checkbox" id="admin">
                            <label class="form-check-label" for="admin">¿Es administrador?</label>
                        </div>
                    </div>
        
                    <!--Check admin-->
                    <div class="form-group form-check col-md-6">
                        <div class="icheck-primary">
                            <input wire:model='active' type="checkbox" id="active">
                            <label class="form-check-label" for="active">¿Está activo?</label>
                        </div>
                    </div>
                    @endif
                    
        
                    {{-- @if ($user->admin === 1)
                    <div class="form-group col-md-12">
                        <label for="sucursal_id">Sucursal:</label>
                        
                        <select wire:model='sucursal_id' id="sucursal_id" class="form-control" style="border-radius: 14px">
        
                            <option value="0">Seleccionar</option>
                            @foreach ($this->Sucursal as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
        
                        @error('sucursal_id')
        
                        <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>
        
                        @enderror
                        
                    </div>
                    @endif --}}
                    
        
                    <!-- Imagen-->
                    <div class="form-group col-md-12">
                        <label for="image">Imagen:</label><br>
                        <input wire:model='image' type="file" id="image" accept="image/*">
                    </div>
        
                    <!--imagen-->
                    <div class="col-md-12">
                        @if ($Id > 0)
                            <x-image :item="$user = App\Models\User::find($Id)" size="200" float="float-right" />
                        @endif
        
                        @if ($this->image)
                            <img src="{{$image->temporaryUrl()}}" class="rounded float-center" width="200">
                            
                        @endif
                    </div>
        
                </div>
                
                <hr>
                <button style="border-radius:16px; background-color: #084d68; color: white" class="btn float-right">{{$Id==0 ? 'Guardar' : 'Editar'}}</button>    
            </form>
         </x-modal>
    </div>

</x-card>