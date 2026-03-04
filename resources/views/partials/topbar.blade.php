<!-- Topbar Start -->
<div class="navbar-custom">

    <!-- MENÚ DERECHO (Usuario) -->
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <!-- Usuario -->
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect"
               data-toggle="dropdown"
               href="#"
               role="button"
               aria-haspopup="false"
               aria-expanded="false">

                <img src="{{ asset('Admin/images/users/avatar-1.jpg') }}"
                     alt="user-image"
                     class="rounded-circle">

                <span class="pro-user-name ml-1">
                    Admin <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right profile-dropdown">

                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Bienvenido</h6>
                </div>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout-variant"></i>
                    <span>Cerrar sesión</span>
                </a>

            </div>
        </li>

    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ url('/administrador') }}" class="logo text-center logo-dark">
            <span class="logo-lg">
                <img src="{{ asset('Admin/images/logo-dark.png') }}" alt="" height="18">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('Admin/images/logo-sm.png') }}" alt="" height="22">
            </span>
        </a>

        <a href="{{ url('/administrador') }}" class="logo text-center logo-light">
            <span class="logo-lg">
                <img src="{{ asset('Admin/images/logo-light.png') }}" alt="" height="18">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('Admin/images/logo-sm.png') }}" alt="" height="22">
            </span>
        </a>
    </div>
    <!-- END LOGO -->

    <!-- MENÚ IZQUIERDO -->
    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">

        <!-- Botón Sidebar -->
        <li>
            <button class="button-menu-mobile waves-effect">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>

    </ul>

</div>
<!-- end Topbar -->