<!DOCTYPE html>
<html>
<head>
    <title>Members</title>
</head>
<body>

<h2>Members List</h2>

<a href="{{ route('members.create') }}">
    Add Member
</a>

<br><br>

<table border="1" cellpadding="10">

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
    <td>{{ $member->first_name }} {{ $member->last_name }}</td>
    <td>{{ $member->email }}</td>
    <td>{{ $member->category->name }}</td>
    <td>{{ $member->level->name }}</td>
    <td>{{ $member->status }}</td>
</tr>

@endforeach

</table>

</body>
</html>