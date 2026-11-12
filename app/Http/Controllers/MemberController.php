<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $status = (string) $request->string('status');

        $members = Member::query()
            ->with(['category', 'level'])
            ->when(in_array($status, ['active', 'inactive'], true), function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($memberQuery) use ($search): void {
                    $memberQuery
                        ->where('membership_no', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search): void {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('level', function ($levelQuery) use ($search): void {
                            $levelQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('members.index', compact('members', 'search', 'status'));
    }

    public function create(): View
    {
        $categories = MembershipCategory::orderBy('name')->get();
        $levels = MembershipLevel::orderBy('fee')->get();

        return view('members.create', compact('categories', 'levels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:membership_categories,id'],
            'level_id' => ['required', 'exists:membership_levels,id'],
        ]);

        $validated['membership_no'] = $this->generateMembershipNumber();
        $validated['status'] = 'active';

        $member = Member::create($validated);

        return redirect()
            ->route('members.show', $member)
            ->with('success', "Member {$member->full_name} was registered successfully.");
    }

    public function show(Member $member): View
    {
        $member->load([
            'category',
            'level',
            'transactions' => fn ($query) => $query->with('level')->withSum('payments', 'amount')->latest(),
        ]);

        return view('members.show', compact('member'));
    }

    public function edit(Member $member): View
    {
        $categories = MembershipCategory::orderBy('name')->get();
        $levels = MembershipLevel::orderBy('fee')->get();

        return view('members.edit', compact('member', 'categories', 'levels'));
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:membership_categories,id'],
            'level_id' => ['required', 'exists:membership_levels,id'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $member->update($validated);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Member details were updated successfully.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->update(['status' => 'inactive']);

        return redirect()
            ->route('members.index')
            ->with('success', 'The member was deactivated.');
    }

    private function generateMembershipNumber(): string
    {
        do {
            $number = 'MEM-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));
        } while (Member::where('membership_no', $number)->exists());

        return $number;
    }
}
