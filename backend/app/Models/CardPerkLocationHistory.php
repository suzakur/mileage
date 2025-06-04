<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardPerkLocationHistory extends Model
{
    protected $fillable = ['card_perk_id', 'place_id', 'changed_at'];

    public function cardPerk()
    {
        return $this->belongsTo(CardPerk::class);
    }

}
