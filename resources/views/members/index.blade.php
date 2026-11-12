@extends('layouts.app')

@section('content')
<div class="page-shell">
    <header class="page-header"><div><span class="eyebrow">MEMBER MANAGEMENT</span><h1>Member directory</h1><p>Register, search, and maintain your membership records.</p></div><a href="{{ route('members.create') }}" class="primary-btn"><i class="fa-solid fa-user-plus"></i> Add member</a></header>

    <section class="table-card">
        <div class="table-toolbar"><div><h2>All members</h2><span>{{ $members->total() }} registered records</span></div><div class="toolbar-controls"><form method="GET" action="{{ route('members.index') }}" class="search-form"><i class="fa-solid fa-magnifying-glass"></i><input name="search" value="{{ $search }}" placeholder="Search name, category, or level"><input type="hidden" name="status" value="{{ $status }}"><button type="submit">Search</button></form><form method="GET" action="{{ route('members.index') }}"><select name="status" onchange="this.form.submit()"><option value="">All statuses</option><option value="active" @selected($status === 'active')>Active</option><option value="inactive" @selected($status === 'inactive')>Inactive</option></select></form></div></div>
        <div class="table-wrapper"><table class="data-table"><thead><tr><th>Membership no.</th><th>Member</th><th>Contact</th><th>Category</th><th>Level</th><th>Status</th><th></th></tr></thead><tbody>
            @forelse($members as $member)
                <tr>
                    <td><a class="record-link" href="{{ route('members.show', $member) }}">{{ $member->membership_no }}</a></td>
                    <td><strong>{{ $member->full_name }}</strong></td>
                    <td><span>{{ $member->email }}</span><small class="cell-subtext">{{ $member->phone ?: 'No phone number' }}</small></td>
                    <td><span class="category-badge">{{ optional($member->category)->name ?? 'Unassigned' }}</span></td>
                    <td><span class="level-badge">{{ optional($member->level)->name ?? 'Unassigned' }}</span></td>
                    <td><span class="status-pill status-{{ $member->status }}">{{ ucfirst($member->status) }}</span></td>
                    <td><a href="{{ route('members.show', $member) }}" class="icon-btn" title="View member"><i class="fa-solid fa-chevron-right"></i></a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty-state"><i class="fa-regular fa-folder-open"></i><strong>No members found</strong><span>Try another search or register a new member.</span></td></tr>
            @endforelse
        </tbody></table></div>
        @if($members->hasPages())<div class="pagination-wrap">{{ $members->links() }}</div>@endif
    </section>
</div>
@endsection
