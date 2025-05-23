@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-users me-2"></i> Data Pelanggan</h1>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-filter me-2"></i> Filter Status</h5>
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

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>Email</th>
                                        <th>Pelayanan</th>
                                        <th>Jam Layanan</th>
                                        <th>Status</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->customer->name }}</td>
                                            <td>{{ $customer->customer->email }}</td>
                                            <td>{{ $customer->service->name }}</td>
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
                                                @if ($customer->status == 'PENDING')
                                                    <form action="{{ route('register.calling', $customer->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info">
                                                            <i class="fas fa-phone me-1"></i> Panggil
                                                        </button>
                                                    </form>
                                                @elseif ($customer->status == 'CALLING')
                                                    <form action="{{ route('register.serving', $customer->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-handshake me-1"></i> Layani
                                                        </button>
                                                    </form>
                                                @elseif ($customer->status == 'SERVING')
                                                    <form action="{{ route('register.complete', $customer->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check-circle me-1"></i> Selesai
                                                        </button>
                                                    </form>
                                                @elseif ($customer->status == 'COMPLETED')
                                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i>
                                                        Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data pelanggan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
