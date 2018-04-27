<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'advertisement_id',
        'name',
        'url',
        'thumb_url'
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
