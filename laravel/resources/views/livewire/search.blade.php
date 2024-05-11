<div>
    <form>
        <div class="input-group">
            <input wire:model.live='search' id='inputS' type="search" class="form-control" placeholder="Buscar Producto F9"
                style="border-radius: 30px; margin-right: 60px; padding: 20px 450px; text-align: center;">

            <!--<div class="input-group-append" wire:click.prevent>
                <button class="btn bnt-default">
                    <i class="fa fa-search"></i>
                </button>
            </div>-->
        </div>
    </form>

    <ul class="list-group" id="list-search">

        @foreach ($products as $product)
            <li class="list-group-item">
                <h5>
                    <a href="{{route('products.show',$product)}}" class="text-dark">
                        <x-image :item="$product" size="50" />
                        {{ $product->name }}
                    </a>
                </h5>

                <div class="d-flex justify-content-between">
                    <div class="mr-3">
                        precio venta:
                        <span class="badge badge-pill badge-info">
                            {{ $product->precio_venta }}
                        </span>
                    </div>
                    <div>
                        stock: {!! $product->stocks !!}

                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
