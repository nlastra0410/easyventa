<div>
    <x-card cardTitle="Listado Proveedores({{$this->totalRegistros}})">

        <x-slot:cardTools>
            <a href="" class="btn" wire:click='create' data-toggle="modal" data-target="#modalProveedor" style="border-radius: 16px; background-color: #084d68; color: white">
                Nuevo Proveedor
                <i class="fa-solid fa-plus-circle"></i>
            </a>
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>

                <th>ID</th>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th width="3%">Ver</th>
                <th width="3%">Ingreso</th>
                <th width="3%">Editar</th>

            </x-slot>


            @forelse ($proveedores as $proveedor)
                
            
            <tr>
                <td>{{$proveedor->id}}</td>
                <td>{{ number_format((int) substr($proveedor->rut, 0, -1), 0, '', '.') . '-' . substr($proveedor->rut, -1) }}</td>
                <td>{{$proveedor->nombre}}</td>
                <td>{{$proveedor->telefono}}</td>
                <td>
                    <a href="{{route('proveedor.show',$proveedor)}}"  class="btn" title="Ver"
                        style="border-radius:8px; background-color: #69C181; color: white">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </td>

                <td>
                    <a href="{{route('proveedor.factura',$proveedor)}}"  class="btn bg-purple" title="Ver"
                        style="border-radius:8px; color: white">
                        <i class="fa-solid fa-file-circle-plus"></i> 
                    </a>
                </td>

                <td>
                    <a href="#" wire:click='edit({{$proveedor->id}})' class="btn" title="editar"
                        style="border-radius:8px; background-color: #084d68; color: white">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
            </tr>

            @empty

            <tr class="text-center">
                <td colspan="6">Sin registros</td>
            </tr>
                
            @endforelse


        </x-table>

        <x-slot:cardFooter>
            {{$proveedores->links()}}
        </x-slot>


    </x-card>

    <x-modal modalId="modalProveedor" modalTitle="Proveedores" modalSize="modal-lg">

        <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
            <div class="form-row">
                {{-- Nombre de la empresa --}}
                <div class="form-group col-6">
                    <label for="name">Nombre:</label>
                    <input type="text" wire:model='name' class="form-control" placeholder="Nombre Proveedor" id="name" style="border-radius: 14px">
                    @error('name')

                    <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                    @enderror
                    
                    
                </div>

                {{-- Rut de la empresa --}}
                <div class="form-group col-6">
                    <label for="rut">Rut:</label>
                    <input type="text" wire:model='rut' class="form-control" placeholder="Rut Proveedor" id="rut" style="border-radius: 14px" oninput="formatRut(this)">
                    @error('rut')

                    <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                    @enderror
                    
                    
                </div>

                <div class="form-group col-12">
                    <label for="email">Correo:</label>
                    <input type="text" wire:model='email' class="form-control" placeholder="Correo Proveedor" id="email" style="border-radius: 14px">
                    @error('email')

                    <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                    @enderror
                    
                    
                </div>

                <div class="form-group col-6">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" wire:model='telefono' class="form-control" placeholder="Teléfono Proveedor" id="telefono" style="border-radius: 14px">
                    @error('telefono')

                    <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                    @enderror
                    
                    
                </div>

                <div class="form-group col-6">
                    <label for="info_contacto">Segundo contacto:</label>
                    <input type="text" wire:model='info_contacto' class="form-control" placeholder="Segunda contacto (opcional)" id="info_contacto" style="border-radius: 14px">
                    @error('info_contacto')

                    <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                    @enderror
                    
                    
                </div>

                <div class="form-group col-12">
                    <label for="direccion">Dirección:</label>
                    <input type="text" wire:model='direccion' class="form-control" placeholder="Dirección Proveedor" id="direccion" style="border-radius: 14px">
                    @error('direccion')

                    <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                    @enderror
                    
                    
                </div>

                <div class="form-group col-12">
                    <label for="nota">Información:</label>
                    <input type="text" wire:model='nota' class="form-control" placeholder="Información adicional (opcional)" id="nota" style="border-radius: 14px">
                    @error('nota')

                    <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                    @enderror
                    
                    
                </div>
            </div>
            
        
            <hr>
            <button class="btn float-right" style="background-color: #0D7685; border-radius: 16px; color: white">{{$Id==0 ? 'Guardar' : 'Editar'}}</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius: 16px;">Cancelar</button>
        </form>

    </x-modal>


    <script>
        function formatRut(input) {
            let rut = input.value.replace(/\./g, '').replace('-', '');
            rut = rut.substring(0, rut.length - 1) + '-' + rut.charAt(rut.length - 1);
            input.value = rut;
        }
    </script>
    
</div>
