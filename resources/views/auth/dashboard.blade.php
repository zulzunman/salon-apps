@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <span class="badge bg-secondary">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    <div class="row">
        @if (auth()->user()->role == 'ADMIN')
            <!-- Dashboard untuk Admin -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card card-dashboard border-left-primary h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    <i class="fas fa-cogs me-2"></i>Total Pelayanan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ App\Models\Service::count() }}
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Jenis pelayanan yang tersedia</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cogs fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('service.get-data') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card card-dashboard border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    <i class="fas fa-users me-2"></i>Total Staff
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ App\Models\User::where('role', 'STAFF')->count() }}
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Staff yang terdaftar dalam sistem</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('staff.get-data') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Summary Cards -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar me-2"></i>Ringkasan Sistem
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <div class="p-3">
                                    <i class="fas fa-user-friends fa-2x text-info mb-2"></i>
                                    <h5>{{ App\Models\Registration::count() }}</h5>
                                    <small class="text-muted">Total Registrasi</small>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="p-3">
                                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                    <h5>{{ App\Models\Registration::where('status', 'PENDING')->count() }}</h5>
                                    <small class="text-muted">Menunggu</small>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="p-3">
                                    <i class="fas fa-phone fa-2x text-info mb-2"></i>
                                    <h5>{{ App\Models\Registration::where('status', 'CALLING')->count() }}</h5>
                                    <small class="text-muted">Dipanggil</small>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="p-3">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                    <h5>{{ App\Models\Registration::where('status', 'COMPLETED')->count() }}</h5>
                                    <small class="text-muted">Selesai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Dashboard untuk Staff -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card card-dashboard border-left-warning h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    <i class="fas fa-clock me-2"></i>Menunggu
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ App\Models\Registration::where('status', 'PENDING')->count() }}
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Pelanggan dalam antrian</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('register.get-data') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card card-dashboard border-left-info h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    <i class="fas fa-phone me-2"></i>Dipanggil
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ App\Models\Registration::where('status', 'CALLING')->count() }}
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Pelanggan sedang dipanggil</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-phone fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('register.get-data') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card card-dashboard border-left-primary h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    <i class="fas fa-handshake me-2"></i>Dilayani
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ App\Models\Registration::where('status', 'SERVING')->count() }}
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span>Pelanggan sedang dilayani</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-handshake fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('register.get-data') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff Activity Summary -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-line me-2"></i>Aktivitas Hari Ini
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-left-success mb-3">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Selesai Hari Ini
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ App\Models\Registration::where('status', 'COMPLETED')->whereDate('updated_at', today())->count() }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-left-secondary mb-3">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                    Total Registrasi
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ App\Models\Registration::count() }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-friends fa-2x text-secondary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Actions Section -->
@endsection

@section('scripts')
    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-secondary {
            border-left: 0.25rem solid #858796 !important;
        }

        .text-xs {
            font-size: 0.7rem;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        .btn-block {
            display: block;
            width: 100%;
        }
    </style>
@endsection
