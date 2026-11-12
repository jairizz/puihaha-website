<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->string('status');
        $search = trim((string) $request->string('search'));

        $transactions = MembershipTransaction::query()
            ->with(['member', 'level'])
            ->withSum('payments', 'amount')
            ->when(in_array($status, ['pending', 'paid', 'approved', 'expired', 'cancelled'], true), function ($query) use ($status): void {
                $query->where('status', $status);
            })
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($transactionQuery) use ($search): void {
                    $transactionQuery
                        ->where('transaction_no', 'like', "%{$search}%")
                        ->orWhereHas('member', function ($memberQuery) use ($search): void {
                            $memberQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('membership_no', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions', 'status', 'search'));
    }

    public function create(): View
    {
        $members = Member::where('status', 'active')->orderBy('last_name')->orderBy('first_name')->get();
        $levels = MembershipLevel::orderBy('fee')->get();

        return view('transactions.create', compact('members', 'levels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'membership_level_id' => ['required', 'exists:membership_levels,id'],
            'transaction_type' => ['required', 'in:application,renewal'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['transaction_no'] = $this->generateTransactionNumber();
        $validated['status'] = 'pending';
        $validated['applied_at'] = now();

        $transaction = MembershipTransaction::create($validated);

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaction created and marked as pending.');
    }

    public function show(MembershipTransaction $transaction): View
    {
        $transaction->load(['member.category', 'level', 'payments' => fn ($query) => $query->latest()]);

        return view('transactions.show', compact('transaction'));
    }

    public function receipt(MembershipTransaction $transaction): View
    {
        $transaction->load(['member.category', 'level', 'payments' => fn ($query) => $query->latest()]);

        return view('transactions.receipt', compact('transaction'));
    }

    public function approve(MembershipTransaction $transaction): RedirectResponse
    {
        $paidAmount = (float) $transaction->payments()->where('status', 'paid')->sum('amount');

        if ($transaction->status !== 'paid' || $paidAmount < (float) $transaction->amount) {
            return back()->with('error', 'Only fully paid transactions may be approved.');
        }

        $transaction->update([
            'status' => 'approved',
            'approved_at' => now(),
            'expires_at' => now()->addMonths($transaction->level->validity_period),
        ]);

        return back()->with('success', 'Transaction approved successfully.');
    }

    public function cancel(MembershipTransaction $transaction): RedirectResponse
    {
        if ($transaction->status === 'approved') {
            return back()->with('error', 'Approved transactions cannot be cancelled.');
        }

        $transaction->update(['status' => 'cancelled']);

        return back()->with('success', 'Transaction cancelled.');
    }

    private function generateTransactionNumber(): string
    {
        do {
            $number = 'TXN-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (MembershipTransaction::where('transaction_no', $number)->exists());

        return $number;
    }
}
