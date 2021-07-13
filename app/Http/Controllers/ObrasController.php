<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Obras;
class ObrasController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => []]);
    }

    public function index()
    {


        $data = Obras::all();


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }


    public function show($id)
    {
        $data = Obras::find($id);
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
        $params = json_decode($json);
        $params_array = json_decode($json, true);


        if (!empty($params_array)) {

            $validate =  \Validator::make($params_array, [

                'id_proyecto'      => 'required',
                'id_tipo_obra'     => 'required',
                'id_user'       => 'required',
                'valor_unidad'  => 'required',
                'direccion'     => 'required'
            ]);
            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha podido guardar el dato',
                    'error' =>   $validate->errors()

                ];
            } else {

                $dt = new Obras();

                $dt->id_proyecto    = $params_array['id_proyecto'];
                $dt->id_tipo_obra   = $params_array['id_tipo_obra'];
                $dt->id_user        = $params_array['id_user'];
                $dt->dimesiones     = $params_array['dimensiones'];
                $dt->habitaciones   = $params_array['habitaciones'];
                $dt->banos          = $params_array['banos'];
                $dt->parqueadero    = $params_array['parqueadero'];
                $dt->valor_unidad   = $params_array['valor_unidad'];
                $dt->descripcion    = $params_array['descripcion'];

                $dt->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Creado correctamente la obra',
                    'obra' => $dt
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Envia los datos correctamente'
            ];
        }
        return response()->json($data, $data['code']);
    }

    function update($id, Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [


                'id_proyecto'      => 'required',
                'id_tipo_obra'     => 'required',
                'id_user'       => 'required',
                'valor_unidad'  => 'required',
                'direccion'     => 'required'

            ]);
            if ($validate->fails()) {

                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'data' => $validate->errors()
                ];
                return response()->json($data, $data['code']);
            }

            unset($params_array['id']);
            unset($params_array['user_id']);
            unset($params_array['created_at']);

            $obra = Obras::where('id', $id)->update($params_array);
            $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'Se ha actualizado correctamente el dato',
                'changes'   => $params_array

            ];
        } else {
            $data = [

                'code'      => 400,
                'status'    => 'error',
                'mensaje'   => 'No se ha enviado ningún dato',


            ];
        }
        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request)
    {
        $dt = Obras::find($id);

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
