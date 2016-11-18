/**
 * Created by saramartinezbayo on 31/5/16.
 */

//VARIABLES GLOABLES UTILIZADAS
var arrayDatos;
var datosPerfil;
var pistasOcupadas=[];
var cadenaPistas="";
var datosReservaRecuperada;
var arrayReservas;
var reservaRecuperada=false;
var reservaGuardada=false;
var datosReservaTemporal;
var fechaExistente=false;
var arrayDatosReservas;
var pruebaClick=false;




$(document).ready(function () {
//ENVIO DEL CSRF TOKEN EN LAS CABECERAS PARA HACER CRUD
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //ADMIN 
        //LISTAS USUARIOS DEL PANEL DE ADMINISTRADOR
    $("#listaUsuarios").click(function(){
        listarUsuarios();

    });
        //LISTAR RESERVAS DEL PANEL DE ADMINISTRADOR
    $('#listaReservas').click(function(){
            listarReservas();
    })



    //PANEL USUARIO
        //CARGA EL PERFIL DEL USUARIO
    
    $('#btnPerfil').click(function(){

        var idUsuario=$('#idUsuario').html();
        infoUsuario(idUsuario);
        $('#contenedorUsuario').load("./perfil.html");
    })
        //CARGA EL LISTADO DE RESERVAS DEL USUARIO
    
    $('#btnReservas').click(function(){
        listarMisReservas();
    })
        
    $('#fecha').datetimepicker({showMinute: false});



    //$('#myForm').validator()

})




function editarPerfilUsuario(){
    //URL DEL API
    var id=datosPerfil.id;
    var url="http://localhost:8888/final-tdw/public/api/usuarios/"+id;
    $('#ModalEditarUsuario').modal('show');
    //RELLENAR LOS DATOS DEL FORMULARIO DE LA VENTANA MODAL
    $('#inputPerfilNombre').val(datosPerfil.nombre);
    $('#inputPerfilApellidos').val(datosPerfil.apellidos);
    $('#inputPerfilEmail').val(datosPerfil.email);
    $('#inputPerfilActivo').val(datosPerfil.activo);
    $('#inputPerfilRol').val(datosPerfil.rol);
    //ACTUALIZAR DATOS
    $('#botonActualizarPerfil').click(function(){
        var datosJSON={
            'nombre': $('#inputPerfilNombre').val(),
            'apellidos': $('#inputPerfilApellidos').val(),
            'email': $('#inputPerfilEmail').val(),
            'activo': $('#inputPerfilActivo').val(),
            'rol': $('#inputPerfilRol').val()
        }
        
        //LLAMADA AJAX PUT
        
        $.ajax({
            type: "PUT",
            url: url,
            dataType: "json",
            data: {
                format: 'json'
            },
            data: datosJSON,
            success: function(){
                $('#mensajeAlertaPerfil').html(' <div class="alert alert-success"> Perfil editado correctamente. </div>')
                $('#modalMensajesPerfil').modal('show');
            },
            error: function(){
                $('#mensajeAlertaPerfil').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                $('#modalMensajesPerfil').modal('show');
            }

        })
    })

}

function infoUsuario(id){
    //ARRAY CON LOS DATOS DEL USUARIO y los añade al formulario (editar usuario)
    
    var url="http://localhost:8888/final-tdw/public/api/usuarios/"+id;
    $.getJSON(url,function(data){
        datos=data.jugador;
        datosPerfil=datos;
        $('#celdaPerfilNombre').append(datos.nombre);
        $('#celdaPerfilApellidos').append(datos.apellidos);
        $('#celdaPerfilEmail').append(datos.email);

    })
}

