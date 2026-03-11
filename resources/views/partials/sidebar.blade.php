<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">

                <li class="menu-title">Menú</li>

                <!-- HOME -->
                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="ion-md-home"></i>
                        <span> Inicio </span>
                    </a>
                </li>

                <!-- MANTENIMIENTO -->
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ion-md-settings"></i>
                        <span> Mantenimiento </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">

                        <li><a href="{{ route('categorias.index') }}">Categorías</a></li>

                        <li><a href="{{ route('marcas.index') }}">Marcas</a></li>

                        <li><a href="{{ route('modelos.index') }}">Modelos</a></li>

                        <li><a href="{{ route('colores.index') }}">Colores</a></li>

                        <li><a href="{{ route('proveedores.index') }}">Proveedores</a></li>

                        <li><a href="{{ route('tipo_ingreso.index') }}">Tipo de ingreso</a></li>

                        <li><a href="{{ route('estado_equipo.index') }}">Estado del equipo</a></li>
                        

                    </ul>
                </li>




                <!-- OPERACIONES -->
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ion-md-cube"></i>
                        <span> Operaciones </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">

                        <li><a href="{{ route('equipos.index') }}">Equipos</a></li>

                        <li><a href="{{ route('inventario.index') }}">Inventario</a></li>
                        

                    </ul>
                </li>


                <!-- REPORTES -->

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ion-md-document"></i>
                        <span> Reportes </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">



                    </ul>
                </li>


                <!-- ACCESOS / SEGURIDAD -->
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="ion-md-lock"></i>
                        <span> Seguridad </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        
                        <li><a href="{{ route('users.index') }}">Usuarios</a></li>


                    </ul>
                </li>





            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>