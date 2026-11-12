<?php

namespace Database\Seeders;

use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@puihaha.test'],
            [
                'name' => 'Puihaha Administrator',
                'password' => 'password',
            ]
        );

        foreach ([
            ['name' => 'Student', 'description' => 'For currently enrolled students.'],
            ['name' => 'Regular', 'description' => 'Standard membership for regular members.'],
            ['name' => 'Senior Citizen', 'description' => 'For qualified senior citizen members.'],
            ['name' => 'Corporate', 'description' => 'For organizations and corporate partners.'],
        ] as $category) {
            MembershipCategory::firstOrCreate(['name' => $category['name']], $category);
        }

        foreach ([
            ['name' => 'Basic', 'fee' => 100, 'validity_period' => 12, 'benefits' => 'Basic membership access.'],
            ['name' => 'Silver', 'fee' => 250, 'validity_period' => 12, 'benefits' => 'Priority support and member discounts.'],
            ['name' => 'Gold', 'fee' => 500, 'validity_period' => 12, 'benefits' => 'Premium benefits and priority processing.'],
            ['name' => 'Platinum', 'fee' => 1000, 'validity_period' => 12, 'benefits' => 'All premium benefits and exclusive access.'],
        ] as $level) {
            MembershipLevel::firstOrCreate(['name' => $level['name']], $level);
        }
    }
}
