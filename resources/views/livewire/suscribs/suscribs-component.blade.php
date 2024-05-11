<div>
    <x-card cardTitle="Listado Suscripciones({{ $this->totalRegistros }})">

        <x-slot:cardTools>
            <a href="" class="btn btn-primary" wire:click='create' data-toggle="modal" data-target="#modalCategory">
                crear suscripción
                <i class="fa-solid fa-plus-circle"></i>
            </a>
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>

                <th>ID</th>
                <th>nombre</th>
                <th>Estado</th>
                <th>Código</th>
                <th width="3%">Ver</th>
                <th width="3%">Editar</th>
                <th width="3%">Eliminar</th>

            </x-slot>


            @forelse ($suscrib as $suscrib)
                <tr>
                    <td>{{ $suscrib->id }}</td>
                    <td>{{ $suscrib->name }}</td>
                    <td>{{ $suscrib->active ? 'Activo' : 'Inactivo'}}</td>
                    <td>{{ $suscrib->codigo }}</td>
                    <td>
                        <a href="{{route('suscrib.show',$suscrib)}}" class="btn btn-sm" title="Ver"
                            style="border-radius:8px; background-color: #69C181; color: white">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>

                    <td>
                        <a href="#" wire:click='edit({{ $suscrib->id }})' class="btn btn-sm" title="editar"
                            style="border-radius:8px; background-color: #084d68; color: white">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                    <td>
                        <a wire:click="$dispatch('delete',{id: {{ $suscrib->id }},eventName:'destroySuscrib'})"
                            class="btn btn-danger btn-sm" title="Eliminar" style="border-radius:8px; color: white">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>

            @empty

                <tr class="text-center">
                    <td colspan="7">Sin registros</td>
                </tr>
            @endforelse


        </x-table>

        {{-- <x-slot:cardFooter>
            {{ $Suscrib->links() }}
        </x-slot> --}}


    </x-card>

    <x-modal modalId="modalSuscrib" modalTitle="Suscripciones">

        <form wire:submit={{ $Id == 0 ? 'store' : "update($Id)" }}>
            <div class="form-row">

                <!--nombre-->
                <div class="form-group col-6">
                    <label for="name">Nombre:</label>
                    <input type="text" wire:model='name' class="form-control" placeholder="Nombre Suscripción"
                        id="name" style="border-radius: 14px">
                    @error('name')
                        <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                    @enderror


                </div>

                <!--codigo-->
                <div class="form-group col-6">
                    <label for="codigo">Código:</label>
                    <input type="text" wire:model='codigo' class="form-control" placeholder="Código Suscripción"
                        id="codigo" style="border-radius: 14px">
                    @error('codigo')
                        <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                    @enderror


                </div>

                <!--meses-->
                <div class="form-group col-6">
                    <label for="meses">Meses:</label>
                    <input type="number" wire:model='meses' class="form-control" placeholder="meses" id="Meses"
                        style="border-radius: 14px">
                    @error('meses')
                        <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                    @enderror


                </div>

                <!--costos meses-->
                <div class="form-group col-6">
                    <label for="costo">Costo:</label>
                    <input type="number" wire:model='costo' class="form-control" placeholder="Costo por mes"
                        id="costo" style="border-radius: 14px">
                    @error('costo')
                        <div class="aletr alert-danger w-100 mt-3">{{ $message }}</div>
                    @enderror


                </div>

                <!--Input active -->
            <div class="form-group col-md-12">
                <div class="icheck-primary">
                    <input wire:model="active" type="checkbox" id="active" checked>
                    <label for="active">¿Está Activo?</label>
                </div>
                @error('active')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>


            </div>




            <hr>
            <button class="btn float-right"
                style="background-color: #0D7685; border-radius: 16px; color: white">{{ $Id == 0 ? 'Guardar' : 'Editar' }}</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                style="border-radius: 16px;">Cancelar</button>
        </form>

    </x-modal>
</div>
