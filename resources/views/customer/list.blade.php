@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users me-2"></i> Data Pelanggan</h6>

                <!-- Menampilkan info total data -->
                <div class="text-muted">
                    Menampilkan {{ $customers->firstItem() }} - {{ $customers->lastItem() }} dari {{ $customers->total() }}
                    data
                </div>
            </div>

            <!-- Filter Status Card -->
            <div class="card-body">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-filter me-2"></i> Filter Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('register.get-data') }}"
                                        class="btn btn-outline-secondary {{ request('status') == '' ? 'active' : '' }}">
                                        Semua
                                    </a>
                                    <a href="{{ route('register.get-data', ['status' => 'PENDING']) }}"
                                        class="btn btn-outline-warning {{ request('status') == 'PENDING' ? 'active' : '' }}">
                                        <i class="fas fa-clock me-1"></i> Menunggu
                                    </a>
                                    <a href="{{ route('register.get-data', ['status' => 'CALLING']) }}"
                                        class="btn btn-outline-info {{ request('status') == 'CALLING' ? 'active' : '' }}">
                                        <i class="fas fa-phone me-1"></i> Dipanggil
                                    </a>
                                    <a href="{{ route('register.get-data', ['status' => 'SERVING']) }}"
                                        class="btn btn-outline-primary {{ request('status') == 'SERVING' ? 'active' : '' }}">
                                        <i class="fas fa-handshake me-1"></i> Dilayani
                                    </a>
                                    <a href="{{ route('register.get-data', ['status' => 'COMPLETED']) }}"
                                        class="btn btn-outline-success {{ request('status') == 'COMPLETED' ? 'active' : '' }}">
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Dropdown untuk mengatur jumlah data per halaman -->
                                <div class="d-flex align-items-center justify-content-end">
                                    <label for="per_page" class="form-label me-2 mb-0">Data per halaman:</label>
                                    <select id="per_page" class="form-select form-select-sm" style="width: auto;"
                                        onchange="changePerPage()">
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10
                                        </option>
                                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100
                                        </option>
                                    </select>
                                </div>
                            </div>
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
                                    <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $index + 1 }}</td>
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

                <!-- Pagination Links -->
                @if ($customers->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Menampilkan {{ $customers->firstItem() }} - {{ $customers->lastItem() }} dari
                            {{ $customers->total() }} data
                        </div>
                        <div>
                            {{ $customers->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function changePerPage() {
            const perPage = document.getElementById('per_page').value;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.delete('page'); // Reset ke halaman pertama
            window.location.href = url.toString();
        }
    </script>
@endsection
