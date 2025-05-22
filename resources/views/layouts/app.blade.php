<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Pelayanan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar .nav-link:hover {
            color: #fff;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .content {
            padding: 20px;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="d-flex flex-column p-3">
                    <a href="{{ route('dashboard') }}" class="navbar-brand text-center mb-4">
                        Sistem Pelayanan
                    </a>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>

                        @if (auth()->user()->role == 'ADMIN')
                            <!-- Menu untuk Admin -->
                            <li class="nav-item">
                                <a href="{{ route('service.get-data') }}"
                                    class="nav-link {{ request()->routeIs('service*') ? 'active' : '' }}">
                                    <i class="fas fa-cogs me-2"></i> Data Pelayanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('staff.get-data') }}"
                                    class="nav-link {{ request()->routeIs('staff*') ? 'active' : '' }}">
                                    <i class="fas fa-users me-2"></i> Data Staff
                                </a>
                            </li>
                        @else
                            <!-- Menu untuk Staff -->
                            <li class="nav-item">
                                <a href="{{ route('register.get-data') }}"
                                    class="nav-link {{ request()->routeIs('register*') ? 'active' : '' }}">
                                    <i class="fas fa-user-friends me-2"></i> Data Pelanggan
                                </a>
                            </li>
                        @endif
                    </ul>
                    <hr>
                    <form action="{{ route('logout') }}" method="post" class="mt-auto">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                    <div class="container-fluid">
                        <span class="navbar-text">
                            Welcome, {{ auth()->user()->name }} ({{ auth()->user()->role }})
                        </span>
                    </div>
                </nav>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
