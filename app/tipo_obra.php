<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class tipo_obra extends Model
{
    protected $table ='tipo_obra';

    public function obras()
    {

        return $this->hasMany('App\obras');

    }

}
