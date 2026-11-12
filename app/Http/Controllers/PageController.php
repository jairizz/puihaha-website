<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\View\View;

class PageController extends Controller
{
    public function dashboard(): View
    {
        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'active')->count();
        $inactiveMembers = Member::where('status', 'inactive')->count();
        $pendingTransactions = MembershipTransaction::where('status', 'pending')->count();
        $collectedPayments = Payment::where('status', 'paid')->sum('amount');
        $totalCategories = MembershipCategory::count();
        $totalLevels = MembershipLevel::count();
        $recentTransactions = MembershipTransaction::with(['member', 'level'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalMembers',
            'activeMembers',
            'inactiveMembers',
            'pendingTransactions',
            'collectedPayments',
            'totalCategories',
            'totalLevels',
            'recentTransactions'
        ));
    }

    public function about(): View
    {
        $data = [
            'course' => 'Web Systems Technologies!',
            'module' => 'Laravel Foundation.'
        ];

        return view('about', $data);
    }

    public function task(string $id): View
    {
        $data = [
            'id' => $id,
            'title' => 'Buy groceries'
        ];

        return view('task', $data);
    }
}
