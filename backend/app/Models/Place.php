<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use SoftDeletes;
     
    protected $fillable = ['name', 'address', 'city_id', 'postal_code', 'latitude', 'longitude', 'google_place_id', 'raw_data'];
    protected $hidden = ['raw_data'];

    protected $casts = [
        'raw_data'  => 'array',
        'latitude'  => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function district()
    {
        return $this->belongsTo(\App\Models\District::class);
    }

    public function cardPerks()
    {
        return $this->belongsToMany(CardPerk::class, 'card_perk_locations');
    }

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_places')
                    ->withPivot(['google_place_id', 'phone', 'address', 'email', 'is_open', 'opening_hours', 'raw_data'])
                    ->withTimestamps();
    }
}
