<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;

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
        'status'
    ];
    public function category()
    {
        return $this->belongsTo(MembershipCategory::class);
    }

    public function level()
    {
        return $this->belongsTo(MembershipLevel::class);
    }
}
