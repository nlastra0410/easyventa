<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{ $title ?? config('app.name') }}</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="icon" href="../../dist/img/caja-registradora.png" type="image/x-icon">

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/6dce50e058.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>




    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->

    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="../../dist/css/estilo.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/ichek-bootstrap/ichek-bootstrap.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <style>
        .botones_inicio {
            color: black;
            justify-content: space-between;
            text-decoration: none;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -700px;
            width: 700px;
            height: 100%;
            background-color: #efefef;
            /* Color de fondo del sidebar */
            transition: all 0.3s ease;
            z-index: 1000;
            border-top-right-radius: 60px;
            /* Redondea la esquina superior derecha */
            border-bottom-right-radius: 60px;
            /* Redondea la esquina inferior derecha */
        }

        .sidebar.active {
            left: 0;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fondo oscuro con transparencia */
            z-index: 900;
            display: none;
            /* Inicialmente oculto */
        }

        .overlay.active {
            display: block;
            /* Mostrar cuando está activo */
        }

        hr.custom-hr {
            border: none;
            /* Elimina el borde predeterminado */
            height: 2px;
            /* Grosor de la línea */
            background-color: rgb(66, 66, 66);
            /* Color de la línea */
            width: 99%;
            /* Longitud de la línea */
            margin: 20px auto;
            /* Margen superior e inferior de 20px, centrado horizontalmente */
        }

        ul {
            list-style-type: none;
            /* Elimina el marcador predeterminado de la lista */
        }

        a {
            text-decoration: none;
            color: #bdbdbd
        }

        ul li a:hover {
            background-color: rgba(0, 0, 0, 0.1);
            /* Color de fondo con transparencia */
            color: white;
            box-shadow: 0 4px 8px rgba(226, 226, 226, 0.302);

        }

        ul li a {
            padding: 20px;
            /* Aumenta el espacio interno para que el fondo sea más grande */
            transition: background-color 0.3s ease;
            /* Transición para el cambio de color de fondo */
            border-radius: 45px;
            /* Aplica bordes redondeados */
        }

        .user-info {
            display: flex;
            /* Usa flexbox */
            justify-content: space-between;
            /* Distribuye los elementos alrededor */
            align-items: center;
            /* Centra verticalmente los elementos */
            width: 100%;
            /* Para asegurar que el ancho sea el total */
        }

        .user-info .name {
            flex: 1;
            /* Toma el espacio restante */
            text-align: left;
            /* Alinea el texto a la izquierda */
        }

        .user-info .role {
            flex: 1;
            /* Toma el espacio restante */
            text-align: center;
            /* Alinea el texto al centro */
        }

        .user-info .sucursal {
            flex: 1;
            /* Toma el espacio restante */
            text-align: right;
            /* Alinea el texto a la derecha */
        }

        .sidebar-close-btn {
            border: none;
            background: none;
            font-size: 50px;
            text-align: right;
            flex: 1;
        }
    </style>

    @yield('styles')
</head>

