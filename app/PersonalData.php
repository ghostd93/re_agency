<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    /**
     * Get the user record associated with the personal data.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
