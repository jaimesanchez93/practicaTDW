<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReservasController extends Controller
{
    //
    //DEVUELVE TODAS LAS RESERVAS
    public function index(){
        
        $reservas= \App\Models\Reserva::get();
        return response()->json([
            "code" => "200",
            "message" => "listado de reservas",
            "reservas"=>$reservas->toArray()
        ]);

    }
    //devuelve una reserva concreta
    public function show($id){

        try{
            $reserva = \App\Models\Reserva::findOrFail($id);
            return response()->json([
                "code" => "200",
                "jugador" => $reserva->toArray()
            ]);

        }catch (ModelNotFoundException $e){
            return response()->json([
                "code" => "404",
                "message" => "reserva no encontrada"
            ],404);

        }

    }
    //CREAR UNA RESERVA (POST)
    public function store(Request $request){

            try {
                $reserva = new \App\Models\Reserva();
                $reserva->idUsuario = $request->input('idUsuario');
                $reserva->nombre = $request->input('nombre');
                $reserva->email = $request->input('email');
                $reserva->pistas = $request->input('pistas');
                $reserva->fecha_reserva = $request->input('fecha_reserva');
                $reserva->tipo = $request->input('tipo');
                $reserva->save();
                return response()->json([
                    "code" => "201",
                    "message" => "reserva creada correctamente",
                    "reserva" => $reserva->toArray()
                ], 201);

            }catch(QueryException $e){
                return response()->json([
                    "code" => "400",
                    "message" => "reserva existente"
                ], 400);
            }


    }
    
    //ACTUALIZAR UNA RESERVA (PUT)
    public function update(Request $request,$id)
    {

        try{
        $reserva = \App\Models\Reserva::findOrFail($id);
        $reserva->idUsuario = $request->input('idUsuario');
        $reserva->nombre = $request->input('nombre');
        $reserva->email = $request->input('email');
        $reserva->pistas = $request->input('pistas');
        $reserva->fecha_reserva = $request->input('fecha_reserva');
        $reserva->tipo = $request->input('tipo');
        $reserva->save();
        return response()->json([
            "code" => "200",
            "message" => "reserva actualizada correctamente"
        ], 200);
    }catch(QueryException $e){
            return response()->json([
                "code" => "400",
                "message" => "reserva existente"
            ], 400);
        }catch(ModelNotFoundException $e){
            return response()->json([
                "code" => "404",
                "message" => "reserva no encontrada"
            ], 404);
        }

    }

    //ELIMINAR UNA RESERVA
    public function destroy($id){
        try {
            $reserva = \App\Models\Reserva::findOrFail($id);
            $reserva->delete();

            return response()->json([
                "code" => "404",
                "message" => "reserva eliminada correctamente",
                "id" => $id
            ], 204);

        }catch(QueryException $e){
            return response()->json([
                "code" => "400",
                "message" => "reserva existente"
            ], 400);
        }catch(ModelNotFoundException $e){
            return response()->json([
                "code" => "404",
                "message" => "reserva no encontrada"
            ], 404);
        }

    }
    
    //DEVUELVE LAS RESERVAS DE UN USUARIO CONCRETO
    public function reserva_users($idUsuario){
        try{
            $reserva_por_usuario=[];
            $reserva = \App\Models\Reserva::get();
            for($i=0;$i<count($reserva);$i++){
                if($reserva[$i]->idUsuario==$idUsuario){
                    array_push($reserva_por_usuario,$reserva[$i]);
                }
            }
            return response()->json([
                "code" => "200",
                "reservas" => $reserva_por_usuario
            ]);

        }catch (ModelNotFoundException $e){
            return response()->json([
                "code" => "404",
                "message" => "reserva no encontrada"
            ],404);

        }
    }
    
    //DEVUELVE LA VISTA RESERVAS
    public function verReservas(){
        return view('reservas/reservas');
    }
}
