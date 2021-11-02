<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use Validator;
class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['']]);
    }



    public function index()
    {
        $data = Clientes::all()->load('tipo_iden', 'id_n_estudio');
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data' => $data
        ]);
    }


    public function show($id)
    {
        $data = Clientes::find($id)->load('tipo_iden', 'id_n_estudio');
        if (is_object($data)) {

            $data = array(

                'code' => 200,
                'status' => 'success',
                'data' => $data

            );
        } else {

            $data = array(

                'code' => 400,
                'status' => 'error',
                'mensaje' => 'dato no existente'

            );
        }
        return response()->json($data, $data['code']);
    }

    public function store(Request $request)
    {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'nombre'             => 'required',
                'tipo_iden'          => 'required',
                'num_identificacion' => 'required|unique:clientes',
                'fecha_nacimiento'   =>  'required',
                'id_n_estudio'       =>  'required',
                'profesion'          => 'required',
                'contacto1'          =>  'required',
                'email'              =>  'required',
                'id_user'            => 'required'

            ]);
            if ($validate->fails()) {

                $data = [

                    'code'      => 400,
                    'status'    => 'error',
                    'mensaje'   => 'No se ha podido guardar el nuevo cliente',
                    'error'     => $validate->errors()

                ];

                return response()->json($data, $data['code']);

            } else {

                $dt = new  Clientes();

                $dt->nombre             = $params_array['nombre'];
                $dt->tipo_iden          = $params_array['tipo_iden'];
                $dt->num_identificacion = $params_array['num_identificacion'];
                $dt->fecha_nacimiento   = $params_array['fecha_nacimiento'];
                $dt->id_n_estudio       = $params_array['id_n_estudio'];
                $dt->profesion          = $params_array['profesion'];
                $dt->contacto1          = $params_array['contacto1'];
                $dt->contacto2          = $params_array['contacto2'];
                $dt->email              = $params_array['email'];
                $dt->descripcion        = $params_array['descripcion'];
                $dt->id_user            = $params_array['id_user'];

                $dt->save();

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente el cliente',
                    'data'      => $dt->nombre

                ];
            }
        } else {

            $data = [

                'code'      => 400,
                'status'    => 'error',
                'mensaje'   => 'No has enviado ningún dato',


            ];
        }
        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'nombre'                => 'required',
                'tipo_iden'             => 'required',
                'num_identificacion'    => 'required',
                'fecha_nacimiento'      => 'required',
                'id_n_estudio'          => 'required',
                'profesion'             => 'required',
                'contacto1'             => 'required',
                'email'                 => 'required',
                'id_user'               => 'required'
            ]);
            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status'  => 'error',
                    'mensaje' => 'Se ha encontrado un error.',
                    'error'   => $validate->errors()
                ];
            } else {

                unset($params_array['id']);
                unset($params_array['id_user']);
                unset($params_array['created_at']);

                $dt = Clientes::where('id', $id)->update($params_array);

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con exito.',
                    'changes'   => $params_array

                ];
            }

            return response()->json($data, $data['code']);
        }
    }

    public function destroy($id, Request $request)
    {

        $dt = Clientes::find($id);
        if (!empty($dt)) {

            $dt->delete();

            $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'Se ha eliminado correctamente el dato.',
                'data'      => $dt

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
