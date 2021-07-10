<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estadoProyecto extends Model
{
    protected $table = 'estado_proyecto';


    public function proyecto()
    {
        return $this->hasMany('App\proyecto');
    }

}
