<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materia;
use Illuminate\Support\Facades\DB;

class MateriaController extends Controller
{
    public function __construct()
    {

        $this->middleware('api.auth', ['except' => ['']]);
    }


    public function index()
    {


        $producto = Materia::all()->load('medida_id', 'categoria_id', 'proveedor_id');


        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'producto'  => $producto

        ]);
    }




    /**Metodo que guarda un dato */

    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate =  \Validator::make($params_array, [

                'nombre'        => 'required',
                'cantidad'      => 'required',
                'precio_compra' => 'required',
                'user'          => 'required',
                'categoria_id'  => 'required',
                'medida_id'     => 'required',
                'proveedor_id'  => 'required'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha podido guardar la Materia',
                    'error' =>   $validate->errors()

                ];
            } else {

                $dt = new Materia();

                $dt->nombre         = $params_array['nombre'];
                $dt->Marca         = $params_array['marca'];

                $dt->cantidad    = $params_array['cantidad'];
                $dt->precio_compra  = $params_array['precio_compra'];
                $dt->categoria_id   = $params_array['categoria_id'];
                $dt->medida_id      = $params_array['medida_id'];
                $dt->proveedor_id   = $params_array['proveedor_id'];
                $dt->user    = $params_array['user'];
                $dt->descripcion    = $params_array['descripcion'];
                $dt->save();


                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Se ha guardado el dato!!!',
                    'dato' => $dt->nombre

                ];
            }
        } else {

            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Los datos enviados no son los correctos.',
                'data' => $params
            );
        }


        return response()->json($data, $data['code']);
    }

    public function show($id)
    {
        $producto = Materia::find($id);

        if (is_object($producto)) {

            $data = [

                'code'      => 200,
                'status'    => 'success',
                'producto'  => $producto
            ];
        } else {

            $data = [
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'el producto no existe'

            ];
        }
        return response()->json($data, $data['code']);
    }

    /**
     * que permite editar un dato
     */
    public function update($id, Request $request)
    {

        //Recoger los datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            //Validar los datos
            $validate = \Validator::make($params_array, [
                'nombre'        => 'required',
                'cantidad'      => 'required',
                'precio_compra' => 'required',
                // 'precio_venta'  => 'required',
                'categoria_id'  => 'required',
                'medida_id'     => 'required',
                'proveedor_id'  => 'required'
            ]);
            if ($validate->fails()) {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'post' => $params_array
                ];
                return response()->json($data, $data['code']);
            }
            //Eliminar lo que no queremos actualizar
            unset($params_array['id']);
            unset($params_array['user']);
            unset($params_array['created_at']);




            $producto = Materia::where('id', $id);


            if (!empty($producto) && is_object($producto)) {

                $producto->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'actualizacion  Correctamente',
                    'post' => $producto,
                    'changes' => $params_array
                ];
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'post' => $params_array
                ];
            }
        }
        return response()->json($data, $data['code']);
    }
    /**
     * Permite eliminar un dato
     */

    public function destroy($id, Request $request)
    {
        $producto = Materia::where('id', $id)->first();

        if (!empty($producto)) {
            $producto->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'mensaje' => 'Dato eliminado correctamente'
            ];
        } else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'Hubo un error al eliminar un producto'
            ];
        }
        return response()->json($data, $data['code']);
    }


    //Metodo para generar los filtros para ordenes de compra


    public function filtroMaterial()
    {


        // $data = Materia::orderBy('proveedor_id','ASC')->havingRaw('count(proveedor_id) >= ?',[1])->get()->load('medida_id','categoria_id','proveedor_id');

        $data = Materia::groupBy('proveedor_id')->havingRaw('count(proveedor_id) >= ?', [1])->get()->load('medida_id', 'categoria_id', 'proveedor_id');



        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }


    public function filtroMaterialNombre($id)
    {

        $data = Materia::WHERE('proveedor_id', $id)->orderBy('precio_compra', 'ASC')->get()->load('medida_id', 'categoria_id', 'proveedor_id');
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data

        ]);
    }

    public function filtroMaterialEconomico($nombre, $marca)
    {
        // $data = DB::select(

        // 'SELECT *,
        // min(A.precio_compra) AS precio_compra
        // FROM `materia` AS A
        // WHERE nombre = ? and marca = ?',
        // [$nombre, $marca]

        // );

        $data = Materia::where(['nombre'=>$nombre,'Marca'=>$marca])->orderBy('precio_compra', 'asc')->first()->load('medida_id', 'categoria_id', 'proveedor_id');

        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data'      => $data,


        ]);
    }

  
}
