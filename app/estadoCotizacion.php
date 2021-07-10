<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estadoCotizacion extends Model
{
    protected $table = 'estado_cotizacion';

    public function cotizacion()
    {
        return $this->hasMany('App\cotizaciones');
    }

   
}
