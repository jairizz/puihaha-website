@extends('layouts.app')

@section('content')

<div class="form-container">

    <div class="page-label">MEMBERSHIP MANAGEMENT</div>

    <h1>Add Category</h1>

    <p class="form-description">
        Create a new membership category for your organization.
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

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <label for="name">Category Name</label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            placeholder="Example: Student Member"
            required
        >

        <label for="description">Description</label>

        <textarea
            id="description"
            name="description"
            rows="5"
            placeholder="Describe this membership category..."
        >{{ old('description') }}</textarea>

        <div class="form-actions">
            <button type="submit" class="primary-btn">
                <i class="fas fa-save"></i>
                Save Category
            </button>

            <a href="{{ route('categories.index') }}" class="secondary-btn">
                Cancel
            </a>
        </div>
    </form>

</div>

@endsection