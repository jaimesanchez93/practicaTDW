<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UsuarioController extends Controller
{
    //

    //DEVUELVE TODOS LOS USUARIOS
    public function index(){
        $jugadores= \App\User::get();
        if($jugadores==null){
            return json_encode([
                "code" => "404",
                "message" => "la tabla  de jugadores esta vacía",

            ],404
            );
        }else{
            return json_encode([
                    "code" => "200",
                    "message" => "listado de jugadores",
                    "jugadores" => $jugadores->toArray()
                ]
            );

        }


    }
    //MUESTRA UN USUARIO CONCRETO
    public function show($id){

        try{
            $jugador = \App\User::findOrFail($id);
            return response()->json([
                "code" => "200",
                "jugador" => $jugador->toArray()
            ]);

        }catch (ModelNotFoundException $e){
            return response()->json([
                "code" => "404",
                "message" => "usuario no encontrado"
            ],404);

        }







    }
        //CREAR UN USUARIO
    public function store(Request $request){

        try {

            $jugador = new \App\User();

            if($request->input('nombre')!=null && $request->input('email')!=null){
                $jugador->nombre = $request->input('nombre');
                $jugador->apellidos = $request->input('apellidos');
                $jugador->email = $request->input('email');
                $jugador->password= \Hash::make($request->input('password'));
                $jugador->activo = $request->input('activo');
                $jugador->rol = $request->input('rol');

                $jugador->save();
                return response()->json([
                    "code" => "201",
                    "message" => "Jugador creado correctamente",
                    "jugador" => $jugador->toArray()
                ], 201);
            }else{
                return response()->json([
                    "code" => "422",
                    "message" => "El campo nombre y el campo email son necesarios",
                ], 422);
            }




        }catch(QueryException $e){
            return response()->json([
                "code" => "400",
                "message" => "este username o email ya existe",
            ],400);
        }

    }

    //ACTUALIZAR UN USUARIO
    public function update(Request $request,$id){


        try{

            //Buscamos el jugador en cuestión a través de su ID
            $jugador= \App\User::findOrFail($id);
            // actualizamos los atributos de jugador y guardamos el jugador

            $jugador->nombre = $request->input("nombre");
            $jugador->apellidos = $request->input("apellidos");
            $jugador->email = $request->input("email");
            $jugador->activo = $request->input("activo");
            $jugador->rol = $request->input("rol");
            $jugador->save();

            return response()->json([
                "code" => "200",
                "message" => "El usuario se ha actualizado correctamente",
                "jugadores" => $jugador->toArray()
            ],200);
        }catch (ModelNotFoundException $e){
            return response()->json([
                "code" => "404",
                "message" => "usuario no encontrado"
            ],404);
        }catch(QueryException $e){
            return response()->json([
                "code" => "400",
                "message" => "este username o email ya existe",
            ],400);
        }


    }
    
    
    //ELIMINAR UN USUARIO
    public function destroy($id){

        try{
            $jugador= \App\User::findOrFail($id);
            $jugador->delete();

            return response()->json([
                "code" => "200",
                "message" => "usuario eliminado correctamente",
                "id" => $id
            ],204);
        }catch (ModelNotFoundException $e){
            return response()->json([
                "code" => "404",
                "message" => "usuario no encontrado"
            ],404);
        }

    }

    //OPTIONS
    public function options(){

        $headers=['Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS'];
        return response()->make("",200,$headers);


    }
    
    //DEVUELVE LA VISTA LOGIN (PLANTILLA DE BLADE)
    public function conectarse(){
        return view('login/login');


    }
    
    //DEVUELVE LA VISTA REGISTER (PLANTILLA BLADE)
    public function registro(){
        return view('registrarse/register');
    }


}
