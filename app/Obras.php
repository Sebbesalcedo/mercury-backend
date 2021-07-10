<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obras extends Model
{
    protected $table = 'obras';

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


  

    
}
