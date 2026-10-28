<!DOCTYPE html>
<html>
<head>
    <title>Add Level</title>

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

        <h2>Add Membership Level</h2>

        <form action="{{ route('levels.store') }}" method="POST">

            @csrf

            <label>Level Name</label>
            <input type="text" name="name">

            <label>Fee</label>
            <input type="number"
                   step="0.01"
                   name="fee">

            <label>Validity Period</label>
            <input type="number"
                   name="validity_period">

            <label>Benefits</label>
            <textarea name="benefits"></textarea>

            <button type="submit">
                Save Level
            </button>

        </form>

    </div>

</div>

</body>
</html>