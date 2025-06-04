<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrawlPlace extends Model
{
    protected $fillable = ['name', 'google_place_id', 'place_id', 'rating', 'user_ratings_total', 'opening_hours', 'category_id'];
    
    protected $casts = [
        'opening_hours' => 'array',
    ];


    public function place()
	{
	    return $this->belongsTo(Place::class, 'place_id');
	}

	public function category()
	{
	    return $this->belongsTo(Category::class, 'category_id');
	}
}
