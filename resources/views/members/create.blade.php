<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>
</head>
<body>

<h2>Add Member</h2>

<form action="{{ route('members.store') }}" method="POST">
    @csrf

    <label>First Name</label><br>
    <input type="text" name="first_name"><br><br>

    <label>Last Name</label><br>
    <input type="text" name="last_name"><br><br>

    <label>Email</label><br>
    <input type="email" name="email"><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone"><br><br>

    <label>Address</label><br>
    <textarea name="address"></textarea><br><br>

    <label>Category</label><br>
    <select name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Level</label><br>
    <select name="level_id">
        @foreach($levels as $level)
            <option value="{{ $level->id }}">
                {{ $level->name }}
            </option>
        @endforeach
    </select><br><br>

    <button type="submit">
        Save Member
    </button>
</form>

</body>
</html>