function listarUsuarios(){
    //lista usuarios en el panel de administrador
    
    $('#contPrueba').load("./listaUser.html");
    $.getJSON("http://localhost:8888/final-tdw/public/api/usuarios",function(data){

        arrayDatos=data.jugadores;
        for(var i in arrayDatos){
            var id=arrayDatos[i].id;
            var nombre=arrayDatos[i].nombre;
            var apellidos=arrayDatos[i].apellidos;
            var email=arrayDatos[i].email;
            var activo=arrayDatos[i].activo;
            var rol=arrayDatos[i].rol;
            //CREAR LAS FILAS DE LOS USUARIOS
            var fila= $('<tr></tr>').html('<td>'+id+'</td><br><td>'+nombre+'</td><br><td>'+apellidos+'</td><br><td>'+email+'</td><br><td><button type="button" onclick="editarUsuario('+i+')" class="btn btn-info"  >Editar</button></td><br><td><button type="button"  class="btn btn-danger" onclick="borrarUsuario('+i+')">Borrar</button></td>');
            $('#tablaUsuarios').append(fila);
        }

    });
}


function crearUsuario(){
    
    //CREAR UN USUARIO DESDE EL PANDEL DE ADMIN
    
    var emailExistente=false;
    var url="http://localhost:8888/final-tdw/public/api/usuarios";
    $('#VentanaCrearUser').modal('show');
    $('#inputCrearEmail').on('focusout',function(){
        var val=$('#inputCrearEmail').val();
        for(var i=0;i<arrayDatos.length;i++){
            if(arrayDatos[i].email==val){

                emailExistente=true;
            }
        }
        if(emailExistente==true){
            $('#mensajeAlerta').html(' <div class="alert alert-danger"> Ya hay un usuario con este email. </div>')
            $('#modalMensajes').modal('show');
            emailExistente=false;
        }else{
            $('#mensajeAlerta').html(' <div class="alert alert-success"> Email válido. </div>')
            $('#modalMensajes').modal('show');
        }
    })
    
    $('#btnCrearUsuario').click(function(){
        var datosJSON={
            'nombre': $('#inputCrearNombre').val(),
            'apellidos': $('#inputCrearApellidos').val(),
            'email': $('#inputCrearEmail').val(),
            'password': $('#inputCrearPassword').val(),
            'activo': $('#selectCrearActivo').val(),
            'rol': $('#selectCrearRol').val()
        }
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
                format: 'json'
            },
            data: datosJSON,
            success: function(data){
                data;
                $('#mensajeAlerta').html('<div class="alert alert-success" id="mensajeCorrecto">  Usuario creado correctamente. </div>');

                $('#modalMensajes').modal('show');
            },error: function(data){
                $('#mensajeAlerta').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                $('#modalMensajes').modal('show');

            }


        });

    })


}

function editarUsuario(indice){
    
    //editar un usuario en el panel de administrador
    
    var id=arrayDatos[indice].id;
    var url="http://localhost:8888/final-tdw/public/api/usuarios/"+id;
    
    //añade los datos a los input del formulario de la ventana modal
    
    $('#inputNombre').val(arrayDatos[indice].nombre);
    $('#inputApellidos').val(arrayDatos[indice].apellidos);
    $('#inputEmail').val(arrayDatos[indice].email);
    $('#selectEditarActivo').val(arrayDatos[indice].activo);
    $('#selectEditarRol').val(arrayDatos[indice].rol);
    $('#VentanaModal').modal('show');
    $('#btnActualizar').click(function() {
        var datos=[$('#inputNombre').val(),$('#inputApellidos').val(),$('#inputEmail').val(),$('#inputActivo').val(),$('#inputRol').val()];

        var datosJSON={
            'nombre': $('#inputNombre').val(),
            'apellidos': $('#inputApellidos').val(),
            'email': $('#inputEmail').val(),
            'activo': $('#selectEditarActivo').val(),
            'rol': $('#selectEditarRol').val()
        }
        
        //llamada ajax

         $.ajax({
            type: "PUT",
            url: url,
            dataType: "json",
            data: {
                format: 'json'
            },
            data: datosJSON,
             success: function(){
                 $('#mensajeAlerta').html('<div class="alert alert-success" id="mensajeCorrecto">  Usuario editado correctamente. </div>');

                 $('#modalMensajes').modal('show');
             },error: function(){
                 $('#mensajeAlerta').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                 $('#modalMensajes').modal('show');
             }

        })

    })




}

