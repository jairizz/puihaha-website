@extends('layouts.app')

@section('content')

<div class="form-container">
    <span class="page-label">MEMBERSHIP MANAGEMENT</span>
    <h1>Register Member</h1>
    <p class="form-description">Add a new member to your membership directory.</p>

    @if ($errors->any())
        <div class="form-alert">
            <strong>Please check the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('members.store') }}" method="POST">
        @csrf

        <label for="first_name">First Name</label>
        <input id="first_name" type="text" name="first_name"
               value="{{ old('first_name') }}" required>

        <label for="last_name">Last Name</label>
        <input id="last_name" type="text" name="last_name"
               value="{{ old('last_name') }}" required>

        <label for="email">Email Address</label>
        <input id="email" type="email" name="email"
               value="{{ old('email') }}" required>

        <label for="phone">Phone Number</label>
        <input id="phone" type="text" name="phone"
               value="{{ old('phone') }}">

        <label for="address">Address</label>
        <textarea id="address" name="address" rows="4">{{ old('address') }}</textarea>

        <label for="category_id">Membership Category</label>
        <select id="category_id" name="category_id" required>
            <option value="">Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label for="level_id">Membership Level</label>
        <select id="level_id" name="level_id" required>
            <option value="">Select a membership level</option>
            @foreach($levels as $level)
                <option value="{{ $level->id }}"
                    {{ old('level_id') == $level->id ? 'selected' : '' }}>
                    {{ $level->name }}
                </option>
            @endforeach
        </select>

        <div class="form-actions">
            <button type="submit" class="primary-btn">
                <i class="fas fa-user-plus"></i>
                Register Member
            </button>

            <a href="{{ route('members.index') }}" class="secondary-btn">Cancel</a>
        </div>
    </form>
</div>

@endsection
