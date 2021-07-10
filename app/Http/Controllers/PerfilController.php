<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perfil;
class PerfilController extends Controller
{
    public function pruebas(Request $request){
        return "Controlador de perfil";
    }

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => []]);
    }


    /**
     * Metodo que me retorna una lista de todas las empresas
     * @return type, listado de empresas
     */
    public function index() {

        $perfiles = Perfil::all();

        return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'perfiles' => $perfiles
        ]);
    }


    public function addPerfil(Request $request){

        $json = $request->input('json', null);
        $params = json_decode($json); //objeto
        $params_array = json_decode($json, true); //array

        if(!empty($params) && !empty($params_array)){

            $params_array = array_map('trim', $params_array);

            $validate = \Validator::make($params_array, [

                'nombre'    => 'required|unique:perfiles',
            ]);

            if ($validate->fails()) {
                $data = array(
                    'code' => 404,
                    'status' => 'error',
                    'mensaje' => 'Datos del nuevo perfil son erroneos.',
                    'error' => $validate->errors()
                );
            } else {
                $perfil = new Perfil();

                $perfil->nombre   = $params_array['nombre'];
                $perfil->descripcion = $params_array['descripcion'];
                

                $perfil->save();

                $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'se ha a creado correctamente el nuevo perfil.',
                    'usuario' => $perfil
                );
            }

        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Los datos enviados son incorrectos.',
            );
        }

        return response()->json($data, $data['code']);
    }


    public function getPerfil($id)
    {
        
        $perfil = Perfil::find($id);

       
        if (is_object($perfil)) {

            $data = array(
                'code' => 200,
                'status' => 'success',
                'perfil' => $perfil
            );
        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'No existe el usuario.'
            );
        }
        return response()->json($data, $data['code']);
    }
}