function borrarUsuario(indice){

//borrar un usuario desde el panel de administrador

    $('#ModalBorrarUser').modal('show');
    $('#confirmBorrar').click(function(){
        var id= arrayDatos[indice].id;
        var url="http://localhost:8888/final-tdw/public/api/usuarios/"+id;

        $.ajax({
            type: "DELETE",
            url: url,
            dataType: "json",
            data: {
                format: 'json'
            },
            success: function(){
                $('#mensajeAlerta').html('<div class="alert alert-success" id="mensajeCorrecto">  Usuario editado correctamente. </div>');

                $('#modalMensajes').modal('show');
            },error: function(){
                $('#mensajeAlerta').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                $('#modalMensajes').modal('show');
            }

        })
        $('#ModalBorrarUser').modal('hide');
    })
    $('#cancelBorrar').click(function() {
        $('#ModalBorrarUser').modal('hide');
    })


}

//PARTE DE RESERVAS

function listarPistas(){
    var pistas= document.getElementsByClassName('tituloPista');

    for(var i=0;i<pistas.length;i++){
        if(pistas[i].style.color=='red'){
            pistasOcupadas.push(pistas[i].textContent);
        }
    }

    for(var j=0;j<pistasOcupadas.length;j++){

        if(j==pistasOcupadas.length-1){
            cadenaPistas=cadenaPistas+pistasOcupadas[j];
        }else{
            cadenaPistas=cadenaPistas+pistasOcupadas[j]+",";
        }
    }
alert(cadenaPistas);
}



function comprobarReserva(){
    //variables necesarias: url, centinela, datos del usuario logueado
    console.log('comprobarReserva()');
    var idUser=$('#idUser').html();
    var estaDentro=false;
    var reservadaEnSesion=false;
    var url="http://localhost:8888/final-tdw/public/api/reservas/usuario/"+idUser;
    var emailUser= $('#emailUser').html();
    $.getJSON(url,function(data){
        arrayReservas=data.reservas;
        var reservaExistente;
        //si existe una reserva temporal de este usuario se guarda
        for(var i=0;i<arrayReservas.length;i++){
            if(arrayReservas[i].email==emailUser && arrayReservas[i].tipo=='temporal'){
                reservaExistente=arrayReservas[i];
                estaDentro=true;
                alert('existe');
            }
        }
        /*MENSAJE: YA HAY UNA RESERVA GUARDADA, DESEA SOBREESCRIBIRLA? (VENTANA MODAL)
         si el usuario dice si:  borrar y guardar la nueva
         si el usuario dice no: salir
         */
        if(estaDentro==true){
            $('#modalBorrarReserva').modal('show');
            //CONFIRMA SOBREESCRIBIR LA RESERVA
            $('#confirmSobreescribir').click(function(){

                var id=reservaExistente.id;
                var url="http://localhost:8888/final-tdw/public/api/reservas/"+id;
                //BORRA
                $.ajax({
                    type: "DELETE",
                    url: url,
                    dataType: "json",
                    data: {
                        format: 'json'
                    },
                    success: function(){
                        //CREA LA NUEVA
                        guardarReserva('temporal');

                        reservaExistente="";
                        arrayReservas=[];
                        estaDentro=false;
                        reservadaEnSesion=true;

                        //CIERRA EL MODAL
                        $('#modalBorrarReserva').modal('hide');


                    }
                });


            });
            //NO QUIERE sobreescribir LA RESERVA
            $('#cancelSobreescribir').click(function(){
                $('#modalBorrarReserva').modal('hide');
            })
        }else{

                console.log('Llamada a guardaReserva()');
                guardarReserva('temporal');
                reservadaEnSesion=true;
                estaDentro = false;
            }


    });


}

