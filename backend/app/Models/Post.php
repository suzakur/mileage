<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
     use SoftDeletes;
     
     protected $fillable = [
        'user_id', 'editor_id', 'page_id', 'card_id', 'merchant_place_id', 'title', 'slug', 'excerpt', 'content', 'image', 'status', 'published_at', 'seo_meta'
    ];

    protected $casts = [
        'seo_meta' => 'array',
        'published_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function merchantPlace(): BelongsTo
    {
        return $this->belongsTo(MerchantPlace::class, 'merchant_place_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
