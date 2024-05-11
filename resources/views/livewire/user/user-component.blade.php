<div>
    <x-card cardTitle="Listado Usuarios ({{$this->totalRegistros}})">
       <x-slot:cardTools>
          <a href="#" class="btn btn-primary" wire:click='create'>
            <i class="fas fa-plus-circle"></i> Crear usuario
          </a>
       </x-slot>

       <x-table>
          <x-slot:thead>
             <th>ID</th>
             <th>Imágen</th>
             <th>Nombre</th>
             <th>Correo</th>
             <th>Sucursal</th>
             <th>Perfil</th>
             <th>Estado</th>
             <th width="3%">...</th>
             <th width="3%">...</th>
             <th width="3%">...</th>
 
          </x-slot>

          @forelse ($users as $user)
              
             <tr>
                <td>{{$user->id}}</td>
                <td>
                    <x-image :item="$user"/>
                </td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <a class="badge badge-secondary" style="font-size: 16px" href="{{route('sucursal.show',$user->sucursal->id)}}">{{$user->sucursal->name}}</a>
                </td>
                <td>{{$user->admin ? 'Administrador' : 'vendedor'}}</td>
                <td>{!!$user->activ!!}</td>
                <td>
                    <a href="{{route('users.show',$user)}}" class="btn btn-sm" title="Ver" style="border-radius:8px; background-color: #69C181; color: white">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
                <td>
                    <a href="#" wire:click='edit({{$user->id}})' class="btn btn-sm" title="Editar" style="border-radius:8px; background-color: #084d68; color: white">
                        <i class="far fa-edit"></i>
                    </a>
                </td>
                <td>
                    <a wire:click="$dispatch('delete',{id: {{$user->id}}, eventName:'destroyUser'})" class="btn btn-danger btn-sm" title="Eliminar" style="border-radius:8px; color: white">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td>
             </tr>

             @empty

             <tr class="text-center">
                <td colspan="10">Sin registros</td>
             </tr>
              
             @endforelse
 
       </x-table>
 
       <x-slot:cardFooter>
            {{$users->links()}}

       </x-slot>
    </x-card>


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
        <button class="btn btn-primary float-right">{{$Id==0 ? 'Guardar' : 'Editar'}}</button>    
    </form>
 </x-modal>

</div>