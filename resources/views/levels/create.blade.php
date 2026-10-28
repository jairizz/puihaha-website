@extends('layouts.app')

@section('content')

<div class="form-container">

    <div class="page-label">MEMBERSHIP MANAGEMENT</div>

    <h1>Add Membership Level</h1>

    <p class="form-description">
        Create a membership plan with its fee, validity, and benefits.
    </p>

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

    <form action="{{ route('levels.store') }}" method="POST">
        @csrf

        <label for="name">Level Name</label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            placeholder="Example: Basic"
            required
        >

        <label for="fee">Membership Fee</label>

        <input
            type="number"
            id="fee"
            name="fee"
            value="{{ old('fee') }}"
            step="0.01"
            min="0"
            placeholder="100.00"
            required
        >

        <label for="validity_period">Validity Period</label>

        <input
            type="number"
            id="validity_period"
            name="validity_period"
            value="{{ old('validity_period') }}"
            min="1"
            placeholder="12"
            required
        >

        <label for="benefits">Benefits</label>

        <textarea
            id="benefits"
            name="benefits"
            rows="5"
            placeholder="Describe the benefits of this membership level..."
        >{{ old('benefits') }}</textarea>

        <div class="form-actions">
            <button type="submit" class="primary-btn">
                <i class="fas fa-save"></i>
                Save Level
            </button>

            <a href="{{ route('levels.index') }}" class="secondary-btn">
                Cancel
            </a>
        </div>
    </form>

</div>

@endsection