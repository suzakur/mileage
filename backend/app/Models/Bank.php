<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
	use SoftDeletes;
	 
    protected $fillable = ['name', 'fullname','phone', 'website', 'logo'];


    public function cards()
    {
        return $this->hasMany(Card::class);
    }

}
