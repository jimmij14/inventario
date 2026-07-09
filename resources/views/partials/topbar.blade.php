<!-- Topbar Start -->
<div class="navbar-custom">

    <!-- MENÚ DERECHO (Usuario) -->
    
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{asset('Admin/images/users/avatar-1.jpg')}}" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1">
                                {{ Auth::user()->name }}   <i class="mdi mdi-chevron-down"></i> 
                            </span>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Bienvenido !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-outline"></i>
                                <span>Perfil</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-settings-outline"></i>
                                <span>Permisos</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="mdi mdi-lock-outline"></i>
                                <span>Ayuda</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a class="dropdown-item notify-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout-variant"></i>
                                <span>{{ __('Cerrar Sesión') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        </div>
                    </li>
                </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ url('/home') }}" class="logo text-center logo-dark">
            <span class="logo-lg">
                <img src="{{ asset('Admin/images/logo-dark.png') }}" alt="" height="18">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('Admin/images/logo-sm.png') }}" alt="" height="22">
            </span>
        </a>

        <a href="{{ url('/home') }}" class="logo text-center logo-light">
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