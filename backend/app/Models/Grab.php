<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grab extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'link',
        'campaign',
        'start',
        'end'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($grab) {
            if (empty($grab->slug)) {
                $grab->slug = Str::slug($grab->title);
            }
        });
    }
}
