@props(['tableId'=>''])

<div class="mb-3 d-flex justify-content-between">
    <div>
        <span>Mostrar</span>
        <select wire:model.live='cant' style="border-radius:12px">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span>Entradas</span>
    </div>

    <div>
        <input id="inputArticulo" wire:model.live='search' autofocus type="text" class="form-control" placeholder="Buscar..." style="border-radius:12px">
    </div>
</div>
<div class="table-responsive">
    <table class="table text-center" id="{{$tableId}}">
        <thead>
            <tr>
                {{$thead}}
            </tr>
        </thead>

        <tbody>
            {{$slot}}
        </tbody>
    </table>
</div>