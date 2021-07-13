<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Tipo_identificacion;

class TidentificacionController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => []]);
    }

    /**
     * Retornar el listado de todos los tipos de identificación
     */
    public function index()
    {

        $data = Tipo_identificacion::all();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $data


        ]);
    }

      /**
     * Busca y retorna un elemento
     */

    public function show($id)
    {
        $data = Tipo_identificacion::find($id);


        if (is_object($data)) {
            $dt = [
                'code' => 200,
                'status' => 'success',
                'data' => $data
            ];
        } else {
            $dt = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'La el tipo de identificación no existe.'
            ];
        }

        return response()->json($dt, $dt['code']);
    }
    /**
     * Metodo que nos permite guardar un tipo de identificación
     */

    public function store(Request $request)
    {

        //Recoger los datos por post

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);


        if (!empty($params_array)) {
            //Validar los datos
            $validate = \Validator::make($params_array, [

                'nombre' => 'required|unique:tipo_identificacion'

            ]);

            //Guardar eL TIPO DE IDENTIFICACION


            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha guardado el tipo de identificación',
                    'error' => $validate->fails()
                ];
            } else {
                $tId = new Tipo_Identificacion();

                $tId->nombre =  $params_array['nombre'];
                $tId->descripcion =  $params_array['descripcion'];
                $tId->save();


                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Se ha guardado el tipo de identificación',
                    'tipo_identificacion' => $tId->nombre

                ];
            }
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'No has enviado ningun dato'

            ];
        }

        //Devolver el resultado

        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request)
    {

        //recoger los datos que vengan por post

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            //Validar los datos
            $validate = \Validator::make($params_array, [

                'nombre' => 'required|unique:tipo_identificacion',
            ]);

            // Quitar lo que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['created_at']);

            //Actualizar el registro
            $tId = Tipo_identificacion::where('id', $id)->update($params_array);
            $data = [
                'code' => 200,
                'status' => 'success',
                'mensaje' => 'Se ha actualizado el tipo de identificación',
                'changes' => $params_array

            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'No has enviado ningun dato'

            ];
        }


        //Devolver respuesta
        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request)
    {
        //conseguir usuario identificado

        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        // Comprobar si existe el registro

        $element = Tipo_identificacion::find($id);
        if (!empty($element) &&   $checkToken) {

            $user = $jwtAuth->checkToken($token, true);
            //Borrarlo

            $element->delete();

            //Devolver algo
            $data = [
                'code' => 200,
                'status' => 'success',
                'mensaje' => 'Se ha eliminado correctamente el dato',
                'data' => $element

            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'No existe ese elemento'
            ];
        }
        return response()->json($data, $data['code']);
    }

}
