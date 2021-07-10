<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estadoFechaPagos extends Model
{
    protected $table ='estado_fecha_pago';

    public function fecha_pagos()
    {
       return  $this->hasMany('App\fecha_pagos');
    }

}
