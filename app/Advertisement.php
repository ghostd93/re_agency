<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'status',
        'type',
        'date_of_announcement',
        'description',
        'price',
        'user_id',
        'property_id',
    ];
    /**
     * Get the user that owns the advertisement.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the property that responds the advertisement.
     */
    public function property()
    {
        return $this->belongsTo('App\Property');
    }
}
