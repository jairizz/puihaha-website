<?php

namespace App\Http\Controllers;

use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with(['transaction.member'])->latest('paid_at')->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function create(MembershipTransaction $transaction): View|RedirectResponse
    {
        $transaction->load('member', 'level');
        $paidAmount = (float) $transaction->payments()->where('status', 'paid')->sum('amount');
        $remainingAmount = max(0, (float) $transaction->amount - $paidAmount);

        if ($remainingAmount <= 0) {
            return redirect()->route('transactions.show', $transaction)
                ->with('error', 'This transaction is already fully paid.');
        }

        return view('payments.create', compact('transaction', 'remainingAmount'));
    }

    public function store(Request $request, MembershipTransaction $transaction): RedirectResponse
    {
        $paidAmount = (float) $transaction->payments()->where('status', 'paid')->sum('amount');
        $remainingAmount = max(0, (float) $transaction->amount - $paidAmount);

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'in:cash,bank_transfer,gcash,card'],
            'paid_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ((float) $validated['amount'] > $remainingAmount) {
            return back()->withErrors([
                'amount' => 'Payment cannot be greater than the remaining balance of ₱' . number_format($remainingAmount, 2) . '.',
            ])->withInput();
        }

        $validated['transaction_id'] = $transaction->id;
        $validated['payment_reference'] = $this->generatePaymentReference();
        $validated['status'] = 'paid';

        Payment::create($validated);

        $newPaidAmount = $paidAmount + (float) $validated['amount'];

        if ($newPaidAmount >= (float) $transaction->amount && $transaction->status === 'pending') {
            $transaction->update(['status' => 'paid']);
        }

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Payment recorded successfully.');
    }

    private function generatePaymentReference(): string
    {
        do {
            $reference = 'PAY-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (Payment::where('payment_reference', $reference)->exists());

        return $reference;
    }
}
