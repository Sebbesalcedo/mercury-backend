<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\proyecto;

class proyectoController extends Controller
{

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = proyecto::all()->load('id_estado');

        return response()->json([

            'code'  => 200,
            'status' => 'success',
            'data'  => $data

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

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'nombre'    => 'required|nombre|unique:proyectos',
                'id_user'   => 'required',
                'id_estado' => 'required',
                'direccion' => 'required'
            ]);

            if ($validate->fails()) {

                $data = [


                    'code'      => 400,
                    'status'    => 'error',
                    'mensaje'   => 'Se ha presentado un error en los datos',
                    'error'     => $validate->errors()

                ];
            } else {

                $dt = new proyecto();

                $dt->nombre               = $params_array['nombre'];
                $dt->id_user              = $params_array['id_user'];
                $dt->id_estado            = $params_array['id_estado'];
                $dt->fecha_inicio         = $params_array['fecha_inicio'];
                $dt->fecha_finalizacion   = $params_array['fecha_finalizacion'];
                $dt->direccion            = $params_array['direccion'];
                $dt->descripcion          = $params_array['descripcion'];

                $dt->save();

                $data = [

                    'code'     => 200,
                    'status'   => 'success',
                    'mensaje'  => 'se ha guardado correctamente el dato',
                    'data'     => $dt

                ];
            }
        } else {

            $data = [

                'code'      => 400,
                'status'    => 'error',
                'mensaje'   => 'Se presentó un error en los datos',


            ];
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
        $data = proyecto::find($id);

        if(is_object($data)){

            $data = array ([

                'code'   => 200,
                'status' => 'success',
                'data'   => $data

            ]);

        }
        else {

            $data = array([

                'code'    => 400,
                'status'  => 'error',
                'mensaje' => 'El dato no existe.'

            ]);
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
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){

            $validate = \Validator::make($params_array,[

                'nombre'    => 'required|nombre|unique:proyectos',
                'id_user'   => 'required',
                'id_estado' => 'required',
                'direccion' => 'required'

            ]);

            if($validate->fails()){

                $data = [

                    'code' => 400,
                    'status'  => 'error',
                    'mensaje' => 'Se ha encontrado un error.',
                    'error'   => $validate->errors()

                ];

            }else {

                unset($params_array['id']);
                unset($params_array['created_at']);

                $dt = nivelEstudios::where('id', $id)->update($params_array);

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con exito.',
                    'changes'   => $params_array

                ];
            }

        }else{

            $data = [

                'code'      => 400,
                'status'    => 'error',
                'mensaje'   => 'Se presentó un error en los datos',


            ];

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
        $dt = proyecto::find($id);

        if(!empty($dt)){

            $dt->delete();

            $data = [

                'code'      => 200,
                'status'    => 'success',
                'mensaje'   => 'Se ha eliminado correctamente el dato.',
                'data'      => $dt

            ];


        }
        else {

            $data = [
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'No existe el dato'
            ];
        }
        return response()->json($data, $data['code']);
    }
}
