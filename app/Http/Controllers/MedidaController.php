<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Medida;
class MedidaController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => []]);
    }

    /**Metod que Lista todo los datos */

    public function index()
    {

        $medida = Medida::all();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $medida
        ]);
    }

    /**Metodo que guarda un dato */

    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate =  \Validator::make($params_array, [

                'nombre' => 'required|unique:medida'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha podido guardar la nueva medida',
                    'error' =>   $validate->fails()

                ];
            } else {

                $dt = new Medida();

                $dt->nombre = $params_array['nombre'];
                $dt->descripcion = $params_array['descripcion'];
                $dt->save();


                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Se ha guardado el dato!!!',
                    'dato' => $dt->nombre

                ];
            }
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'No has enviado ningun dato'

            ];
        }


        return response()->json($data, $data['code']);
    }
    /**Metodo que permite visualizar un dato */

    public function show($id)
    {

        $medida = Medida::find($id);

        if (is_object($medida)) {

            $data = array(
                'code' => 200,
                'status' => 'success',
                'data' => $medida
            );
        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'El dato no existe.'
            );
        }
        return response()->json($data, $data['code']);
    }

    /**Metodo que actualiza un dato */

    public function update($id, Request $request)
    {

        //recoger los datos que vengan por post

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'nombre' => 'required|unique:medida'

            ]);

            if ($validate->fails()) {
                $data = [

                    'code'      => 400,
                    'status'    => 'error',
                    'mensaje'   => 'Se ha encontrado un error',
                    'error'   => $validate->errors()

                ];
            } else {
                unset($params_array['id']);
                unset($params_array['created_at']);

                $dt = Medida::where('id', $id)->update($params_array);
                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha actualizado correctamente el dato',
                    'changes'   => $params_array

                ];
            }
        } else {
            $data = [

                'code'      => 400,
                'status'    => 'error',
                'mensaje'   => 'No se ha enviado ningún dato',


            ];
        }
        return response()->json($data, $data['code']);
    }

    /**Metodo que elimina un dato */

    public function destroy($id, Request $request)
    {
        $dt = Medida::find($id);
        if (!empty($dt)) {

            $dt->delete();

            $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'Se ha eliminado el dato con exito',
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
