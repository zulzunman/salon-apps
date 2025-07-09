@extends('layouts.app')

@section('title', 'Data Staff')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Staff</h6>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                    <i class="fas fa-user-plus"></i> Tambah Staff
                </button>
            </div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Staff</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->role }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button type="button" class="btn btn-primary btn-sm edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#editStaffModal"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                data-email="{{ $item->email }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('staff.delete-data', $item->id) }}" method="POST"
                                                class="d-inline delete-form" data-name="{{ $item->name }}">
                                                @csrf
                                                @method('POST')
                                                <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data staff.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info">
                            @if ($data->total() > 0)
                                Menampilkan {{ $data->firstItem() }} - {{ $data->lastItem() }}
                                dari {{ $data->total() }} staff
                            @else
                                Tidak ada data untuk ditampilkan
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers float-right">
                            @if ($data->hasPages())
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Modal Files -->
    @include('admin.staff.formAdd')
    @include('admin.staff.formEdit')
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete confirmations
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    const itemName = form.getAttribute('data-name');

                    if (confirm(`Apakah Anda yakin ingin menghapus data staff "${itemName}"?`)) {
                        form.submit();
                    }
                });
            });

            // Handle edit button clicks
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const email = this.getAttribute('data-email');

                    // Update form action URL - sesuaikan dengan route Anda
                    const editForm = document.getElementById('editStaffForm');
                    editForm.action = `/admin/staff/edit/${id}`;

                    // Populate form fields
                    document.getElementById('edit_name').value = name;
                    document.getElementById('edit_email').value = email;
                    document.getElementById('edit_password').value = '';
                    document.getElementById('edit_password_confirmation').value = '';
                });
            });

            // Handle modal close - clear forms
            const addModal = document.getElementById('addStaffModal');
            const editModal = document.getElementById('editStaffModal');

            if (addModal) {
                addModal.addEventListener('hidden.bs.modal', function() {
                    // Clear add form
                    document.getElementById('addStaffForm').reset();
                    // Remove validation classes
                    const inputs = addModal.querySelectorAll('.form-control');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid', 'is-valid');
                    });
                });
            }

            if (editModal) {
                editModal.addEventListener('hidden.bs.modal', function() {
                    // Clear edit form
                    document.getElementById('editStaffForm').reset();
                    // Remove validation classes
                    const inputs = editModal.querySelectorAll('.form-control');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid', 'is-valid');
                    });
                });
            }

            // Show modal if there are validation errors
            @if ($errors->any())
                @if (old('_token'))
                    @if (request()->routeIs('staff.get-data'))
                        // Show add modal if add form has errors
                        const addModalInstance = new bootstrap.Modal(document.getElementById('addStaffModal'));
                        addModalInstance.show();
                    @elseif (request()->routeIs('staff.edit-data'))
                        // Show edit modal if edit form has errors
                        const editModalInstance = new bootstrap.Modal(document.getElementById('editStaffModal'));
                        editModalInstance.show();
                    @endif
                @endif
            @endif
        });
    </script>
    <style>
        /* Pagination Styles - sama seperti di service */
        .dataTables_info {
            padding-top: 8px;
            color: #6c757d;
            font-size: 14px;
        }

        .dataTables_paginate {
            padding-top: 0;
        }

        .pagination-sm .page-link {
            padding: 0.4rem 0.65rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
            color: #fff;
        }

        .pagination .page-link {
            color: #6c757d;
            border: 1px solid #e3e6f0;
            margin: 0 2px;
        }

        .pagination .page-link:hover {
            color: #4e73df;
            background-color: #f8f9fc;
            border-color: #4e73df;
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #fff;
            border-color: #e3e6f0;
        }

        @media (max-width: 576px) {
            .float-right {
                float: none !important;
            }

            .dataTables_paginate {
                text-align: center;
                margin-top: 10px;
            }

            .col-sm-12.col-md-5,
            .col-sm-12.col-md-7 {
                text-align: center;
            }
        }
    </style>
@endsection
