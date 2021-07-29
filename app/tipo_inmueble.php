<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class tipo_inmueble extends Model
{
    protected $table ='tipo_inmueble';

    public function inmueble()
    {

        return $this->hasMany('App\inmueble');

    }

}
