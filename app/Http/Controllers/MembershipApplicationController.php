<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembershipApplicationRequest;
use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use App\Notifications\MembershipApplicationSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MembershipApplicationController extends Controller
{
    public function create(): View
    {
        return view('membership.create', [
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('fee')->get(),
        ]);
    }

    public function store(StoreMembershipApplicationRequest $request): RedirectResponse
    {
        $application = DB::transaction(function () use ($request): MembershipTransaction {
            $data = $request->validated();
            $nameParts = preg_split('/\s+/', trim($data['full_name'])) ?: [];
            $firstName = array_shift($nameParts) ?: $data['full_name'];
            $lastName = $nameParts !== [] ? implode(' ', $nameParts) : null;
            $member = Member::create([
                'membership_no' => $this->generateMembershipNumber(),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'category_id' => $data['membership_category_id'],
                'level_id' => $data['membership_level_id'],
                'status' => 'active',
            ]);

            $level = MembershipLevel::findOrFail($data['membership_level_id']);
            $application = MembershipTransaction::create([
                'transaction_no' => $this->generateTransactionNumber(),
                'member_id' => $member->id,
                'membership_level_id' => $level->id,
                'transaction_type' => 'application',
                'amount' => $level->fee,
                'status' => 'pending',
                'notes' => 'Public membership application submitted online.',
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'applied_at' => now(),
            ]);

            Notification::route('mail', $member->email)
                ->notify(new MembershipApplicationSubmitted($application));

            $application->update(['verification_sent_at' => now()]);

            return $application;
        });

        return redirect()->route('membership.create')->with(
            'success',
            "Application saved. Confirmation email queued. Reference: {$application->transaction_no}"
        );
    }

    private function generateMembershipNumber(): string
    {
        do {
            $number = 'MEM-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));
        } while (Member::where('membership_no', $number)->exists());

        return $number;
    }

    private function generateTransactionNumber(): string
    {
        do {
            $number = 'APP-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (MembershipTransaction::where('transaction_no', $number)->exists());

        return $number;
    }
}
