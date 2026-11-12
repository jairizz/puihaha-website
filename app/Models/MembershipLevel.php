<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipLevel extends Model
{
    protected $fillable = [
        'name',
        'fee',
        'validity_period',
        'benefits',
    ];

    protected function casts(): array
    {
        return [
            'fee' => 'decimal:2',
            'validity_period' => 'integer',
        ];
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'level_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MembershipTransaction::class);
    }
}
