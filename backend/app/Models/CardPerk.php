<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardPerk extends Model
{
      protected $fillable = [
        'card_id', 
        'perk_id',
        'formulas', 
        'start', 
        'end'
    ];

    // Define the relationships (if applicable)

    // A card perk belongs to a card
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    // A card perk belongs to a perk
    public function perk()
    {
        return $this->belongsTo(Perk::class);
    }
    
    public function places()
    {
        return $this->hasMany(CardPerkLocation::class);
    }
}