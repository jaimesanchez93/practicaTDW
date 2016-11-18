
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Padel TDW</title>
    <link  rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="./js/bootstrap.js"></script>
    <script src="js/funciones.js"></script>
    <script src="js/validator.min.js"></script>

</head>

<body>
<!-- MEMU SUPERIOR -->
<nav class="navbar navbar-inverse ">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Padel TDW</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Padel TDW</a>

        </div>

        <div id="navbar" class="collapse navbar-collapse">
            @if (Auth::guest())
            <ul class="nav navbar-nav">
                    <li><a href="./reservas">Reservar</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->

                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                </ul>
                @else
                    @if(Auth::user()->activo==1)
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <ul class="nav navbar-nav">
                        <li><a href="./reservas">Reservar</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                            <li><a>¡Bienvenido {{Auth::user()->nombre}} !</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    </ul>
                     @else
                    <ul class="nav navbar-nav navbar-right">
                        <li><a>¡Bienvenido {{Auth::user()->nombre}} !</a></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    </ul>
                     @endif

                @endif

        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    @yield('content')

</div><!-- /.container -->



</body>
</html>
