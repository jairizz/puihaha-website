<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f4f7fc;
            padding:40px;
        }

        .container{
            max-width:900px;
            margin:auto;
        }

        .header{
            text-align:center;
            margin-bottom:30px;
        }

        .header h1{
            color:#2c3e50;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,.1);
            margin-bottom:20px;
        }

        label{
            font-weight:bold;
        }

        input, textarea{
            width:100%;
            padding:12px;
            margin-top:5px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:8px;
        }

        button{
            background:#3498db;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:8px;
            cursor:pointer;
        }

        button:hover{
            background:#2980b9;
        }

        .success{
            background:#d4edda;
            color:#155724;
            padding:12px;
            border-radius:8px;
            margin-bottom:15px;
        }

        .task-card{
            background:white;
            margin-top:15px;
            padding:20px;
            border-radius:12px;
            box-shadow:0 2px 8px rgba(0,0,0,.08);
        }

        .task-card h3{
            color:#2c3e50;
            margin-bottom:10px;
        }

        .status{
            display:inline-block;
            margin-top:10px;
            padding:5px 10px;
            border-radius:20px;
            background:#ffeaa7;
            color:#2d3436;
        }

        .no-task{
            text-align:center;
            color:#888;
            margin-top:20px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="header">
        <h1> Task Manager</h1>
        <p>Manage your daily tasks easily</p>
    </div>

    <div class="card">

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <label>Task Title</label>
            <input
                type="text"
                name="task_title"
                value="{{ old('task_title') }}"
                placeholder="Enter task title">

            @error('task_title')
                <p style="color:red">{{ $message }}</p>
            @enderror

            <label>Description</label>
            <textarea
                name="description"
                rows="4"
                placeholder="Task description">{{ old('description') }}</textarea>

            <button type="submit">
                Add Task
            </button>
        </form>

    </div>

    <h2>Saved Tasks</h2>

    @forelse($tasks as $task)

        <div class="task-card">
            <h3>{{ $task->task_title }}</h3>

            <p>
                {{ $task->description ?: 'No description provided.' }}
            </p>

            <span class="status">
                {{ $task->completed ? '✅ Completed' : '⌛ Not Completed' }}
            </span>
        </div>

    @empty

        <p class="no-task">
            No tasks have been added yet.
        </p>

    @endforelse

</div>

</body>
</html>