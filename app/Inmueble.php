<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table = 't_unidades';

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function id_tipo_inmueble()
    {
        return $this->belongsTo('App\tipo_inmueble','id_tipo_inmueble');
    }


    public function id_torre()
    {
        return  $this->belongsTo('App\Torre','id_torre');
    }

    /**
     * Get the user that owns the Inmueble
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function id_proyecto()
    {
        return $this->belongsTo('App\proyecto', 'id_proyecto');
    }





}
