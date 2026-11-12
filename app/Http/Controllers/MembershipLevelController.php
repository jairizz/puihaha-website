<?php

namespace App\Http\Controllers;

use App\Models\MembershipLevel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipLevelController extends Controller
{
    public function index(): View
    {
        $levels = MembershipLevel::withCount('members')->orderBy('fee')->get();

        return view('levels.index', compact('levels'));
    }

    public function create(): View
    {
        return view('levels.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:membership_levels,name'],
            'fee' => ['required', 'numeric', 'min:0'],
            'validity_period' => ['required', 'integer', 'min:1', 'max:120'],
            'benefits' => ['nullable', 'string', 'max:1000'],
        ]);

        MembershipLevel::create($validated);

        return redirect()->route('levels.index')->with('success', 'Membership level added successfully.');
    }

    public function edit(MembershipLevel $level): View
    {
        return view('levels.edit', compact('level'));
    }

    public function update(Request $request, MembershipLevel $level): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:membership_levels,name,' . $level->id],
            'fee' => ['required', 'numeric', 'min:0'],
            'validity_period' => ['required', 'integer', 'min:1', 'max:120'],
            'benefits' => ['nullable', 'string', 'max:1000'],
        ]);

        $level->update($validated);

        return redirect()->route('levels.index')->with('success', 'Membership level updated successfully.');
    }

    public function destroy(MembershipLevel $level): RedirectResponse
    {
        if ($level->members()->exists() || $level->transactions()->exists()) {
            return back()->with('error', 'This level cannot be deleted while it is in use.');
        }

        $level->delete();

        return redirect()->route('levels.index')->with('success', 'Membership level deleted successfully.');
    }
}
