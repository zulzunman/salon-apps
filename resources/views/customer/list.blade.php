@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-users me-2"></i>Data Pelanggan
                </h1>
                <p class="text-muted mb-0">Kelola data pelanggan dan antrian layanan</p>
            </div>
            <div class="text-muted">
                <small><strong>Total:</strong> {{ $customers->total() }} pelanggan</small>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card shadow">
            <!-- Card Header dengan Filter -->
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-table me-2"></i>
                        <h6 class="m-0 font-weight-bold d-inline">Daftar Pelanggan</h6>
                    </div>
                    <div>
                        <small>
                            Menampilkan {{ $customers->firstItem() ?? 0 }} - {{ $customers->lastItem() ?? 0 }} dari
                            {{ $customers->total() }} data
                        </small>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Filter Status Section -->
                <div class="card mb-4 border-0 bg-light">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 text-primary">
                            <i class="fas fa-filter me-2"></i>Filter Status & Pengaturan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Filter Buttons -->
                            <div class="col-md-8">
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('register.get-data') }}"
                                        class="btn btn-outline-secondary {{ request('status') == '' ? 'active' : '' }}">
                                        <i class="fas fa-list me-1"></i>Semua
                                    </a>
                                    @if (auth()->user()->role !== 'STAFF')
                                        <a href="{{ route('register.get-data', ['status' => 'PENDING']) }}"
                                            class="btn btn-outline-warning {{ request('status') == 'PENDING' ? 'active' : '' }}">
                                            <i class="fas fa-clock me-1"></i>Menunggu
                                        </a>
                                        <a href="{{ route('register.get-data', ['status' => 'CALLING']) }}"
                                            class="btn btn-outline-info {{ request('status') == 'CALLING' ? 'active' : '' }}">
                                            <i class="fas fa-phone me-1"></i>Dipanggil
                                        </a>
                                    @endif
                                    <a href="{{ route('register.get-data', ['status' => 'SERVING']) }}"
                                        class="btn btn-outline-primary {{ request('status') == 'SERVING' ? 'active' : '' }}">
                                        <i class="fas fa-handshake me-1"></i>Dilayani
                                    </a>
                                    <a href="{{ route('register.get-data', ['status' => 'COMPLETED']) }}"
                                        class="btn btn-outline-success {{ request('status') == 'COMPLETED' ? 'active' : '' }}">
                                        <i class="fas fa-check-circle me-1"></i>Selesai
                                    </a>
                                </div>
                            </div>

                            <!-- Per Page Selector -->
                            <div class="col-md-4">
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
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="60">#</th>
                                <th><i class="fas fa-user me-1"></i>Nama Pelanggan</th>
                                @if (auth()->user()->role !== 'STAFF')
                                    <th><i class="fas fa-envelope me-1"></i>Email</th>
                                    <th><i class="fas fa-calendar me-1"></i>Tanggal Pendaftaran</th>
                                @endif
                                <th><i class="fas fa-concierge-bell me-1"></i>Pelayanan</th>
                                <th class="text-center"><i class="fas fa-ticket-alt me-1"></i>No. Antrian</th>
                                <th class="text-center"><i class="fas fa-info-circle me-1"></i>Status</th>
                                @if (auth()->user()->role !== 'STAFF')
                                    <th class="text-center"><i class="fas fa-user-tie me-1"></i>Staff</th>
                                @endif
                                @if (auth()->user()->role === 'CASHIER')
                                    <th class="text-center" width="120">
                                        <i class="fas fa-cogs me-1"></i>Aksi
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $index => $customer)
                                @if (auth()->user()->role === 'STAFF' && in_array($customer->status, ['PENDING', 'CALLING']))
                                    @continue
                                @endif
                                <tr>
                                    <td class="text-center">
                                        <span
                                            class="fw-bold">{{ ($customers->currentPage() - 1) * $customers->perPage() + $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $customer->customer->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    @if (auth()->user()->role !== 'STAFF')
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-envelope text-muted me-2"></i>
                                                {{ $customer->customer->email }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar text-muted me-2"></i>
                                                {{ \Carbon\Carbon::parse($customer->booking_date)->format('d/m/Y') }}
                                            </div>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-concierge-bell text-muted me-2"></i>
                                            {{ $customer->service->name }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($customer->queue_number)
                                            <span class="badge bg-info px-3 py-2">
                                                <i class="fas fa-ticket-alt me-1"></i>{{ $customer->queue_number }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusConfig = match ($customer->status) {
                                                'PENDING' => [
                                                    'class' => 'bg-warning text-dark',
                                                    'icon' => 'clock',
                                                    'text' => 'Menunggu',
                                                ],
                                                'CALLING' => [
                                                    'class' => 'bg-info',
                                                    'icon' => 'phone',
                                                    'text' => 'Dipanggil',
                                                ],
                                                'SERVING' => [
                                                    'class' => 'bg-primary',
                                                    'icon' => 'handshake',
                                                    'text' => 'Dilayani',
                                                ],
                                                'COMPLETED' => [
                                                    'class' => 'bg-success',
                                                    'icon' => 'check-circle',
                                                    'text' => 'Selesai',
                                                ],
                                                default => [
                                                    'class' => 'bg-secondary',
                                                    'icon' => 'question',
                                                    'text' => 'Unknown',
                                                ],
                                            };
                                        @endphp
                                        @if (($customer->status == 'PENDING' || $customer->status == 'CALLING') && auth()->user()->role !== 'STAFF')
                                            <span class="badge {{ $statusConfig['class'] }} px-3 py-2">
                                                <i
                                                    class="fas fa-{{ $statusConfig['icon'] }} me-1"></i>{{ $statusConfig['text'] }}
                                            </span>
                                        @elseif ($customer->status == 'SERVING' || $customer->status == 'COMPLETED')
                                            <span class="badge {{ $statusConfig['class'] }} px-3 py-2">
                                                <i
                                                    class="fas fa-{{ $statusConfig['icon'] }} me-1"></i>{{ $statusConfig['text'] }}
                                            </span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->role !== 'STAFF')
                                        <td class="text-center">
                                            @if ($customer->users && $customer->users->count() > 0)
                                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                                    @foreach ($customer->users as $staff)
                                                        <span class="badge bg-info px-2 py-1">
                                                            <i class="fas fa-user me-1"></i>{{ $staff->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endif
                                    @if (auth()->user()->role === 'CASHIER')
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @if ($customer->status == 'PENDING')
                                                    <form action="{{ route('register.calling', $customer->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-info btn-sm"
                                                            title="Panggil Pelanggan">
                                                            <i class="fas fa-phone"></i>
                                                        </button>
                                                    </form>
                                                @elseif ($customer->status == 'CALLING')
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#staffModal{{ $customer->id }}"
                                                        title="Layani Pelanggan">
                                                        <i class="fas fa-handshake"></i>
                                                    </button>
                                                @elseif ($customer->status == 'SERVING')
                                                    <form action="{{ route('register.complete', $customer->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success btn-sm"
                                                            title="Selesaikan Layanan">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    </form>
                                                @elseif ($customer->status == 'COMPLETED')
                                                    <span class="badge bg-success px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i>Selesai
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
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="staffModalLabel{{ $customer->id }}">
                                                        <i class="fas fa-user-tie me-2"></i>Pilih Staff untuk Melayani
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card border-0 bg-light mb-3">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <strong class="text-primary">Pelanggan:</strong><br>
                                                                    <span
                                                                        class="fw-bold">{{ $customer->customer->name }}</span>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <strong class="text-primary">Layanan:</strong><br>
                                                                    <span
                                                                        class="fw-bold">{{ $customer->service->name }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h6 class="mb-3 text-primary">
                                                        <i class="fas fa-users me-2"></i>Daftar Staff Tersedia:
                                                    </h6>

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
                                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border rounded mb-2">
                                                                        <div>
                                                                            <div class="d-flex align-items-center">
                                                                                <div
                                                                                    class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                                                    <i class="fas fa-user text-white"></i>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="fw-bold">
                                                                                        {{ $staff->name }}</div>
                                                                                    @if ($staff->email)
                                                                                        <small
                                                                                            class="text-muted">{{ $staff->email }}</small>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <span class="badge bg-primary rounded-pill">
                                                                            <i class="fas fa-arrow-right me-1"></i>Pilih
                                                                        </span>
                                                                    </button>
                                                                </form>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning border-0" role="alert">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                                <div>
                                                                    <strong>Tidak ada staff tersedia</strong><br>
                                                                    <small>Semua staff sedang tidak tersedia saat
                                                                        ini.</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Batal
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'CASHIER' ? (auth()->user()->role !== 'STAFF' ? 9 : 6) : (auth()->user()->role !== 'STAFF' ? 8 : 5) }}"
                                        class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada data pelanggan</h5>
                                            <p class="text-muted">Belum ada pelanggan yang terdaftar untuk hari ini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($customers->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            <small>
                                @if ($customers->total() > 0)
                                    Menampilkan {{ $customers->firstItem() }} - {{ $customers->lastItem() }} dari
                                    {{ $customers->total() }} pelanggan
                                @else
                                    Tidak ada data untuk ditampilkan
                                @endif
                            </small>
                        </div>
                        <div>
                            <nav aria-label="Pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- Previous -->
                                    @if ($customers->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $customers->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Page Numbers -->
                                    @foreach ($customers->getUrlRange(max(1, $customers->currentPage() - 2), min($customers->lastPage(), $customers->currentPage() + 2)) as $page => $url)
                                        @if ($page == $customers->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    <!-- Next -->
                                    @if ($customers->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $customers->nextPageUrl() }}">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
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

        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth animations for table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';

                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            });

            // Enhanced button interactions
            const actionButtons = document.querySelectorAll('.btn-sm');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Add loading state for form submissions
            document.addEventListener('submit', function(e) {
                const submitButton = e.target.querySelector('button[type="submit"]');
                if (submitButton && !submitButton.classList.contains('btn-secondary')) {
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                    submitButton.disabled = true;

                    // Restore button if form validation fails
                    setTimeout(() => {
                        if (submitButton.disabled) {
                            submitButton.innerHTML = originalText;
                            submitButton.disabled = false;
                        }
                    }, 3000);
                }
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .avatar-sm {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            border-color: #dee2e6;
        }

        .table td {
            border-color: #dee2e6;
            vertical-align: middle;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .btn-group .btn {
            border-radius: 0.375rem;
            margin: 0 1px;
        }

        .card-header {
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        .table-responsive {
            border-radius: 0.375rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        .pagination .page-link {
            color: #6c757d;
            border: 1px solid #dee2e6;
            margin: 0 2px;
            border-radius: 0.375rem;
        }

        .pagination .page-link:hover {
            color: #0d6efd;
            background-color: #f8f9fa;
            border-color: #0d6efd;
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #fff;
            border-color: #dee2e6;
        }

        /* Hover effect untuk table rows */
        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        /* Filter buttons styling */
        .btn-outline-secondary.active,
        .btn-outline-warning.active,
        .btn-outline-info.active,
        .btn-outline-primary.active,
        .btn-outline-success.active {
            transform: scale(1.02);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Modal improvements */
        .modal-header.bg-primary {
            border-bottom: none;
        }

        .modal-footer.bg-light {
            border-top: 1px solid #dee2e6;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
            transition: all 0.2s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .btn-group {
                flex-direction: column;
            }

            .btn-group .btn {
                margin: 1px 0;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }

            .pagination {
                justify-content: center;
            }

            .d-flex.flex-wrap.gap-2 {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .avatar-sm {
                display: none;
            }

            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 0.5rem;
            }

            .col-md-8,
            .col-md-4 {
                text-align: center;
                margin-bottom: 1rem;
            }
        }

        /* Animation improvements */
        .btn {
            transition: all 0.2s ease;
        }

        .badge {
            transition: all 0.2s ease;
        }

        .card {
            transition: box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
