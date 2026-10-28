<!DOCTYPE html>
<html>
<head>
    <title>Members</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="navbar">
    <a href="/categories">Categories</a>
    <a href="/levels">Levels</a>
    <a href="/members">Members</a>
</div>

<div class="container">

    <h2>Members List</h2>

    <a href="{{ route('members.create') }}"
       class="btn btn-primary">
       Add Member
    </a>

    <table>

        <tr>
            <th>Membership No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Category</th>
            <th>Level</th>
            <th>Status</th>
        </tr>

        @foreach($members as $member)

        <tr>
            <td>{{ $member->membership_no }}</td>
            <td>{{ $member->first_name }}
                {{ $member->last_name }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->category->name }}</td>
            <td>{{ $member->level->name }}</td>
            <td>{{ $member->status }}</td>
        </tr>

        @endforeach

    </table>

</div>

</body>
</html>