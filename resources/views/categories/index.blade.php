<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>

<h2>Membership Categories</h2>

<a href="{{ route('categories.create') }}">
    Add Category
</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
    </tr>

    @foreach($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>{{ $category->name }}</td>
        <td>{{ $category->description }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>