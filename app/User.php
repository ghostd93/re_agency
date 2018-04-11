<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * Get the personal data record associated with the user.
     */
    public function personalData()
    {
        return $this->hasOne('App\PersonalData');
    }

    /**
     * Get the advertisement record associated with the user.
     */
    public function advertisement()
    {
        return $this->hasMany('App\Advertisement');
    }

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

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user')->withTimestamps();
    }

    public function advertisements()
    {
        return $this->hasMany('App\Advertisement');
    }
}
