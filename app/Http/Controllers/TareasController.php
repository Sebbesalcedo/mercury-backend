<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tareas;

class TareasController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['']]);
    }


    public function index()
    {
        $data = Tareas::all()->load('id_estado','cliente','id_user','oportunidad_venta');
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data' => $data

        ]);
    }

    public function show($id)
    {
        $data = Tareas::find($id);
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

                'tarea' => 'required',
                'fecha_recordatorio' => 'required',
                'id_user' => 'required',
                'id_estado' => 'required'

            ]);
            if ($validate->fails()) {

                $data = [

                    'code'      => 400,
                    'status'    => 'error',
                    'mensaje'   => 'No se ha podido guardar la tarea',
                    'error'     => $validate->errors()

                ];
            } else {


                $dt = new Tareas();
                
                $dt->oportunidad_venta  = $params_array['oportunidad_venta'];
                $dt->tarea              = $params_array['tarea'];
                $dt->fecha_recordatorio = $params_array['fecha_recordatorio'];
                $dt->id_user            = $params_array['id_user'];
                $dt->id_estado          = $params_array['id_estado'];

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

    public function update($id, Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'tarea' => 'required',
                'fecha_recordatorio' => 'required',
                'id_estado' =>   'required'


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
                $dt = Tareas::where('id', $id)->update($params_array);
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

        $dt = Tareas::find($id);
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
