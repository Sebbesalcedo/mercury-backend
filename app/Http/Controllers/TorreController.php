<?php

namespace App\Http\Controllers;

use App\Inmueble;
use Illuminate\Http\Request;
use App\Torre;

class TorreController extends Controller
{

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['filterProyectoId']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Torre::all()->load('id_proyecto', 'id_user');

        return response()->json([

            'code'  => 200,
            'status' => 'success',
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


        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'nombre'        =>  'required',
                'cant_pisos'    =>  'required',
                'id_proyecto'   =>  'required',
                'id_user'       =>  'required'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No se ha podido guardar la torre',
                    'error'     => $validate->errors()

                ];
            } else {

                $dt  = new Torre();

                $dt->nombre         = $params_array['nombre'];
                $dt->cant_pisos     = $params_array['cant_pisos'];
                $dt->id_proyecto    = $params_array['id_proyecto'];
                $dt->id_user        = $params_array['id_user'];
                $dt->descripcion    = $params_array['descripcion'];

                $dt->save();


                $data = [

                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Se creo correctamente la torre',
                    'data'   => $dt

                ];
            }
        } else {

            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Error en el envio de los datos'
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
                'mensaje' => 'El dato no existe'

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

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'nombre'        =>  'required',
                'cant_pisos'    =>  'required',
                'id_proyecto'   =>  'required',
                'id_user'       =>  'required'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code'   => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'error'  => $validate->errors()

                ];

                return  response()->json($data, $data['code']);
            } else {

                unset($params_array['id']);
                unset($params_array['id_user']);
                unset($params_array['created_at']);

                $torre = Torre::where('id', $id)->update($params_array);

                $data = [

                    'code'    =>   200,
                    'status'  =>   'success',
                    'message' =>    'Se ha actualizado correctamente el dato',
                    'change'  =>    $params_array

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dt = Torre::find($id);

        if (!empty($dt)) {

            $dt->delete();

            $data = [

                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Se ha Eliminado el dato con exito',
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

    public function filterProyectoId($id)
    {
        $dt = Torre::where('id_proyecto', $id)->get();


        $data = [

            'code'      => 200,
            'status'    => 'success',

            'data'      =>  $dt

        ];

        return response()->json($data, $data['code']);
    }
}
