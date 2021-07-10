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
    public function obra_id()
    {
        return $this->belongsTo('App\Obras','obra_id');
    }

    /**
     * 
     */

    public function estado_id()
    {
        return $this->belongsTo('App\Estado_Op','estado_id');
    }

    /**
     * 
     */
    public function proyecto_id()
    {
        return $this->belongsTo('App\proyecto','proyecto_id');
    }
   

    //-----------Relaciónes de uno a muchos--------------------

    /**
     * 
     */
     public function tareas()
    {
        return $this->hasMany('App\Tareas');
    }
    
    /**
     * 
     */

    public function op_venta()
    {          
        return $this->hasMany('App\Tareas');
    }

    /**
     * 
     */
    public function op_venta_cotizacion()
    {
        return $this->hasMany('App\cotizaciones');
    }

}
