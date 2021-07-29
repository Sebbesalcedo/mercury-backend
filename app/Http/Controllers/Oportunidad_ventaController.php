<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Oportunidad_venta;

class Oportunidad_ventaController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => []]);
    }
    public function index()
    {


        $data = Oportunidad_venta::all()->load('cliente_id', 'inmueble_id', 'estado_id');


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'  => $data

        ]);
    }

    public function show($id)
    {
        $data = Oportunidad_venta::find($id);
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

                'cliente_id'    =>  'required',
                'inmueble_id'       =>  'required',
                'id_user'       =>  'required',
                'cantidad'      =>  'required',
                'valor_compra'  =>  'required',
                'fecha_cierre'  =>  'required',
                'estado_id'     =>  'required'



            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];
            } else {

                $dt = new Oportunidad_venta();
                $dt->cliente_id   = $params_array['cliente_id'];
                $dt->inmueble_id      = $params_array['inmueble_id '];
                $dt->id_user      = $params_array['id_user'];
                $dt->cantidad     = $params_array['cantidad'];
                $dt->valor_compra = $params_array['valor_compra'];
                $dt->fecha_cierre = $params_array['fecha_cierre'];
                $dt->estado_id    = $params_array['estado_id'];
                $dt->descripcion  = $params_array['descripcion'];
                $dt->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Se ha guardado el dato!!!',
                    'dato' => $dt

                ];
            }
        } else {

            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Los datos enviados no son los correctos.',
                'data' => $params_array
            );
        }


        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request)
    {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [


                'cliente_id'    =>  'required',
                'inmueble_id'       =>  'required',
                'id_user'       =>  'required',
                'cantidad'      =>  'required',
                'valor_compra'  =>  'required',
                'fecha_cierre'  =>  'required',
                'estado_id'     =>  'required'


            ]);
            if ($validate->fails()) {

                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'post' => $validate->errors()
                ];
                return response()->json($data, $data['code']);
            }
            unset($params_array['id']);
            unset($params_array['cliente_id']);
             unset($params_array['id_user']);
            unset($params_array['created_at']);

            $dt = Oportunidad_Venta::where('id', $id);


            if (!empty($dt) && is_object($dt)) {

                $dt->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'actualización  Correctamente',
                    'data' => $dt,
                    'changes' => $params_array
                ];
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'data' => $params_array
                ];
            }
        }
        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request)
    {
        $dt = Oportunidad_venta::find($id);

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
