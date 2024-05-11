<style>
    .indi.active {
        background-color: #084d68;
        /* Color de fondo para resaltar */
        /* Otros estilos que desees aplicar al enlace activo */
        border-radius: 16px;
        text-align: center;
        align-items: center;
        color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.302); 
    }

    .indi{
        color: black
    }

    .indi:hover{
        background-color: #084d6864;
        color: black;
        border-radius: 16px;
        text-align: center;
        align-items: center;
    }
</style>

<div class="content-header">
    <div class="container">
        <div class="row ">
            <div class="col-2 botones_inicio">

                <a href="{{ route('sales.create') }}" class="nav-link indi text-center" data-route="sales.create"
                    style="text-decoration: none; margin-right: 50px;">F2Ventas</a>
                
            </div>
            
            <div class="col-2 botones_inicio">

                <a href="{{ route('corte') }}" class="nav-link indi text-center" data-route="corte"
                    style="text-decoration: none; margin-right: 50px">F4Corte</a>

            </div>

            <div class="col-2 botones_inicio">
                <a href="{{route('proveedor')}}" style="text-decoration: none; margin-right: 50px" class="nav-link indi text-center" data-route="proveedor">F6Proveedor</a>
            </div>

            <div class="col-2 botones_inicio">

                <a href="{{ route('products') }}" class="nav-link indi text-center" data-route="products"
                    style="text-decoration: none; margin-right: 50px">F8Productos</a>
            </div>

            <div class="col-2 botones_inicio">
                <a href="{{route('reporte')}}" style="text-decoration: none" class="nav-link indi text-center" data-route="reporte">Reportes</a>
            </div>

            <div class="col-2 botones_inicio">
                <a href="{{route('inventario')}}" style="text-decoration: none" class="nav-link indi text-center" data-route="inventario">Inventario</a>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {


        var currentRoute = "{{ \Route::currentRouteName() }}";  // Obtén la ruta actual desde Laravel

        // Encuentra el enlace correspondiente a la ruta actual y agrega la clase 'active'
        var activeLink = document.querySelector('[data-route="' + currentRoute + '"]');
        if (activeLink) {
            activeLink.classList.add('active');
        }
    });
</script>
