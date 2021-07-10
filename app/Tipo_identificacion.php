<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_identificacion extends Model
{
    protected $table = 'tipo_identificacion';

    public function T_Indentificacion(){

        return $this->hasMany('App\Proveedor');
    }

    
    public function clienteIdentificacion(){

        return $this->hasMany('App\Clientes');
    }
}
