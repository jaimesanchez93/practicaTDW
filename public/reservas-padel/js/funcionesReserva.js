/**
 * Created by jaime on 10/04/16.
 */

var numJugadores=0;
var contadorHuecosLibres=0;
var nJug;

$(document).ready(function(){

//AÑADIR UN NUEVO JUGADOR


    $('#envioNombre').click(function(){
        var nombre= $('#nombre').val();
        var tx2= $('<tr></tr>').html('<td class="nombreJugador" data-toggle="modal" data-target="modalAsignarJugador" >'+ nombre +' <button style="float: right" onblur="setTitle(this)" id="btnAsignar" class="btn btn-primary" data-toggle="modal" data-target="#modalAsignarJugador">Asignar</button></td><td class="borrarJugador" onclick="borrarJugador(this)"><img class="botonBorrar"  src="reservas-padel/img/delete.svg"  alt="añadir jugador" width=25px" height="40px"></td>')
        var nombresJugadores=document.getElementsByClassName('nombreJugador');

        if(numJugadores==0){
            var ident= 'jugador'+numJugadores;
            tx2.attr('id',ident);
            $('#tablaJugadores').append(tx2);
            numJugadores++;
            $('#nombre').val("");

        } else{
            var existe =false;
            for (var i=0;i<nombresJugadores.length;i++){
                if(nombresJugadores[i].firstChild.textContent.trim()==nombre){
                    alert('El jugador ya existe');
                    existe=true;
                }
            }
            if(existe==false){
                var ident= 'jugador'+numJugadores;
                tx2.attr('id',ident);
                $('#tablaJugadores').append(tx2);
                numJugadores++;
                $('#nombre').val("");
            }


        }




    });





})



/* recuperar nombre del jugador para ponerlo en el icono jugador*/
function setTitle(sender){
    var row= sender.parentNode;
    var  nombrejugador= row.firstChild.textContent;
    nJug=nombrejugador;
}

/*Borrar jugador */
function borrarJugador(sender){
    var fila= sender.parentNode;
    var idFila= fila.getAttribute("id");
    // var tabla= document.getElementById('tablaJugadores');
    var tabla= fila.parentNode;
    var celda= fila.firstChild
    var nombre= celda.firstChild.textContent;
    tabla.removeChild(fila);
    borrarIconoJugador(nombre);
    cambiarColorTitulo();


}


//BORRAR ICONO DEL JUGADOR
function borrarIconoJugador(nombre){
    var jugadores= document.getElementsByClassName('huecoJugador');
    for (var i in jugadores){
        if(jugadores[i].title==nombre){
            jugadores[i].style.visibility='hidden';
            jugadores[i].title="";
        }
    }
}

//CLICKAR EN EL ICONO DE UN JUGADOR Y DESASIGNARLO
function desAsignarJugador(sender){
    var nombreJugador= sender.title;
    sender.style.visibility="hidden";
    var tablaNombres= document.getElementsByClassName("nombreJugador");
    for(var i in tablaNombres){
        var nombre= tablaNombres[i].firstChild;

        if(nombre.textContent==nombreJugador){
            tablaNombres[i].style.color='black';
            tablaNombres[i].style.fontWeight='normal';
        }
        cambiarColorTitulo();
    }


}


//ASGINAR UN JUGADOR A UNA PISTA
function asignarJugador(sender){
    var asignado;
    var contador=0;

    var listadoPistas= document.getElementById('listadoPistas')
    var nombrePista= listadoPistas.value;
    var pista= document.getElementById(nombrePista);
    var tablaPista= pista.getElementsByClassName('huecoJugador');
    var valor= sender.textContent;
    var jugadores= document.getElementsByClassName('nombreJugador');

    for(var j in jugadores){
        if(jugadores[j].firstChild.textContent==nJug){
            if(jugadores[j].style.color=='rgb(255, 0, 0)'){
                asignado=true;
            }else{
                asignado=false;
            }
            var jugador= jugadores[j];
            break;
        }
    }

    if(asignado==false) {
        for (var i in tablaPista) {
            if (tablaPista[i].style.visibility != 'visible') {
                tablaPista[i].style.visibility = 'visible';
                tablaPista[i].title = nJug;
                contador++;
                asignado = true;
                jugador.style.color = 'rgb(256,0,0)';
                jugador.style.fontWeight='bold';
                break;
            }
        }
    }

    cambiarColorTitulo();

}


function cambiarColorTitulo(){

    //  PONER EL TITULO DE PISTA EN ROJO O NO
    var titulos= $('.tituloPista');
    var pistas= $('.court');
    for(var i=0; i<pistas.length;i++){
        var jugadores=pistas[i].getElementsByClassName('huecoJugador');
        var contador=0;
        for(var j=0;j<jugadores.length;j++){
            if(jugadores[j].style.visibility=='visible'){
                contador++;
            }

        }
        if(contador%4==0 && contador!=0){
            titulos[i].style.color='red';
        }
        else if(contador%4>0 && contador%4<4){
            titulos[i].style.color='green';
        }
        else{
            titulos[i].style.color='black';
        }
    }
}

var nombres;
function setCourtTitle(){

    var pistas= document.getElementsByClassName('court');
    for(var i in pistas){
        var encabezado=document.getElementsByTagName('h4');
        var celdas=pistas[i].getElementsByClassName('huecoJugador');
        //  alert(encabezado[i].textContent);
        for(var j in celdas){
            nombres= nombres+celdas[j].title+", ";
        }


        encabezado[0].setAttribute('title',nombres);
    }

}



// Asignar el atribute title a los titulos "pista 1, pista 2,..." con los nombres de los jugadores
function ponerTitulos(){
    var nombres="";
    var titulos= document.getElementsByClassName('tituloPista');
    var pistas= document.getElementsByClassName('court');
    for(var i=0;i<titulos.length;i++){
        var jugadores= pistas[i].getElementsByClassName('huecoJugador');
        for(var j=0;j<jugadores.length;j++){
            nombres= nombres  + jugadores[j].title +"\n";
        }
        titulos[i].setAttribute('title',nombres);
        nombres="";
    }
}


