<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipLevel extends Model
{
    protected $fillable = [
        'name',
        'fee',
        'validity_period',
        'benefits'
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}