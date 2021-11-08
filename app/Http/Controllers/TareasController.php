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
        $data = Tareas::all();
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }

    public function show($id)
    {
        $data = Tareas::find($id);
        if (is_object($data)) {

            $data = array(

                'code'      => 200,
                'status'    => 'success',
                'data'      => $data

            );
        } else {

            $data = array(

                'code'      => 400,
                'status'    => 'error',
                'mensaje'   => 'dato no existente'

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

                'Tarea_Descr'           => 'required',
                'Fecha_Recordatorio'    => 'required',
                'Estado_Tarea'          => 'required',
                'User_ID'               => 'required'

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


                $dt->Tarea_Descr          = $params_array['Tarea_Descr'];
                $dt->Fecha_Recordatorio   = $params_array['Fecha_Recordatorio'];
                $dt->Estado_Tarea         = $params_array['Estado_Tarea'];
                $dt->User_ID              = $params_array['User_ID'];

                $dt->save();

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente el dato',
                    'data'      => $dt

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

                'Tarea_Descr'           => 'required',
                'Fecha_Recordatorio'    => 'required',
                'Estado_Tarea'          => 'required',
                'User_ID'               => 'required'


            ]);
            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status'  => 'error',
                    'mensaje' => 'Se ha encontrado un error.',
                    'error'   => $validate->errors()
                ];
            } else {

                unset($params_array['Tarea_id']);
                unset($params_array['User_ID']);
               
                $dt = Tareas::where('Tarea_id', $id)->update($params_array);
                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con éxito.',
                    'data'      => $params_array,
                    'Changes'   => $dt

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
