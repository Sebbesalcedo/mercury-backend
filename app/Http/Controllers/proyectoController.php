<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\proyectos;
use Illuminate\Support\Facades\DB;

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
        $data = proyectos::get();
   
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
        $cantidadRegistros=proyectos::all()->count();

        if (!empty($params_array)) {

            $validate = \Validator::make($params_array, [



                'Project_Name'          => 'required|unique:t_proyecto',
                'Estado_Proyecto'       => 'required',
                'Tipo_Proyecto'         => 'required',
                'Fecha_Inicio_Projecto' => 'required',
                'Fecha_Fin_Projecto'    => 'required',
                'Departamento'          => 'required',
                'Ciudad'                => 'required',
                'Direccion'             => 'required',

                'User_ID'               => 'required'

            ]);

            if ($validate->fails()) {

                $data = [


                    'code'      => 400,
                    'status'    => 'error',
                    'mensaje'   => 'Se ha presentado un error en los datos',
                    'error'     => $validate->errors()

                ];
                return response()->json($data, $data['code']);
            } else {

                $dt = new proyectos();


                $suma=$cantidadRegistros+4;
                $generateID="PO-".$suma;

                $dt->Proyecto_ID             = $generateID;
                $dt->Project_Name               = $params_array['Project_Name'];
                $dt->Estado_Proyecto            = $params_array['Estado_Proyecto'];
                $dt->Tipo_Proyecto              = $params_array['Tipo_Proyecto'];
                $dt->Fecha_Inicio_Projecto      = $params_array['Fecha_Inicio_Projecto'];
                $dt->Fecha_Fin_Projecto         = $params_array['Fecha_Fin_Projecto'];
                $dt->Departamento               = $params_array['Departamento'];
                $dt->Ciudad                     = $params_array['Ciudad'];
                $dt->Direccion                  = $params_array['Direccion'];
                $dt->Descr_Proyecto             = $params_array['Descr_Proyecto'];
                $dt->User_ID                    = $params_array['User_ID'];



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
        $data = proyectos::find($id);

        if (is_object($data)) {

            $data = array([

                'code'   => 200,
                'status' => 'success',
                'data'   => $data

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

                'Project_Name'    => 'required|nombre|unique:t_proyecto&unidades',
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

                $dt = proyectos::where('id', $id)->update($params_array);
                $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Dato actualizado con exito.',
                    'changes'   => $params_array
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        var_dump($id);
        exit;
         $dt = proyectos::find($id);
        // $dt = DB::select(

        // 'SELECT *
        // FROM `materia` t_proyecto
        // WHERE 	Proyecto_ID  = ? ',
        // [$id]

        // );
        if (!empty($dt)) {





                // $dt = DB::select(

                //     'DELETE FROM t_proyecto WHERE Proyecto_ID  = ?' ,
                //     [$id]

                // );
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
                'mensaje' => 'No existe el dato'
            ];
        }
        return response()->json($data, $data['code']);
    }


}
