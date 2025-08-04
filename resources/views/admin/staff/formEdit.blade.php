<!-- Modal Edit Staff -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white border-0">
                <div class="d-flex align-items-center">
                    <div class="modal-icon me-3">
                        <i class="fas fa-user-edit fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="editStaffModalLabel">Edit Data Staff</h5>
                        <small class="opacity-75">Perbarui informasi staff</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <form action="" method="post" id="editStaffForm" novalidate>
                @csrf
                @method('POST')
                <div class="modal-body p-4">
                    <!-- Staff Information Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="section-header mb-4">
                                <h6 class="text-primary mb-0">
                                    <i class="fas fa-user-circle me-2"></i>Informasi Staff
                                </h6>
                                <hr class="mt-2 mb-0">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Nama Staff -->
                        <div class="col-md-4">
                            <label for="edit_name" class="form-label fw-semibold">
                                <i class="fas fa-user me-1 text-primary"></i>
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text"
                                    class="form-control border-start-0 @error('name') is-invalid @enderror"
                                    id="edit_name" name="name" placeholder="Masukkan nama lengkap" required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <label for="edit_email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1 text-primary"></i>
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email"
                                    class="form-control border-start-0 @error('email') is-invalid @enderror"
                                    id="edit_email" name="email" placeholder="contoh@email.com" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="edit_role" class="form-label fw-semibold">
                            <i class="fas fa-user-tag me-1 text-primary"></i>
                            Role Akses <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-user-tag text-muted"></i>
                            </span>
                            <select class="form-select border-start-0 @error('role') is-invalid @enderror"
                                id="edit_role" name="role" required>
                                <option value="">Pilih Role Akses</option>
                                <option value="STAFF">STAFF</option>
                                <option value="CASHIER">CASHIER</option>
                            </select>
                        </div>
                        @error('role')
                            <div class="invalid-feedback d-block">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Tentukan level akses staff
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="section-header mb-4">
                                <h6 class="text-warning mb-0">
                                    <i class="fas fa-key me-2"></i>Ubah Password (Opsional)
                                </h6>
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                                <hr class="mt-2 mb-0">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Password Baru -->
                        <div class="col-md-6">
                            <label for="edit_password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1 text-warning"></i>
                                Password Baru
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password"
                                    class="form-control border-0 @error('password') is-invalid @enderror"
                                    id="edit_password" name="password" placeholder="Minimal 8 karakter">
                                <button type="button" class="btn btn-outline-secondary border-start-0"
                                    id="toggleEditPassword">
                                    <i class="fas fa-eye" id="editPasswordIcon"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Minimal 8 karakter untuk keamanan yang baik
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6">
                            <label for="edit_password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1 text-warning"></i>
                                Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-shield-alt text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-0" id="edit_password_confirmation"
                                    name="password_confirmation" placeholder="Ulangi password baru">
                                <button type="button" class="btn btn-outline-secondary border-start-0"
                                    id="toggleEditPasswordConfirm">
                                    <i class="fas fa-eye" id="editPasswordConfirmIcon"></i>
                                </button>
                            </div>
                            <div class="password-match-indicator mt-2" id="passwordMatchIndicator"
                                style="display: none;">
                                <small class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>Password cocok
                                </small>
                            </div>
                            <div class="password-mismatch-indicator mt-2" id="passwordMismatchIndicator"
                                style="display: none;">
                                <small class="text-danger">
                                    <i class="fas fa-times-circle me-1"></i>Password tidak cocok
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info border-0 bg-light-info">
                                <div class="d-flex align-items-start">
                                    <div class="alert-icon me-3">
                                        <i class="fas fa-info-circle fa-lg text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="alert-heading mb-2">
                                            <i class="fas fa-shield-alt me-1"></i>Informasi Keamanan
                                        </h6>
                                        <ul class="mb-0">
                                            <li>Jika password diubah, staff harus login ulang dengan password baru</li>
                                            <li>Pastikan password yang digunakan cukup kuat untuk keamanan akun</li>
                                            <li>Biarkan field password kosong jika tidak ingin mengubah password saat
                                                ini</li>
                                        </ul>
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

    /* Alert Enhancements */
    .alert-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border-left: 4px solid #2196f3;
    }

    .alert-icon {
        padding-top: 2px;
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

    /* Password Strength Indicator */
    .password-strength {
        height: 4px;
        border-radius: 2px;
        margin-top: 5px;
        transition: all 0.3s ease;
    }

    .password-strength.weak {
        background: #dc3545;
        width: 33%;
    }

    .password-strength.medium {
        background: #ffc107;
        width: 66%;
    }

    .password-strength.strong {
        background: #28a745;
        width: 100%;
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
    }
</style>

<!-- Enhanced JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        function setupPasswordToggle(toggleId, inputId, iconId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (toggle && input && icon) {
                toggle.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    icon.className = type === 'text' ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            }
        }

        // Setup password toggles
        setupPasswordToggle('toggleEditPassword', 'edit_password', 'editPasswordIcon');
        setupPasswordToggle('toggleEditPasswordConfirm', 'edit_password_confirmation',
            'editPasswordConfirmIcon');

        // Enhanced password validation
        const editPasswordField = document.getElementById('edit_password');
        const editPasswordConfirmField = document.getElementById('edit_password_confirmation');
        const matchIndicator = document.getElementById('passwordMatchIndicator');
        const mismatchIndicator = document.getElementById('passwordMismatchIndicator');
        const submitButton = document.getElementById('submitEditForm');

        function validateEditPasswords() {
            const password = editPasswordField.value;
            const confirmPassword = editPasswordConfirmField.value;

            // Reset classes
            editPasswordField.classList.remove('is-valid', 'is-invalid');
            editPasswordConfirmField.classList.remove('is-valid', 'is-invalid');

            // Hide indicators
            if (matchIndicator) matchIndicator.style.display = 'none';
            if (mismatchIndicator) mismatchIndicator.style.display = 'none';

            // Only validate if password is entered (since it's optional for edit)
            if (password.length > 0) {
                // Validate password length
                if (password.length >= 8) {
                    editPasswordField.classList.add('is-valid');
                } else {
                    editPasswordField.classList.add('is-invalid');
                }

                // Validate password confirmation
                if (confirmPassword.length > 0) {
                    if (password === confirmPassword && password.length >= 8) {
                        editPasswordConfirmField.classList.add('is-valid');
                        if (matchIndicator) matchIndicator.style.display = 'block';
                    } else {
                        editPasswordConfirmField.classList.add('is-invalid');
                        if (mismatchIndicator) mismatchIndicator.style.display = 'block';
                    }
                }
            } else {
                // If password is empty, confirmation should also be empty
                if (confirmPassword.length > 0) {
                    editPasswordConfirmField.classList.add('is-invalid');
                    if (mismatchIndicator) mismatchIndicator.style.display = 'block';
                }
            }
        }

        // Add event listeners for real-time validation
        if (editPasswordField && editPasswordConfirmField) {
            editPasswordField.addEventListener('input', validateEditPasswords);
            editPasswordConfirmField.addEventListener('input', validateEditPasswords);
        }

        // Modal event handlers
        const editModal = document.getElementById('editStaffModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function() {
                // Clear and reset password fields
                const fields = ['edit_password', 'edit_password_confirmation'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.value = '';
                        field.setAttribute('type', 'password');
                        field.classList.remove('is-valid', 'is-invalid');
                    }
                });

                // Reset icons
                const icons = [{
                        id: 'editPasswordIcon',
                        className: 'fas fa-eye'
                    },
                    {
                        id: 'editPasswordConfirmIcon',
                        className: 'fas fa-eye'
                    }
                ];
                icons.forEach(icon => {
                    const element = document.getElementById(icon.id);
                    if (element) element.className = icon.className;
                });

                // Hide indicators
                if (matchIndicator) matchIndicator.style.display = 'none';
                if (mismatchIndicator) mismatchIndicator.style.display = 'none';
            });

            // Add form submission handler
            const form = document.getElementById('editStaffForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Add loading state to submit button
                    if (submitButton) {
                        submitButton.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                        submitButton.disabled = true;
                    }
                });
            }

            // Reset form handler
            const resetButton = document.getElementById('resetEditForm');
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    // Reset form
                    const form = document.getElementById('editStaffForm');
                    if (form) {
                        form.reset();

                        // Clear validation classes
                        const inputs = form.querySelectorAll('.form-control');
                        inputs.forEach(input => {
                            input.classList.remove('is-valid', 'is-invalid');
                        });

                        // Hide indicators
                        if (matchIndicator) matchIndicator.style.display = 'none';
                        if (mismatchIndicator) mismatchIndicator.style.display = 'none';
                    }
                });
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
</script>
