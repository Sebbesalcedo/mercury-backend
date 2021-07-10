<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\estado_tarea;
class Estado_tareaController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => []]);
    }


    public function index()
    {
        $data = estado_tarea::all();
        return response()->json([

            'code'      => 200,
            'status'    => 'success',
            'data' => $data

        ]);
    }

    public function show($id)
    {
        $data = estado_tarea::find($id);
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
}
