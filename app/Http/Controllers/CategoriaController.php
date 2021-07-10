<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => []]);
    }

    /**
     * Metodo que lista todas las categorias
     */

    public function index()
    {
        


        $categoria = Categoria::all();
        // var_dump($categoria);
        // die();
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'categoria' => $categoria

        ]);
    }

    /**
     * Metodo que guarda un dato
     */

    public function store(Request $request)
    {

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'nombre' => 'required|unique:categoria'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code'      => 400,
                    'status'    => 'error',
                    'mensaje'   => 'No se ha podido guardar la nueva categoria',
                    'error'     => $validate->errors()

                ];
            } else {

                $dt = new Categoria();

                $dt->nombre = $params_array['nombre'];
                $dt->descripcion = $params_array['descripcion'];
                $dt->save();

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente la categoria',
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

    /**
     *  Metodo que permite visualizar un dato
     */

    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (is_object($categoria)) {

            $data = array([

                'code'   => 200,
                'status' => 'success',
                'data'   => $categoria

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

    /**
     * Metodo que edita un dato
     */

    public function update($id, Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \validator::make($params_array, [

                'nombre' => 'required|unique:categoria'

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
                unset($params_array['created_at']);
                $dt = Categoria::where('id', $id)->update($params_array);
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

    /**
     * Metodo que elimina un dato
     */

    public function destroy($id, Request $request)
    {

        $dt = Categoria::find($id);
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
