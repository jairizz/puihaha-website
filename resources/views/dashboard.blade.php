@extends('layouts.app')

@section('content')
@php
    $activeRate = $totalMembers > 0 ? round(($activeMembers / $totalMembers) * 100) : 0;
    $firstName = explode(' ', trim(auth()->user()->name))[0] ?? auth()->user()->name;
@endphp

<div class="page-shell dashboard-page">
    <header class="page-header dashboard-header">
        <div>
            <span class="eyebrow">MEMBERSHIP MANAGEMENT SYSTEM</span>
            <h1>Good day, {{ $firstName }}.</h1>
            <p>Here is the latest overview of your membership operations.</p>
        </div>
        <div class="date-chip">
            <i class="fa-regular fa-calendar"></i>
            {{ now()->format('F d, Y') }}
        </div>
    </header>

    <section class="stat-grid">
        <a href="{{ route('members.index') }}" class="stat-card stat-card-blue">
            <span class="stat-icon"><i class="fa-solid fa-users"></i></span>
            <span class="stat-copy"><small>Total members</small><strong>{{ $totalMembers }}</strong><em>View directory <i class="fa-solid fa-arrow-up-right-from-square"></i></em></span>
        </a>
        <a href="{{ route('members.index', ['status' => 'active']) }}" class="stat-card stat-card-green">
            <span class="stat-icon"><i class="fa-solid fa-user-check"></i></span>
            <span class="stat-copy"><small>Active members</small><strong>{{ $activeMembers }}</strong><em>{{ $activeRate }}% active rate</em></span>
        </a>
        <a href="{{ route('transactions.index', ['status' => 'pending']) }}" class="stat-card stat-card-amber">
            <span class="stat-icon"><i class="fa-solid fa-hourglass-half"></i></span>
            <span class="stat-copy"><small>Pending transactions</small><strong>{{ $pendingTransactions }}</strong><em>Needs attention</em></span>
        </a>
        <a href="{{ route('payments.index') }}" class="stat-card stat-card-purple">
            <span class="stat-icon"><i class="fa-solid fa-peso-sign"></i></span>
            <span class="stat-copy"><small>Collected payments</small><strong>₱{{ number_format($collectedPayments, 2) }}</strong><em>Recorded payments</em></span>
        </a>
    </section>

    <section class="dashboard-grid-main">
        <div class="dashboard-primary-column">
            <section class="hero-panel">
                <div class="hero-content">
                    <span class="eyebrow eyebrow-light">THE BIG PICTURE</span>
                    <strong class="hero-number">{{ $totalMembers }}</strong>
                    <h2>Members connected in one place.</h2>
                    <p>Keep registration, membership plans, and transaction records organized from one workspace.</p>
                    <a href="{{ route('members.create') }}" class="hero-link">Register a member <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="hero-orbit orbit-one"></div>
                <div class="hero-orbit orbit-two"></div>
            </section>

            <section class="section-block">
                <div class="section-heading">
                    <div><span class="eyebrow">YOUR SETUP</span><h2>Membership building blocks</h2></div>
                    <span class="section-note">{{ $totalCategories + $totalLevels }} managed items</span>
                </div>
                <div class="setup-grid">
                    <a href="{{ route('categories.index') }}" class="setup-card setup-card-blue">
                        <span class="setup-icon"><i class="fa-solid fa-layer-group"></i></span>
                        <strong>{{ $totalCategories }}</strong>
                        <h3>Categories</h3>
                        <p>Organize members by group and membership type.</p>
                        <i class="setup-arrow fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    <a href="{{ route('levels.index') }}" class="setup-card setup-card-orange">
                        <span class="setup-icon"><i class="fa-solid fa-medal"></i></span>
                        <strong>{{ $totalLevels }}</strong>
                        <h3>Membership levels</h3>
                        <p>Manage fees, validity periods, and benefits.</p>
                        <i class="setup-arrow fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
            </section>
        </div>

        <div class="dashboard-secondary-column">
            <section class="pulse-panel">
                <div class="panel-heading"><div><span class="eyebrow">MEMBERSHIP PULSE</span><h2>Current member health</h2></div><span class="pulse-dot"></span></div>
                <div class="pulse-number">{{ $activeRate }}<small>%</small></div>
                <p class="panel-muted">of members are currently active</p>
                <div class="progress-track"><span style="width: {{ $activeRate }}%"></span></div>
                <div class="pulse-breakdown"><div><strong>{{ $activeMembers }}</strong><small>Active</small></div><div><strong>{{ $inactiveMembers }}</strong><small>Inactive</small></div></div>
            </section>

            <section class="quick-panel">
                <span class="eyebrow">MAKE YOUR NEXT MOVE</span>
                <h2>A little admin.<br><span>A more organized day.</span></h2>
                <a href="{{ route('transactions.create') }}" class="quick-action quick-action-highlight"><span><strong>Create a transaction</strong><small>Start an application or renewal.</small></span><i class="fa-solid fa-plus"></i></a>
                <a href="{{ route('members.index') }}" class="quick-action"><span><strong>Manage your members</strong><small>Search, update, and review records.</small></span><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
            </section>
        </div>
    </section>

    <section class="recent-panel">
        <div class="panel-heading"><div><span class="eyebrow">ACTIVITY</span><h2>Recent transactions</h2></div><a href="{{ route('transactions.index') }}" class="text-link">View all <i class="fa-solid fa-arrow-right"></i></a></div>
        <div class="mini-table-wrap">
            <table class="data-table mini-table">
                <thead><tr><th>Reference</th><th>Member</th><th>Type</th><th>Amount</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recentTransactions as $transaction)
                        <tr>
                            <td><a class="record-link" href="{{ route('transactions.show', $transaction) }}">{{ $transaction->transaction_no }}</a></td>
                            <td>{{ optional($transaction->member)->full_name ?? 'Unknown member' }}</td>
                            <td>{{ ucfirst($transaction->transaction_type) }}</td>
                            <td>₱{{ number_format($transaction->amount, 2) }}</td>
                            <td><span class="status-pill status-{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty-state">No transactions have been recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
