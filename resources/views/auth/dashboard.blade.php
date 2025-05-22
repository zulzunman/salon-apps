@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="mb-4">Dashboard</h1>

                <div class="row">
                    @if (auth()->user()->role == 'ADMIN')
                        <!-- Dashboard untuk Admin -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i> Pelayanan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h2 class="mb-0">{{ App\Models\Service::count() }}</h2>
                                        <i class="fas fa-cogs fa-3x text-primary"></i>
                                    </div>
                                    <p class="mt-3 mb-0">Total jenis pelayanan yang tersedia</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('service.get-data') }}" class="btn btn-sm btn-primary">Lihat Data</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-users me-2"></i> Staff</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h2 class="mb-0">{{ App\Models\User::where('role', 'STAFF')->count() }}</h2>
                                        <i class="fas fa-users fa-3x text-success"></i>
                                    </div>
                                    <p class="mt-3 mb-0">Total staff yang terdaftar</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('staff.get-data') }}" class="btn btn-sm btn-success">Lihat Data</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Dashboard untuk Staff -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i> Menunggu</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h2 class="mb-0">
                                            {{ App\Models\Registration::where('status', 'PENDING')->count() }}</h2>
                                        <i class="fas fa-clock fa-3x text-warning"></i>
                                    </div>
                                    <p class="mt-3 mb-0">Pelanggan dalam status menunggu</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('register.get-data') }}" class="btn btn-sm btn-warning">Lihat Data</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-phone me-2"></i> Dipanggil</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h2 class="mb-0">
                                            {{ App\Models\Registration::where('status', 'CALLING')->count() }}</h2>
                                        <i class="fas fa-phone fa-3x text-info"></i>
                                    </div>
                                    <p class="mt-3 mb-0">Pelanggan dalam status dipanggil</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('register.get-data') }}" class="btn btn-sm btn-info">Lihat Data</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-handshake me-2"></i> Dilayani</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h2 class="mb-0">
                                            {{ App\Models\Registration::where('status', 'SERVING')->count() }}</h2>
                                        <i class="fas fa-handshake fa-3x text-primary"></i>
                                    </div>
                                    <p class="mt-3 mb-0">Pelanggan dalam status dilayani</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('register.get-data') }}" class="btn btn-sm btn-primary">Lihat Data</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
