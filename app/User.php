<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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

    public function estado() {
        return $this->belongsTo('App\Models\Estado','estado_id');
    }

    public function pais() {
        return $this->belongsTo('App\Models\Pais','pais_id');
    }

    public function pedidos () {
        return $this->hasMany('App\Models\Purchase', 'user_id');
    }
    
}
