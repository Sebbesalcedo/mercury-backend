<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado_Op extends Model
{
    protected $table = 'estado_op_venta';

    public function estado()
    {
        return $this->hasMany('App\Oportunidad_venta');
    }
}
