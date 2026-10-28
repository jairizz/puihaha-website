@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <div class="page-label">MEMBERSHIP MANAGEMENT</div>
        <h1>Members</h1>
        <p>Manage and monitor all registered members.</p>
    </div>

    <a href="{{ route('members.create') }}" class="primary-btn">
        <i class="fas fa-user-plus"></i>
        Add Member
    </a>
</div>

<div class="table-card">

    <div class="table-heading">
        <div>
            <h2>Member Directory</h2>
            <span>All registered membership records</span>
        </div>

        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search members...">
        </div>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Membership No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Category</th>
                    <th>Level</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td class="member-number">
                            {{ $member->membership_no }}
                        </td>

                        <td>
                            <strong>
                                {{ $member->first_name }}
                                {{ $member->last_name }}
                            </strong>
                        </td>

                        <td>
                            {{ $member->email }}
                        </td>

                        <td>
                            <span class="category-badge">
                                {{ optional($member->category)->name ?? 'Unassigned' }}
                            </span>
                        </td>

                        <td>
                            <span class="level-badge">
                                {{ optional($member->level)->name ?? 'Unassigned' }}
                            </span>
                        </td>

                        <td>
                            <span class="status-badge">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No members found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection