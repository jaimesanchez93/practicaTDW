
@extends('admin.admin')

@section('content')
    @if (Auth::user()->rol=="admin")
        <br><br><br>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h2>Bienvenido Admin!¿Que desea hacer?</h2>
        <button id="listaUsuarios">Usuarios</button>
        <button id="listaReservas">Reservas</button>

        <div id="contPrueba">
        </div>
        <!-- Modal -->



    @else
        <br><br><br>
        <p>No eres admin</p>
    @endif

@endsection