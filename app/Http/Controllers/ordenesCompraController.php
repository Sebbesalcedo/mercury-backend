<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ordenesCompra;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ordenesCompraController extends Controller
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
        // $data = ordenesCompra::all();

        $data = DB::select(

        'SELECT * FROM t_ordenes_compra ORDER BY created_at DESC ,No_Orden'
      

        );




        return response()->json([

            'code'      => 200,
            'status'    => 'success',
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
        //Recoger los datos por post

        $json = $request->input('json', null);
        $params_array = json_decode($json, true);


        if (!empty($params_array)) {

            $validate =  \Validator::make($params_array, [

                'Material_Name'         => 'required',
                'No_Documento_Prov'     => 'required',


            ]);
            if ($validate->fails()) {

                $data = [

                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No se ha podido guardar el dato',
                    'error' =>   $validate->errors()

                ];
            } else {

                // $cantidadRegistros = ordenesCompra::all()->count();
                // $permitted_chars = '0123456789';
                // $timestamp = time();
                // $date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
                // $fecha = Carbon::parse($date);
                // $mfecha = $fecha->month;
                // $dfecha = $fecha->day;
                // $afecha = $fecha->year;


                // $reference = "OD" . substr(str_shuffle($permitted_chars), 0,5)  . $mfecha . $dfecha . $afecha;

                // $existencia = ordenesCompra::where('No_Orden',  $reference)->exists();





                $dt = new ordenesCompra();



              
                $dt->No_Orden                    = $params_array['No_Orden'];
                // $dt->No_Orden                    = $params_array['No_Orden'];
                $dt->Material_Name               = $params_array['Material_Name'];
                $dt->Marca                       = $params_array['Marca'];
                $dt->No_Documento_Prov           = $params_array['No_Documento_Prov'];
                $dt->Proveedor_Name              = $params_array['Proveedor_Name'];
                $dt->Estado_Gerente              =$params_array['Estado_Gerente'];
                $dt->Precio_Unitario             = $params_array['Precio_Unitario'];
                $dt->Cantidad_Material           = $params_array['Cantidad_Material'];
                $dt->Medida                      = $params_array['Medida'];
                // $dt->Fecha_Aprob_Gerente	     = $params_array['Fecha_Aprob_Gerente'];
                // $dt->Fecha_Aprob_Final        = $params_array['Fecha_Aprob_Final'];
                $dt->User_ID                     = $params_array['User_ID'];


                $dt->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Creado la orden de compra',
                    'orden' => $dt
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Datos erroneos'
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

    /**Metodo para generar las referencias unicas para las ordenes de compra */

    public function generateReference()
    {

        $timestamp = time();
        $date = gmdate("Y-m-d\TH:i:s\Z", $timestamp);
        $fecha = Carbon::parse($date);
        $mfecha = $fecha->month;
        $dfecha = $fecha->day;
        $afecha = $fecha->year;

               



        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-'; 
        $reference = 'OD'. substr(str_shuffle($permitted_chars), 0,7) . $mfecha . $dfecha . $afecha;
  

        $data = [
            'code' => 200,
            'status' => 'success',
            'data' => $reference
        ];

        return response()->json($data, $data['code']);
    }
    public function FiltroGerente()
    {


        $estado='En Revision';

        $data = DB::select(

        'SELECT * FROM `t_ordenes_compra` WHERE `Estado_Gerente`=?',
        [$estado]
   

        );
        $data = [
            'code' => 200,
            'status' => 'success',
            'data' => $data
        ];

        return response()->json($data, $data['code']);
        // $data = DB::select(

            // 'SELECT *,
            // min(A.precio_compra) AS precio_compra
            // FROM `materia` AS A
            // WHERE nombre = ? and marca = ?',
            // [$nombre, $marca]
    
            // );
    
    }


    public function revisionGerente(Request $request,$id)
    {

       
        //Recoger los datos por post
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            //Validar los datos
            $validate = \Validator::make($params_array, [
                'Estado_Gerente'  => 'required',
                'Comentario'      => 'required'
               
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
           
            unset($params_array['created_at']);




            $orden = ordenesCompra::where('No_Orden', $id);


            if (!empty($orden) && is_object($orden)) {

                $orden->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'actualizacion  Correctamente',
                    'post' => $orden,
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
}
