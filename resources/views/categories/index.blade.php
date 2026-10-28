<!DOCTYPE html>
<html>
<head>
    <title>Membership Categories</title>

    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<div class="navbar">
    <a href="/categories">Categories</a>
    <a href="/levels">Levels</a>
    <a href="/members">Members</a>
</div>

<div class="container">

    <h2>Membership Categories</h2>

    <a href="{{ route('categories.create') }}"
       class="btn btn-primary">
       Add Category
    </a>

    <table>

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

</div>

</body>
</html>