function comprobarFecha(fecha){
    var url="http://localhost:8888/final-tdw/public/api/reservas";


}

function guardarReserva(tipo_reserva){
  //  var url="http://localhost:8888/final-tdw/public/api/reservas";
    listarPistas();
  //  var emailUser= $('#emailUser').html();
   // var idUser= $('#idUser').html();
   // var nameUser= $('#nombreUser').html();
    var cont=0;
    $('#modalNuevaReserva').modal('show');

    $('#okReserva').click(function(){
        if(pruebaClick==true){
            alert('ha entrado aqui');
        }
        cont=cont+1;
        var idUser=$('#idUser').html();
        var nameUser= $('#nombreUser').html();
        var emailUser= $('#emailUser').html();
        var url="http://localhost:8888/final-tdw/public/api/reservas";
        var fecha= $('#fecha').val();
        var bookingArray;
        $.getJSON(url,function(data){
            bookingArray=data.reservas;
            for(var i=0;i<bookingArray.length;i++){
                if(bookingArray[i].fecha_reserva==fecha){
                    $('#mensajeAlertaInterfazReserva').html(' <div class="alert alert-danger"> La fecha ya está reservada. </div>')
                    $('#modalMensajesInterfazReserva').modal('show');
                    fechaExistente=true;
                }
            }
            if(fechaExistente==false){
                var datosJSON={
                    'idUsuario': idUser,
                    'nombre': nameUser,
                    'email': emailUser,
                    'pistas': cadenaPistas,
                    'fecha_reserva': fecha,
                    'tipo': tipo_reserva
                };
               //alert(cadenaPistas);
                $.ajax({

                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: {
                        format: 'json'
                    },
                    data: datosJSON,
                    success: function(data){
                        //data;
                        console.log(""+cont);

                        $('#mensajeAlertaInterfazReserva').html('<div class="alert alert-success" id="mensajeCorrecto">  Reserva guardada correctamente. </div>');
                        $('#modalMensajesInterfazReserva').modal('show');
                        cadenaPistas="";
                        pistasOcupadas=[];
                        reservaGuardada=true;
                        pruebaClick=true;
                        //   var datosJSONToList=[idUser,nameUser,emailUser,cadenaPistas,fecha,tipo_reserva];
                        //  datosReservaTemporal=datosJSONToList;

                    },error: function(){
                        $('#mensajeAlertaInterfazReserva').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                        $('#modalMensajesInterfazReserva').modal('show');
                    }

                })

            }

        })

    });
    console.log('guardaReserva');
   cadenaPistas="";
    pistasOcupadas=[];



}


function enviarReserva(tipo_reserva){



}

function recuperarReserva(){
    //SE TOMAN LOS DATOS DEL USUARIO DE LA RESERVA
    var url="http://localhost:8888/final-tdw/public/api/reservas";
    var emailUser= $('#emailUser').html();
    var idUser= $('#idUser').html();
    var nameUser= $('#nombreUser').html();
    $.getJSON(url,function(data){
        arrayReservas=data.reservas;
        for(var i in arrayReservas){
            //SE COMPRUEBA SI EL USUARIO TIENE UNA RESERVA TEMORAL Y SE GUARDAN LOS DATOS
            if(arrayReservas[i].email==emailUser && arrayReservas[i].tipo=="temporal"){
                datosReservaRecuperada=arrayReservas[i];
                var pistasReservadas=datosReservaRecuperada.pistas;
                var arrayPistasReservadas=pistasReservadas.split(",");
                for(var j=0;j<arrayPistasReservadas.length;j++){
                    var pistas= document.getElementsByClassName('tituloPista');
                    //SE PONEN LAS PISTAS OCUPADAS EN LA RESERVA TEMPORAL OCUPADAS
                    for(var k=0;k<pistas.length;k++){
                        if(pistas[k].textContent==arrayPistasReservadas[j]){
                            pistas[k].style.color='red';
                            reservaRecuperada=true;

                            var pistaEntera= pistas[k].parentNode;
                            var monigotes= pistaEntera.getElementsByClassName('huecoJugador');
                            for(var h=0;h<monigotes.length;h++){
                                monigotes[h].style.visibility='visible';
                            }

                        }
                    }
                }
            }
        } if(reservaRecuperada==true){
            $('#mensajeAlertaInterfazReserva').html('<div class="alert alert-success" id="mensajeCorrecto">  Reserva actualizada correctamente. </div>');
            $('#modalMensajesInterfazReserva').modal('show');
        }else{

         $('#mensajeAlertaInterfazReserva').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
         $('#modalMensajesInterfazReserva').modal('show');
         }
    });


}


