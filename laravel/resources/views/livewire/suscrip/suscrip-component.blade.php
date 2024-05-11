<div>
    <x-card cardTitle="Listado Suscriptores ({{$this->totalRegistros}})">
       <x-slot:cardTools>
          <a href="#" class="btn btn-primary" wire:click='create'>
            <i class="fas fa-plus-circle"></i> Nuevo Suscriptor
          </a>
       </x-slot>

       <x-table>
          <x-slot:thead>
             <th>ID</th>
             <th>Cliente</th>
             <th>Suscripción</th>
             <th>Estado</th>
             <th width="3%">...</th>
             <th width="3%">...</th>
             <th width="3%">...</th>
 
          </x-slot>

          @forelse ($suscrip as $suscrip)
              
             <tr>
                <td>{{$suscrip->id}}</td>
                <td>{{$suscrip->client_id}}</td>
                <td>{{$suscrip->suscrib_id}}</td>
                <td>{!!$suscrip->activ!!}</td>
                <td>
                    <a href="" class="btn btn-sm" title="Ver" style="border-radius:8px; background-color: #69C181; color: white">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
                <td>
                    <a href="#" wire:click='edit({{$suscrip->id}})' class="btn btn-sm" title="Editar" style="border-radius:8px; background-color: #084d68; color: white">
                        <i class="far fa-edit"></i>
                    </a>
                </td>
                <td>
                    <a wire:click="$dispatch('delete',{id: {{$suscrip->id}}, eventName:'destroySuscrip'})" class="btn btn-danger btn-sm" title="Eliminar" style="border-radius:8px; color: white">
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
 
       {{-- <x-slot:cardFooter>
            {{$suscrip->links()}}

       </x-slot> --}}
    </x-card>


 <x-modal modalId="modalSuscrip" modalTitle="Suscriptores">
    <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
        <div class="form-row">

            <!--Cliente-->
            <div class="form-group col-md-6">
                <label for="client_id">Cliente:</label>
                
                <select wire:model='client_id' id="client_id" class="form-control" style="border-radius: 14px">

                    <option value="0">Seleccionar</option>
                    @foreach ($this->cliente as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->name}}</option>
                    @endforeach

                </select>

                @error('client_id')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Suscripcion-->
            <div class="form-group col-md-6">
                <label for="suscrib_id">Suscripción:</label>
                
                <select wire:model='suscrib_id' id="suscrib_id" class="form-control" style="border-radius: 14px">

                    <option value="0">Seleccionar</option>
                    @foreach ($this->suscribs as $suscribs)
                    <option value="{{$suscribs->id}}">{{$suscribs->name}}</option>
                    @endforeach

                </select>

                @error('suscrib_id')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Fecha Inicio-->
            <div class="form-group col-12 col-md-6">
                <label for="inicio">Fecha inicio:</label>
                <input wire:model='inicio' type="date" class="form-control" placeholder="Fecha de Inicio" id="inicio" style="border-radius: 16px">
                @error('inicio')
                    <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                @enderror
            </div>

            <!--Fecha fin-->
            <div class="form-group col-12 col-md-6">
                <label for="fin">Fecha fin:</label>
                <input wire:model='fin' type="date" class="form-control" placeholder="Fecha de Fin" id="fin" style="border-radius: 16px">
                @error('fin')
                    <div class="alert alert-danger w-100 mt-2">{{$message}}</div>
                @enderror
            </div>

            <!--Check admin-->
            <div class="form-group form-check col-md-6">
                <div class="icheck-primary">
                    <input wire:model='active' type="checkbox" id="active">
                    <label class="form-check-label" for="active">¿Está activo?</label>
                </div>
            </div>

        </div>
        
        <hr>
        <button class="btn btn-primary float-right">{{$Id==0 ? 'Guardar' : 'Editar'}}</button>    
    </form>
 </x-modal>

</div>