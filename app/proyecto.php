<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
    protected $table = 'proyectos';

    /**
     * Relacion de muchos a uno con la tabla estado_proyecto
     */

    public function id_estado()
    {
        return $this->belongsTo('App\estadoProyecto','id_estado');
    }

    public function id_user()
    {
        return $this->belongsTo('App\User','id_user');
    }


    /**
     * Relacion de uno a muchos con la tabla torre
     */

    public function torre()
    {
        return $this->hasMany('App\Torre');
    }

    /**
     * Get all of the comments for the proyecto
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inmueble()
    {
        return $this->hasMany( 'App\Inmueble');
    }

}
