<div>
    <style>
        .containers {
            margin: 50px auto;
            background-color: rgb(238, 238, 238);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .store-image {
            width: 300px;
            /* Tamaño de la imagen de la tienda */
            margin-right: 30px;
            /* Espacio entre la imagen y el texto */
            border-radius: 5000px;
        }

        .store-info {
            flex-grow: 1;
            /* Para que ocupe el espacio restante */
        }

        h1 {
            font-size: 86px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }

        .slogan {
            font-size: 16px;
            color: #999;
            margin-top: 10px;
        }

        .store-type {
            font-size: 16px;
            color: #999;
            margin-bottom: 10px;
        }

        .slider-container {
            max-width: 800px;
            margin: 50px auto;
            overflow: hidden;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }

        .card {
            flex: 0 0 300px;
            margin-right: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .card-content {
            padding: 20px;
        }

        .card-content h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .card-content p {
            font-size: 16px;
            color: #666;
        }
    </style>
    <div class="containers">
        <img src="../../dist/img/tienda.jpeg" alt="Imagen de la Tienda" class="store-image">
        <div class="store-info">
            <p class="store-type">{{ $store->type }}</p>
            <h1>{{ $store->name }}</h1>
            <p class="slogan">{{ $store->slogan }} | {{ $store->telefono }}</p>
        </div>
    </div>

    <div class="card text-center">
        <div class="card-header">
            <h2>Cierre de caja del
                {{ \Carbon\Carbon::parse($cierre->fecha_apertura)->locale('es')->isoFormat('DD [de] MMMM [del] YYYY') }}
            </h2>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-success card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <x-image :item="$cierre->user" size="250" />
                        </div>
                        <h2 class="profile-username text-center">{{ $cierre->user->name }}</h2>
                        <p class="text-muted text-center">
                            {{ $cierre->user->admin ? 'Administrador' : 'Vendedor' }}
                        </p>
                        <ul class="list-group mb-3">
                            <a id="cobrarButton" class="btn bg-purple mt-4" style="font-size: 30px; border-radius:16px">
                                <i class="fa-regular fa-eye"></i>
                                Ver
                            </a>
                        </ul>
                    </div>

                </div>

            </div>

            <div class="col-md-8">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Monto inicial</th>
                            <th>Monto final</th>
                            <th>Fecha de cierre</th>
                            <th>Diferencia</th>

                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>{{ money($cierre->monto_inicial) }}</td>
                            @if ($cierre->monto_final)
                                <td>{{ money($cierre->monto_final) }}</td>
                            @else
                                <td>No hay monto final</td>
                            @endif

                            @if ($cierre->fecha_cierre)
                                <td>{{ $cierre->fecha_cierre }}</td>
                            @else
                                <td>Sin fecha de cierre</td>
                            @endif

                            @if ($cierre->diferencia)
                                @if ($cierre->diferencia <= 0)
                                    <td><span class="badge badge-success" style="font-size: 20px">{{ money($cierre->diferencia) }}</span></td>
                                @else
                                    <td><span class="badge badge-danger" style="font-size: 20px">{{ money($cierre->diferencia) }}</span></td>
                                @endif
                            @else
                            <td><span class="badge badge-success" style="font-size: 20px">$0</span></td>
                            @endif


                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-body-secondary">
            2 days ago
        </div>
    </div>
</div>
