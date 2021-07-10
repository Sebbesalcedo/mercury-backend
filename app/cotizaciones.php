<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cotizaciones extends Model
{
    protected $table = 'cotizaciones';

    public function id_cliente()
    {

        return $this->belongsTo('App\clientes', 'id_cliente');
    }
    public function id_user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function id_op_venta()
    {
        return $this->belongsTo('App\Oportunidad_venta', 'id_op_venta');
    }

    public function fechaCotizacion()
    {
        return $this->hasMany('App\fechaPagosCotizacion');
    }
    public function id_estado()
    {
        return $this->belongsTo('App\estadoCotizacion', 'id_estado');
    }
}
