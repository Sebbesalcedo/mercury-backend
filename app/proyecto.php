<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
    protected $table = 'proyectos';

    public function oportunidad_venta()
    {
        return $this->hasMany('App\Oportunidad_venta');
    }

    public function id_estado()
    {
        return $this->belongsTo('App\estadoProyecto','id_estado');
    }

}
