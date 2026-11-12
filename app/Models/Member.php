<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'membership_no',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'category_id',
        'level_id',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MembershipCategory::class, 'category_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(MembershipLevel::class, 'level_id');
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(MembershipTransaction::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
