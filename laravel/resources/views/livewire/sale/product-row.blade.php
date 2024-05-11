
<tr wire:click='addProduct({{$product->id}})'
    wire:loading.attr='disabled' wire:target='addProduct'>
    <td>
        <button data-action="seleccionar"
            class="btn btn-primary btn-xs visually-hidden" style="border-radius: 10px"
            wire:loading.attr='disabled' wire:target='aumentar'>
            +
        </button>
    </td>
    
    <td>{{$product->SKU}}</td>
    <td>{{$product->name}}</td>
    <td>
       <x-image :item="$product" size="50" /> 
    </td>
    <td>{!!$product->precio!!}</td>
    <td>{!!$stockLabel!!}</td>
</tr>


