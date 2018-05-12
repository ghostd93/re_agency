<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active'
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user_id' => $this->id,
            'user_roles' => $this->roles()->get()
        ];
    }

    public function authorizeRoles($roles)
    {
        if(is_array($roles)){
            return $this->hasAnyRole($roles) ||
                abort('401', 'This action is unauthorized');
        }

        return $this->hasRole($roles) ||
            abort('401', 'This action is unauthorized');
    }

    public function hasAnyRole($roles)
    {
        return (
            null !== $this->roles()->whereIn('role_name', $roles)->first()
        );
    }

    public function hasRole($role)
    {
        return (
            null !== $this->roles()->where('role_name', $role)->first()
        );
    }

    public function isOwner($model)
    {
        if(is_object($model)) {
            if ($model->user_id) {
                if ($this->id === $model->user_id || $this->hasRole('administrator')) {
                    return true;
                }
            } else if ($this->id === $model->id || $this->hasRole('administrator')) {
                return true;
            }
            return false;
        }
        return false;
    }
}