<body class="hold-transition layout-top-nav">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="wrapper">
        <div class="overlay"></div>


        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Aquí coloca el contenido del sidebar -->
            <button class="sidebar-close-btn"><i class="fa-regular fa-circle-xmark"></i></button>
            <div class="sidebar-top mt-1">
                <span class="text text-muted" style="font-size: 25px; width: 90%;">Administración</span>
                <hr class="custom-hr">
            </div>

            <ul>
                <li style="margin-top: 10px">
                    <a href="{{ route('users') }}" style="font-size: 50px"><i
                            class=" nav-icon fa-solid fa-user-shield mr-3"></i>Usuarios</a>
                </li>

                <li class="mt-4">
                    <a href="{{ route('clients') }}" style="font-size: 50px">
                        <i class="fa-solid fa-address-book"></i> Clientes
                    </a>
                </li>

                <li class="mt-4">
                    <a href="{{ route('category') }}" style="font-size: 50px">
                        <i class="fa-solid fa-layer-group"></i> Categorias
                    </a>
                </li>

                <li class="mt-4">
                    <a href="{{ route('enfermedad') }}" style="font-size: 50px">
                        <i class="fa-solid fa-disease"></i> Enfermedades
                    </a>
                </li>

                <li class="mt-4">
                    <a href="{{ route('sucursal') }}" style="font-size: 50px">
                        <i class="fa-solid fa-store"></i> Sucursales
                    </a>
                </li>

                <li class="mt-4">
                    <a href="{{ route('datos') }}" style="font-size: 50px">
                        <i class="fa-solid fa-building"></i> Farmacia
                    </a>
                </li>

                <li class="mt-4">
                    <a href="{{ route('cierre') }}" style="font-size: 50px">
                        <i class="fa-solid fa-file-circle-exclamation"></i> Cierres
                    </a>
                </li>

                <select value="" id="nombreImpresoras"></select>
                <button onclick="imprimeTicket()" type="button">imprime</button>

                {{-- <li class="mt-4">
                    <a href="{{ route('impresora') }}" style="font-size: 50px">
                        <i class="fa-solid fa-print"></i> Impresora
                    </a>
                </li> --}}


            </ul>

            <div class="sidebar-top" style="margin-top: 20px">
                <hr class="custom-hr">
                <span class="text text-muted" style="font-size: 25px; width: 90%;">Información</span>
                <p class="mt-1 user-info" style="font-size: 20px">
                    <span class="name">{{ auth()->user()->name }}</span>
                    <span class="role"><small><span
                                class="badge badge-success">{{ auth()->user()->admin ? 'Administrador' : 'Vendedor' }}</span></small></span>
                    <span class="sucursal">{{ auth()->user()->sucursal->name }}</span>
                </p>

            </div>
        </aside>
        <!-- /.sidebar -->

        <!-- Navbar -->
        @include('components.layouts.partials.navbar')
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('components.layouts.partials.content-header')
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @livewire('messages')
                    {{ $slot }}

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



        <!-- Main Footer -->
        @include('components.layouts.partials.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.js"></script>
    @yield('js')
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../plugins/impresion/escpos.js"></script>
    <script src="../../plugins/impresion/tikets.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var sidebarToggler = document.querySelector('.sidebar-toggler');
            var sidebar = document.querySelector('.sidebar');
            var overlay = document.querySelector('.overlay');
            var sidebarCloseBtn = document.querySelector('.sidebar-close-btn');

            // Función para abrir y cerrar el sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }

            // Evento de clic en el botón para abrir/cerrar el sidebar
            sidebarToggler.addEventListener('click', toggleSidebar);

            // Evento de clic fuera del sidebar para cerrarlo
            overlay.addEventListener('click', toggleSidebar);

            // Evento de clic en el botón de cierre dentro del sidebar para cerrarlo
            sidebarCloseBtn.addEventListener('click', toggleSidebar);
        });
    </script>



    <script language="javascript">
        function presionar_tecla(e) {

            var e = e || event;
            var tecla_F1 = event.keyCode;
            var tecla_F2 = event.keyCode;
            var tecla_F3 = event.keyCode;
            var tecla_F4 = event.keyCode;
            var tecla_F6 = event.keyCode;
            var tecla_F8 = event.keyCode;
            var tecla_F9 = event.keyCode;
            var tecla_arriba = event.keyCode;
            var tecla_abajo = event.keyCode;
            // var tecla_escape = event.keyCode;

            if(tecla_F6 == 117){
                e.preventDefault();
                window.location.href = "{{route('proveedor')}}";
                return false;
            }

            if (tecla_F3 == 114) {
                e.preventDefault(); // Evita el comportamiento predeterminado del navegador para F3
                Livewire.dispatch('open-modal', 'modalCaja');
                return false; // Para evitar la acción predeterminada del navegador
            }
            if (tecla_F1 == 112) {
                Livewire.dispatch('open-modal', 'modalProducto');
            }

            if (tecla_F2 == 113) {
                window.location.href = "{{ route('sales.create') }}";
            }

            if (tecla_F4 == 115) {
                window.location.href = "{{ route('corte') }}";
            }

            if (tecla_F8 == 119) {
                window.location.href = "{{ route('products') }}";
            }




        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('close-modal', (idMOdal) => {
                $('#' + idMOdal).modal('hide');
            })
        })

        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', (idMOdal) => {
                $('#' + idMOdal).modal('show');
            })
        })

        document.addEventListener('livewire:init', () => {
            Livewire.on('delete', (e) => {
                //alert(e.id+'-'+e.eventName)
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Esta acción no se puede revertir!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Eliminar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch(e.eventName, {
                            id: e.id
                        })
                    }
                });
            })
        })



        window.onkeydown = presionar_tecla
    </script>




</body>

</html>
