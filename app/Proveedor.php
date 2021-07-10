<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    public function tipo_iden_id()
    {

        return $this->belongsTo('App\Tipo_identificacion', 'tipo_iden_id');
    }

    public function id_user()
    {
        return $this->belongsTo('App\User','id_user');
    }

    public function producto()
    {
        return $this->hasMany('App\Producto');
    }
}
