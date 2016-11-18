<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TDW- Pistas de padel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="reservas-padel/css/bootstrap.css">
    <link rel="stylesheet" href="reservas-padel/css/style.css">
    <script type="text/javascript" src="reservas-padel/js/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="reservas-padel/js/funcionesReserva.js"></script>
    <script src="js/funciones.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>


</head>
<body>

<header>

    <!-- MENU -->
    <!--
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavBar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="reservas-padel/img/tdw.png" alt=""></a>
            </div>
            <div class="collapse navbar-collapse ">
                <ul class="nav navbar-nav" id="myNavBar" >
                    <li class="active"><a href="#">Home</a></li>
                    <li><a  onclick="comprobarReserva()">Guardar reserva</a></li>
                    <li><a  onclick="recuperarReserva()">Recuperar reserva</a></li>
                    <li><a  onclick="fijarReserva()">Finalizar reserva</a></li>

                </ul>
            </div>

        </div>
    </nav> -->
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
                @if (Auth::user()->activo==1)
                <ul class="nav navbar-nav" id="myNavBar" >
                    <li class="active"><a href="./">Home</a></li>
                    <li><a  onclick="comprobarReserva()">Guardar reserva</a></li>
                    <li><a  onclick="recuperarReserva()">Recuperar reserva</a></li>
                    <li><a  onclick="fijarReserva()">Finalizar reserva</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">

                        <li><a>¡Bienvenido {{Auth::user()->nombre}} !</a></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                    @else
                        <ul class="nav navbar-nav navbar-right">

                            <li><a>¡Bienvenido {{Auth::user()->nombre}} !</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>

                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

</header>
@if(Auth::user()->activo==1)
<main>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="container-fluid">
        <div id="container">
            <!-- MENU PARA AGREGAR JUGADORES Y LISTADO JUGADORES -->
            <div  id="menuLat">
                <p class="hidden" id="emailUser">{{ Auth::user()->email }}</p>
                <p class="hidden" id="idUser">{{ Auth::user()->id }}</p>
                <p class="hidden" id="nombreUser">{{ Auth::user()->nombre }}</p>
                <table class="table table-bordered" id="tablaJugadores">
                    <tr>
                        <td class="addJugador"  >
                            <p>Añadir jugador</p>

                        </td>
                        <td class="addJugador">
                            <button id="botonMas" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">+</button>
                        </td>
                    </tr>

                </table>
            </div>
            <!-- PISTAS -->
            <div  id="pistas">
                <table id="tablaPistas" >
                    <!-- Las pistas estan realizadas con un table de 3 filas y 2 columnas, y dentro de
                    cada celda, se encuentra otra tabla de 2x2, cada celda equivale al hueco de un jugador -->
                    <tr>
                        <td>
                            <h4 id="titulo1" class="tituloPista" onmouseover="ponerTitulos()" title="">Pista 1</h4>
                            <table class="court" id="pista1">
                                <tr>
                                    <td class="huecoJugador" id="hueco11" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco12" onclick="desAsignarJugador(this)" ><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                                <tr>
                                    <td class="huecoJugador" id="hueco13" onclick="desAsignarJugador(this)" ><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco14" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <h4 class="tituloPista" onmouseover="ponerTitulos()">Pista 2</h4>
                            <table class="court" id="pista2">
                                <tr>
                                    <td class="huecoJugador" id="hueco21" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco22" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                                <tr>
                                    <td class="huecoJugador" id="hueco23" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco24" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4 class="tituloPista" onmouseover="ponerTitulos()">Pista 3</h4>
                            <table class="court" id="pista3">
                                <tr>
                                    <td class="huecoJugador" id="hueco31" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco32" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                                <tr>
                                    <td class="huecoJugador" id="hueco33" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco34" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <h4 class="tituloPista" onmouseover="ponerTitulos()">Pista 4</h4>
                            <table class="court" id="pista4">
                                <tr class="pruebaPista4">
                                    <td class="huecoJugador" id="hueco41" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco42" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                                <tr>
                                    <td class="huecoJugador" id="hueco43" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco44" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4 class="tituloPista" onmouseover="ponerTitulos()">Pista 5</h4>
                            <table class="court" id="pista5">
                                <tr>
                                    <td class="huecoJugador" id="hueco51" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco52" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                                <tr>
                                    <td class="huecoJugador" id="hueco53" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco54" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <h4 class="tituloPista" onmouseover="ponerTitulos()">Pista 6</h4>
                            <table class="court" id="pista6">
                                <tr>
                                    <td class="huecoJugador" id="hueco61" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco62" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                                <tr>
                                    <td class="huecoJugador" id="hueco63" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                    <td class="huecoJugador" id="hueco64" onclick="desAsignarJugador(this)"><img class="iconoJugador" src="reservas-padel/img/sports.svg" alt="" height="35px"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- VENTANA MODAL AÑADIR JUGADOR -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Añadir un nuevo jugador</h4>
                </div>
                <div class="modal-body">
                    <p>Por favor, escriba su nombre</p>
                    <input type="text" id="nombre" value="" width="20px" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" id="envioNombre" class="btn btn-success" data-dismiss="modal">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    <!-- VENTANA MODAL ASIGNAR JUGADOR -->
    <div class="modal fade" id="modalAsignarJugador" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Añadir un nuevo jugador</h4>
                </div>
                <div class="modal-body">
                    <p>Por favor, escoja una pista</p>
                    <select  class="c-select" name="listadoPistas" id="listadoPistas">
                        <option value="pista1">Pista 1</option>
                        <option value="pista2">Pista 2</option>
                        <option value="pista3">Pista 3</option>
                        <option value="pista4">Pista 4</option>
                        <option value="pista5">Pista 5</option>
                        <option value="pista6">Pista 6</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" id="seleccionPista" class="btn btn-success" data-dismiss="modal" onclick="asignarJugador(this)">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL NUEVA RESERVA -->
    <div class="modal fade" id="modalNuevaReserva" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Guardar reserva</h4>
                </div>
                <div class="modal-body">
                    <p>Por favor, elija una hora de reserva</p>
                    <input type="text" name="fecha" id="fecha" class="text ui-widget-content ui-corner-all" />

                </div>
                <div class="modal-footer">
                    <button type="button" id="okReserva" class="btn btn-success" data-dismiss="modal">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="modalBorrarReserva" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <h4>Ya existe una reserva, ¿quiere sobreescribirla?</h4>
                    <button type="button" class="btn btn-info" id="confirmSobreescribir">Si</button>
                    <button type="button" class="btn btn-sm"  id="cancelSobreescribir">No</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="modalMensajesInterfazReserva" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" id="mensajeAlertaInterfazReserva">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="cerrarMensaje" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@else
    <div style="margin-left: 15%;">
        <h1>Bienvenido {{Auth::user()->nombre}}</h1>
        <br>
        <h4>Su usuario está inactivo.</h4>
    </div>

@endif
</main>

<footer></footer>
</body>
</html>