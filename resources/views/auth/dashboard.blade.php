@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Header dengan Salon Beauty Theme -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-4 mb-4">
        <div>
            <h1 class="page-title gradient-text">
                <i class="fas fa-tachometer-alt me-3 icon-pulse"></i>Dashboard
            </h1>
            <p class="page-subtitle">Selamat datang di sistem manajemen salon kecantikan</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <span class="badge badge-primary shimmer">
                    <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('d M Y') }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        @if (auth()->user()->role == 'ADMIN')
            <!-- Dashboard untuk Admin -->
            <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
                <div class="stat-card slide-up">
                    <div class="stat-icon">
                        <i class="fas fa-cogs icon-bounce"></i>
                    </div>
                    <div class="stat-number">{{ App\Models\Service::count() }}</div>
                    <div class="stat-label">Total Pelayanan</div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Jenis pelayanan yang tersedia</small>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <a href="{{ route('service.get-data') }}" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>Lihat Data
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
                <div class="stat-card slide-up" style="animation-delay: 0.1s;">
                    <div class="stat-icon">
                        <i class="fas fa-users icon-pulse"></i>
                    </div>
                    <div class="stat-number">{{ App\Models\User::where('role', 'STAFF')->count() }}</div>
                    <div class="stat-label">Total Staff</div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Staff yang terdaftar dalam sistem</small>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <a href="{{ route('staff.get-data') }}" class="btn btn-success">
                            <i class="fas fa-eye me-2"></i>Lihat Data
                        </a>
                    </div>
                </div>
            </div>

            <!-- Admin Summary Cards -->
            <div class="col-12 mb-4">
                <div class="card-dashboard slide-up" style="animation-delay: 0.2s;">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="stat-icon me-3" style="font-size: 2rem;">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div>
                                <h5 class="gradient-text mb-0">Ringkasan Sistem</h5>
                                <small class="text-muted">Status keseluruhan registrasi</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-6 mb-3">
                                <div class="glass-card p-4 text-center h-100">
                                    <div class="status-indicator active mb-2"></div>
                                    <i class="fas fa-user-friends fa-2x text-primary mb-3 icon-bounce"></i>
                                    <h4 class="gradient-text mb-2">{{ App\Models\Registration::count() }}</h4>
                                    <small class="text-muted fw-bold">Total Registrasi</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="glass-card p-4 text-center h-100">
                                    <div class="status-indicator pending mb-2"></div>
                                    <i class="fas fa-clock fa-2x text-warning mb-3 icon-pulse"></i>
                                    <h4 class="gradient-text mb-2">
                                        {{ App\Models\Registration::where('status', 'PENDING')->count() }}</h4>
                                    <small class="text-muted fw-bold">Menunggu</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="glass-card p-4 text-center h-100">
                                    <div class="status-indicator active mb-2"></div>
                                    <i class="fas fa-phone fa-2x text-info mb-3 icon-bounce"></i>
                                    <h4 class="gradient-text mb-2">
                                        {{ App\Models\Registration::where('status', 'CALLING')->count() }}</h4>
                                    <small class="text-muted fw-bold">Dipanggil</small>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <div class="glass-card p-4 text-center h-100">
                                    <div class="status-indicator active mb-2"></div>
                                    <i class="fas fa-check-circle fa-2x text-success mb-3 icon-pulse"></i>
                                    <h4 class="gradient-text mb-2">
                                        {{ App\Models\Registration::where('status', 'COMPLETED')->count() }}</h4>
                                    <small class="text-muted fw-bold">Selesai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Dashboard untuk Staff -->
            <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                <div class="stat-card slide-up">
                    <div class="stat-icon">
                        <i class="fas fa-clock icon-pulse"></i>
                    </div>
                    <div class="stat-number">{{ App\Models\Registration::where('status', 'PENDING')->count() }}</div>
                    <div class="stat-label">Menunggu</div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Pelanggan dalam antrian</small>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <a href="{{ route('register.get-data') }}" class="btn btn-warning text-dark">
                            <i class="fas fa-eye me-2"></i>Lihat Data
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                <div class="stat-card slide-up" style="animation-delay: 0.1s;">
                    <div class="stat-icon">
                        <i class="fas fa-phone icon-bounce"></i>
                    </div>
                    <div class="stat-number">{{ App\Models\Registration::where('status', 'CALLING')->count() }}</div>
                    <div class="stat-label">Dipanggil</div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Pelanggan sedang dipanggil</small>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <a href="{{ route('register.get-data') }}" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>Lihat Data
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12 mb-4">
                <div class="stat-card slide-up" style="animation-delay: 0.2s;">
                    <div class="stat-icon">
                        <i class="fas fa-handshake icon-pulse"></i>
                    </div>
                    <div class="stat-number">{{ App\Models\Registration::where('status', 'SERVING')->count() }}</div>
                    <div class="stat-label">Dilayani</div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">Pelanggan sedang dilayani</small>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        <a href="{{ route('register.get-data') }}" class="btn btn-success">
                            <i class="fas fa-eye me-2"></i>Lihat Data
                        </a>
                    </div>
                </div>
            </div>

            <!-- Staff Activity Summary -->
            <div class="col-12 mb-4">
                <div class="card-dashboard slide-up" style="animation-delay: 0.3s;">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="stat-icon me-3" style="font-size: 2rem;">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h5 class="gradient-text mb-0">Aktivitas Hari Ini</h5>
                                <small class="text-muted">Ringkasan pekerjaan staff</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <div class="glass-card p-4">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="stat-icon me-3" style="font-size: 2.5rem;">
                                                <i class="fas fa-check-circle icon-bounce"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Selesai Hari Ini
                                            </div>
                                            <div class="h4 mb-0 gradient-text">
                                                {{ App\Models\Registration::where('status', 'COMPLETED')->whereDate('updated_at', today())->count() }}
                                            </div>
                                            <small class="text-muted">Pelanggan yang telah dilayani</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-3">
                                <div class="glass-card p-4">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="stat-icon me-3" style="font-size: 2.5rem;">
                                                <i class="fas fa-user-friends icon-pulse"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                Total Registrasi
                                            </div>
                                            <div class="h4 mb-0 gradient-text">
                                                {{ App\Models\Registration::count() }}
                                            </div>
                                            <small class="text-muted">Keseluruhan data registrasi</small>
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
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-dashboard slide-up" style="animation-delay: 0.4s;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="stat-icon me-3" style="font-size: 2rem;">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <h5 class="gradient-text mb-0">Aksi Cepat</h5>
                            <small class="text-muted">Fitur yang sering digunakan</small>
                        </div>
                    </div>

                    <div class="row">
                        @if (auth()->user()->role == 'ADMIN')
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('service.get-data') }}"
                                    class="btn btn-primary w-100 p-3 beauty-border">
                                    <i class="fas fa-cogs fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Kelola Layanan</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('staff.get-data') }}" class="btn btn-success w-100 p-3 beauty-border">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Kelola Staff</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('register.get-data') }}"
                                    class="btn btn-warning text-dark w-100 p-3 beauty-border">
                                    <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Data Registrasi</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="#" class="btn btn-secondary w-100 p-3 beauty-border">
                                    <i class="fas fa-chart-bar fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Laporan</span>
                                </a>
                            </div>
                        @else
                            <div class="col-lg-4 col-md-6 mb-3">
                                <a href="{{ route('register.get-data') }}"
                                    class="btn btn-primary w-100 p-3 beauty-border">
                                    <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Kelola Antrian</span>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <a href="#" class="btn btn-success w-100 p-3 beauty-border">
                                    <i class="fas fa-user-check fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Layani Pelanggan</span>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-12 mb-3">
                                <a href="#" class="btn btn-warning text-dark w-100 p-3 beauty-border">
                                    <i class="fas fa-history fa-2x mb-2 d-block"></i>
                                    <span class="fw-bold">Riwayat Layanan</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        /* Additional Custom Styles untuk Dashboard */
        .text-xs {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Enhanced Button Styles */
        .btn {
            border-radius: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Progress Indicators */
        .progress-ring {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: conic-gradient(var(--primary-color) 70%, #e9ecef 70%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--text-dark);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .stat-card {
                margin-bottom: 1.5rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .stat-icon {
                font-size: 2.5rem;
            }

            .glass-card {
                padding: 1.5rem !important;
            }
        }

        /* Loading States */
        .loading-card {
            position: relative;
            overflow: hidden;
        }

        .loading-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            to {
                left: 100%;
            }
        }

        /* Enhanced Hover Effects */
        .stat-card:hover .stat-icon {
            transform: scale(1.2) rotate(5deg);
            color: var(--primary-dark);
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.2);
        }

        /* Notification Badges */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            animation: notification-pulse 2s infinite;
        }

        @keyframes notification-pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }
    </style>
@endsection
