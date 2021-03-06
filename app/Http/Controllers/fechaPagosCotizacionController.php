<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\fechaPagosCotizacion;

class fechaPagosCotizacionController extends Controller
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
        $data = fechaPagosCotizacion::all();

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
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        $cantidadRegistros=fechaPagosCotizacion::all()->count();
        if (!empty($params_array)) {


            $validate = \Validator::make($params_array, [

                'Cotizacion_id'    =>  'required'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];
            } else {

                $dt = new fechaPagosCotizacion();
                $suma=$cantidadRegistros+4;
                $generateID="IN-".$suma;
                $dt->Pagos_Cot_id  = $generateID;
                $dt->Cotizacion_id = $params_array['Cotizacion_id'];
                $dt->Numero_Cuota  = $params_array['Numero_Cuota'];
                $dt->Fecha_Cuota  = $params_array['Fecha_Cuota'];
                $dt->Valor_Cuota  = $params_array['Valor_Cuota'];



                $dt->User_ID        = $params_array['User_ID'];

                $dt->save();

                $data = [

                    'code'    => 200,
                    'status'  => 'success',
                    'mensaje' => 'Se ha guardado el dato!!',
                    'data'    => $params_array

                ];
            }
        } else {

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
        $data = fechaPagosCotizacion::find($id);
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
        $params_array  = json_decode($json, true);

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'id_cotizacion' => 'required',
                'fecha_pagos'   => 'required',

                'id_user'       => 'required'

            ]);


            if ($validate->fails()) {

                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Datos enviados incorrectamente',
                    'post' => $validate->errors()
                ];
                return response()->json($data, $data['code']);
            }

            unset($params_array['id']);
            unset($params_array['id_cotizacion']);

            unset($params_array['created_at']);

            $dt = fechaPagosCotizacion::where('id', $id);

            if (!empty($dt) && is_object($dt)) {

                $dt->update($params_array);

                $data = [

                    'code' => 200,
                    'status' => 'success',
                    'message' => 'actualizaci??n  Correctamente',
                    'data' => $dt,
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dt = fechaPagosCotizacion::find($id);

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
