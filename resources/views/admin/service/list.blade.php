@extends('layouts.app')

@section('title', 'Data Pelayanan')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Pelayanan</h6>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                    <i class="fas fa-plus-circle"></i> Tambah Pelayanan
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
                                <th>Nama Pelayanan</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Durasi (Menit)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $index => $service)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->description }}</td>
                                    <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                                    <td>{{ $service->duration }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <!-- PERBAIKAN: Gunakan data-bs-toggle untuk Bootstrap 5 -->
                                            <button type="button" class="btn btn-primary btn-sm edit-btn"
                                                data-bs-toggle="modal" data-bs-target="#editServiceModal"
                                                data-id="{{ $service->id }}" data-name="{{ $service->name }}"
                                                data-description="{{ $service->description }}"
                                                data-price="{{ $service->price }}"
                                                data-duration="{{ $service->duration }}" title="Edit Pelayanan">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('service.delete-data', $service->id) }}" method="POST"
                                                class="d-inline delete-form" data-name="{{ $service->name }}">
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
                                    <td colspan="6" class="text-center">Tidak ada data pelayanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Modal Files -->
    @include('admin.service.create')
    @include('admin.service.edit')
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

                    if (confirm(`Apakah Anda yakin ingin menghapus pelayanan "${itemName}"?`)) {
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
                    const description = this.getAttribute('data-description');
                    const price = this.getAttribute('data-price');
                    const duration = this.getAttribute('data-duration');

                    // Update form action URL
                    const editForm = document.getElementById('editServiceForm');
                    editForm.action = `/service/edit/${id}/edit-data`; // PERBAIKAN: URL yang benar

                    // Populate form fields
                    document.getElementById('edit_name').value = name;
                    document.getElementById('edit_description').value = description;
                    document.getElementById('edit_price').value = price;
                    document.getElementById('edit_duration').value = duration;

                    // Start warning alert countdown
                    startWarningCountdown();
                });
            });

            // Variable global untuk menyimpan interval
            let warningCountdownInterval = null;

            // Function untuk countdown warning alert
            function startWarningCountdown() {
                const warningAlert = document.getElementById('edit-warning-alert');
                const countdownElement = document.getElementById('countdown-timer');
                const progressBar = document.getElementById('progress-bar');

                // Clear interval sebelumnya jika ada
                if (warningCountdownInterval) {
                    clearInterval(warningCountdownInterval);
                }

                let timeLeft = 10;

                // Reset alert visibility dan progress bar
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

                    // Update progress bar
                    if (progressBar) {
                        const progressPercentage = (timeLeft / 10) * 100;
                        progressBar.style.width = progressPercentage + '%';
                    }

                    if (timeLeft <= 0) {
                        clearInterval(warningCountdownInterval);
                        warningCountdownInterval = null;

                        // Hide alert dengan fade out
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

            // Reset countdown ketika modal ditutup
            const editModal = document.getElementById('editServiceModal');
            if (editModal) {
                editModal.addEventListener('hidden.bs.modal', function() {
                    if (warningCountdownInterval) {
                        clearInterval(warningCountdownInterval);
                        warningCountdownInterval = null;
                    }
                    // Reset alert untuk next time
                    const warningAlert = document.getElementById('edit-warning-alert');
                    const countdownElement = document.getElementById('countdown-timer');
                    if (warningAlert && countdownElement) {
                        warningAlert.style.display = 'block';
                        warningAlert.classList.remove('d-none');
                        countdownElement.textContent = '10';
                    }
                });
            }

            // Handle modal close - clear forms
            const addModal = document.getElementById('addServiceModal');
            const editModal = document.getElementById('editServiceModal');

            if (addModal) {
                addModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('addServiceForm').reset();
                    const inputs = addModal.querySelectorAll('.form-control');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid', 'is-valid');
                    });
                });
            }

            if (editModal) {
                editModal.addEventListener('hidden.bs.modal', function() {
                    document.getElementById('editServiceForm').reset();
                    const inputs = editModal.querySelectorAll('.form-control');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid', 'is-valid');
                    });
                });
            }

            // Show modal if there are validation errors - PERBAIKAN
            @if ($errors->any() && session('edit_error_service_id'))
                // Show edit modal if edit form has errors
                const editModalInstance = new bootstrap.Modal(document.getElementById('editServiceModal'));
                editModalInstance.show();

                // Populate form dengan data yang error
                const serviceId = {{ session('edit_error_service_id') }};
                document.getElementById('edit_name').value = "{{ old('name') }}";
                document.getElementById('edit_description').value = "{{ old('description') }}";
                document.getElementById('edit_price').value = "{{ old('price') }}";
                document.getElementById('edit_duration').value = "{{ old('duration') }}";

                // Update form action
                const editForm = document.getElementById('editServiceForm');
                editForm.action = `/service/edit/${serviceId}/edit-data`;
            @elseif ($errors->any())
                // Show add modal if add form has errors
                const addModalInstance = new bootstrap.Modal(document.getElementById('addServiceModal'));
                addModalInstance.show();
            @endif
        });
    </script>
@endsection
