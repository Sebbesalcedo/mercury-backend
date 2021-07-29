<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Torre extends Model
{
    protected $table = 'torre';


    public function id_proyecto()
    {
       return $this->belongsTo('App\proyecto','id_proyecto');
    }

    public function id_user()
    {
       return $this->belongsTo('App\user','id_user');
    }

}
