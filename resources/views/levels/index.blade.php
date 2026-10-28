<!DOCTYPE html>
<html>
<head>
    <title>Membership Levels</title>

    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<div class="navbar">
    <a href="/categories">Categories</a>
    <a href="/levels">Levels</a>
    <a href="/members">Members</a>
</div>

<div class="container">

    <h2>Membership Levels</h2>

    <a href="{{ route('levels.create') }}"
       class="btn btn-primary">
       Add Level
    </a>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Fee</th>
            <th>Validity</th>
            <th>Benefits</th>
        </tr>

        @foreach($levels as $level)

        <tr>
            <td>{{ $level->id }}</td>
            <td>{{ $level->name }}</td>
            <td>{{ $level->fee }}</td>
            <td>{{ $level->validity_period }}</td>
            <td>{{ $level->benefits }}</td>
        </tr>

        @endforeach

    </table>

</div>

</body>
</html>