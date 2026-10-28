<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Puihaha Membership' }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=3">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="app-shell">
        <aside class="sidebar">
            <div class="logo">
                <div class="logo-circle">P</div>

                <div>
                    <h2>Puihaha</h2>
                    <p>Membership Management System</p>
                </div>
            </div>

            <nav class="sidebar-menu" aria-label="Main navigation">
                <a href="{{ route('dashboard') }}"
                   class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('members.index') }}"
                   class="menu-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                    <i class="fas fa-user-group"></i>
                    <span>Members</span>
                </a>

                <a href="{{ route('categories.index') }}"
                   class="menu-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i>
                    <span>Categories</span>
                </a>

                <a href="{{ route('levels.index') }}"
                   class="menu-link {{ request()->routeIs('levels.*') ? 'active' : '' }}">
                    <i class="fas fa-crown"></i>
                    <span>Membership Levels</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <strong>Puihaha Membership</strong>
                Membership records made simple.
            </div>
        </aside>

        <main class="main-content">
            @if (session('success'))
                <div class="form-alert" style="border-color:#b8e3d0;background:#effaf4;color:#2d7d61;">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>
