<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perk extends Model
{
	 use SoftDeletes;
	 
    protected $fillable = ['name', 'description'];

    /**
     * A perk has many card perks.
     */
    public function cardPerks()
    {
        return $this->hasMany(CardPerk::class);
    }

    /**
     * A perk belongs to many cards through card perks.
     */
    public function cards()
    {
        return $this->belongsToMany(Card::class, 'card_perks')->withPivot('score', 'offer', 'conditional', 'start', 'end');
    }
}
