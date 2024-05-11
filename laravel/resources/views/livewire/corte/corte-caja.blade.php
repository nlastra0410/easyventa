<div>

    <style>
        .fondo {
            background-color: #084d68;
        }
        h1 {
            color: white;
        }
    </style>
    
    <div style="flex: 1; text-align: right; margin-top: 20px; margin-bottom: 30px">
        <a href="" class="btn btn-warning" data-toggle="modal"  wire:click="abreCierre"
            style="border-radius: 16px;">
            Cerrar Turno
            <i class="fa-solid fa-lock"></i>
        </a>
    </div>

    {{-- row cards ventas hoy --}}

    @include('Venta.row-cads-sales')

    

    <x-modal modalId="modalCierre" modalSize="modal-lg" modalTitle="Cierre de turno">
        <p class="text-muted text-center" style="font-size: 20px">
            Por favor cuenta el dinero en caja e ingrésalo para proceder con el cierre de turno

        <form wire:submit.prevent="registro">
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="monto_inicial">Monto inicial:</label>
                    <input type="text" class="form-control" value="{{ money($montoInicial) }}" readonly>
                </div>
                <div class="form-group col-6">
                    <label for="monto_efectivo_ventas">Efectivo de ventas:</label>
                    <input type="text" class="form-control" value="{{ money($montoEfectivoVentas) }}" readonly>
                </div>
                <div class="form-group col-12">
                    <label for="monto_actual">Efectivo actual en caja:</label>
                    <input autofocus type="text" wire:model.live="montoActual" wire:change="actualizarDiferencia"
                        wire:keyup="actualizarDiferencia" class="form-control"
                        placeholder="Ingrese el efectivo actual en caja">

                    @error('montoActual')
                        <div class="alert alert-danger w-100 mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-12 text-center mt-5" style="font-size: 50px">
                    <label for="diferencia">Diferencia:</label>
                    <span
                        class="{{ $diferencia <= 0 ? 'text-success' : 'text-danger' }}">{{ money($diferencia) }}</span>


                </div>
            </div>

            @if ($diferencia == 0)
                <div class="alert alert-success text-center" role="alert">
                    <i class="fa-solid fa-check-double"></i>
                    ¡Excelente! Todo en orden
                </div>
            @else
                <div class="alert alert-warning text-center" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Esta diferencia será registrada en tu turno 
                </div>
            @endif

            <hr>
            <button type="submit" class="btn float-right"
                style="background-color: #0D7685; border-radius: 16px; color: white">Guardar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                style="border-radius: 16px;">Cancelar</button>
        </form>
        </p>
    </x-modal>

</div>
