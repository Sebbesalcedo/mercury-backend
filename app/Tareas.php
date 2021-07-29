<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
    protected $table = 'tareas';

    public function id_user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
    public function cliente()
    {
        return $this->belongsTo('App\Clientes', 'op_venta');
    }

    public function id_estado()
    {
        return $this->belongsTo('App\estado_tarea', 'id_estado');
    }


}
