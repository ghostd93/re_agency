<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * Get the advertisement that is connected to the property.
     */
    public function advertisement()
    {
        return $this->hasOne('App\Advertisement');
    }
}
