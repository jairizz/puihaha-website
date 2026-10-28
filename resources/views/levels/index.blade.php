@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <div class="page-label">MEMBERSHIP MANAGEMENT</div>
        <h1>Membership Levels</h1>
        <p>Manage membership plans, fees, validity, and benefits.</p>
    </div>

    <a href="{{ route('levels.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i>
        Add Level
    </a>
</div>

<div class="table-card">

    <div class="table-heading">
        <div>
            <h2>Membership Level Directory</h2>
            <span>All available membership plans</span>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Fee</th>
                    <th>Validity</th>
                    <th>Benefits</th>
                </tr>
            </thead>

            <tbody>
                @forelse($levels as $level)
                    <tr>
                        <td class="record-id">
                            #{{ $level->id }}
                        </td>

                        <td>
                            <span class="level-badge">
                                {{ $level->name }}
                            </span>
                        </td>

                        <td>
                            <strong>₱{{ number_format($level->fee, 2) }}</strong>
                        </td>

                        <td>
                            {{ $level->validity_period }} months
                        </td>

                        <td>
                            {{ $level->benefits ?: 'No benefits listed' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            No membership levels found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection