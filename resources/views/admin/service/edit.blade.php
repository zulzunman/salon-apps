<!-- Modal Edit Pelayanan -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white border-0">
                <div class="d-flex align-items-center">
                    <div class="modal-icon me-3">
                        <i class="fas fa-edit fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="editServiceModalLabel">Edit Pelayanan</h5>
                        <small class="opacity-75">Perbarui informasi pelayanan</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <form id="editServiceForm" action="#" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-body p-4">
                    <!-- Service Information Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="section-header mb-4">
                                <h6 class="text-primary mb-0">
                                    <i class="fas fa-concierge-bell me-2"></i>Informasi Pelayanan
                                </h6>
                                <hr class="mt-2 mb-0">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Nama Pelayanan -->
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label fw-semibold">
                                <i class="fas fa-tag me-1 text-primary"></i>
                                Nama Pelayanan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-tag text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="edit_name" name="name"
                                    placeholder="Masukkan nama pelayanan" required>
                            </div>
                        </div>

                        <!-- Harga Pelayanan -->
                        <div class="col-md-6">
                            <label for="edit_price" class="form-label fw-semibold">
                                <i class="fas fa-money-bill-wave me-1 text-primary"></i>
                                Harga Pelayanan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="number" class="form-control border-start-0" id="edit_price" name="price"
                                    placeholder="0" required min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <!-- Durasi Pelayanan -->
                        <div class="col-md-6">
                            <label for="edit_duration" class="form-label fw-semibold">
                                <i class="fas fa-clock me-1 text-primary"></i>
                                Durasi Pelayanan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-clock text-muted"></i>
                                </span>
                                <input type="number" class="form-control border-0" id="edit_duration" name="duration"
                                    placeholder="0" required min="1">
                                <span class="input-group-text border-start-0">Menit</span>
                            </div>
                        </div>

                        <!-- Deskripsi Pelayanan -->
                        <div class="col-md-6">
                            <label for="edit_description" class="form-label fw-semibold">
                                <i class="fas fa-align-left me-1 text-primary"></i>
                                Deskripsi Pelayanan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-align-left text-muted"></i>
                                </span>
                                <textarea class="form-control border-start-0" id="edit_description" name="description" rows="3"
                                    placeholder="Masukkan deskripsi pelayanan" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="section-header mb-4">
                                <h6 class="text-warning mb-0">
                                    <i class="fas fa-image me-2"></i>Gambar Pelayanan (Opsional)
                                </h6>
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                <hr class="mt-2 mb-0">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Current Picture Column -->
                        <div class="col-md-6">
                            <div id="current-picture" class="picture-container current-picture" style="display: none;">
                                <div class="picture-header">
                                    <i class="fas fa-eye me-1"></i>
                                    <small class="text-muted fw-bold">Gambar Saat Ini</small>
                                </div>
                                <div class="picture-frame">
                                    <img id="current-picture-img" src="" alt="" class="picture-img">
                                </div>
                            </div>
                        </div>

                        <!-- New Picture Preview Column -->
                        <div class="col-md-6">
                            <div id="edit-picture-preview" class="picture-container new-picture"
                                style="display: none;">
                                <div class="picture-header">
                                    <i class="fas fa-image me-1"></i>
                                    <small class="text-success fw-bold">Preview Gambar Baru</small>
                                </div>
                                <div class="picture-frame">
                                    <img id="edit-preview-img" src="" alt="Preview" class="picture-img">
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger mt-2 w-100"
                                    onclick="removeEditPreview()">
                                    <i class="fas fa-times me-1"></i> Hapus Preview
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- File Input -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="edit_picture" class="form-label fw-semibold">
                                <i class="fas fa-upload me-1 text-warning"></i>
                                Upload Gambar Baru
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-upload text-muted"></i>
                                </span>
                                <input type="file" class="form-control border-start-0" id="edit_picture"
                                    name="picture" accept="image/*" onchange="previewEditImage(this)">
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Format: JPG, JPEG, PNG, GIF | Maksimal: 10MB
                            </div>
                        </div>
                    </div>

                    <!-- Warning Notice -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-warning border-0 bg-light-warning">
                                <div class="d-flex align-items-start">
                                    <div class="alert-icon me-3">
                                        <i class="fas fa-exclamation-triangle fa-lg text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="alert-heading mb-2">
                                            <i class="fas fa-info-circle me-1"></i>Informasi Penting
                                        </h6>
                                        <ul class="mb-0">
                                            <li>Perubahan data pelayanan akan mempengaruhi semua pendaftaran yang
                                                menggunakan pelayanan ini</li>
                                            <li>Pastikan informasi yang dimasukkan sudah benar sebelum menyimpan</li>
                                            <li>Gambar yang diupload akan menggantikan gambar sebelumnya</li>
                                        </ul>
                                        <div class="mt-2">
                                            <small>Alert ini akan hilang dalam <span id="countdown-timer">10</span>
                                                detik</small>
                                            <div class="countdown-progress">
                                                <div class="countdown-progress-bar" id="progress-bar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <div class="d-flex justify-content-between w-100">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <div>
                            <button type="reset" class="btn btn-outline-warning me-2 px-4" id="resetEditForm">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-4" id="submitEditForm">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Modal Enhancements */
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .modal-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .section-header h6 {
        font-weight: 600;
        margin-bottom: 0;
    }

    .section-header hr {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, #007bff, transparent);
    }

    /* Form Enhancements */
    .input-group-text {
        border: 1px solid #dee2e6;
        background: #f8f9fa;
    }

    .form-control {
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        transform: translateY(-1px);
    }

    .form-control.is-valid {
        border-color: #28a745;
        background-image: none;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background-image: none;
    }

    /* Picture container styles */
    .picture-container {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .picture-container.current-picture {
        border-color: #6c757d;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .picture-container.new-picture {
        border-color: #28a745;
        background: linear-gradient(135deg, #f0fff4 0%, #e6ffed 100%);
    }

    .picture-header {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .picture-frame {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .picture-img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .picture-img:hover {
        transform: scale(1.05);
    }

    /* Alert Enhancements */
    .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
        border-left: 4px solid #ffc107;
    }

    .alert-icon {
        padding-top: 2px;
    }

    /* Progress bar visual */
    .countdown-progress {
        width: 100%;
        height: 4px;
        background-color: #e9ecef;
        border-radius: 2px;
        overflow: hidden;
        margin-top: 8px;
    }

    .countdown-progress-bar {
        height: 100%;
        background-color: #ffc107;
        transition: width 0.1s linear;
    }

    /* Button Enhancements */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
    }

    .btn-outline-secondary:hover {
        background: #6c757d;
        transform: translateY(-1px);
    }

    .btn-outline-warning:hover {
        background: #ffc107;
        transform: translateY(-1px);
    }

    .form-text {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 3px solid #007bff;
        font-size: 0.875rem;
    }

    /* Animation for form validation */
    .is-valid,
    .is-invalid {
        animation: validationPulse 0.3s ease;
    }

    @keyframes validationPulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.02);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 1rem;
        }

        .modal-header {
            padding: 1rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem !important;
        }

        .modal-icon {
            width: 40px;
            height: 40px;
        }

        .picture-container {
            margin-bottom: 15px;
        }

        .picture-img {
            height: 100px;
        }
    }
