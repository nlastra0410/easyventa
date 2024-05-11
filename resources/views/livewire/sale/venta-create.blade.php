<div>
    <style>
        .fondo {
            background-color: #084d68;
        }

        h1 {
            color: white;
            style="background-color: #084d68; border-radius:40px"
        }

        .selected-row {
            background-color: #000000;
            /* Cambia el color de fondo según tu preferencia */
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
            /* Ajusta la duración y la curva de la animación según tus preferencias */
            opacity: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .redondo {
            border-radius: 16px;
        }
    </style>

    <div class="row fondo">
        <div class="col-3">
            <h1>Venta tiket-1</h1>
        </div>

        {{-- @livewire('sale.date-time') --}}

        <div class="col-3">
            <h1>Sucursal: {{ auth()->user()->sucursal->name }}</h1>
        </div>
    </div>

    <div style="margin-top: 30px">
        <div>
            <div class="card-header">
                <div class="card-tools">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">

                        <div style="margin-left: 50px">
                            <form >
                        
                                <div class="input-group">
                                        <input 
                                            id="inputSku"
                                            autofocus
                                            wire:model.live="SKU"
                                            type="search"
                                            wire:keydown.enter="escanner"
                                            placeholder="Ingresar producto"
                                            class="form-control mb-4"
                                            style="align-items: center; border-radius: 20px; margin-top:20px; padding: 25px 510px; text-align: center; border-color:rgb(114, 114, 114);">
                        
                                </div>
                            </form>
                        
                        
                        
                        </div>
                        <div>
                            <a href="#" class="btn btn-danger mr-3" wire:click='clear' style="border-radius: 16px">
                                <i class="fas fa-trash"></i> Cancelar venta
                            </a>
                        </div>
                        <div>
                            <a href="" class="btn" data-toggle="modal" data-target="#modalProducto"
                                style="border-radius: 16px;background-color: #084d68; color: white">
                                Lista productos F1
                                <i class="fa-solid fa-pills"></i>
                            </a>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
