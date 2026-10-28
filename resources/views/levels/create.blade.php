<!DOCTYPE html>
<html>
<head>
    <title>Add Level</title>
</head>
<body>

<h2>Add Membership Level</h2>

<form action="{{ route('levels.store') }}" method="POST">
    @csrf

    <label>Level Name</label><br>
    <input type="text" name="name"><br><br>

    <label>Fee</label><br>
    <input type="number" step="0.01" name="fee"><br><br>

    <label>Validity Period</label><br>
    <input type="number" name="validity_period"><br><br>

    <label>Benefits</label><br>
    <textarea name="benefits"></textarea><br><br>

    <button type="submit">Save Level</button>
</form>

</body>
</html>