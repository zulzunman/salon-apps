@extends('layouts.app')

@section('title', 'Data Staff')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-users-cog me-2"></i>Data Staff
                </h1>
                <p class="text-muted mb-0">Kelola data staff dan pengguna sistem</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="fas fa-user-plus me-2"></i>Tambah Staff
            </button>
        </div>

        <!-- Main Card -->
        <div class="card shadow">
            <!-- Card Header -->
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-table me-2"></i>
                        <h6 class="m-0 font-weight-bold d-inline">Daftar Staff</h6>
                    </div>
                    <div>
                        <small>Total: {{ $data->total() }} staff</small>
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
                                <th><i class="fas fa-user me-1"></i>Nama Staff</th>
                                <th><i class="fas fa-envelope me-1"></i>Email</th>
                                <th class="text-center"><i class="fas fa-user-tag me-1"></i>Role</th>
                                <th class="text-center" width="120">
                                    <i class="fas fa-cogs me-1"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        <span
                                            class="fw-bold">{{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $item->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-envelope text-muted me-2"></i>
                                            {{ $item->email }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $roleClass = match ($item->role) {
                                                'ADMIN' => 'bg-danger',
                                                'STAFF' => 'bg-success',
                                                'CASHIER' => 'bg-warning text-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $roleClass }} px-3 py-2">
                                            <i class="fas fa-user-shield me-1"></i>{{ $item->role }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-sm edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                data-email="{{ $item->email }}" title="Edit Staff">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('staff.delete-data', $item->id) }}" method="POST"
                                                class="d-inline delete-form" data-name="{{ $item->name }}">
                                                @csrf
                                                @method('POST')
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    title="Hapus Staff" data-id="{{ $item->id }}"
                                                    data-name="{{ $item->name }}" data-email="{{ $item->email }}"
                                                    onclick="openDeleteModal(this)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada data staff</h5>
                                            <p class="text-muted">Silakan tambah staff baru dengan mengklik tombol "Tambah
                                                Staff"</p>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addStaffModal">
                                                <i class="fas fa-user-plus me-2"></i>Tambah Staff Pertama
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($data->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            <small>
                                @if ($data->total() > 0)
                                    Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }} dari
                                    {{ $data->total() }} staff
                                @else
                                    Tidak ada data untuk ditampilkan
                                @endif
                            </small>
                        </div>
                        <div>
                            <nav aria-label="Pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    <!-- Previous -->
                                    @if ($data->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $data->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Page Numbers -->
                                    @foreach ($data->getUrlRange(max(1, $data->currentPage() - 2), min($data->lastPage(), $data->currentPage() + 2)) as $page => $url)
                                        @if ($page == $data->currentPage())
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
                                    @if ($data->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $data->nextPageUrl() }}">
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
    @include('admin.staff.formAdd')
    @include('admin.staff.formEdit')
    @include('admin.staff.delete')
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
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function openDeleteModal(button) {
                const id = button.getAttribute('data-id');
                const form = document.getElementById('deleteForm');
                form.action = `/staff/delete/${id}`; // Atau gunakan route helper jika di-parse ke JS
                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            }

            // Handle edit button clicks
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const email = this.getAttribute('data-email');

                    // Update form action URL
                    const editForm = document.getElementById('editStaffForm');
                    if (editForm) {
                        editForm.action = `/staff/edit/${id}/edit-data`;
                    }

                    // Populate form fields
                    const nameField = document.getElementById('edit_name');
                    const emailField = document.getElementById('edit_email');
                    const passwordField = document.getElementById('edit_password');
                    const passwordConfirmField = document.getElementById(
                        'edit_password_confirmation');

                    if (nameField) nameField.value = name;
                    if (emailField) emailField.value = email;
                    if (passwordField) passwordField.value = '';
                    if (passwordConfirmField) passwordConfirmField.value = '';

                    // Clear validation classes
                    [nameField, emailField, passwordField, passwordConfirmField].forEach(field => {
                        if (field) {
                            field.classList.remove('is-invalid', 'is-valid');
                        }
                    });
                });
            });

            // Handle modal close - clear forms and validation
            const modals = ['addStaffModal', 'editStaffModal'];
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
                        }
                    });
                }
            });

            // Auto-show modal if validation errors exist
            @if ($errors->any())
                @if (old('_token'))
                    const modalToShow = '{{ old('modal_type', 'add') }}' === 'edit' ? 'editStaffModal' :
                        'addStaffModal';
                    const modalElement = document.getElementById(modalToShow);
                    if (modalElement) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
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
    </script>
@endsection
