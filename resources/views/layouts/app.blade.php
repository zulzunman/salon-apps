<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Pelayanan - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('app/layout.css') }}">
    @yield('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="sidebar-header">
                    <div class="brand-logo">
                        <i class="fas fa-cut brand-icon"></i>
                        <div class="brand-text">
                            <h4 class="brand-title">Beauty Salon</h4>
                            <small class="brand-subtitle">Management System</small>
                        </div>
                    </div>
                    <div class="user-profile">
                        <div class="user-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span
                                class="role-badge {{ Auth::user()->role == 'STAFF' ? 'staff' : (Auth::user()->role == 'CASHIER' ? 'cashier' : 'admin') }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <nav class="sidebar-nav">
                    <ul class="nav flex-column">
                        <!-- Dashboard - Untuk semua role -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        @if (auth()->user()->role === 'ADMIN')
                            <!-- Menu untuk Admin -->
                            <li class="nav-item">
                                <a href="{{ route('service.get-data') }}"
                                    class="nav-link {{ request()->routeIs('service*') ? 'active' : '' }}">
                                    <i class="fas fa-spa"></i>
                                    <span>Data Pelayanan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('staff.get-data') }}"
                                    class="nav-link {{ request()->routeIs('staff.get-data') ? 'active' : '' }}">
                                    <i class="fas fa-users-cog"></i>
                                    <span>Data Staff</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('staff.reporting') }}"
                                    class="nav-link {{ request()->routeIs('staff.reporting') ? 'active' : '' }}">
                                    <i class="fas fa-chart-pie"></i>
                                    <span>Report</span>
                                </a>
                            </li>
                        @elseif (auth()->user()->role === 'STAFF')
                            <!-- Menu untuk Staff -->
                            <li class="nav-item">
                                <a href="{{ route('register.get-data') }}"
                                    class="nav-link {{ request()->routeIs('register*') ? 'active' : '' }}">
                                    <i class="fas fa-user-friends"></i>
                                    <span>Data Pelanggan</span>
                                </a>
                            </li>
                        @elseif (auth()->user()->role === 'CASHIER')
                            <!-- Menu untuk Cashier -->
                            <li class="nav-item">
                                <a href="{{ route('register.get-data') }}"
                                    class="nav-link {{ request()->routeIs('register*') ? 'active' : '' }}">
                                    <i class="fas fa-user-friends"></i>
                                    <span>Data Pelanggan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('staff.reporting') }}"
                                    class="nav-link {{ request()->routeIs('staff.reporting') ? 'active' : '' }}">
                                    <i class="fas fa-chart-pie"></i>
                                    <span>Report</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>

            <!-- Content -->
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light top-navbar mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link home-link" href="{{ route('dashboard') }}">
                                        <i class="fas fa-home"></i> Home
                                    </a>
                                </li>
                            </ul>
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle user-dropdown" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown">
                                        <div class="user-avatar-small">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                        <span class="user-name-nav">{{ Auth::user()->name }}</span>
                                        <small class="text-muted">({{ ucfirst(Auth::user()->role) }})</small>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu"
                                        aria-labelledby="navbarDropdown">
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item logout-btn">
                                                    <i class="fas fa-sign-out-alt"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid main-content">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show custom-alert success-alert"
                            role="alert">
                            <i class="fas fa-check-circle alert-icon"></i>
                            <span>{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show custom-alert error-alert"
                            role="alert">
                            <i class="fas fa-exclamation-circle alert-icon"></i>
                            <span>{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show custom-alert warning-alert"
                            role="alert">
                            <i class="fas fa-exclamation-triangle alert-icon"></i>
                            <span>{{ session('warning') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show custom-alert error-alert"
                            role="alert">
                            <i class="fas fa-exclamation-circle alert-icon"></i>
                            <ul class="mb-0 mt-2 error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Auto hide alerts after 5 seconds -->
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });

        // Add smooth scrolling and hover effects
        $(document).ready(function() {
            // Smooth transitions for nav links
            $('.nav-link').on('mouseenter', function() {
                $(this).addClass('nav-link-hover');
            }).on('mouseleave', function() {
                $(this).removeClass('nav-link-hover');
            });

            // Add floating animation to cards
            $('.card-dashboard').hover(
                function() {
                    $(this).addClass('card-float');
                },
                function() {
                    $(this).removeClass('card-float');
                }
            );
        });
    </script>

    @yield('scripts')
</body>

</html>
