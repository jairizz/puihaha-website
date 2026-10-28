<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>

  <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<div class="navbar">
    <a href="/categories">Categories</a>
    <a href="/levels">Levels</a>
    <a href="/members">Members</a>
</div>

<div class="container">

    <div class="form-container">

        <h2>Add Membership Category</h2>

        <form action="{{ route('categories.store') }}" method="POST">

            @csrf

            <label>Name</label>
            <input type="text" name="name">

            <label>Description</label>
            <textarea name="description"></textarea>

            <button type="submit">
                Save Category
            </button>

        </form>

    </div>

</div>

</body>
</html>