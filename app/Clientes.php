<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';

    public function productos(){
        return $this->hasMany('App\Producto');
    }

    public function tipo_iden()
    {
        return $this->belongsTo('App\tipo_identificacion','tipo_iden');
    }

     public function tarea()
    {
       return $this->hasMany('App\Tareas');
    }

     public function clienteCotizacion()
    {
      return $this->hasMany('App\cotizaciones');   
    }

    public function id_n_estudio()
    {
        return $this->belongsTo('App\nivelEstudios','id_n_estudio');
    }

}
