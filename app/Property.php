<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Property
 *
 * @property-read \App\Advertisement $advertisement
 * @mixin \Eloquent
 * @property int $id
 * @property string $property_type
 * @property string $description
 * @property string $date_of_registration
 * @property string|null $property_area
 * @property string|null $date_of_construction
 * @property int|null $number_of_floors
 * @property int|null $number_of_rooms
 * @property int|null $floor
 * @property int|null $balcony
 * @property int|null $garage
 * @property string $land_area
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $street_number
 * @property string $postal_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereBalcony($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereDateOfConstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereDateOfRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereGarage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereLandArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereNumberOfFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereNumberOfRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property wherePropertyArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property wherePropertyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereStreetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Property whereUpdatedAt($value)
 */
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
        return $this->belongsTo('App\Advertisement');
    }

}
