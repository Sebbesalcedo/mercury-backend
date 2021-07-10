<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    protected $table = 'medida';

    public function productos(){
        return $this->hasMany('App\productos');
    }

}
