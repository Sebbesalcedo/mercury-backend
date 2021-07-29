<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table = 'inmueble';

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }





}