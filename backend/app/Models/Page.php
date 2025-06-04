<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
	use SoftDeletes;
	 
    protected $fillable = ['name', 'slug', 'content', 'status', 'seo_meta'];

    protected $casts = [
        'seo_meta' => 'array', // Cast JSON field to array
    ];
}
