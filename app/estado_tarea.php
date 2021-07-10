<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_tarea extends Model
{
    protected $table = 'estado_tarea';


    public function tareas(){
        return $this->hasMany('App\Tareas');
    }

}
