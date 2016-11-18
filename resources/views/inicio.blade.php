@extends('layout')

@section('content')

    <div class="contenedorInicio" style="margin-left: 10%;" >
        @if(Auth::guest())
            <div id="contenedorInvitado" style="margin-left: 35%;">
                <h1 id="tituloWeb">PADEL TDW</h1>
                <br><br>
                <div id="imagenPrincipal">
                    <img src="http://centrodeportivomorales.com/wp-content/uploads/2015/04/tenis4.png" alt="Padel TDW">
                </div>
                <div style="margin-left: 5%;">
                    <a href="login"><h4>Conectarse</h4></a>
                    <br><br>
                    <a href="registro"><h4>Registrarse</h4></a>

                </div>
            </div>

        @else
            @if(Auth::user()->activo==1)
                <!-- si el usuario esta activo muestra este código HTML -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h1>Bienvenido  {{Auth::user()->nombre}} <span class="hidden" id="idUsuario">{{Auth::user()->id}}</span></h1>
            <button class="btn btn-info" id="btnPerfil">Mi perfil</button>
            <button class="btn btn-info" id="btnReservas">Reservas</button>
            <div id="contenedorUsuario">

            </div>
            <!-- Modal EDITAR PERFIL USUARIO -->
            <div id="ModalEditarUsuario" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" id="myForm" data-toggle="validator">
                                <div class="form-group has-feedback">
                                    <label for="inputPerfilNombre">Nombre</label>
                                    <input name="nombre" type="text" class="form-control" id="inputPerfilNombre"
                                           placeholder="Introduce tu nombre" required>
                                </div>

                                <div class="form-group has-feedback">
                                    <label for="inputPerfilApellidos">Apellidos</label>
                                    <input name="apellidos" type="text" class="form-control" id="inputPerfilApellidos"
                                           placeholder="Introduce tus apellidos" required>
                                </div>

                                <div class="form-group has-feedback">
                                    <label for="inputPerfilEmail">Email</label>
                                    <input name="email" type="email" class="form-control" id="inputPerfilEmail"
                                           placeholder="Introduce tu email" required>
                                </div>

                                <div class="form-group">
                                    <label for="inputPerfilActivo">Activo</label>
                                    <input name="activo" type="text" class="form-control" id="inputPerfilActivo"
                                           readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label for="inputPerfilRol">Rol</label>
                                    <input name="rol" type="text" class="form-control" id="inputPerfilRol"
                                           placeholder="Introduce tu rol" readonly="readonly">
                                </div>
                                <button type="button" id="botonActualizarPerfil" class="btn btn-default">Guardar</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- MODAL PARA MENSAJES: CORRECTO O FALLO -->
                <div id="modalMensajesPerfil" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-body" id="mensajeAlertaPerfil">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" id="cerrarMensaje" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
             @else
                <!-- EL USUARIO ESTA INACTIVO POR LO QUE NO PUEDE ACCEDER -->
                <div>
                    <h1>Bienvenido  {{Auth::user()->nombre}} <span class="hidden" id="idUsuario">{{Auth::user()->id}}</span></h1>
                    <h4>Su cuenta esta inactiva.</h4>
                </div>
                @endif
        @endif

    </div>



@endsection