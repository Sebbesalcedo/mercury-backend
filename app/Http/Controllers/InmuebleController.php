<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inmueble;
use Illuminate\Database\Eloquent\Collection;
use PhpParser\Node\Expr\Print_;

class InmuebleController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => ['filtroInmuebles', 'filtroInmueblesTipo','inmueblesDisponibles']]);
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
        $cantidadRegistros=Inmueble::all()->count();

        if (!empty($params_array)) {

            $validate =  \Validator::make($params_array, [

                'Proyecto_ID'         => 'required',
                'User_ID'             => 'required',
                'Valor_Total_Unidad'  => 'required'

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
                $suma=$cantidadRegistros+4;
                $generateID="IN-".$suma;

                $dt->id_unidad              = $generateID;
                $dt->Torre_ID                   = $params_array['Torre_ID'];
                $dt->Proyecto_ID                = $params_array['Proyecto_ID'];
                $dt->Unidad                     = $params_array['Unidad'];
                $dt->Nomenclatura_Unidad        = $params_array['Nomenclatura_Unidad'];
                $dt->Area_Habitable_M2          = $params_array['Area_Habitable_M2'];
                $dt->Area_Extension_M2          = $params_array['Area_Extension_M2'];
                $dt->Tipo_Extension             = $params_array['Tipo_Extension'];
                $dt->Area_Total_M2              = $params_array['Area_Total_M2'];
                $dt->No_Parqueaderos            = $params_array['No_Parqueaderos'];
                $dt->Parque_Descr               = $params_array['Parque_Descr'];
                $dt->Bodega_Deposito_M2         = $params_array['Bodega_Deposito_M2'];
                $dt->Tipo_Inmueble              = $params_array['Tipo_Inmueble'];
                $dt->Estado_Unidad              = $params_array['Estado_Unidad'];
                $dt->Valor_Parqueadero          = $params_array['Valor_Parqueadero'];
                $dt->Valor_Deposito             = $params_array['Valor_Deposito'];
                $dt->Valor_Total_Unidad         = $params_array['Valor_Total_Unidad'];
                $dt->User_ID                    = $params_array['User_ID'];

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

     /**
     * Método que nos sirve para consultar los inmuebles disponibles
     * Filtrado por proyecto
     */

    public function inmueblesDisponibles($proyecto_id)
    {
        $variable='Disponible';

        $sql = Inmueble::where('Proyecto_ID',$proyecto_id)->where('Estado_Unidad',$variable)->get();

        return response()->json($sql);
    }

}

