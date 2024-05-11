<style>
    .contenedor-botones {
        display: flex;
        justify-content: space-between;
        /* Distribuye los elementos a lo largo del eje principal */
        align-items: center;
        /* Centra los elementos a lo largo del eje transversal */
    }

    .boton-con-icono {
        position: relative;
        padding-top: 25px;
        font-size: 25px;
    }

    .icono-superpuesto {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    .boton-activo {
        background-color: #ccc; /* Color de fondo para resaltar el botón activo */
    }
</style>

<div>

    <div>
        <h2 class="text-center" wire:model.live="pago" style="font-size: 50px">Total a pagar: {{$total}}</h2>
        <p class="text-center">{{ numerosLetras($total) }}</p>
    </div>

    <div class="text-center mt-5 mb-5 contenedor-botones">
        <button class="boton-con-icono btn {{ $tipo_pago == 'Efectivo' ? 'boton-activo' : '' }}" wire:click="setEfectivo" onclick="mostrarContenido('setEfectivo')">
            <i class="icono-superpuesto fa-solid fa-dollar-sign"></i>
            <b>Efectivo</b>
        </button>
    
        <button class="boton-con-icono btn {{ $tipo_pago == 'Tarjeta' ? 'boton-activo' : '' }}" wire:click="setTarjeta" onclick="mostrarContenido('setTarjeta')">
            <i class="icono-superpuesto fa-regular fa-credit-card"></i>
            <b>Tarjeta</b>
        </button>
    
        <button class="boton-con-icono btn {{ $tipo_pago == 'Mixto' ? 'boton-activo' : '' }}" wire:click="setMixto" onclick="mostrarContenido('setMixto')">
            <i class="icono-superpuesto fa-solid fa-file-invoice-dollar"></i>
            <b>Mixto</b>
        </button>
    
        <button class="boton-con-icono btn {{ $tipo_pago == 'transferencia' ? 'boton-activo' : '' }}" wire:click="setTransferencia" onclick="mostrarContenido('setTransferencia')">
            <i class="icono-superpuesto fa-solid fa-mobile"></i>
            <b>Transferencia</b>
        </button>
    </div>

    <div class="contenedor-contenido">

        <div id="setEfectivo" style="display: none;" wire:ignore>

            <h1 style="color: black" class="text-center">Venta en Efectivo</h1>

            <div class="d-flex justify-content-center align-items-center flex-wrap">
                @foreach ($this->valores as $valor)
                    @if ($tieneSuscripcion === true)
                        <button wire:click="setePago({{ $valor }})" type="button" class="btn btn-success m-1"
                            {{ $valor <= $totalConSuscripcion ? 'disabled' : '' }} style="border-radius: 16px">
                            {{ money($valor) }}
                        </button>
                    @else
                        <button wire:click="setePago({{ $valor }})" type="button" class="btn btn-success m-1"
                            {{ $valor <= $total ? 'disabled' : '' }} style="border-radius: 16px">
                            {{ money($valor) }}
                        </button>
                    @endif
                @endforeach

                <button wire:click="setePago({{ $total }})" type="button" style="border-radius: 16px"
                    class="btn btn-success m-1">Exacto
                </button>
            </div>

            <div class="row mt-5">
                <div class="col-md-3">
                    <h2 class="">Pagó con:</h2>
                </div>
                <div class="col-md-9">
                    <input id="efectivo" type="number" wire:model.live="pago" wire:input="actualizarDevuelve"
                        min="1" class="form-control" style="border-radius: 14px">

                    <!-- Usa wire:input para manejar cambios en el input -->
                </div>
            </div>


            <div class="card-footer" style="border-radius: 40px; margin-top:20px;">
                <div class="col-12">
                    <h2 for="pago" class="text-center">Devuelve: {{ money($devuelve) }}</h2>
                    <p class="text-center">{{ numerosLetras($devuelve) }}</p>
                </div>
            </div>


        </div>

        <div id="setTarjeta" style="display: none;" wire:ignore>

            <h1 style="color: black" class="text-center">Venta con tarjeta</h1>
            <h4 class="text-center mt-5">
                Referencia
            </h4>

            <input type="text" id="referencia" class="form-control" style="border-radius: 14px"
                wire:model.live="detalle">
            <p class="text-center mb-5">
                Número de aprobación, Mastercard, Visa, etc.
            </p>

        </div>

        <div id="setMixto" style="display: none;" wire:ignore>

            <h1 style="color: black" class="text-center">Venta de forma mixta</h1>

            <div>
                <div class="text-center">
                    <label for="efectivo">Efectivo:</label>
                    <input class="form-control" type="number" id="efectivo" min="0" step="any"
                        oninput="calcularRestante()">
                </div>
                <div class="text-center">
                    <label for="tarjeta">Tarjeta:</label>
                    <input class="form-control" type="number" id="tarjeta" min="0" step="any"
                        oninput="calcularRestante()">
                </div>
                <div class="text-center">
                    <label for="restante">Restante:</label>
                    <input class="form-control" type="text" id="restante" disabled>
                </div>

            </div>

        </div>

        <div id="setTransferencia" style="display: none;" wire:ignore>

            <h1 style="color: black" class="text-center">Venta con transferencia</h1>
            <h4 class="text-center mt-5">
                Referencia
            </h4>

            <input type="text" id="referencia" class="form-control" style="border-radius: 14px"
                wire:model.live="detalle">
            <p class="text-center mb-5">
                Número de aprobación, Id transaccion, etc.
            </p>

        </div>

    </div>








    <h4 class="mt-3 text-center">Total de Articulos: {{ $totalQy }}</h4>

    <button wire:click='createVenta' type="button" id="boton-cobrar"
        style="border-radius: 16px;background-color: #084d68; color: white" class="btn redondo float-right">
        <i class="fa-solid fa-print"></i> Cobrar
    </button>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputEfectivo = document.getElementById('efectivo');

            inputEfectivo.addEventListener('focus', function() {
                // Borra el contenido al obtener el foco
                this.value = '';
            });

            // Mantiene el enfoque en el input y borra el contenido al presionar cualquier tecla
            document.addEventListener('keydown', function(event) {
                if (event.target.tagName.toLowerCase() !== 'input') {
                    inputEfectivo.focus();
                    inputEfectivo.value = '';
                }
            });
        });

        $(document).ready(function() {
            $('#modalPago').on('shown.bs.modal', function() {
                // Muestra el contenido de Efectivo al abrir el modal
                mostrarContenido('setEfectivo');
            });
        });

        function mostrarContenido(id) {
            var contenidos = document.querySelectorAll('.contenedor-contenido > div');
            contenidos.forEach(function(contenido) {
                contenido.style.display = 'none';
            });

            var contenidoMostrar = document.getElementById(id);
            contenidoMostrar.style.display = 'block';
        }

        function calcularRestante() {
            var total = {{ $tieneSuscripcion ? $totalConSuscripcion : $total }}; // Total a pagar
            var efectivo = parseFloat(document.getElementById("efectivo").value) || 0;
            var tarjeta = parseFloat(document.getElementById("tarjeta").value) || 0;

            // Calcular el monto restante
            var restante = total - efectivo - tarjeta;

            // Mostrar el monto restante
            document.getElementById("restante").value = restante;
        }

        document.getElementById('boton-cobrar').addEventListener('click', function() {
            // Aquí colocas el código para generar la boleta, por ejemplo:
            const boleta = generarBoleta();

            // Luego, puedes utilizar una función para imprimir automáticamente
            imprimirBoleta(boleta);
        });

        function generarBoleta() {
            // Aquí generas la boleta, puedes obtener la información de la venta, calcular total, etc.
            const boletaGenerada = "Boleta de Venta\n\nFecha: 19/02/2024\nProducto: Producto 1\nCantidad: 1\nPrecio: $10\nTotal: $10";
            return boletaGenerada;
        }

        function imprimirBoleta(boleta) {
            // Aquí utilizas el código para imprimir automáticamente, por ejemplo:
            // Este es solo un ejemplo, necesitarás adaptarlo dependiendo de tu entorno y configuración
            window.print();
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputEfectivo = document.getElementById('efectivo');

        inputEfectivo.addEventListener('focus', function() {
            // Borra el contenido al obtener el foco
            this.value = '';
        });

        // Mantiene el enfoque en el input y borra el contenido al presionar cualquier tecla
        document.addEventListener('keydown', function(event) {
            if (event.target.tagName.toLowerCase() !== 'input') {
                inputEfectivo.focus();
                inputEfectivo.value = '';
            }
        });

        // Mostrar la sección de efectivo al cargar la página
        mostrarContenido('setEfectivo');

        // Navegación entre tipos de pago con las flechas de izquierda y derecha
        document.addEventListener('keydown', function(event) {
            if (event.keyCode === 37 || event.keyCode === 39) { // Flecha izquierda o derecha
                const tiposPago = ['setEfectivo', 'setTarjeta', 'setMixto', 'setTransferencia'];
                let currentIndex = tiposPago.indexOf(document.querySelector('.contenedor-contenido > div[style*="display: block"]').id);
                let newIndex;
                if (event.keyCode === 37) { // Flecha izquierda
                    newIndex = currentIndex === 0 ? tiposPago.length - 1 : currentIndex - 1;
                } else { // Flecha derecha
                    newIndex = currentIndex === tiposPago.length - 1 ? 0 : currentIndex + 1;
                }
                mostrarContenido(tiposPago[newIndex]);

                actualizarEstiloBotonActivo(tiposPago[newIndex]);
            }
        });
    });

    function actualizarEstiloBotonActivo(tipoPagoActivo) {
        // Remover la clase boton-activo de todos los botones
        document.querySelectorAll('.contenedor-botones button').forEach(function(button) {
            button.classList.remove('boton-activo');
        });

        // Agregar la clase boton-activo al botón correspondiente al tipo de pago activo
        document.querySelector('.contenedor-botones button[data-tipo="' + tipoPagoActivo + '"]').classList.add('boton-activo');
    }

    // Resto del código...
</script>


</div>
