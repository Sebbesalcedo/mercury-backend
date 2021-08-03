<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\tipo_inmueble;

class tipo_inmuebleController extends Controller
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
        $data =tipo_inmueble::all();

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

                'nombre' => 'required|unique:tipo_inmueble'
            ]);

            if ($validate->fails()) {

                $data = [

                    'code'  => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha podido guardar el tipo de inmueble, por favor verifica los datos',
                    'error' =>  $validate->errors()

                ];
            } else {

                $dt = new tipo_inmueble();

                $dt->nombre = $params_array['nombre'];
                $dt->descripcion = $params_array['descripcion'];
                $dt->save();
                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente el tipo de inmueble',
                    'data'      => $dt

                ];
            }

        } else {

            $data = [

                'code' => 400,
                'status' => 'error',
                'mensaje' => 'No has enviado ningún dato'

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
        $result = tipo_inmueble::find($id);

        if (is_object($result)) {

            $data = array([

                'code'  => 200,
                'status' => 'success',
                'data'  => $result
            ]);
        } else {


            $data = array([

                'code'  => 400,
                'status' => 'errror',
                'mensaje' => ' el dato no existe'
            ]);
        }

        return  response()->json($data, $data['code']);
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

                'nombre' => 'required|unique:tipo_inmueble'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No has enviado ningún nombre o el dato ya exite en la base de datos',
                    'error' => $validate->errors()

                ];
            }
        } else {

            unset($params_array['id']);
            unset($params_array['created_at']);

            $dt = tipo_inmueble::where('id', $id)->update($params_array);


            $data = [

                'code' => 200,
                'status' => 'success',
                'mensaje' => 'se actualizo correctamente el dato'

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
        $dt  = tipo_inmueble::find($id);

        if (!empty($dt)) {

            $dt->delete();

            $data = [

                'code'   => 200,
                'status' => 'success',
                'mensaje' => 'Se ha elimando el dato correctamente',
                'data'   => $dt

            ];
        } else {

            $data = [

                'code' => 404,
                'status' => 'error',
                'mensaje' => 'Dato no encontrado'

            ];
        }

        return response()->json($data, $data['code']);
    }
}
