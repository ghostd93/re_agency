<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        "property_type",
        "description",
        "date_of_registration",
        "property_area",
        "date_of_construction",
        "number_of_floors",
        "number_of_rooms",
        "floor",
        "balcony",
        "garage",
        "land_area",
        "country",
        "city",
        "street",
        "street_number",
        "postal_code"
    ];
    /**
     * Get the advertisement that is connected to the property.
     */
    public function advertisement()
    {
        return $this->hasOne('App\Advertisement');
    }

}
