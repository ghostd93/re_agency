<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'phone_number',
        'country',
        'city',
        'street',
        'street_number',
        'postal_code'
    ];

    /**
     * Get the user record associated with the personal data.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
