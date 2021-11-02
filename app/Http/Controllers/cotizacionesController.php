<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cotizaciones;

class cotizacionesController extends Controller
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
        $data = cotizaciones::all();
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

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [

                'Client_ID'        => 'required',
                'Op_Venta_ID'           => 'required',



            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];
            } else {


                $cantidadRegistros = cotizaciones::all()->count();

                $dt = new cotizaciones();
                $suma = $cantidadRegistros + 3;
                $generateID = "COT-" . $suma;

                $dt->	Cotizacion_id                  = $generateID;
                 $dt->Client_ID                      = $params_array['Client_ID'];
                $dt->Op_Venta_ID                    = $params_array['Op_Venta_ID'];

                $dt->Unidad_ID                         = $params_array['Unidad_ID'];
                $dt->Valor_Total_Unidad             = $params_array['Valor_Total_Unidad'];
                $dt->Porcentaje_Valor_Descuento     = $params_array['Porcentaje_Valor_Descuento'];
                $dt->Valor_Descuento                = $params_array['Valor_Descuento'];
                $dt->Valor_Congelacion              = $params_array['Valor_Congelacion'];
                $dt->Fecha_Congelacion              = $params_array['Fecha_Congelacion'];

                $dt->Valor_Cuota_Separacion         = $params_array['Valor_Cuota_Separacion'];
                $dt->Cuota_Inicial                  = $params_array['Cuota_Inicial'];
                $dt->Valor_Cuota_Inicial_20         = $params_array['Valor_Cuota_Inicial_20'];
                $dt->Numero_Cuotas_20               = $params_array['Numero_Cuotas_20'];
                $dt->Tipo_Cuotas_20                 = $params_array['Tipo_Cuotas_20'];
                $dt->Valor_Cuota_20                 = $params_array['Valor_Cuota_20'];
                $dt->Valor_Cuota_70                 = $params_array['Valor_Cuota_70'];
                $dt->Fecha_Cuota_Separacion         = $params_array['Fecha_Cuota_Separacion'];
                $dt->Estado_Cotizacion              = $params_array['Estado_Cotizacion'];
                $dt->Valor_Unidad_Final             = $params_array['Valor_Unidad_Final'];
                $dt->User_ID                        = $params_array['User_ID'];




                $dt->save();

                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha guardado correctamente la cotización',
                    'data'      => $dt

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data =cotizaciones::where('Cotizacion_id',$id)->get();
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
        $params_array = json_decode($json, true);
        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [




                'id_cliente'        => 'required',
                'id_user'           => 'required',
                'id_op_venta'       => 'required',
                'cuota_congelacion' => 'required',
                'valor_separacion'  => 'required',
                'cuota_inicial'     => 'required',
                'num_cuotas'        => 'required',
                'valor_credito'     => 'required'

            ]);

            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];
            } else {

                unset($params_array['id']);
                unset($params_array['id_user']);
                unset($params_array['created_at']);

                $dt = cotizaciones::where('id', $id)->update($params_array);
                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con éxito.',
                    'changes'   => $params_array

                ];
            }
            return response()->json($data, $data['code']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dt = cotizaciones::find($id);
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
