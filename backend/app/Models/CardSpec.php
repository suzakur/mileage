<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardSpec extends Model
{
    protected $fillable = [
        'card_id',
        'annual_fee',
        'suplement_fee',
        'rate',
        'penalty_fee',
        'admin_fee',
        'advance_cash_fee',
        'replacement_fee',
        'minimum_limit',
        'minimum_salary',
        'maximum_age',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
