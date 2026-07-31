<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Bottle Management')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('styles')

    <!-- Optional: custom overrides for a more polished look -->
    <style>
        .navbar-brand { font-weight: 600; letter-spacing: -0.5px; }
        .nav-link i { margin-right: 6px; width: 1.2em; text-align: center; }
        .dropdown-item i { width: 1.8em; }
        .flash-message { animation: fadeInDown 0.3s ease; }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Sticky footer (optional) */
        main { min-height: 80vh; }
    </style>
</head>
<body>

    <!-- Fixed top navbar for better navigation -->
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                ♻️ Bottle Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left side navigation -->
                <ul class="navbar-nav me-auto">

                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>

                    {{-- Administration dropdown (only for users with proper permissions) --}}
                    @canany(['view users', 'view roles', 'view permissions'])
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'active' : '' }}"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog"></i> Administration
                            </a>
                            <ul class="dropdown-menu">
                                @can('view users')
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                           href="{{ route('users.index') }}">
                                            <i class="fas fa-users-cog"></i> User Management
                                        </a>
                                    </li>
                                @endcan
                                @can('view roles')
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                                           href="{{ route('roles.index') }}">
                                            <i class="fas fa-user-tag"></i> Roles & Permissions
                                        </a>
                                    </li>
                                @endcan
                                @can('view permissions')
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}"
                                           href="{{ route('permissions.index') }}">
                                            <i class="fas fa-lock"></i> Permission List
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    {{-- Operations dropdown --}}
                    @canany(['view collections', 'view sales'])
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('collections.*') || request()->routeIs('sales.*') ? 'active' : '' }}"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-exchange-alt"></i> Operations
                            </a>
                            <ul class="dropdown-menu">
                                @can('view collections')
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('collections.*') ? 'active' : '' }}"
                                           href="{{ route('collections.index') }}">
                                            <i class="fas fa-recycle"></i> Collections
                                        </a>
                                    </li>
                                @endcan
                                @can('view sales')
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('sales.*') ? 'active' : '' }}"
                                           href="{{ route('sales.index') }}">
                                            <i class="fas fa-truck"></i> Sales
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    {{-- Master Data dropdown --}}
                    @canany(['view collectors', 'view buyers', 'view bottle-types'])
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('collectors.*') || request()->routeIs('buyers.*') || request()->routeIs('bottle-types.*') ? 'active' : '' }}"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-database"></i> Master Data
                            </a>
                            <ul class="dropdown-menu">
                                @can('view collectors')
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('collectors.*') ? 'active' : '' }}"
                                           href="{{ route('collectors.index') }}">
                                            <i class="fas fa-users"></i> Collectors
                                        </a>
                                    </li>
                                @endcan
                                @can('view buyers')
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('buyers.*') ? 'active' : '' }}"
                                           href="{{ route('buyers.index') }}">
                                            <i class="fas fa-store"></i> Buyers
                                        </a>
                                    </li>
                                @endcan
                                @can('view bottle-types')
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('bottle-types.*') ? 'active' : '' }}"
                                           href="{{ route('bottle-types.index') }}">
                                            <i class="fas fa-boxes"></i> Bottle Types
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                </ul>

                <!-- Right side user menu -->
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fas fa-user-circle fa-lg"></i>
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                {{-- Optional: profile link --}}
                                {{-- <a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a> --}}
                                {{-- <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="py-4">
        <div class="container">
            <!-- Flash Messages with auto-dismiss and improved styling -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show flash-message" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show flash-message" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show flash-message" role="alert">
                    <i class="fas fa-times-circle me-2"></i> Please fix the following errors:
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Page content -->
            @yield('content')
        </div>
    </main>

    <!-- Optional footer (uncomment if needed) -->
    {{-- <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} Bottle Management – Built with ♥
        </div>
    </footer> --}}

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <!-- Auto-dismiss flash messages after 5 seconds (optional) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function (alert) {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                });
            }, 5000);
        });
    </script>
</body>
</html>
