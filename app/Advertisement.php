<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Advertisement
 *
 * @property-read \App\Property $property
 * @property-read \App\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $date_of_announcement
 * @property string $description
 * @property int $price
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $property_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereDateOfAnnouncement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Advertisement whereUserId($value)
 */
class Advertisement extends Model
{
    use Searchable;

    protected $fillable = [
        'status',
        'type',
        'date_of_announcement',
        'description',
        'price',
        'user_id',
        'property_id',
        'admin_notes'
    ];

    protected $hidden = [
        'property_id',
        'user_id'
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
        return $this->hasOne('App\Property');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
