<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardPerkLocation extends Model
{
    protected $fillable = ['card_perk_id', 'place_id'];

    public function cardPerk()
    {
        return $this->belongsTo(CardPerk::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

}
