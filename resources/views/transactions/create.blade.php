@extends('layouts.app')

@section('content')
<div class="page-shell narrow-shell"><div class="back-link"><a href="{{ route('transactions.index') }}"><i class="fa-solid fa-arrow-left"></i> Back to transactions</a></div><section class="form-card"><div class="form-heading"><span class="eyebrow">TRANSACTION PROCESSING</span><h1>Create transaction</h1><p>Start a new membership application or process a renewal.</p></div>@include('partials.validation-errors')<form action="{{ route('transactions.store') }}" method="POST" class="form-grid">@csrf<div class="form-field full-field"><label for="member_id">Member <span>*</span></label><select id="member_id" name="member_id" required><option value="">Select member</option>@foreach($members as $member)<option value="{{ $member->id }}" @selected(old('member_id', request('member_id')) == $member->id)>{{ $member->full_name }} — {{ $member->membership_no }}</option>@endforeach</select></div><div class="form-field"><label for="transaction_type">Transaction type <span>*</span></label><select id="transaction_type" name="transaction_type" required><option value="application" @selected(old('transaction_type') === 'application')>New application</option><option value="renewal" @selected(old('transaction_type') === 'renewal')>Renewal</option></select></div><div class="form-field"><label for="membership_level_id">Membership level <span>*</span></label><select id="membership_level_id" name="membership_level_id" required><option value="">Select level</option>@foreach($levels as $level)<option value="{{ $level->id }}" data-fee="{{ $level->fee }}" @selected(old('membership_level_id') == $level->id)>{{ $level->name }} — ₱{{ number_format($level->fee, 2) }}</option>@endforeach</select></div><div class="form-field"><label for="amount">Amount due <span>*</span></label><input id="amount" type="number" name="amount" value="{{ old('amount') }}" min="0.01" step="0.01" required></div><div class="form-field full-field"><label for="notes">Notes</label><textarea id="notes" name="notes" rows="4" placeholder="Add relevant application or renewal notes...">{{ old('notes') }}</textarea></div><div class="form-actions full-field"><button class="primary-btn" type="submit"><i class="fa-solid fa-file-circle-plus"></i> Create transaction</button><a href="{{ route('transactions.index') }}" class="secondary-btn">Cancel</a></div></form></section></div>
@endsection

@push('scripts')
<script>
    document.getElementById('membership_level_id')?.addEventListener('change', function () {
        const fee = this.options[this.selectedIndex]?.dataset.fee;
        if (fee) document.getElementById('amount').value = fee;
    });
</script>
@endpush
