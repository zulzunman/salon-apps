<!-- Modal Tambah Pelayanan -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="addServiceModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Pelayanan Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('service.add-data') }}" method="post" id="addServiceForm"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <!-- Alert Info -->
                    <div class="alert alert-info border-0 bg-light-info mb-4">
                        <div class="d-flex align-items-center">
                            <div class="alert-icon me-3">
                                <i class="fas fa-info-circle fa-lg text-info"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading mb-1">Informasi Penting</h6>
                                <small class="text-muted">
                                    Pastikan semua data pelayanan yang dimasukkan valid dan sesuai dengan layanan yang
                                    akan disediakan.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Nama Pelayanan -->
                        <div class="col-12">
                            <label for="add_name" class="form-label fw-semibold">
                                <i class="fas fa-concierge-bell me-1 text-primary"></i>
                                Nama Pelayanan
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-concierge-bell text-muted"></i>
                                </span>
                                <input type="text"
                                    class="form-control border-start-0 @error('name') is-invalid @enderror"
                                    id="add_name" name="name" value="{{ old('name') }}"
                                    placeholder="Masukkan nama pelayanan" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi Pelayanan -->
                        <div class="col-12">
                            <label for="add_description" class="form-label fw-semibold">
                                <i class="fas fa-file-alt me-1 text-primary"></i>
                                Deskripsi Pelayanan
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 align-items-start pt-2">
                                    <i class="fas fa-file-alt text-muted"></i>
                                </span>
                                <textarea class="form-control border-start-0 @error('description') is-invalid @enderror" id="add_description"
                                    name="description" rows="3" placeholder="Jelaskan detail pelayanan yang akan diberikan" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Deskripsi akan ditampilkan kepada pelanggan
                            </div>
                        </div>

                        <!-- Harga dan Durasi -->
                        <div class="col-md-6">
                            <label for="add_price" class="form-label fw-semibold">
                                <i class="fas fa-money-bill-wave me-1 text-primary"></i>
                                Harga Pelayanan
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-rupiah-sign text-muted"></i>
                                </span>
                                <input type="number" class="form-control border-0 @error('price') is-invalid @enderror"
                                    id="add_price" name="price" value="{{ old('price') }}" placeholder="0" required
                                    min="0">
                                <span class="input-group-text border-start-0">Rupiah</span>
                                @error('price')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Price Display -->
                            <div class="form-text">
                                <i class="fas fa-calculator me-1"></i>
                                <span id="priceDisplay" class="fw-bold text-success">Rp 0</span>
                            </div>
                        </div>

                        <!-- Durasi -->
                        <div class="col-md-6">
                            <label for="add_duration" class="form-label fw-semibold">
                                <i class="fas fa-clock me-1 text-primary"></i>
                                Durasi Pelayanan
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-clock text-muted"></i>
                                </span>
                                <input type="number"
                                    class="form-control border-0 @error('duration') is-invalid @enderror"
                                    id="add_duration" name="duration" value="{{ old('duration') }}" placeholder="30"
                                    required min="1">
                                <span class="input-group-text border-start-0">Menit</span>
                                @error('duration')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Estimasi waktu pengerjaan
                            </div>
                        </div>

                        <!-- Gambar Pelayanan -->
                        <div class="col-12">
                            <label for="add_picture" class="form-label fw-semibold">
                                <i class="fas fa-image me-1 text-primary"></i>
                                Gambar Pelayanan
                                <span class="text-muted">(Opsional)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-image text-muted"></i>
                                </span>
                                <input type="file"
                                    class="form-control border-start-0 @error('picture') is-invalid @enderror"
                                    id="add_picture" name="picture" accept="image/jpeg,image/jpg,image/png">
                                @error('picture')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Format: JPEG, JPG, PNG. Maksimal 10 MB. Gambar akan membantu pelanggan mengenali
                                layanan.
                            </div>

                            <!-- Preview gambar -->
                            <div id="add-picture-preview" class="mt-3" style="display: none;">
                                <div class="card border-primary" style="max-width: 300px;">
                                    <img id="add-picture-preview-img" src="#" class="card-img-top"
                                        style="height: 200px; object-fit: cover;" alt="Preview">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-eye me-1"></i>Preview Gambar
                                            </small>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                id="add-remove-picture">
                                                <i class="fas fa-times me-1"></i>Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements Notice -->
                    <div class="alert alert-warning border-0 bg-light-warning mt-4">
                        <div class="d-flex align-items-start">
                            <div class="alert-icon me-3">
                                <i class="fas fa-exclamation-triangle fa-lg text-warning"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading mb-2">Persyaratan Data</h6>
                                <ul class="list-unstyled mb-0 small">
                                    <li><i class="fas fa-check text-success me-2"></i>Nama pelayanan harus unik dan
                                        jelas</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Deskripsi minimal 10 karakter
                                    </li>
                                    <li><i class="fas fa-check text-success me-2"></i>Harga harus lebih dari Rp 0</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Durasi minimal 1 menit</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-top-0 p-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitServiceBtn" disabled>
                        <i class="fas fa-save me-1"></i>Simpan Pelayanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-light-info {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }

    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
        padding: 1.5rem 2rem;
    }

    .input-group-text {
        border-color: #e3e6f0;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .alert-icon {
        flex-shrink: 0;
    }

    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    /* Enhanced placeholder styling */
    .form-control::placeholder {
        color: #6c757d !important;
        opacity: 0.8 !important;
        font-weight: 400;
    }

    .form-control:focus::placeholder {
        color: #adb5bd !important;
        opacity: 0.6 !important;
        transition: all 0.3s ease;
    }

    /* Price display animation */
    #priceDisplay {
        transition: all 0.3s ease;
    }

    /* File input styling */
    .form-control[type="file"] {
        padding: 0.6rem 0.75rem;
    }

    .form-control[type="file"]::-webkit-file-upload-button {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        color: #495057;
        cursor: pointer;
        font-size: 0.875rem;
        margin-right: 0.75rem;
        padding: 0.375rem 0.75rem;
    }

    .form-control[type="file"]::-webkit-file-upload-button:hover {
        background: #e9ecef;
        border-color: #adb5bd;
    }

    /* Card preview enhancements */
    .card.border-primary {
        border-width: 2px !important;
        box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.075);
    }

    /* Textarea styling */
    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    /* Validation styling improvements */
    .is-valid {
        border-color: #198754 !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .valid-feedback,
    .invalid-feedback {
        font-size: 0.875rem;
    }

    /* CSS untuk membuat placeholder text lebih terlihat dan timbul */
    .form-control::placeholder {
        color: #ffffff !important;
        opacity: 0.9 !important;
        font-weight: 500;
        text-shadow:
            1px 1px 2px rgba(0, 0, 0, 0.7),
            0px 0px 1px rgba(255, 255, 255, 0.3);
    }

    /* Untuk input group dengan background gelap */
    .input-group .form-control::placeholder {
        color: #f8f9fa !important;
        opacity: 1 !important;
        font-weight: 600;
        text-shadow:
            0 1px 0 rgba(0, 0, 0, 0.8),
            0 0 2px rgba(255, 255, 255, 0.5);
    }

    /* Saat input difocus, placeholder tetap terlihat sampai user mengetik */
    .form-control:focus::placeholder {
        color: #e9ecef !important;
        opacity: 0.8 !important;
        transition: all 0.3s ease;
    }

    /* Untuk browser Firefox */
    .form-control::-moz-placeholder {
        color: #ffffff !important;
        opacity: 0.9 !important;
        font-weight: 500;
        text-shadow:
            1px 1px 2px rgba(0, 0, 0, 0.7),
            0px 0px 1px rgba(255, 255, 255, 0.3);
    }

    /* Untuk browser Webkit (Chrome, Safari) */
    .form-control::-webkit-input-placeholder {
        color: #ffffff !important;
        opacity: 0.9 !important;
        font-weight: 500;
        text-shadow:
            1px 1px 2px rgba(0, 0, 0, 0.7),
            0px 0px 1px rgba(255, 255, 255, 0.3);
    }

    /* Untuk Microsoft Edge */
    .form-control::-ms-input-placeholder {
        color: #ffffff !important;
        opacity: 0.9 !important;
        font-weight: 500;
        text-shadow:
            1px 1px 2px rgba(0, 0, 0, 0.7),
            0px 0px 1px rgba(255, 255, 255, 0.3);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const addNameInput = document.getElementById('add_name');
        const addDescriptionInput = document.getElementById('add_description');
        const addPriceInput = document.getElementById('add_price');
        const addDurationInput = document.getElementById('add_duration');
        const addPictureInput = document.getElementById('add_picture');
        const priceDisplay = document.getElementById('priceDisplay');
        const submitServiceBtn = document.getElementById('submitServiceBtn');

        // Price formatter
        function formatPrice(price) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
        }

        // Real-time price display
        if (addPriceInput && priceDisplay) {
            addPriceInput.addEventListener('input', function() {
                const value = parseInt(this.value) || 0;
                priceDisplay.textContent = formatPrice(value);

                // Add animation effect
                priceDisplay.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    priceDisplay.style.transform = 'scale(1)';
                }, 200);

                validateForm();
            });
        }

        // Real-time validation
        function validateField(field, condition, validClass = 'is-valid', invalidClass = 'is-invalid') {
            field.classList.remove(validClass, invalidClass);

            if (field.value.trim() === '') {
                return false;
            }

            if (condition) {
                field.classList.add(validClass);
                return true;
            } else {
                field.classList.add(invalidClass);
                return false;
            }
        }

        // Validate form
        function validateForm() {
            const name = addNameInput.value.trim();
            const description = addDescriptionInput.value.trim();
            const price = parseInt(addPriceInput.value) || 0;
            const duration = parseInt(addDurationInput.value) || 0;

            const isNameValid = name.length >= 3;
            const isDescriptionValid = description.length >= 10;
            const isPriceValid = price > 0;
            const isDurationValid = duration > 0;

            // Validate each field
            validateField(addNameInput, isNameValid);
            validateField(addDescriptionInput, isDescriptionValid);
            validateField(addPriceInput, isPriceValid);
            validateField(addDurationInput, isDurationValid);

            const isFormValid = isNameValid && isDescriptionValid && isPriceValid && isDurationValid;

            // Update submit button
            submitServiceBtn.disabled = !isFormValid;

            if (isFormValid) {
                submitServiceBtn.classList.remove('btn-secondary');
                submitServiceBtn.classList.add('btn-primary');
            } else {
                submitServiceBtn.classList.remove('btn-primary');
                submitServiceBtn.classList.add('btn-secondary');
            }

            return isFormValid;
        }

        // Event listeners for validation
        if (addNameInput) {
            addNameInput.addEventListener('input', function() {
                validateField(this, this.value.trim().length >= 3);
                validateForm();
            });
        }

        if (addDescriptionInput) {
            addDescriptionInput.addEventListener('input', function() {
                validateField(this, this.value.trim().length >= 10);
                validateForm();
            });
        }

        if (addDurationInput) {
            addDurationInput.addEventListener('input', function() {
                const value = parseInt(this.value);
                validateField(this, value > 0);
                validateForm();
            });
        }

        // Numeric input restrictions
        [addPriceInput, addDurationInput].forEach(input => {
            if (input) {
                input.addEventListener('keypress', function(e) {
                    if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Escape',
                            'Enter'
                        ].includes(e.key)) {
                        e.preventDefault();
                    }
                });
            }
        });

        // Picture preview functionality
        if (addPictureInput) {
            addPictureInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('add-picture-preview');
                const previewImg = document.getElementById('add-picture-preview-img');

                if (file) {
                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak didukung. Gunakan JPEG, JPG, atau PNG.');
                        this.value = '';
                        preview.style.display = 'none';
                        return;
                    }

                    // Validate file size (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar. Maksimal 10 MB.');
                        this.value = '';
                        preview.style.display = 'none';
                        return;
                    }

                    // Show preview with animation
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.style.display = 'block';
                        preview.style.opacity = '0';
                        setTimeout(() => {
                            preview.style.transition = 'opacity 0.3s ease';
                            preview.style.opacity = '1';
                        }, 10);
                    };
                    reader.readAsDataURL(file);

                    // Add validation styling
                    addPictureInput.classList.remove('is-invalid');
                    addPictureInput.classList.add('is-valid');
                } else {
                    preview.style.display = 'none';
                    addPictureInput.classList.remove('is-valid', 'is-invalid');
                }
            });
        }

        // Remove picture preview
        const addRemovePictureBtn = document.getElementById('add-remove-picture');
        if (addRemovePictureBtn) {
            addRemovePictureBtn.addEventListener('click', function() {
                const preview = document.getElementById('add-picture-preview');

                // Fade out animation
                preview.style.transition = 'opacity 0.3s ease';
                preview.style.opacity = '0';

                setTimeout(() => {
                    addPictureInput.value = '';
                    preview.style.display = 'none';
                    addPictureInput.classList.remove('is-valid', 'is-invalid');
                }, 300);
            });
        }

        // Reset form when modal is hidden
        const addServiceModal = document.getElementById('addServiceModal');
        if (addServiceModal) {
            addServiceModal.addEventListener('hidden.bs.modal', function() {
                const form = document.getElementById('addServiceForm');
                if (form) {
                    form.reset();
                }

                // Reset price display
                if (priceDisplay) {
                    priceDisplay.textContent = 'Rp 0';
                }

                // Reset preview
                const preview = document.getElementById('add-picture-preview');
                if (preview) {
                    preview.style.display = 'none';
                }

                // Reset validation classes
                document.querySelectorAll('#addServiceModal .is-valid, #addServiceModal .is-invalid')
                    .forEach(el => {
                        el.classList.remove('is-valid', 'is-invalid');
                    });

                // Reset submit button
                submitServiceBtn.disabled = true;
                submitServiceBtn.classList.remove('btn-primary');
                submitServiceBtn.classList.add('btn-secondary');
            });
        }

        // Auto-format description
        if (addDescriptionInput) {
            addDescriptionInput.addEventListener('blur', function() {
                // Capitalize first letter
                const value = this.value.trim();
                if (value.length > 0) {
                    this.value = value.charAt(0).toUpperCase() + value.slice(1);
                }
            });
        }

        // Initial validation check
        validateForm();

        // Add loading state for form submission
        const form = document.getElementById('addServiceForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (validateForm()) {
                    submitServiceBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
                    submitServiceBtn.disabled = true;
                } else {
                    e.preventDefault();
                }
            });
        }
    });
</script>
