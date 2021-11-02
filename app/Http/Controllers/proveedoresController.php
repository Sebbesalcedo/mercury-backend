<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;
class proveedoresController extends Controller
{
        public function __construct()
    {

        $this->middleware('api.auth', ['except' => []]);
    }


    /**
     * Retornar el listado de todos los proveedores
     */
    public function index()
    {

        $data = Proveedor::all()->load('tipo_iden_id','id_user');

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
        $data = Proveedor::find($id);


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
                'mensaje' => 'La no existe el proveedor.'
            ];
        }

        return response()->json($dt, $dt['code']);
    }


    // /**
    //  * Metodo que nos permite agregar un nuevo proveedor
    //  */
    public function store(Request $request)
    {

        //Recoger los datos por post

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);



        //COMPROBAR SI EL USUARIO ESTA IDENTIFICADO

        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);


        if (!empty($params_array) && $checkToken) {
            $user = $jwtAuth->checkToken($token, true);
            //Validar los datos
            $validate = \Validator::make($params_array, [

                'nombre' => 'required',
                'tipo_iden_id' => 'required',
                'num_identificacion' => 'required|unique:proveedores',
                'contacto1' => 'required',
                'id_user'   => 'required',
                'email' => 'required|unique:proveedores',
                'direccion' => 'required'


            ]);

            //Guardar eL proveedor


            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha guardado el proveedor no ha enviado los datos correcto o ya existe el proveedor ',
                    'error' => $validate->errors()
                ];
            } else {
                $tId = new Proveedor();

                $tId->nombre =  $params_array['nombre'];
                $tId->tipo_iden_id =  $params_array['tipo_iden_id'];
                $tId->num_identificacion =  $params_array['num_identificacion'];
                $tId->contacto1 =  $params_array['contacto1'];
                $tId->contacto2 =  $params_array['contacto2'];
                $tId->email =  $params_array['email'];
                $tId->direccion =  $params_array['direccion'];
                $tId->id_user = $params_array['id_user'];

                $tId->save();


                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Se ha guardado el nuevo proveedor',
                    'proveedor' => $tId->nombre

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
            $validate = \Validator::make($params_array,[

                'nombre'=>'required|unique:proveedores',
            ]);

            // Quitar lo que no quiero actualizar
            unset($params_array['id']);

            unset($params_array['created_at']);

            //Actualizar el registro
            $tId = Proveedor::where('id',$id)->update($params_array);
            $data = [
                'code' => 200,
                'status' => 'success',
                'mensaje' => 'Se ha actualizado el tipo de identificación',
                'changes' =>$params_array

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
        $proveedor = Proveedor::where('id', $id)->first();

        if (!empty($proveedor)) {
            $proveedor->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'mensaje' => 'Dato eliminado correctamente'
            ];
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'Hubo un error al eliminar el dato'
            ];
        }
        return response()->json($data, $data['code']);
    }
}
