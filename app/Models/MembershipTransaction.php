<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_no',
        'member_id',
        'membership_level_id',
        'transaction_type',
        'amount',
        'status',
        'notes',
        'latitude',
        'longitude',
        'applied_at',
        'approved_at',
        'expires_at',
        'verification_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'applied_at' => 'datetime',
            'approved_at' => 'datetime',
            'expires_at' => 'datetime',
            'verification_sent_at' => 'datetime',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(MembershipLevel::class, 'membership_level_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'transaction_id');
    }

    public function getPaidAmountAttribute(): float
    {
        return (float) $this->payments->sum('amount');
    }

    public function getBalanceAttribute(): float
    {
        return max(0, (float) $this->amount - $this->paid_amount);
    }
}
