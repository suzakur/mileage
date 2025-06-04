<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantPlace extends Model
{
	protected $fillable = [
        'merchant_id', // ✅ Add this
        'place_id',
        'rating',
        'user_ratings_total',
        'google_place_id',
        'opening_hours',
    ];
    
    public function merchant() {
	    return $this->belongsTo(Merchant::class);
	}

	public function place() {
	    return $this->belongsTo(Place::class);
	}
}
