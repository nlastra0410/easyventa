<x-modal modalId="modalProduct" modalTitle="Producto" modalSize="modal-lg">

    <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
        <div class="form-row">

            <!--Input SKU-->
            <div class="form-group col-md-12">
                <label for="SKU">SKU:</label>
                <input type="text" wire:model='SKU' class="form-control" placeholder="SKU Producto" id="SKU" style="border-radius: 14px">
                @error('SKU')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input name-->
            <div class="form-group col-md-7">
                <label for="name">Nombre:</label>
                <input type="text" wire:model='name' class="form-control" placeholder="Nombre Producto" id="name" style="border-radius: 14px">
                @error('name')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input CATEGORY-->
            <div class="form-group col-md-5">
                <label for="category_id">Categoria:</label>
                
                <select wire:model='category_id' id="category_id" class="form-control" style="border-radius: 14px">

                    <option value="0">Seleccionar</option>
                    @foreach ($this->categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>

                @error('category_id')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input descripcion-->
            <div class="form-group col-md-12">
                <label for="descripcion">Descripcion:</label>
                <textarea wire:model='descripcion' id="descripcion" class="form-control"  rows="4" style="border-radius: 14px"></textarea>
                @error('descripcion')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input precio compra-->
            <div class="form-group col-md-4">
                <label for="precio_compra">Precio Compra:</label>
                <input min="0" step="any" type="text" wire:model='precio_compra' class="form-control" placeholder="Precio compra" id="precio_compra" style="border-radius: 14px">
                @error('precio_compra')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input precio venta-->
            <div class="form-group col-md-4">
                <label for="precio_venta">Precio Venta:</label>
                <input min="0" step="any" type="text" wire:model='precio_venta' class="form-control" placeholder="Precio Venta" id="precio_venta" style="border-radius: 14px">
                @error('precio_venta')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input precio venta-->
            <div class="form-group col-md-4">
                <label for="precio_farmaPL">Precio Farma Plus:</label>
                <input min="0" step="any" type="text" wire:model='precio_farmaPL' class="form-control" placeholder="Precio Farma Plus" id="precio_farmaPL" style="border-radius: 14px">
                @error('precio_farmaPL')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input stock -->
            <div class="form-group col-md-6">
                <label for="stock">Stock:</label>
                <input min="0" type="text" wire:model='stock' class="form-control" placeholder="Stock" id="stock" style="border-radius: 14px">
                @error('stock')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input stock minimo -->
            <div class="form-group col-md-6">
                <label for="stock_minimo">Stock Minimo:</label>
                <input min="0" type="text" wire:model='stock_minimo' class="form-control" placeholder="Stock minimo" id="stock_minimo" style="border-radius: 14px">
                @error('stock_minimo')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input CATEGORY-->
            <div class="form-group col-md-6">
                <label for="enfermedad_id">Enfermedad:</label>
                
                <select wire:model='enfermedad_id' id="enfermedad_id" class="form-control" style="border-radius: 14px">

                    <option value="0">Seleccionar</option>
                    @foreach ($this->enfermedad as $enfermedad)
                    <option value="{{$enfermedad->id}}">{{$enfermedad->name}}</option>
                    @endforeach

                </select>

                @error('enfermedad_id')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input CATEGORY-->
            <div class="form-group col-md-6">
                <label for="principio_id">Principio Activo:</label>
                
                <select wire:model='principio_id' id="principio_id" class="form-control" style="border-radius: 14px">

                    <option value="0">Seleccionar</option>
                    @foreach ($this->principio as $principio)
                    <option value="{{$principio->id}}">{{$principio->name}}</option>
                    @endforeach

                </select>

                @error('principio_id')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input active -->
            <div class="form-group col-md-3">
                <div class="icheck-primary">
                    <input wire:model="active" type="checkbox" id="active" checked>
                    <label for="active">¿Está Activo?</label>
                </div>
                @error('active')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--Input imagen -->
            <div class="form-group col-md-3">
                <label for="image">Imagen:</label>
                <input wire:model='image' type="file" id="image" accept="image/*">
                @error('image')

                <div class="aletr alert-danger w-100 mt-3" >{{$message}}</div>

                @enderror
                
            </div>

            <!--imagen -->
            <div class="form-group col-md-6">

                @if ($Id>0)
                    <x-image :item="$product = App\Models\Product::find($Id)" size="220" float="float-right"/>
                @endif

                @if($this->image)

                <img src="{{$image->temporaryUrl()}}" class="float-right" style="border-radius: 16px" width="200">

                @endif
            
            </div>
        </div>
        
    
        <hr>
        <button wire:loading.attr='disabled' class="btn float-right" style="background-color: #0D7685; border-radius: 16px; color: white">{{$Id==0 ? 'Guardar' : 'Editar'}}</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="border-radius: 16px;">Cancelar</button>
    </form>

</x-modal>