<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfil_id(){
        return $this->belongsTo('App\Perfil','perfil_id'); 
    }

    public function obras(){

        return $this->hasMany('App\Obras');
    }

    public function user_cotizaciones(){
    
        return $this->hasMany('App\cotizaciones');

    }

    public function proveedor()
    {
        return $this->hasMany('App\Proveedor');
    }
}
