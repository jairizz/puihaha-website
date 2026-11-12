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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=5-mobile">
</head>

<body>
    @auth
        <header class="mobile-topbar" id="mobile-topbar">
            <a href="{{ route('dashboard') }}" class="mobile-brand">
                <span class="brand-mark">P</span>
                <span>Puihaha</span>
            </a>
            <button type="button" class="mobile-menu-toggle" id="mobile-menu-toggle"
                    aria-label="Open navigation" aria-controls="app-sidebar" aria-expanded="false">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </header>
        <div class="sidebar-backdrop" id="sidebar-backdrop" aria-hidden="true" hidden></div>
        <aside class="sidebar" id="app-sidebar" aria-label="Main menu" tabindex="-1">
            <button type="button" class="sidebar-close" id="sidebar-close" aria-label="Close navigation">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
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
                    <i class="fa-solid fa-table-cells-large"></i>
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

    <main id="main-content" class="main-content {{ auth()->check() ? '' : 'guest-content' }}">
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

    @auth
        <script>
            (() => {
                const sidebar = document.getElementById('app-sidebar');
                const toggle = document.getElementById('mobile-menu-toggle');
                const close = document.getElementById('sidebar-close');
                const backdrop = document.getElementById('sidebar-backdrop');
                const main = document.getElementById('main-content');
                const topbar = document.getElementById('mobile-topbar');
                const mobile = window.matchMedia('(max-width: 960px)');
                let isOpen = false;

                function setMenu(open, restoreFocus = true) {
                    const wasOpen = isOpen;
                    isOpen = mobile.matches && open;
                    document.body.classList.toggle('navigation-open', isOpen);
                    toggle.setAttribute('aria-expanded', String(isOpen));
                    toggle.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
                    backdrop.hidden = !isOpen;
                    main.inert = isOpen;
                    topbar.inert = isOpen;

                    if (isOpen) {
                        sidebar.inert = false;
                        sidebar.setAttribute('role', 'dialog');
                        sidebar.setAttribute('aria-modal', 'true');
                        sidebar.removeAttribute('aria-hidden');
                        close.focus();
                    } else {
                        sidebar.removeAttribute('role');
                        sidebar.removeAttribute('aria-modal');
                    
                        if (mobile.matches && (wasOpen || sidebar.contains(document.activeElement)) && restoreFocus) {
                            toggle.focus();
                        }
                        sidebar.inert = mobile.matches;
                        if (mobile.matches) sidebar.setAttribute('aria-hidden', 'true');
                        else sidebar.removeAttribute('aria-hidden');
                    }
                }

                document.body.classList.add('mobile-nav-ready');
                setMenu(false);
                toggle.addEventListener('click', () => setMenu(!isOpen));
                close.addEventListener('click', () => setMenu(false));
                backdrop.addEventListener('click', () => setMenu(false));
                sidebar.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => { if (isOpen) setMenu(false); });
                });
                document.addEventListener('keydown', event => {
                    if (!isOpen) return;
                    if (event.key === 'Escape') {
                        event.preventDefault();
                        setMenu(false);
                    }
                    if (event.key === 'Tab') {
                        const items = [...sidebar.querySelectorAll('a[href], button:not([disabled]), [tabindex="0"]')]
                            .filter(item => item.getClientRects().length && !item.closest('[hidden]'));
                        const first = items[0];
                        const last = items[items.length - 1];
                        if (event.shiftKey && (document.activeElement === first || !sidebar.contains(document.activeElement))) {
                            event.preventDefault();
                            last?.focus();
                        } else if (!event.shiftKey && (document.activeElement === last || !sidebar.contains(document.activeElement))) {
                            event.preventDefault();
                            first?.focus();
                        }
                    }
                });
                mobile.addEventListener('change', () => setMenu(false));
            })();
        </script>
    @endauth

    <script>

        document.querySelectorAll('.table-wrapper, .mini-table-wrap').forEach(wrapper => {
            wrapper.setAttribute('tabindex', '0');
            wrapper.setAttribute('role', 'region');
            if (!wrapper.hasAttribute('aria-label')) wrapper.setAttribute('aria-label', 'Records table; scroll horizontally for more columns');
        });
    </script>
    @stack('scripts')
</body>
</html>