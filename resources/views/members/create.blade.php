<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="navbar">
    <a href="/categories">Categories</a>
    <a href="/levels">Levels</a>
    <a href="/members">Members</a>
</div>

<div class="container">

    <div class="form-container">

        <h2>Member Registration</h2>

        <form action="{{ route('members.store') }}"
              method="POST">

            @csrf

            <label>First Name</label>
            <input type="text"
                   name="first_name">

            <label>Last Name</label>
            <input type="text"
                   name="last_name">

            <label>Email</label>
            <input type="email"
                   name="email">

            <label>Phone</label>
            <input type="text"
                   name="phone">

            <label>Address</label>
            <textarea name="address"></textareagory)

                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>

                @endforeach

            </select>

            <label>Membership Level</label>

            <select name="level_id">

                @foreach($levels as $level)

                <option value="{{ $level->id }}">
                    {{ $level->name }}
                </option>

                @endforeach

            </select>

            <button type="submit">
                Save Member
            </button>

        </form>

    </div>

</div>

</body>
</html>