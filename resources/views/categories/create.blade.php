<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>

<h2>Add Membership Category</h2>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <label>Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit">Save Category</button>
</form>

</body>
</html>