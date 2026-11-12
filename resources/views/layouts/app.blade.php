<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Puihaha Membership' }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=4">
</head>

<body>
    @auth
        <aside class="sidebar">
            <a href="{{ route('dashboard') }}" class="brand">
                <span class="brand-mark">P</span>
                <span class="brand-copy">
                    <strong>Puihaha</strong>
                    <small>Membership operations</small>
                </span>
            </a>

            <div class="sidebar-divider"></div>
            <p class="nav-caption">Workspace</p>

            <nav class="sidebar-menu" aria-label="Main navigation">
                <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-grid-2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('members.index') }}" class="menu-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Members</span>
                </a>
                <a href="{{ route('categories.index') }}" class="menu-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Categories</span>
                </a>
                <a href="{{ route('levels.index') }}" class="menu-link {{ request()->routeIs('levels.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-medal"></i>
                    <span>Membership Levels</span>
                </a>
                <a href="{{ route('transactions.index') }}" class="menu-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    <span>Transactions</span>
                </a>
                <a href="{{ route('payments.index') }}" class="menu-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet"></i>
                    <span>Payments</span>
                </a>
            </nav>

            <div class="sidebar-bottom">
                <div class="admin-chip">
                    <span class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span>
                        <strong>{{ auth()->user()->name }}</strong>
                        <small>Administrator</small>
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-link">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Sign out
                    </button>
                </form>
            </div>
        </aside>
    @endauth

    <main class="main-content {{ auth()->check() ? '' : 'guest-content' }}">
        @if (session('success'))
            <div class="flash flash-success">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flash flash-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
