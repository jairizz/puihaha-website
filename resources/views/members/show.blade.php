@extends('layouts.app')

@section('content')
<style>
    .member-print-record { display: none; }

    @media print {
        @page { size: A4 portrait; margin: 16mm; }
        html, body { min-height: 0; height: auto; background: #fff !important; }
        body { margin: 0; padding: 0; color: #17243b; font: 11pt/1.5 Arial, sans-serif; }
        body.navigation-open { overflow: visible; }
        .sidebar, .mobile-topbar, .sidebar-backdrop, .flash, .member-profile-screen { display: none !important; }
        main.main-content { min-height: 0; margin: 0 !important; padding: 0 !important; }
        .member-print-record { display: block; width: 100%; max-width: none; }
        .member-print-record * { box-sizing: border-box; }
        .member-print-record .record-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 16pt; padding-bottom: 16pt; border-bottom: 2pt solid #1767cf; }
        .member-print-record .record-brand { margin: 0; font-size: 22pt; font-weight: 800; color: #1767cf; }
        .member-print-record .record-caption { margin: 4pt 0 0; color: #52617a; font-size: 9pt; }
        .member-print-record .record-reference { min-width: 0; max-width: 55%; text-align: right; }
        .member-print-record .record-reference strong { display: block; margin-top: 5pt; font-size: 11pt; overflow-wrap: anywhere; }
        .member-print-record h1 { margin: 20pt 0 6pt; font-size: 23pt; line-height: 1.2; overflow-wrap: anywhere; }
        .member-print-record .record-status { display: inline-block; margin-top: 5pt; padding: 3pt 9pt; border: 1pt solid #9baac0; border-radius: 4pt; font-size: 9pt; }
        .member-print-record h2 { margin: 22pt 0 12pt; padding-bottom: 7pt; border-bottom: 1pt solid #dce3ed; color: #17243b; font-size: 12pt; break-after: avoid; }
        .member-print-record dl { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 14pt 24pt; margin: 0; }
        .member-print-record dl > div { min-width: 0; break-inside: avoid; }
        .member-print-record .record-wide { grid-column: 1 / -1; }
        .member-print-record dt { color: #52617a; font-size: 9pt; }
        .member-print-record dd { margin: 4pt 0 0; color: #17243b; font-size: 11pt; overflow-wrap: anywhere; white-space: pre-line; }
        .member-print-record .record-signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 30pt; margin-top: 42pt; break-inside: avoid; }
        .member-print-record .record-signatures p { margin: 0; padding-top: 7pt; border-top: 1pt solid #9baac0; color: #52617a; font-size: 9pt; text-align: center; }
        .member-print-record .record-footer { margin-top: 25pt; padding-top: 10pt; border-top: 1pt solid #dce3ed; color: #52617a; font-size: 8pt; line-height: 1.6; }
    }
</style>

<div class="page-shell member-profile-screen">
    <div class="back-link"><a href="{{ route('members.index') }}"><i class="fa-solid fa-arrow-left"></i> Back to members</a></div>
    <header class="profile-header">
        <div class="profile-identity">
            <span class="profile-avatar">{{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}</span>
            <div>
                <span class="eyebrow">MEMBER PROFILE</span>
                <h1>{{ $member->full_name }}</h1>
                <p>{{ $member->membership_no }} <span class="dot-separator">•</span> <span class="status-pill status-{{ $member->status }}">{{ ucfirst($member->status) }}</span></p>
            </div>
        </div>
        <div class="header-actions">
            <button type="button" class="secondary-btn" onclick="window.print()">
                <i class="fa-solid fa-print" aria-hidden="true"></i>
                Print membership record
            </button>
            <a href="{{ route('members.edit', $member) }}" class="secondary-btn"><i class="fa-solid fa-pen"></i> Edit profile</a>
            <a href="{{ route('transactions.create', ['member_id' => $member->id]) }}" class="primary-btn"><i class="fa-solid fa-plus"></i> New transaction</a>
        </div>
    </header>

    <div class="profile-grid">
        <section class="detail-card"><div class="panel-heading"><div><span class="eyebrow">PERSONAL DETAILS</span><h2>Contact information</h2></div></div><div class="detail-list"><div><small>Email</small><strong>{{ $member->email }}</strong></div><div><small>Phone</small><strong>{{ $member->phone ?: 'Not provided' }}</strong></div><div class="full-detail"><small>Address</small><strong>{{ $member->address ?: 'Not provided' }}</strong></div><div><small>Category</small><span class="category-badge">{{ optional($member->category)->name ?? 'Unassigned' }}</span></div><div><small>Current level</small><span class="level-badge">{{ optional($member->level)->name ?? 'Unassigned' }}</span></div></div></section>
        <section class="detail-card"><div class="panel-heading"><div><span class="eyebrow">ACCOUNT STATUS</span><h2>Membership summary</h2></div></div><div class="summary-list"><div><span>Total transactions</span><strong>{{ $member->transactions->count() }}</strong></div><div><span>Approved transactions</span><strong>{{ $member->transactions->where('status', 'approved')->count() }}</strong></div><div><span>Member since</span><strong>{{ optional($member->created_at)->format('M d, Y') ?: '—' }}</strong></div></div></section>
    </div>

    <section class="table-card"><div class="table-toolbar"><div><span class="eyebrow">MEMBER HISTORY</span><h2>Transaction history</h2><span>Applications, renewals, and payment status</span></div></div><div class="table-wrapper"><table class="data-table"><thead><tr><th>Reference</th><th>Type</th><th>Level</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead><tbody>@forelse($member->transactions as $transaction)<tr><td><a class="record-link" href="{{ route('transactions.show', $transaction) }}">{{ $transaction->transaction_no }}</a></td><td>{{ ucfirst($transaction->transaction_type) }}</td><td>{{ optional($transaction->level)->name ?? '—' }}</td><td>₱{{ number_format($transaction->amount, 2) }}</td><td><span class="status-pill status-{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span></td><td>{{ optional($transaction->applied_at)->format('M d, Y') ?: '—' }}</td></tr>@empty<tr><td colspan="6" class="empty-state">No transaction history for this member.</td></tr>@endforelse</tbody></table></div></section>
</div>

<article class="member-print-record" aria-label="Printable membership record">
    <header class="record-top">
        <div>
            <p class="record-brand">Puihaha</p>
            <p class="record-caption">Membership Management System</p>
        </div>
        <div class="record-reference">
            <p class="record-caption">MEMBERSHIP RECORD</p>
            <strong>{{ $member->membership_no }}</strong>
        </div>
    </header>

    <h1>{{ $member->full_name }}</h1>
    <p class="record-status">Account status: {{ ucfirst($member->status) }}</p>

    <section>
        <h2>Personal information</h2>
        <dl>
            <div>
                <dt>First name</dt>
                <dd>{{ $member->first_name }}</dd>
            </div>
            <div>
                <dt>Last name</dt>
                <dd>{{ $member->last_name }}</dd>
            </div>
            <div>
                <dt>Email address</dt>
                <dd>{{ $member->email ?: 'Not provided' }}</dd>
            </div>
            <div>
                <dt>Phone number</dt>
                <dd>{{ $member->phone ?: 'Not provided' }}</dd>
            </div>
            <div class="record-wide">
                <dt>Address</dt>
                <dd>{{ $member->address ?: 'Not provided' }}</dd>
            </div>
        </dl>
    </section>

    <section>
        <h2>Membership information</h2>
        <dl>
            <div>
                <dt>Membership category</dt>
                <dd>{{ optional($member->category)->name ?? 'Unassigned' }}</dd>
            </div>
            <div>
                <dt>Current membership level</dt>
                <dd>{{ optional($member->level)->name ?? 'Unassigned' }}</dd>
            </div>
            <div>
                <dt>Level fee</dt>
                <dd>
                    @if (optional($member->level)->fee !== null)
                        ₱{{ number_format($member->level->fee, 2) }}
                    @else
                        Not specified
                    @endif
                </dd>
            </div>
            <div>
                <dt>Level validity period</dt>
                <dd>
                    @if (optional($member->level)->validity_period !== null)
                        {{ $member->level->validity_period }} months
                    @else
                        Not specified
                    @endif
                </dd>
            </div>
            <div>
                <dt>Registered on</dt>
                <dd>{{ optional($member->created_at)->format('F d, Y') ?: 'Not recorded' }}</dd>
            </div>
            <div class="record-wide">
                <dt>Level benefits</dt>
                <dd>{{ optional($member->level)->benefits ?: 'No benefits specified.' }}</dd>
            </div>
        </dl>
    </section>

    <div class="record-signatures">
        <p>Member signature</p>
        <p>Administrator signature</p>
    </div>

    <footer class="record-footer">
        Generated by Puihaha Membership Management System on {{ now()->format('F d, Y h:i A T') }}.<br>
        This record contains the member profile and assigned plan details as stored in the system.
    </footer>
</article>
@endsection