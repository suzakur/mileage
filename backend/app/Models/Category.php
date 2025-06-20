<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
     use SoftDeletes;
     
    protected $fillable = ['name', 'status', 'type'];

    public function merchants()
    {
        return $this->belongsToMany(Merchant::class, 'merchant_category');
    }
}
