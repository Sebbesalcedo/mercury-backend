<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\estadoCotizacion;
class estadoCotizacionController extends Controller
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
        $data = estadoCotizacion::all()->load('id_estado','id_op_venta','id_user','id_cliente');

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

            $validate = \Validate::make($params_array,[

                    'nombre' => 'required|nombre|unique:estado_cotizacion'

            ]);

            if($validate->fails()){

                $data = [

                    'code'      => 400,
                    'status'    => 'error',
                    'message'   => 'No se ha podigo guardar el nuevo estado',
                    'error'     => $validate->errors()

                ];

            }else{

                $dt = new estadoCotizacion();

                $dt -> nombre =$params_array['nombre'];
                $dt -> descripcion=$params_array['descripcion'];

                $dt->save();

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente el dato',
                    'data'      => $dt->nombre

                ];

            }

        }else{


            $data = [

                'code'      => 400,
                'status'    => 'error',
                'mensaje'   => 'No has enviado ningún dato'

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
        $data = estadoCotizacion::find($id);

        if(is_object($data)){

            $data =array([
                 'code'   => 200,
                'status' => 'success',
                'data'   => $data

            ]);
        }else{

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

                'nombre' => 'required|nombre|unique:estado_cotizacion'

            ]);
            if($validate->fails()){

                $data = [

                    'code' => 400,
                    'status'  => 'error',
                    'mensaje' => 'Se ha encontrado un error.',
                    'error'   => $validate->errors()
                ];

            }else{

                unset($params_array['id']);
                unset($params_array['created_at']);

                $dt=estadoCotizacion::where('id',$id)->update($params_array);
                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con exito.',
                    'changes'   => $params_array

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
        $dt =estadoCotizacion::find($id);

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
