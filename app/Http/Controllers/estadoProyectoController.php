<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\estadoProyecto;
class estadoProyectoController extends Controller
{

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = estadoProyecto::all();

        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data' => $data

        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){

            $validate = \Validator::make($params_array,[

                'nombre'=> 'required|nombre|unique:estado_proyecto'

            ]);

            if($validate->fails()){

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];

            }else{

                $dt =  new estadoProyecto();

                $dt -> nombre = $params_array['nombre'];
                $dt -> descripcion = $params_array['descripcion'];

                $dt -> save();


                
                $data = [

                    'code'    => 200,
                    'status'  => 'success',
                    'mensaje' => 'Se ha guardado el dato!!',
                    'data'    => $params_array

                ];


            }

        }else{

            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'Los datos enviados no son los correctos.',
                'data' => $params_array
            );

        }

        return response()->json($data, $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = estadoProyecto::find($id);

        if(is_object($data)){

            $data = array (

                'code' => 200,
                'status' => 'success',
                'data' => $data

            );

        }else{

            $data = array(

                'code' => 400,
                'status' => 'error',
                'mensaje' => 'dato no existente'

            );

        }
        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $json = $request ->input ('json',null);
        $params_array  = json_decode($json,true);

        if(!empty($params_array)){

            $validate = \validator::make($params_array,[

                'nombre'=> 'required|nombre|unique:estado_proyecto'

            ]);


            if($validate->fails()){

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'post' => $validate->errors()

                ];

                return response()->json($data, $data['code']);

            }

            unset($params_array['id']);
            unset($params_array['created_at']);

            $dt = estadoProyecto::where('id',$id);

            if(!empty($dt) && is_object($dt)){

                $dt -> update($params_array);

                $data = [

                    'code' => 200,
                    'status' => 'success',
                    'message' => 'actualización  Correctamente',
                    'data' => $dt,
                    'changes' => $params_array

                ];


            }else{

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dt = estadoProyecto::find($id);

        if(!empty($dt)){

            $dt ->delete();

            $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'Se ha eliminado el dato con exito',
                'data'      => $dt

            ];

        }
        else{

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'No existe ese elemento'
            ];

        }
        return response()->json($data, $data['code']);
    }
}
