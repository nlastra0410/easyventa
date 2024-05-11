<div>
    <x-card cardTitle="Listado Productos({{$this->totalRegistros}})">

        <x-slot:cardTools>
            <a href="" class="btn btn-primary" wire:click='create' data-toggle="modal" data-target="#modalCategory">
                crear Producto
                <i class="fa-solid fa-plus-circle"></i>
            </a>
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>

                <th>ID</th>
                <th>SKU</th>
                <th>Imagen</th>
                <th>nombre</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Categoria</th>
                <th>Estado</th>
                <th width="3%">Ver</th>
                <th width="3%">Editar</th>
                <th width="3%">Eliminar</th>

            </x-slot>


            @forelse ($products as $product)
                
            
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->SKU}}</td>
                <td>
                    <x-image :item="$product" />
                </td>
                <td>{{$product->name}}</td>
                <td>{{$product->precio_venta}}</td>
                <td>{!!$product->stocks!!}</td>
                <td>
                    <a class="badge badge-secondary" style="font-size: 16px" href="{{route('categories.show',$product->category->id)}}">{{$product->category->name}}</a>
                </td>
                <td>{!!$product->activ!!}</td>
                <td>
                    <a href="{{route('products.show',$product->id)}}"  class="btn btn-sm" title="Ver"
                        style="border-radius:8px; background-color: #69C181; color: white">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </td>

                <td>
                    <a href="#" wire:click='edit({{$product->id}})' class="btn btn-sm" title="editar"
                        style="border-radius:8px; background-color: #084d68; color: white">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
                <td>
                    <a wire:click="$dispatch('delete',{id: {{$product->id}},eventName:'destroyProduct'})" class="btn btn-danger btn-sm" title="Eliminar" style="border-radius:8px; color: white">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>

            @empty

            <tr class="text-center">
                <td colspan="11">Sin registros</td>
            </tr>
                
            @endforelse


        </x-table>

        <x-slot:cardFooter>
            {{$products->links()}}
        </x-slot>


    </x-card>

    @include('products.modal')
</div>
