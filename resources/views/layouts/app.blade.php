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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .navbar-brand { font-weight: 600; letter-spacing: -0.5px; }
        .nav-link i { margin-right: 6px; width: 1.2em; text-align: center; }
        .dropdown-item i { width: 1.8em; }
        .footer {
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 1rem 0;
            margin-top: auto;
        }
        .footer a { color: #6c757d; text-decoration: none; }
        .footer a:hover { color: #0d6efd; text-decoration: underline; }
    </style>
</head>
<body>

    <!-- Navbar (sticky-top) -->
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

                    {{-- Administration dropdown --}}
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
            <!-- Flash messages are now displayed via SweetAlert toasts -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <span class="text-muted">
                &copy; {{ date('Y') }} <a href="{{ route('dashboard') }}">SyncInfotech Pvt. Ltd.</a>.
                Built with <i class="fas fa-heart text-danger"></i> using Laravel & Bootstrap.
            </span>
            {{--  <span class="text-muted ms-3">
                <a href="#" onclick="event.preventDefault();">Privacy</a> &middot;
                <a href="#" onclick="event.preventDefault();">Terms</a>
            </span>  --}}
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <!-- SweetAlert Flash Messages Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle Laravel flash messages from session
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 4000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    timer: 5000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            @if ($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '• {{ $error }}\n';
                @endforeach
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMessages,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Got it!'
                });
            @endif

            // Optional: Add a global confirmation helper for delete actions
            window.confirmDelete = function (message, url, method = 'DELETE') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: message || "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        form.innerHTML = `@csrf @method('${method}')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };
        });
    </script>
</body>
</html>
