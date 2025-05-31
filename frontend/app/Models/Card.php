<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_name',
        'card_type',
        'card_level',
        'card_number_masked',
        'bank_name',
        'card_color',
        'credit_limit',
        'current_balance',
        'available_credit',
        'reward_points',
        'miles_earned',
        'expiry_date',
        'is_active',
        'status',
        'benefits',
    ];

    protected $casts = [
        'benefits' => 'array',
        'expiry_date' => 'date',
        'credit_limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'available_credit' => 'decimal:2',
        'miles_earned' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the card.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the card's utilization percentage.
     */
    public function getUtilizationPercentageAttribute(): float
    {
        if ($this->credit_limit <= 0) {
            return 0;
        }
        
        return ($this->current_balance / $this->credit_limit) * 100;
    }

    /**
     * Get the card's brand logo.
     */
    public function getBrandLogoAttribute(): string
    {
        $logos = [
            'visa' => 'assets/media/svg/card-logos/visa.svg',
            'mastercard' => 'assets/media/svg/card-logos/mastercard.svg',
            'amex' => 'assets/media/svg/card-logos/american-express.svg',
            'jcb' => 'assets/media/svg/card-logos/jcb.svg',
            'unionpay' => 'assets/media/svg/card-logos/unionpay.svg',
        ];

        return $logos[strtolower($this->card_type)] ?? 'assets/media/svg/card-logos/default.svg';
    }

    /**
     * Get formatted card number.
     */
    public function getFormattedCardNumberAttribute(): string
    {
        return substr_replace($this->card_number_masked, ' ', 4, 0);
    }
}
