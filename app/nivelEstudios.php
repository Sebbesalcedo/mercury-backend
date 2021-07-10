<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nivelEstudios extends Model
{
    protected $table = 'nivel_estudios';

    public function clientes()
    {
        return $this->hasMany('App\clientes');
    }
    
}
