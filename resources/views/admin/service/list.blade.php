@extends('layouts.app')

@section('title', 'Data Pelayanan')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-concierge-bell me-2"></i>Data Pelayanan
                </h1>
                <p class="text-muted mb-0">Kelola data pelayanan dan layanan sistem</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                <i class="fas fa-plus-circle me-2"></i>Tambah Pelayanan
            </button>
        </div>

        <!-- Alerts -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Card -->
        <div class="card shadow">
            <!-- Card Header -->
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-table me-2"></i>
                        <h6 class="m-0 font-weight-bold d-inline">Daftar Pelayanan</h6>
                    </div>
                    <div>
                        <small>Total: {{ $services->total() }} pelayanan</small>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="60">#</th>
                                <th class="text-center" width="80"><i class="fas fa-image me-1"></i>Gambar</th>
                                <th><i class="fas fa-concierge-bell me-1"></i>Nama Pelayanan</th>
                                <th><i class="fas fa-file-alt me-1"></i>Deskripsi</th>
                                <th class="text-center"><i class="fas fa-money-bill-wave me-1"></i>Harga</th>
                                <th class="text-center"><i class="fas fa-clock me-1"></i>Durasi</th>
                                <th class="text-center" width="120">
                                    <i class="fas fa-cogs me-1"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $index => $service)
                                <tr>
                                    <td class="text-center">
                                        <span
                                            class="fw-bold">{{ ($services->currentPage() - 1) * $services->perPage() + $index + 1 }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($service->picture)
                                            <img src="{{ asset('assets/img/service/' . $service->picture) }}"
                                                alt="{{ $service->name }}" class="img-thumbnail service-image"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div class="no-image-placeholder d-flex align-items-center justify-content-center bg-light border rounded"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-concierge-bell text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $service->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted" style="max-width: 200px;">
                                            {{ Str::limit($service->description, 50) }}
                                            @if (strlen($service->description) > 50)
                                                <button type="button" class="btn btn-link btn-sm p-0 ms-1"
                                                    data-bs-toggle="tooltip" title="{{ $service->description }}">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-rupiah-sign text-success me-1"></i>
                                            <span
                                                class="fw-bold text-success">{{ number_format($service->price, 0, ',', '.') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>{{ $service->duration }} menit
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-sm edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#editServiceModal"
                                                data-id="{{ $service->id }}" data-name="{{ $service->name }}"
                                                data-description="{{ $service->description }}"
                                                data-price="{{ $service->price }}"
                                                data-duration="{{ $service->duration }}"
                                                data-picture="{{ $service->picture }}" title="Edit Pelayanan">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('service.delete-data', $service->id) }}" method="POST"
                                                class="d-inline delete-form" data-name="{{ $service->name }}">
                                                @csrf
                                                @method('POST')
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    title="Hapus Pelayanan" data-id="{{ $service->id }}"
                                                    data-name="{{ $service->name }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-concierge-bell fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada data pelayanan</h5>
                                            <p class="text-muted">Silakan tambah pelayanan baru dengan mengklik tombol
                                                "Tambah Pelayanan"</p>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addServiceModal">
                                                <i class="fas fa-plus-circle me-2"></i>Tambah Pelayanan Pertama
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($services->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            <small>
                                @if ($services->total() > 0)
                                    Menampilkan {{ $services->firstItem() }} - {{ $services->lastItem() }} dari
                                    {{ $services->total() }} pelayanan
                                @else
                                    Tidak ada data untuk ditampilkan
                                @endif
                            </small>
                        </div>
                        <div>
                            <nav aria-label="Pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- Previous -->
                                    @if ($services->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $services->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Page Numbers -->
                                    @foreach ($services->getUrlRange(max(1, $services->currentPage() - 2), min($services->lastPage(), $services->currentPage() + 2)) as $page => $url)
                                        @if ($page == $services->currentPage())
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
                                    @if ($services->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $services->nextPageUrl() }}">
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

    <!-- Include Modal Files -->
    @include('admin.service.create')
    @include('admin.service.edit')
    @include('admin.service.delete')
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

        /* Service specific styles */
        .service-image {
            cursor: pointer;
            transition: transform 0.2s ease;
            border: 2px solid #e9ecef;
        }

        .service-image:hover {
            transform: scale(1.1);
            border-color: #0d6efd;
        }

        .no-image-placeholder {
            cursor: default;
            transition: all 0.2s ease;
        }

        .no-image-placeholder:hover {
            background-color: #f8f9fa !important;
        }

        /* Hover effect untuk table rows */
        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        /* Alert improvements */
        .alert {
            border-left: 4px solid;
            border-radius: 0.5rem;
        }

        .alert-success {
            border-left-color: #198754;
            background-color: #d1eddd;
        }

        .alert-danger {
            border-left-color: #dc3545;
            background-color: #f8d7da;
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

            /* Hide avatar on small screens */
            .avatar-sm {
                display: none;
            }

            /* Adjust table for mobile */
            .table-responsive table {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 0.5rem;
            }

            /* Stack service name and description */
            .table td {
                padding: 0.75rem 0.5rem;
            }
        }

        /* Tooltip improvements */
        .tooltip-inner {
            max-width: 300px;
            text-align: left;
        }

        /* Price styling */
        .text-success {
            color: #198754 !important;
        }

        /* Duration badge styling */
        .badge.bg-info {
            background-color: #0dcaf0 !important;
            color: #000 !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Handle edit button clicks
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description');
                    const price = this.getAttribute('data-price');
                    const duration = this.getAttribute('data-duration');
                    const picture = this.getAttribute('data-picture');

                    // Update form action URL
                    const editForm = document.getElementById('editServiceForm');
                    if (editForm) {
                        editForm.action = `/service/edit/${id}/edit-data`;
                    }

                    // Populate form fields
                    const nameField = document.getElementById('edit_name');
                    const descriptionField = document.getElementById('edit_description');
                    const priceField = document.getElementById('edit_price');
                    const durationField = document.getElementById('edit_duration');

                    if (nameField) nameField.value = name;
                    if (descriptionField) descriptionField.value = description;
                    if (priceField) priceField.value = price;
                    if (durationField) durationField.value = duration;

                    // Show current picture if exists
                    const currentPictureDiv = document.getElementById('current-picture');
                    const currentPictureImg = document.getElementById('current-picture-img');

                    if (picture && picture.trim() !== '') {
                        if (currentPictureImg) {
                            currentPictureImg.src = `/assets/img/service/${picture}`;
                            currentPictureImg.alt = name;
                        }
                        if (currentPictureDiv) {
                            currentPictureDiv.style.display = 'block';
                        }
                    } else {
                        if (currentPictureDiv) {
                            currentPictureDiv.style.display = 'none';
                        }
                    }

                    // Clear validation classes
                    [nameField, descriptionField, priceField, durationField].forEach(field => {
                        if (field) {
                            field.classList.remove('is-invalid', 'is-valid');
                        }
                    });

                    // Start warning countdown if function exists
                    if (typeof startWarningCountdown === 'function') {
                        startWarningCountdown();
                    }
                });
            });

            // Handle modal close - clear forms and validation
            const modals = ['addServiceModal', 'editServiceModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.addEventListener('hidden.bs.modal', function() {
                        const form = modal.querySelector('form');
                        if (form) {
                            form.reset();

                            // Remove validation classes
                            const inputs = modal.querySelectorAll('.form-control');
                            inputs.forEach(input => {
                                input.classList.remove('is-invalid', 'is-valid');
                            });

                            // Clear validation messages
                            const feedbacks = modal.querySelectorAll('.invalid-feedback');
                            feedbacks.forEach(feedback => {
                                feedback.style.display = 'none';
                            });

                            // Reset file input preview
                            const previews = modal.querySelectorAll('[id$="-picture-preview"]');
                            previews.forEach(preview => {
                                preview.style.display = 'none';
                            });
                        }
                    });
                }
            });

            // Auto-show modal if validation errors exist
            @if ($errors->any())
                @if (session('edit_error_service_id'))
                    const editModalInstance = new bootstrap.Modal(document.getElementById('editServiceModal'));
                    editModalInstance.show();

                    // Populate form dengan data yang error
                    const serviceId = {{ session('edit_error_service_id') }};
                    const editForm = document.getElementById('editServiceForm');
                    if (editForm) {
                        editForm.action = `/service/edit/${serviceId}/edit-data`;
                    }

                    // Populate fields with old values
                    const editNameField = document.getElementById('edit_name');
                    const editDescField = document.getElementById('edit_description');
                    const editPriceField = document.getElementById('edit_price');
                    const editDurationField = document.getElementById('edit_duration');

                    if (editNameField) editNameField.value = "{{ old('name') }}";
                    if (editDescField) editDescField.value = "{{ old('description') }}";
                    if (editPriceField) editPriceField.value = "{{ old('price') }}";
                    if (editDurationField) editDurationField.value = "{{ old('duration') }}";
                @else
                    const addModalInstance = new bootstrap.Modal(document.getElementById('addServiceModal'));
                    addModalInstance.show();
                @endif
            @endif

            // Add smooth animations
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

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.classList.contains('show')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            });

            // Enhanced service image interactions
            const serviceImages = document.querySelectorAll('.service-image');
            serviceImages.forEach(img => {
                img.addEventListener('click', function() {
                    // Create modal to show larger image
                    const modal = document.createElement('div');
                    modal.className = 'modal fade';
                    modal.innerHTML = `
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Preview Gambar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="${this.src}" alt="${this.alt}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(modal);

                    const bsModal = new bootstrap.Modal(modal);
                    bsModal.show();

                    // Remove modal after hide
                    modal.addEventListener('hidden.bs.modal', function() {
                        document.body.removeChild(modal);
                    });
                });
            });
        });

        // Add loading state for form submissions
        document.addEventListener('submit', function(e) {
            const submitButton = e.target.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
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

        // Variable global untuk countdown (if needed for edit warning)
        let warningCountdownInterval = null;

        function startWarningCountdown() {
            const warningAlert = document.getElementById('edit-warning-alert');
            const countdownElement = document.getElementById('countdown-timer');
            const progressBar = document.getElementById('progress-bar');

            if (warningCountdownInterval) {
                clearInterval(warningCountdownInterval);
            }

            let timeLeft = 10;

            if (warningAlert) {
                warningAlert.style.display = 'block';
                warningAlert.style.opacity = '1';
                warningAlert.style.visibility = 'visible';
                warningAlert.classList.remove('d-none');
            }

            if (countdownElement) {
                countdownElement.textContent = timeLeft;
            }

            if (progressBar) {
                progressBar.style.width = '100%';
            }

            warningCountdownInterval = setInterval(function() {
                timeLeft--;

                if (countdownElement) {
                    countdownElement.textContent = timeLeft;
                }

                if (progressBar) {
                    const progressPercentage = (timeLeft / 10) * 100;
                    progressBar.style.width = progressPercentage + '%';
                }

                if (timeLeft <= 0) {
                    clearInterval(warningCountdownInterval);
                    warningCountdownInterval = null;

                    if (warningAlert) {
                        warningAlert.style.transition = 'opacity 0.5s ease-out';
                        warningAlert.style.opacity = '0';

                        setTimeout(() => {
                            warningAlert.style.display = 'none';
                            warningAlert.classList.add('d-none');
                        }, 500);
                    }
                }
            }, 1000);
        }
    </script>
@endsection