function fijarReserva(){
    if(reservaRecuperada==false){
        if(reservaGuardada==false){
            //NO SE HA GUARDADO NINGUNA RESERVA TEMPORAL
            guardarReserva('fija');
        }else{
            //SE HA GUARDADO UNA RESERVA TEMPORAL EN LA MISMA SESION
            var emailUser= $('#emailUser').html();
            var idUser= $('#idUser').html();
            var nameUser= $('#nombreUser').html();
            //SE OBTIENEN LOS DATOS DE LA RESERVA TEMPORAL A NOMBRE DEL USUARIO LOGUEADO
            $.getJSON("http://localhost:8888/final-tdw/public/api/reservas",function(data){
                arrayReservas=data.reservas;
                var reservaExistente;

                for(var i=0;i<arrayReservas.length;i++){
                    if(arrayReservas[i].email==emailUser && arrayReservas[i].tipo=='temporal'){
                        reservaExistente=arrayReservas[i];
                        estaDentro=true;
                    }
                }
                //DATOS NECESARIOS PARA ACTUALIZAR LA RESERVA DEL USUARIO
                var idReserva=reservaExistente.id;
                var url="http://localhost:8888/final-tdw/public/api/reservas/"+idReserva;
                var pistasReservadas=reservaExistente.pistas;
                //SE CREA UN JSON PARA ENVIAR LOS DATOS Y SE HACE UN PUT
                var datosJSON={
                    'idUsuario': idUser,
                    'nombre': nameUser,
                    'email': emailUser,
                    'pistas': pistasReservadas,
                    'fecha_reserva': reservaExistente.fecha_reserva,
                    'tipo': "fija",
                }
                alert("hola");
                //SE HACE LA LLAMADA PUT
                $.ajax({
                    type: "PUT",
                    url: url,
                    dataType: "json",
                    data: {
                        format: 'json'
                    },
                    data: datosJSON,
                    success: function(){
                        $('#mensajeAlertaInterfazReserva').html('<div class="alert alert-success" id="mensajeCorrecto">  Reserva actualizada correctamente. </div>');
                        $('#modalMensajesInterfazReserva').modal('show');
                    },error: function(){
                        $('#mensajeAlertaInterfazReserva').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                        $('#modalMensajesInterfazReserva').modal('show');
                    }

                })

            });


        }


    }else{
        //DESPUES DE RECUPERAR LA RESERVA, SE TOMAN LOS DATOS Y SE HACE UN PUT
        var cadPistas="";
        var emailUser= $('#emailUser').html();
        var idUser= $('#idUser').html();
        var nameUser= $('#nombreUser').html();
        var idReserva=datosReservaRecuperada.id;
        var url="http://localhost:8888/final-tdw/public/api/reservas/"+idReserva;
        var pistasReservadas=datosReservaRecuperada.pistas;

        var datosJSON={
            'idUsuario': idUser,
            'nombre': nameUser,
            'email': emailUser,
            'pistas': pistasReservadas,
            'fecha_reserva': datosReservaRecuperada.fecha_reserva,
            'tipo': "fija",
        }

        $.ajax({
            type: "PUT",
            url: url,
            dataType: "json",
            data: {
                format: 'json'
            },
            data: datosJSON,
            success: function(){
                $('#mensajeAlertaInterfazReserva').html('<div class="alert alert-success" id="mensajeCorrecto">  Reserva actualizada correctamente. </div>');
                $('#modalMensajesInterfazReserva').modal('show');
            },error: function(){
                $('#mensajeAlertaInterfazReserva').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                $('#modalMensajesInterfazReserva').modal('show');
            }

        })

    }
}