</style>

<!-- Enhanced JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced form validation
        const form = document.getElementById('editServiceForm');
        const submitButton = document.getElementById('submitEditForm');
        const resetButton = document.getElementById('resetEditForm');

        // Real-time validation
        function validateForm() {
            const requiredFields = ['edit_name', 'edit_description', 'edit_price', 'edit_duration'];
            let isValid = true;

            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.classList.remove('is-valid', 'is-invalid');

                    if (field.value.trim() === '') {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        // Additional validation for specific fields
                        if (fieldId === 'edit_price' || fieldId === 'edit_duration') {
                            if (parseFloat(field.value) <= 0) {
                                field.classList.add('is-invalid');
                                isValid = false;
                            } else {
                                field.classList.add('is-valid');
                            }
                        } else {
                            field.classList.add('is-valid');
                        }
                    }
                }
            });

            return isValid;
        }

        // Add event listeners for real-time validation
        const formInputs = form.querySelectorAll('input[required], textarea[required]');
        formInputs.forEach(input => {
            input.addEventListener('blur', validateForm);
            input.addEventListener('input', function() {
                // Clear invalid state on input
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Modal event handlers
        const editModal = document.getElementById('editServiceModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function() {
                // Reset form validation states
                const inputs = form.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    input.classList.remove('is-valid', 'is-invalid');
                });

                // Hide picture previews
                const currentPicture = document.getElementById('current-picture');
                const editPicturePreview = document.getElementById('edit-picture-preview');
                if (currentPicture) currentPicture.style.display = 'none';
                if (editPicturePreview) editPicturePreview.style.display = 'none';

                // Start countdown timer
                startCountdownTimer();
            });

            // Form submission handler
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                        return false;
                    }

                    // Add loading state to submit button
                    if (submitButton) {
                        submitButton.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                        submitButton.disabled = true;
                    }
                });
            }

            // Reset form handler
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    // Reset form
                    form.reset();

                    // Clear validation classes
                    const inputs = form.querySelectorAll('.form-control');
                    inputs.forEach(input => {
                        input.classList.remove('is-valid', 'is-invalid');
                    });

                    // Hide picture previews
                    const editPicturePreview = document.getElementById('edit-picture-preview');
                    if (editPicturePreview) editPicturePreview.style.display = 'none';

                    // Reset file input
                    const fileInput = document.getElementById('edit_picture');
                    if (fileInput) fileInput.value = '';
                });
            }
        }

        // Countdown timer functionality
        function startCountdownTimer() {
            let timeLeft = 10;
            const timerElement = document.getElementById('countdown-timer');
            const progressBar = document.getElementById('progress-bar');

            if (timerElement && progressBar) {
                progressBar.style.width = '100%';

                const countdown = setInterval(() => {
                    timeLeft--;
                    timerElement.textContent = timeLeft;
                    progressBar.style.width = (timeLeft / 10 * 100) + '%';

                    if (timeLeft <= 0) {
                        clearInterval(countdown);
                        const alertElement = document.getElementById('edit-warning-alert');
                        if (alertElement) {
                            alertElement.style.transition = 'opacity 0.5s ease';
                            alertElement.style.opacity = '0';
                            setTimeout(() => {
                                alertElement.style.display = 'none';
                            }, 500);
                        }
                    }
                }, 1000);
            }
        }

        // Add smooth animations for form interactions
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.parentNode.style.transform = 'translateY(-1px)';
            });

            control.addEventListener('blur', function() {
                this.parentNode.style.transform = 'translateY(0)';
            });
        });
    });

    // Function untuk preview gambar baru saat edit
    function previewEditImage(input) {
        const preview = document.getElementById('edit-picture-preview');
        const previewImg = document.getElementById('edit-preview-img');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validasi ukuran file (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 10MB.');
                input.value = '';
                preview.style.display = 'none';
                return;
            }

            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.');
                input.value = '';
                preview.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    // Function untuk menghapus preview gambar edit
    function removeEditPreview() {
        const input = document.getElementById('edit_picture');
        const preview = document.getElementById('edit-picture-preview');

        input.value = '';
        preview.style.display = 'none';
    }
</script>
