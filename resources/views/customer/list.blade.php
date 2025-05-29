@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users me-2"></i> Data Pelanggan</h6>
            </div>

            <!-- Filter Status Card -->
            <div class="card-body">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-filter me-2"></i> Filter Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('register.get-data') }}" class="btn btn-outline-secondary">
                                Semua
                            </a>
                            <a href="{{ route('register.get-data', ['status' => 'PENDING']) }}"
                                class="btn btn-outline-warning">
                                <i class="fas fa-clock me-1"></i> Menunggu
                            </a>
                            <a href="{{ route('register.get-data', ['status' => 'CALLING']) }}"
                                class="btn btn-outline-info">
                                <i class="fas fa-phone me-1"></i> Dipanggil
                            </a>
                            <a href="{{ route('register.get-data', ['status' => 'SERVING']) }}"
                                class="btn btn-outline-primary">
                                <i class="fas fa-handshake me-1"></i> Dilayani
                            </a>
                            <a href="{{ route('register.get-data', ['status' => 'COMPLETED']) }}"
                                class="btn btn-outline-success">
                                <i class="fas fa-check-circle me-1"></i> Selesai
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Email</th>
                                <th>Pelayanan</th>
                                <th>Tanggal Booking</th>
                                <th>Jam Layanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $index => $customer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $customer->customer->name }}</td>
                                    <td>{{ $customer->customer->email }}</td>
                                    <td>{{ $customer->service->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($customer->booking_date)->format('d/m/Y') }}</td>
                                    <td>{{ $customer->bookingTime->time ?? 'Tidak ada' }}</td>
                                    <td>
                                        @if ($customer->status == 'PENDING')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($customer->status == 'CALLING')
                                            <span class="badge bg-info">Dipanggil</span>
                                        @elseif ($customer->status == 'SERVING')
                                            <span class="badge bg-primary">Dilayani</span>
                                        @elseif ($customer->status == 'COMPLETED')
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if ($customer->status == 'PENDING')
                                                <form action="{{ route('register.calling', $customer->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info btn-sm"
                                                        title="Panggil Pelanggan">
                                                        <i class="fas fa-phone"></i>
                                                    </button>
                                                </form>
                                            @elseif ($customer->status == 'CALLING')
                                                <form action="{{ route('register.serving', $customer->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                        title="Layani Pelanggan">
                                                        <i class="fas fa-handshake"></i>
                                                    </button>
                                                </form>
                                            @elseif ($customer->status == 'SERVING')
                                                <form action="{{ route('register.complete', $customer->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        title="Selesaikan Layanan">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            @elseif ($customer->status == 'COMPLETED')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Selesai
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data pelanggan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
