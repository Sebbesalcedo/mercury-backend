<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado_Op;
class Estado_OpController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => []]);
    }

    public function index()
    {
        $data = Estado_Op::all();
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data' => $data

        ]);
    }


   
    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {


            $validate = \Validator::make($params_array, [

                'nombre' => 'required|nombre|unique:Estado_Op'
            ]);

            if ($validate->fails()) {

                $data = [

                    'code'      => 400,
                    'status'    => 'error',
                    'mensaje'   => 'No se ha podido guardar el nuevo estado',
                    'error'     => $validate->errors()

                ];
            } else {
                $dt = new Estado_Op();
                $dt->nombre    = $params_array['nombre'];
                $dt->descripcion = $params_array['descripcion'];

                $dt->save();

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente el dato',
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

    public function show($id)
    {
        $data = Estado_Op::find($id);
        if (is_object($data)) {

            $data = array([

                'code'   => 200,
                'status' => 'success',
                'data'   => $data

            ]);
        } else {

            $data = array([

                'code'    => 400,
                'status'  => 'error',
                'mensaje' => 'El dato no existe.'

            ]);
        }

        return response()->json($data, $data['code']);
    }


    public function update($id, Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'nombre' => 'required|nombre|unique:Estado_Op'


            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status'  => 'error',
                    'mensaje' => 'Se ha encontrado un error.',
                    'error'   => $validate->errors()
                ];
            }else {

                unset($params_array['id']);
               
                unset($params_array['created_at']);
                $dt = Estado_Op::where('id', $id)->update($params_array);
                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con exito.',
                    'changes'   => $params_array

                ];
            }

        }
        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request)
    {

        $dt = Estado_Op::find($id);
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