//CRUD DEL ADMIN DE RESERVAS

function listarReservas(){
    $('#contPrueba').load('./listaReservas.html');
    $.getJSON('http://localhost:8888/final-tdw/public/api/reservas',function(data){
        arrayDatosReservas=data.reservas;
        for(var i in arrayDatosReservas){
            var idRes=arrayDatosReservas[i].id;
            var idUser=arrayDatosReservas[i].idUsuario;
            var emailUser=arrayDatosReservas[i].email;
            var pistasRes=arrayDatosReservas[i].pistas;
            var fechaRes=arrayDatosReservas[i].fecha_reserva;
            var tipoRes=arrayDatosReservas[i].tipo;
            var fila=$('<tr></tr>').html('<td>'+idRes+'</td><br><td>'+idUser+'</td><br><td>'+emailUser+'</td><br><td>'+pistasRes+'</td><br><td>'+fechaRes+'</td><br><td>'+tipoRes+'</td><br><td><button class="btn btn-info" id="btnEditarReserva" onclick="editarReserva('+i+')">Editar</button></td><br><td><button class="btn btn-danger" id="btnBorrarReserva" onclick="borrarReserva('+i+')">Borrar</button></td>');
            $('#tablaReservas').append(fila);
        }
    })
}

function editarReserva(indice){
        //put
    var id=arrayDatosReservas[indice].id;
    var url="http://localhost:8888/final-tdw/public/api/reservas/"+id;
    $('#inputReservaEditarIdUser').val(arrayDatosReservas[indice].idUsuario);
    $('#inputReservaEditarNombre').val(arrayDatosReservas[indice].nombre);
    $('#inputReservaEditarEmail').val(arrayDatosReservas[indice].email);
    $('#inputReservaEditarPistas').val(arrayDatosReservas[indice].pistas);
    $('#inputReservaEditarFecha').val(arrayDatosReservas[indice].fecha_reserva);
    $('#inputReservaEditarTipo').val(arrayDatosReservas[indice].tipo);
    $('#VentanaModalEditarReserva').modal('show');
    $('#inputReservaEditarFecha').datetimepicker({showMinute: false});
    //se guardan los datos de la reserva

    $('#btnActualizarReserva').click(function(){
        var datosJSON={
            'idUsuario': $('#inputReservaEditarIdUser').val(),
            'nombre': $('#inputReservaEditarNombre').val(),
            'email': $('#inputReservaEditarEmail').val(),
            'pistas': $('#inputReservaEditarPistas').val(),
            'fecha_reserva': $('#inputReservaEditarFecha').val(),
            'tipo': $('#inputReservaEditarTipo').val(),
        }
        $.ajax({
            type: "PUT",
            url: url,
            dataType: "json",
            data: {
                format: 'json'
            },
            data: datosJSON,
            success: function(){
                $('#mensajeAlertaReserva').html('<div class="alert alert-success" id="mensajeCorrecto">  Reserva actualizada correctamente. </div>');
                $('#modalMensajesReserva').modal('show');
            },error: function(){
                $('#mensajeAlertaReserva').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                $('#modalMensajesReserva').modal('show');
            }

        })
    })

}

function borrarReserva(indice){
    //DELETE
    $('#VentanaModalBorrarReserva').modal('show');
    $('#confirmBorrarReserva').click(function(){
        var id=arrayDatosReservas[indice].id;
        var url="http://localhost:8888/final-tdw/public/api/reservas/"+id;
        $.ajax({
            type: "DELETE",
            url: url,
            dataType: "json",
            data: {
                format: 'json'
            },

        })
        $('#VentanaModalBorrarReserva').modal('hide');
    })
    $('#cancelBorrarReserva').click(function(){
        $('#VentanaModalBorrarReserva').modal('hide');
    })

    
}

