<div>
    <x-card cardTitle="Listado Clientes ({{$this->totalRegistros}})">
       <x-slot:cardTools>
          <a href="#" class="btn btn-primary" wire:click='create'>
            <i class="fas fa-plus-circle"></i> Nuevo Cliente
          </a>
       </x-slot>

       <x-table>
          <x-slot:thead>
             <th>ID</th>
             <th>Nombre</th>
             <th>Rut</th>
             <th>Correo</th>
             <th>Teléfono</th>
             <th width="3%">...</th>
             <th width="3%">...</th>
             <th width="3%">...</th>
 
          </x-slot>

          @forelse ($clientes as $cliente)
              
             <tr>
                <td>{{$cliente->id}}</td>
                <td>{{$cliente->name}}</td>
                <td>{{$cliente->rut}}</td>
                <td>{{$cliente->email}}</td>
                <td>{{$cliente->telefono}}</td>
                <td>
                    <a href="{{route('clients.show',$cliente)}}" class="btn btn-sm" title="Ver" style="border-radius:8px; background-color: #69C181; color: white">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
                <td>
                    <a href="#" wire:click='edit({{$cliente->id}})' class="btn btn-sm" title="Editar" style="border-radius:8px; background-color: #084d68; color: white">
                        <i class="far fa-edit"></i>
                    </a>
                </td>
                <td>
                    <a wire:click="$dispatch('delete',{id: {{$cliente->id}}, eventName:'destroyClient'})" class="btn btn-danger btn-sm" title="Eliminar" style="border-radius:8px; color: white">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td>
             </tr>

             @empty

             <tr class="text-center">
                <td colspan="8">Sin registros</td>
             </tr>
              
             @endforelse
 
       </x-table>
 
       <x-slot:cardFooter>
            {{$clientes->links()}}

       </x-slot>
    </x-card>


 <x-modal modalId="modalClient" modalTitle="Clientes">
    <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
        <div class="form-row">

            <!-- name-->
            <div class="form-group col-6">
                <label for="name">Nombre:</label>
                <input wire:model='name' type="text" class="form-control" placeholder="Nombre Cliente" id="name" style="border-radius: 16px">
                @error('name')
                    <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                @enderror
            </div>

            <!-- rut-->
            <div class="form-group col-6">
                <label for="rut">Rut:</label>
                <input wire:model='rut' type="text" class="form-control" placeholder="Rut Cliente" id="rut" style="border-radius: 16px">
                @error('rut')
                    <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                @enderror
            </div>

            <!-- telefono-->
            <div class="form-group col-12">
                <label for="telefono">Teléfono:</label>
                <input wire:model='telefono' type="text" class="form-control" placeholder="Telefono Cliente" id="telefono" style="border-radius: 16px">
                @error('telefono')
                    <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                @enderror
            </div>

            <!-- email-->
            <div class="form-group col-12">
                <label for="email">Correo:</label>
                <input wire:model='email' type="text" class="form-control" placeholder="Correo" id="email" style="border-radius: 16px">
                @error('email')
                    <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                @enderror
            </div>

            <!-- password-->
            <div class="form-group col-6">
                <label for="password">Contraseña:</label>
                <input wire:model='password' type="password" class="form-control" placeholder="Contraseña" id="password" style="border-radius: 16px">
                @error('password')
                    <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                @enderror

                
            </div>

            <!-- re_password-->
            <div class="form-group col-6">
                <label for="re_password">Repetir Contraseña:</label>
                <input wire:model='re_password' type="password" class="form-control" placeholder="Repetir Contraseña" id="re_password" style="border-radius: 16px">
                @error('re_password')
                    <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                @enderror

                
            </div>

            <div class="form-group col-12">
                <p class="text-muted text-center mt-2">
                    Los campos de correo y contraseña son opcionales
                </p>
            </div>

        </div>
        
        <hr>
        <button class="btn float-right" style="background-color: #0D7685; border-radius: 16px; color: white">{{$Id==0 ? 'Guardar' : 'Editar'}}</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius: 16px;">Cancelar</button>   
    </form>
 </x-modal>

</div>