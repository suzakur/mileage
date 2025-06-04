<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	protected $table = 'cities'; // Explicitly set table name

    protected $fillable = ['name']; // Allow mass assignment
}
