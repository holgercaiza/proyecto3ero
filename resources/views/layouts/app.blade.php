<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pensiones') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    @if (!Auth::guest())
                        <ul class="nav navbar-nav " style="margin-top:6px;" >
                            <li class="btn-info" style="border-radius:5px;" ><a style="color:white"   href="{{ route('pensiones.index') }}"> <i class="fa fa-list"></i> Pensiones</a></li>
                            <li class="btn-info" style="border-radius:5px;margin-left:5px" ><a  style="color:white" href="{{ route('reportes') }}"><i class="fa fa-bar-chart"></i> Reportes</a></li>
                            <li class="btn-info" style="border-radius:5px;margin-left:5px" ><a  style="color:white" href="{{ route('usuarios.index') }}"><i class="fa fa-user"></i> Usuarios</a></li>
                            <li class="btn-info" style="border-radius:5px;margin-left:5px" ><a  style="color:white" href="{{ route('cargar_datos.index') }}"><i class="fa fa-file-excel-o text-success"></i> Cargar Datos</a></li>
                            <li class="btn-info" style="border-radius:5px;margin-left:5px" ><a  style="color:white" href="{{ route('generar_ordenes') }}"><i class="fa fa-list text-success"></i> Generar Órdenes</a></li>
                        </ul>
                    @endif

                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right p-3">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                        <li class="dropdown mt-4">
                                <a href="#" class="dropdown-toggle bg-info" style="border-radius:5px;" data-toggle="dropdown" role="button" aria-expanded="false">
                                   <strong class="text-white" >{{Session::get('suc_nombre')}}</strong> {{ Auth::user()->usr_usuario }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" style="border-radius:5px;" role="menu">
                                    <li>
                                        <a href="{{ route('profile',Auth::user()->usr_id) }}" ><i class="fa fa-key"></i> Cambiar Clave</a>
                                    </li>
                                    <li><hr style="margin-top:5px" ></li>
                                    <li>
                                        <a href="{{ route('logout') }}" style="margin-top:-10px;" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fa fa-close"></i> Salir
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>

                            </li>
                        @endif
                    </ul>

                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>    
</body>
</html>
