<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
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

    /**
     * Get the personal data record associated with the user.
     */
    public function personalData()
    {
        return $this->hasOne(PersonalData::class);
    }

    /**
     * Get the advertisement record associated with the user.
     */
    public function advertisement()
    {
        return $this->hasMany('App\Advertisement');
    }
}
