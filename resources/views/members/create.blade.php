@extends('layouts.app')

@section('content')
<div class="page-shell narrow-shell">
    <div class="back-link"><a href="{{ route('members.index') }}"><i class="fa-solid fa-arrow-left"></i> Back to members</a></div>
    <section class="form-card">
        <div class="form-heading"><span class="eyebrow">MEMBER MANAGEMENT</span><h1>Register a member</h1><p>Create a member profile and assign the appropriate category and membership level.</p></div>
        @include('partials.validation-errors')
        <form action="{{ route('members.store') }}" method="POST" class="form-grid">
            @csrf
            <div class="form-field"><label for="first_name">First name <span>*</span></label><input id="first_name" name="first_name" value="{{ old('first_name') }}" required></div>
            <div class="form-field"><label for="last_name">Last name <span>*</span></label><input id="last_name" name="last_name" value="{{ old('last_name') }}" required></div>
            <div class="form-field"><label for="email">Email address <span>*</span></label><input id="email" type="email" name="email" value="{{ old('email') }}" required></div>
            <div class="form-field"><label for="phone">Phone number</label><input id="phone" name="phone" value="{{ old('phone') }}" placeholder="09XX XXX XXXX"></div>
            <div class="form-field full-field"><label for="address">Address</label><textarea id="address" name="address" rows="3">{{ old('address') }}</textarea></div>
            <div class="form-field"><label for="category_id">Membership category <span>*</span></label><select id="category_id" name="category_id" required><option value="">Select category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
            <div class="form-field"><label for="level_id">Membership level <span>*</span></label><select id="level_id" name="level_id" required><option value="">Select level</option>@foreach($levels as $level)<option value="{{ $level->id }}" @selected(old('level_id') == $level->id)>{{ $level->name }} — ₱{{ number_format($level->fee, 2) }}</option>@endforeach</select></div>
            <div class="form-actions full-field"><button class="primary-btn" type="submit"><i class="fa-solid fa-user-plus"></i> Register member</button><a href="{{ route('members.index') }}" class="secondary-btn">Cancel</a></div>
        </form>
    </section>
</div>
@endsection
