<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use SoftDeletes;


    protected $fillable = ['name',  'website', 'status', 'category_id'];

    protected $casts = [
        'opening_hours' => 'array',
        'raw_data' => 'array',
    ];

    protected static function booted()
    {
        static::created(function ($merchant) {
            $allLocation = \App\Models\Place::find(1); // Fetch the "All Locations" location
            // If the location exists, sync the merchant with that location
            if ($allLocation) {
                $merchant->places()->attach($allLocation->id);
            }
        });
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'merchant_places')
                    ->withPivot(['google_place_id', 'phone', 'address', 'email', 'is_open', 'opening_hours', 'raw_data'])
                    ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}