@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <div class="page-label">MEMBERSHIP MANAGEMENT</div>
        <h1>Membership Categories</h1>
        <p>Organize and manage different types of members.</p>
    </div>

    <a href="{{ route('categories.create') }}" class="primary-btn">
        <i class="fas fa-plus"></i>
        Add Category
    </a>
</div>

<div class="table-card">
    <div class="table-heading">
        <div>
            <h2>Category Directory</h2>
            <span>All available membership categories</span>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="record-id">
                            #{{ $category->id }}
                        </td>

                        <td>
                            <strong>{{ $category->name }}</strong>
                        </td>

                        <td>
                            {{ $category->description ?: 'No description provided' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection