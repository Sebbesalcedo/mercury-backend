<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 't_proveedores';
    protected $primaryKey = 'No_Documento_Prov';
    public $timestamps = false;

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
