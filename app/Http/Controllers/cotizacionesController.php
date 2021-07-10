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
        $data =cotizaciones::all()->load('id_cliente','id_user','id_op_venta');
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

        if(!empty($params_array)){

            $validate = \Validator::make($params_array,[

                'id_cliente'        => 'required',
                'id_user'           => 'required',
                'id_op_venta'       => 'required',
                'cuota_congelacion' => 'required',
                'valor_separacion'  => 'required',
                'cuota_inicial'     => 'required',
                'num_cuotas'        => 'required',
                'valor_credito'     => 'required'
            ]);

            if($validate->fails()){

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error en los datos',
                    'error' =>   $validate->errors()

                ];
                
            }else{

                $dt = new cotizaciones();
                $dt -> id_cliente           = $params_array['id_cliente'];
                $dt -> id_user              = $params_array['id_user'];
                $dt -> id_op_venta          = $params_array['id_op_venta'];
                $dt -> cuota_congelacion    = $params_array['cuota_conlegacion'];
                $dt -> pFecha_congelacion   = $params_array['pFecha_congelacion'];
                $dt -> valor_separacion     = $params_array['valor_separacion'];
                $dt -> cuota_inicial        = $params_array['cuota_inicial'];
                $dt -> num_cuotas           = $params_array['num_cuotas'];
                $dt -> valor_credito        = $params_array['valor_credito'];


            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
