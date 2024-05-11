<!-- Dentro de tu vista de blade -->
<?php
$rut = $proveedor->rut;

// Separar el RUT en parte numérica y dígito verificador
$rutNumerico = substr($rut, 0, -1);
$digitoVerificador = substr($rut, -1);

// Convertir la parte numérica del RUT a un número entero
$rutNumerico = (int) $rutNumerico;

// Agregar los puntos al RUT formateado
$rutFormateado = number_format($rutNumerico, 0, '', '.');

// Concatenar el dígito verificador y el guion
$rutFormateado .= '-' . $digitoVerificador;

?>

<x-card cardTitle="Detalles Proveedor">
    <x-slot name="cardTools">
        <a href="{{ route('proveedor') }}" class="btn"
            style="border-radius:16px; background-color: #084d68; color: white">
            Volver
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card card-success card-outline">
                <div class="card-body box-profile">
                    <h1 class="profile-username text-center" style="font-size: 45px">{{ $proveedor->nombre }}</h1>
                    <p class="text-muted text-center">
                        {{ $rutFormateado }}
                    </p>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <b>Creado</b> <a class="float-right">{{ $proveedor->created_at }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Correo</b> <a class="float-right">{{ $proveedor->email }}</a>
                        </li>

                        <li class="list-group-item">
                            <b>Teléfono</b> <a class="float-right">{{ $proveedor->telefono }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Dirección</b> <a class="float-right">{{ $proveedor->direccion }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Nota</b> <a class="float-right"><span class="badge badge-success"
                                    style="font-size: 18px">{{ $proveedor->nota }}</span></a>
                        </li>
                        <li class="list-group-item">
                            <b>Segundo Contacto</b> <a class="float-right">{{ $proveedor->info_contacto }}</a>
                        </li>
                        <a id="cobrarButton" class="btn bg-purple mt-4" style="font-size: 30px" href="{{route('proveedor.factura',$proveedor)}}">
                            <i class="fa-solid fa-file-circle-plus"></i> 
                            Ingresar Factura
                        </a>

                        
                    </ul>
                    
                </div>

            </div>

        </div>

        <div class="col-md-8">
            <div>
                <input id="inputArticulo" wire:model.live='search' autofocus type="text" class="form-control text-center" placeholder="Buscar por SKU" style="border-radius:12px">
            </div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nombre</th>
                        <th><i class="fas fa-image"></i></th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Ingreso</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->SKU }}</td>
                        <td>{{ $producto->name }}</td>
                        <td><img src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}" style="max-width: 100px;"></td>
                        <td>{{ money($producto->precio_compra) }}</td>
                        <td>{{ money($producto->precio_venta) }}</td>
                        <td style="font-size: 22px"><span class="badge badge-success">{{ $producto->pivot->quantity }}</span></td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-card>
