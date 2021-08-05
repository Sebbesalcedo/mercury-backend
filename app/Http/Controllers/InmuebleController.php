<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inmueble;
use Illuminate\Database\Eloquent\Collection;

class InmuebleController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => ['filtroInmuebles', 'filtroInmueblesTipo']]);
    }


    // get

    public function index()
    {


        $data = Inmueble::all()->load('id_tipo_inmueble', 'id_torre', 'id_proyecto');


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }

    //consultar un elemento

    public function show($id)
    {
        $data = Inmueble::find($id);
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

    // post

    public function store(Request $request)
    {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);


        if (!empty($params_array)) {

            $validate =  \Validator::make($params_array, [

                'id_proyecto'               => 'required',
                'id_tipo_inmueble'     => 'required',
                'id_user'               => 'required',
                'valor_unitario'  => 'required',

            ]);
            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha podido guardar el dato',
                    'error' =>   $validate->errors()

                ];
            } else {

                $dt = new Inmueble();

                $dt->id_proyecto        =   $params_array['id_proyecto'];
                $dt->id_tipo_inmueble   =   $params_array['id_tipo_inmueble'];
                $dt->id_user            =   $params_array['id_user'];
                $dt->id_torre           =   $params_array['id_torre'];
                $dt->dimensiones        =   $params_array['dimensiones'];
                $dt->habitaciones       =   $params_array['habitaciones'];
                $dt->banos              =   $params_array['banos'];
                $dt->parqueadero        =   $params_array['parqueadero'];
                $dt->cantidad           =   $params_array['cantidad'];
                $dt->valor_unitario     =   $params_array['valor_unitario'];
                $dt->descripcion        =   $params_array['descripcion'];

                $dt->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Creado correctamente el inmueble',
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

    // update

    function update($id, Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [


                'id_proyecto'      => 'required',
                'id_tipo_obra'     => 'required',
                'id_user'       => 'required',
                'id_torre'      => 'required',
                'valor_unitario'  => 'required',


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
            unset($params_array['id_user']);
            unset($params_array['created_at']);

            $obra = Inmueble::where('id', $id)->update($params_array);
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

    // delete

    public function destroy($id)
    {
        $dt = Inmueble::find($id);

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


    /**
     * Método que filtra los inmuebles por proyecto
     */
    public function filtroInmuebles($idProyecto)
    {

        $data = Inmueble::where('id_proyecto', $idProyecto)->get()->load('id_tipo_inmueble', 'id_torre', 'id_proyecto');


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }

    /**
     * Método que filtra los inmuebles por tipo de inmueble
     */
    public function filtroInmueblesTipo($tipo)
    {

        $data = Inmueble::where('id_tipo_inmueble', $tipo)->get()->load('id_tipo_inmueble', 'id_torre', 'id_proyecto');


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }
}
