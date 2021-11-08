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

        $data = Proveedor::all();

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
                'code'   => 200,
                'status' => 'success',
                'data'   => $data
            ];
        } else {
            $dt = [
                'code'      => 404,
                'status'    => 'error',
                'mensaje'   => 'La no existe el proveedor.'
            ];
        }

        return response()->json($dt, $dt['code']);
    }


    //
    //   Metodo que nos permite agregar un nuevo proveedor
    //  
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

                'Proveedor_Name'        => 'required',
                'Tipo_Documento_Prov'   => 'required',
                'No_Documento_Prov'     => 'required|unique:t_proveedores',
                'Celular_Prov'          => 'required',
                'Email_Prov'            => 'required|unique:t_proveedores',
                'Ciudad'                => 'required',
                'Direccion_Prov'        => 'required',
                'User_ID	'           => 'required'
                


            ]);

            //Guardar eL proveedor


            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos, por favor valida que todo este correctamente',
                    'error' => $validate->errors()
                ];
            } else {
                $tId = new Proveedor();

                $tId->Proveedor_Name	    =  $params_array['Proveedor_Name'];
                $tId->Tipo_Documento_Prov   =  $params_array['Tipo_Documento_Prov'];
                $tId->No_Documento_Prov	    =  $params_array['No_Documento_Prov	'];
                $tId->Celular_Prov          =  $params_array['Celular_Prov'];
                $tId->Telefono_Prov         =  $params_array['Telefono_Prov'];
                $tId->Email_Prov	        =  $params_array['Email_Prov'];
                $tId->Ciudad                =  $params_array['Ciudad'];
                $tId->Direccion_Prov        =  $params_array['Direccion_Prov'];
                $tId->User_ID               = $params_array['User_ID'];

                $tId->save();


                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Se ha Registrado el nuevo Proveedor',
                    'proveedor' => $tId

                ];
            }
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'Error en el envio de los datos.'

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

                'Proveedor_Name'        => 'required',
                'Tipo_Documento_Prov'   => 'required',
                'No_Documento_Prov'     => 'required|unique:t_proveedores',
                'Celular_Prov'          => 'required',
                'Email_Prov'            => 'required|unique:t_proveedores',
                'Ciudad'                => 'required',
                'Direccion_Prov'        => 'required',
            ]);

            // Quitar lo que no quiero actualizar
            


            //Actualizar el registro
            $tId = Proveedor::where('No_Documento_Prov', $id)->update($params_array);
            $data = [
                'code' => 200,
                'status' => 'success',
                'mensaje' => 'Se ha realizado con exito la actualización de los datos.',
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
        $proveedor = Proveedor::where('No_Documento_Prov', $id)->first();

        if (!empty($proveedor)) {
            $proveedor->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'mensaje' => 'Se ha eliminado con Exito el Proveedor '
            ];
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'Se presento un error al eliminar el Proveedor'
            ];
        }
        return response()->json($data, $data['code']);
    }
}
