@extends('layouts.app')

@section('content')
<div class="page-shell">
    <div class="back-link"><a href="{{ route('transactions.index') }}"><i class="fa-solid fa-arrow-left"></i> Back to transactions</a></div>
    <header class="profile-header">
        <div class="profile-identity"><span class="transaction-avatar"><i class="fa-solid fa-arrow-right-arrow-left"></i></span>
            <div><span class="eyebrow">TRANSACTION RECORD</span>
                <h1>{{ $transaction->transaction_no }}</h1>
                <p>{{ ucfirst($transaction->transaction_type) }} for {{ optional($transaction->member)->full_name ?? 'Unknown member' }} <span class="dot-separator">•</span> <span class="status-pill status-{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span></p>
            </div>
        </div>
        <div class="header-actions"><a href="{{ route('transactions.receipt', $transaction) }}" target="_blank" class="secondary-btn"><i class="fa-solid fa-print"></i> Print receipt</a>
            @if($transaction->status !== 'approved' && $transaction->status !== 'cancelled')<a href="{{ route('payments.create', $transaction) }}" class="primary-btn"><i class="fa-solid fa-wallet"></i> Record payment</a>
            @endif

            @if($transaction->status === 'paid')<form action="{{ route('transactions.approve', $transaction) }}" method="POST">
                @csrf<button class="secondary-btn approve-btn" type="submit"><i class="fa-solid fa-check"></i> Approve</button></form>
            @endif</div>
    </header>
    <div class="transaction-grid">
        <section class="detail-card">
            <div class="panel-heading">
                <div><span class="eyebrow">TRANSACTION DETAILS</span>
                    <h2>Application summary</h2>
                </div>
            </div>
            <div class="detail-list">
                <div><small>Member</small><strong><a class="record-link" href="{{ optional($transaction->member)->id ? route('members.show', $transaction->member) : '#' }}">{{ optional($transaction->member)->full_name ?? 'Unknown member' }}</a></strong></div>
                <div><small>Membership level</small><strong>{{ optional($transaction->level)->name ?? '—' }}</strong></div>
                <div><small>Amount due</small><strong>₱{{ number_format($transaction->amount, 2) }}</strong></div>
                <div><small>Amount paid</small><strong>₱{{ number_format($transaction->payments->where('status', 'paid')->sum('amount'), 2) }}</strong></div>
                <div><small>Applied on</small><strong>{{ optional($transaction->applied_at)->format('M d, Y h:i A') ?: '—' }}</strong></div>
                <div><small>Expires on</small><strong>{{ optional($transaction->expires_at)->format('M d, Y') ?: 'Pending approval' }}</strong></div>
                <div class="full-detail"><small>Notes</small><strong>{{ $transaction->notes ?: 'No notes provided.' }}</strong></div>
            </div>
        </section>
        <section class="detail-card balance-card"><span class="eyebrow">PAYMENT STATUS</span>
            <h2>{{ $transaction->status === 'approved' ? 'Membership approved' : 'Balance to settle' }}</h2><strong class="balance-number">₱{{ number_format(max(0, (float) $transaction->amount - (float) $transaction->payments->where('status', 'paid')->sum('amount')), 2) }}</strong>
            <p>{{ $transaction->status === 'approved' ? 'This transaction has been approved.' : 'Record the full amount before approving this transaction.' }}</p>
            @if($transaction->status !== 'approved' && $transaction->status !== 'cancelled')<form action="{{ route('transactions.cancel', $transaction) }}" method="POST" onsubmit="return confirm('Cancel this transaction?')">
                @csrf<button type="submit" class="danger-btn">Cancel transaction</button></form>
            @endif
        </section>
    </div>
    <section class="table-card">
        <div class="table-toolbar">
            <div><span class="eyebrow">PAYMENT HISTORY</span>
                <h2>Recorded payments</h2>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Paid on</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaction->payments as $payment)<tr>
                        <td class="record-id">{{ $payment->payment_reference }}</td>
                        <td><strong>₱{{ number_format($payment->amount, 2) }}</strong></td>
                        <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td><span class="status-pill status-{{ $payment->status === 'paid' ? 'paid' : 'cancelled' }}">{{ ucfirst($payment->status) }}</span></td>
                        <td>{{ optional($payment->paid_at)->format('M d, Y h:i A') }}</td>
                    </tr>
                    @empty<tr>
                        <td colspan="5" class="empty-state">No payments recorded for this transaction.</td>
                    </tr>
                    @endforelse</tbody>
            </table>
        </div>
    </section>
</div>
@endsection