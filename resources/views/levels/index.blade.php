<!DOCTYPE html>
<html>
<head>
    <title>Membership Levels</title>
</head>
<body>

<h2>Membership Levels</h2>

<a href="{{ route('levels.create') }}">
    Add Level
</a>

<br><br>

<table border="1" cellpadding="10">
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

</body>
</html>