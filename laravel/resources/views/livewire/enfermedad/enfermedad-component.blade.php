<div>
    <x-card cardTitle="Listado de Enfermedades ({{$this->totalRegistros}})">
        <x-slot:cardTools>
        <button type="button" class="btn " wire:click='create' style="border-radius: 16px; background-color: #084d68; color: white">
           Registar Enfermedad
           <i class="fa-solid fa-plus-circle"></i>
        </button>
        </x-slot>
        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Nombre</th>
                <th width="3%">Ver</th>
                <th width="3%">Editar</th>
                <th width="3%">Eliminar</th>
                </x-slot>

                @forelse($categories as $Category)

                
        
                <tr>
                    <td>{{$Category->id}}</td>
                    <td>{{$Category->name}}</td>
                    <td>
                        <a href="{{route('enfermedad.show',$Category)}}" class="btn btn-sm" title="Ver" style="border-radius:8px; background-color: #69C181; color: white">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
        
                    <td>
                        <a href="#" wire:click='edit({{$Category->id}})' class="btn btn-sm" title="editar" style="border-radius:8px; background-color: #084d68; color: white">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                    <td>
                        <a href="#" wire:click="$dispatch('delete',{id:{{$Category->id}} , eventName:'destroyCategory' })" class="btn btn-danger btn-sm" title="Eliminar" style="border-radius:8px">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>

                @empty

                <tr class="text-center">
                    <td colspan="5">Sin Registros</td>
                </tr>

                @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{$categories -> links()}}

        </x-slot>

    </x-card>

<x-modal modalId="modalCategory" modalTitle="Nueva Enfermedad">

    <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="name">Nombre:</label>
                <input wire:model='name' type="text" class="form-control" placeholder="Nombre Enfermedad" id="name" style="border-radius: 14px">
                @error('name')
                <div class="alert alert-danger w-100 mt-3">{{$message}}</div>
                @enderror
            </div>
        </div>
        
    
        <hr>
        <button class="btn float-right" style="background-color: #0D7685; border-radius: 16px; color: white">{{$Id==0 ? 'Guardar': 'Editar'}}</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius: 16px;">Cancelar</button>
    </form>

</x-modal>
</div>