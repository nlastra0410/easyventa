<div>
    <div>
        <label for="impresora">Selecciona la impresora:</label>
        <select wire:model="impresora" id="impresora">
            @foreach($impresorasDisponibles as $impresora)
                <option value="{{ $impresora }}">{{ $impresora }}</option>
            @endforeach
        </select>
    </div>
    
</div>