function crearReserva(){
    //post
    var nombreUser;
    var emailUser;

    var url="http://localhost:8888/final-tdw/public/api/reservas";
    $('#VentanaCrearReserva').modal('show');
    $('#inputReservaCrearIdUser').on("focusout",function(){
        var idUser=$('#inputReservaCrearIdUser').val();
        var url_user= "http://localhost:8888/final-tdw/public/api/usuarios/"+idUser;
        $.getJSON(url_user,function(data){

            nombreUser=data.jugador.nombre;
            emailUser=data.jugador.email;
            $('#inputReservaCrearNombre').val(nombreUser);
            $('#inputReservaCrearEmail').val(emailUser);
        })


    })
    $('#fecha').datetimepicker({showMinute: false});

    $('#botonModalCrearReserva').click(function(){
        var datosJSON={
            'idUsuario': $('#inputReservaCrearIdUser').val(),
            'nombre': $('#inputReservaCrearNombre').val(),
            'email': $('#inputReservaCrearEmail').val(),
            'pistas': $('#inputReservaCrearPistas').val(),
            'fecha_reserva': $('#fecha').val(),
            'tipo': $('#inputReservaCrearTipo').val(),
        }
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
                format: 'json'
            },
            data: datosJSON,
            success: function(data){
                data;
                $('#mensajeAlertaReserva').html('<div class="alert alert-success" id="mensajeCorrecto">  Reserva creada correctamente. </div>');
                $('#modalMensajesReserva').modal('show');
            },error: function(){
                $('#mensajeAlertaReserva').html(' <div class="alert alert-danger"> Ha habido un error. </div>')
                $('#modalMensajesReserva').modal('show');
            }

        })
    })

}


//PANEL DE USUARIO MIS RESERVAS

function listarMisReservas(){
    var id=$('#idUsuario').html();
    var datosMisReservas;
    var url="http://localhost:8888/final-tdw/public/api/reservas/usuario/"+id;
    $('#contenedorUsuario').load('./reservasUsuario.html');
    $.getJSON(url,function(data){
        datosMisReservas=data.reservas;
        for(var i in datosMisReservas){
            var idRes=datosMisReservas[i].id;
            var idUser=datosMisReservas[i].idUsuario;
            var emailUser=datosMisReservas[i].email;
            var pistasRes=datosMisReservas[i].pistas;
            var fechaRes=datosMisReservas[i].fecha_reserva;
            var tipoRes=datosMisReservas[i].tipo;
            var fila=$('<tr></tr>').html('<td>'+idRes+'</td><br><td>'+emailUser+'</td><br><td>'+pistasRes+'</td><br><td>'+fechaRes+'</td><br><td>'+tipoRes+'</td><br>');
            $('#tablaReservas').append(fila);
        }
    })
}

function buscarPorUsuario(){
    var idUser;
    idUser=prompt("Introduzca el id del usuario");
    var url="http://localhost:8888/final-tdw/public/api/reservas/usuario/"+idUser;
    $('#contPrueba').load('./reservasUsuario.html');
    $.getJSON(url,function(data){
        datosMisReservas=data.reservas;
        for(var i in datosMisReservas){
            var idRes=datosMisReservas[i].id;
            var idUser=datosMisReservas[i].idUsuario;
            var emailUser=datosMisReservas[i].email;
            var pistasRes=datosMisReservas[i].pistas;
            var fechaRes=datosMisReservas[i].fecha_reserva;
            var tipoRes=datosMisReservas[i].tipo;
            var fila=$('<tr></tr>').html('<td>'+idRes+'</td><br><td>'+emailUser+'</td><br><td>'+pistasRes+'</td><br><td>'+fechaRes+'</td><br><td>'+tipoRes+'</td><br>');
            $('#tablaReservas').append(fila);
        }
    })

}