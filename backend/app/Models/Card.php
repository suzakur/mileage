<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'name', 'link', 'bank_id', 'card_number', 'image', 'network', 'type', 'tier', 'class', 'status'
    ];


     /**
     * A card has many card perks.
     */
    public function cardPerks()
    {
        return $this->hasMany(CardPerk::class);
    }

    /**
     * A card has many card perks.
     */
    public function cardSpec()
    {
        return $this->hasOne(CardSpec::class);
    }

    /**
     * A card has many perks through card perks.
     */
    public function perks()
    {
        return $this->belongsToMany(Perk::class, 'card_perks')->withPivot('score', 'offer', 'conditional', 'start', 'end');
    }

    /**
     * A card belongs to a bank.
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}