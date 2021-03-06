<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 't_materiales';

    public function  medida_id()
    {
        return $this->belongsTo('App\Medida','medida_id');
    }

    public function categoria_id(){

        return $this->belongsTo('App\Categoria','categoria_id');
    }

    public function proveedor_id()
    {
        return $this->belongsTo('App\Proveedor','proveedor_id');
    }
}
