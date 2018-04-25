<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PersonalData
 *
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData ofUser($userId)
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $phone_number
 * @property string $country
 * @property string $city
 * @property string $street
 * @property string $street_number
 * @property string $postal_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereStreetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PersonalData whereUserId($value)
 */
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

    protected $hidden = ['user_id'];

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
