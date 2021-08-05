<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oportunidad_venta extends Model
{
    protected $table = 'oportunidad_venta';


    //-----------Relaciónes de muchos a uno--------------------


    /**
     *
     */
    public function cliente_id(){
        return $this->belongsTo('App\Clientes','cliente_id');
    }
    /**
     *
     */
    public function inmueble_id()
    {
        return $this->belongsTo('App\Inmueble','inmueble_id');
    }

    /**
     *
     */

    public function estado_id()
    {
        return $this->belongsTo('App\Estado_Op','estado_id');
    }



    //-----------Relaciónes de uno a muchos--------------------

    /**
     *
     */
    public function op_venta_cotizacion()
    {
        return $this->hasMany('App\cotizaciones');
    }

}
