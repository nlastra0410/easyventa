<nav class=" navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid mt-3">
        <a href="{{ route('home') }}" class="navbar-brand nav-item">
            <img src="../../dist/img/logo.png" alt="AdminLTE Logo" width="150px" style="margin-left: 120px"
                class="nav-item">
        </a>

        <!-- Right navbar links -->
        <ul class="navbar-nav">
            <!-- Navbar Search -->
            <li class="nav-item">
                @livewire('search')

            </li>

            <li class="nav-item dropdown user-menu" style="">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <b><span class="d-none d-md-inline"
                            style="color: black; margin-right: 10px">{{ auth()->user()->name }}</span></b>
                    <img src="{{ auth()->user()->imagen }}" class="user-image img-circle elevation-2" alt="User Image">
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                    <!-- User image -->
                    <li class="user-header bg-lightblue">
                        <img src="{{ auth()->user()->imagen }}" class="img-circle elevation-2" alt="User Image">

                        <p>
                            {{ auth()->user()->name }}
                            <small>{{ auth()->user()->admin ? 'Administrador' : 'Vendedor' }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->

                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a class="btn btn-default btn-flat" style="border-radius: 30px; border-color: grey"
                            href="{{ route('users.show', auth()->user()) }}">Perfil</a>
                        <button type="button" class="btn btn-default btn-flat float-right"
                            style="border-radius: 30px; border-color: grey" data-toggle="modal"
                            data-target="#modalOpciones">
                            Salir
                        </button>


                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>

        </ul>

        <button class="btn btn-sidebar-toggle sidebar-toggler" onclick="toggleSidebar()"
            style="margin-right: 60px; font-size:25px">
            <i class="fa-solid fa-ellipsis-vertical"></i>
        </button>


        <x-modal modalId="modalOpciones" modalSize="modal-md" modalTitle="Salir de EasyVenta">
          <p class="text-muted text-center" style="font-size: 20px">
              Por favor  elige la opción que deseas...
          </p>
      
          <div class="text-center">
              <!-- Botón para cerrar el turno -->
              <a href="{{ route('cierre.salida') }}" style="border-radius: 16px" class="btn-lg btn btn-success mt-4 mr-2">
                <i class="fa-solid fa-lock"></i>  Cerrar Turno
            </a>
            
              <!-- Botón para dejar el turno abierto y salir -->
              <button style="border-radius: 16px; background-color: #213869; color: white" type="button" class="btn-lg btn mt-3" data-dismiss="modal" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();"> <i class="fa-solid fa-door-open"></i>  Dejar Turno Abierto y Salir</button>
          </div>

          <p class="text-muted text-center" style="font-size: 20px; margin-bottom: -15px; margin-top: 45px">
            Presione ESC para cancelar
        </p>
      </x-modal>


      
      
    </div>
</nav>
