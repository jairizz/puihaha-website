@extends('layouts.app')

@section('content')

@php
    $totalMembers = $members->count();
    $activeMembers = $members->where('status', 'active')->count();
    $inactiveMembers = $totalMembers - $activeMembers;
    $activeRate = $totalMembers > 0
        ? round(($activeMembers / $totalMembers) * 100)
        : 0;
@endphp

<div class="dash-page">
    <header class="dash-header">
        <div>
            <span class="dash-eyebrow">MEMBERSHIP OPERATIONS HUB</span>
            <h1>Dashboard</h1>
            <p>Your membership community at a glance.</p>
        </div>

        <div class="dash-date">{{ now()->format('F d, Y') }}</div>
    </header>

    <div class="dash-main-grid">
        <div class="dash-left-column">
            <section class="dash-hero">
                <span class="dash-card-label">MEMBER SNAPSHOT</span>
                <div class="dash-hero-number">{{ $totalMembers }}</div>
                <h2>Total Members</h2>
                <p>Every member connected in one organized system.</p>

                <a href="{{ route('members.index') }}" class="dash-hero-link">
                    View member directory <span>↗</span>
                </a>
            </section>

            <section>
                <span class="dash-eyebrow">YOUR SETUP</span>
                <h2 class="dash-section-title">Membership building blocks</h2>

                <div class="dash-setup-grid">
                    <a href="{{ route('categories.index') }}"
                       class="dash-info-card dash-category-card">
                        <span class="dash-info-icon">▦</span>
                        <strong>{{ $categories->count() }}</strong>
                        <h3>Categories</h3>
                        <p>Groups your members belong to.</p>
                    </a>

                    <a href="{{ route('levels.index') }}"
                       class="dash-info-card dash-level-card">
                        <span class="dash-info-icon">☆</span>
                        <strong>{{ $levels->count() }}</strong>
                        <h3>Membership Levels</h3>
                        <p>Manage fees, validity, and benefits.</p>
                    </a>
                </div>
            </section>
        </div>

        <div class="dash-right-column">
            <section class="dash-pulse-card">
                <div class="dash-card-title">
                    <h2>Membership pulse</h2>
                    <span class="dash-status-dot"></span>
                </div>

                <div class="dash-pulse-number">
                    {{ $activeRate }}<small>%</small>
                </div>

                <p>of members are currently active</p>

                <div class="dash-progress">
                    <span style="width: {{ $activeRate }}%;"></span>
                </div>

                <div class="dash-pulse-stats">
                    <div>
                        <strong>{{ $activeMembers }}</strong>
                        <span>Active</span>
                    </div>

                    <div>
                        <strong>{{ $inactiveMembers }}</strong>
                        <span>Inactive</span>
                    </div>
                </div>
            </section>

            <section class="dash-actions-card">
                <span class="dash-card-label">QUICK ACTIONS</span>
                <h2>Keep things<br>organized.</h2>

                <a href="{{ route('members.create') }}"
                   class="dash-action-link dash-action-primary">
                    <span>
                        <strong>Register a member</strong>
                        <small>Add someone new.</small>
                    </span>
                    <b>+</b>
                </a>

                <a href="{{ route('members.index') }}" class="dash-action-link">
                    <span>
                        <strong>Manage your members</strong>
                        <small>Search, update, and review records.</small>
                    </span>
                    <b>↗</b>
                </a>
            </section>
        </div>
    </div>
</div>

@endsection
