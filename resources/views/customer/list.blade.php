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
                                    @if (auth()->user()->role !== 'STAFF')
                                        <a href="{{ route('register.get-data', ['status' => 'PENDING']) }}"
                                            class="btn btn-outline-warning {{ request('status') == 'PENDING' ? 'active' : '' }}">
                                            <i class="fas fa-clock me-1"></i> Menunggu
                                        </a>
                                        <a href="{{ route('register.get-data', ['status' => 'CALLING']) }}"
                                            class="btn btn-outline-info {{ request('status') == 'CALLING' ? 'active' : '' }}">
                                            <i class="fas fa-phone me-1"></i> Dipanggil
                                        </a>
                                    @endif
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
                                @if (auth()->user()->role !== 'STAFF')
                                    <th>Email</th>
                                    <th>Tanggal Pendaftaran</th>
                                @endif
                                <th>Pelayanan</th>
                                <th>Nomor Antrian</th>
                                <th>Status</th>
                                @if (auth()->user()->role !== 'STAFF')
                                    <th>Staff</th>
                                @endif
                                @if (auth()->user()->role === 'CASHIER')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $index => $customer)
                                @if (auth()->user()->role === 'STAFF' && in_array($customer->status, ['PENDING', 'CALLING']))
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $index + 1 }}</td>
                                    <td>{{ $customer->customer->name }}</td>
                                    @if (auth()->user()->role !== 'STAFF')
                                        <td>{{ $customer->customer->email }}</td>
                                        <td>{{ \Carbon\Carbon::parse($customer->booking_date)->format('d/m/Y') }}</td>
                                    @endif
                                    <td>{{ $customer->service->name }}</td>
                                    <td>{{ $customer->queue_number ?? '-' }}</td>
                                    <td>
                                        @if ($customer->status == 'PENDING' && auth()->user()->role !== 'STAFF')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif ($customer->status == 'CALLING' && auth()->user()->role !== 'STAFF')
                                            <span class="badge bg-info">Dipanggil</span>
                                        @elseif ($customer->status == 'SERVING')
                                            <span class="badge bg-primary">Dilayani</span>
                                        @elseif ($customer->status == 'COMPLETED')
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->role !== 'STAFF')
                                        <td>
                                            @if ($customer->users && $customer->users->count() > 0)
                                                @foreach ($customer->users as $staff)
                                                    <span class="badge bg-info me-1">
                                                        <i class="fas fa-user me-1"></i>{{ $staff->name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if (auth()->user()->role === 'CASHIER')
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
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#staffModal{{ $customer->id }}"
                                                        title="Layani Pelanggan">
                                                        <i class="fas fa-handshake"></i>
                                                    </button>
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
                                    @endif
                                </tr>

                                <!-- Modal untuk setiap customer -->
                                @if (auth()->user()->role === 'CASHIER' && $customer->status == 'CALLING')
                                    <div class="modal fade" id="staffModal{{ $customer->id }}" tabindex="-1"
                                        aria-labelledby="staffModalLabel{{ $customer->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staffModalLabel{{ $customer->id }}">
                                                        <i class="fas fa-user-tie me-2"></i>
                                                        Pilih Staff untuk Melayani
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <strong>Pelanggan:</strong> {{ $customer->customer->name }}<br>
                                                        <strong>Layanan:</strong> {{ $customer->service->name }}
                                                    </div>
                                                    <hr>
                                                    <h6 class="mb-3">Daftar Staff Tersedia:</h6>

                                                    @if ($staffList->count() > 0)
                                                        <div class="list-group">
                                                            @foreach ($staffList as $staff)
                                                                <form
                                                                    action="{{ route('register.serving', $customer->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="user_id"
                                                                        value="{{ $staff->id }}">
                                                                    <button type="submit"
                                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <i class="fas fa-user me-2"></i>
                                                                            <strong>{{ $staff->name }}</strong>
                                                                            @if ($staff->email)
                                                                                <br><small
                                                                                    class="text-muted">{{ $staff->email }}</small>
                                                                            @endif
                                                                        </div>
                                                                        <span
                                                                            class="badge bg-primary rounded-pill">Pilih</span>
                                                                    </button>
                                                                </form>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning" role="alert">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            Tidak ada staff yang tersedia saat ini.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i> Batal
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'CASHIER'
                                        ? (auth()->user()->role !== 'STAFF'
                                            ? 9
                                            : 6)
                                        : (auth()->user()->role !== 'STAFF'
                                            ? 8
                                            : 5) }}"
                                        class="text-center">
                                        Tidak ada data pelanggan
                                    </td>
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
