<!-- Modal Tambah Staff -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="addStaffModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Tambah Staff Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Form -->
            <form action="{{ route('staff.add-data') }}" method="post" id="addStaffForm">
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
                                    Pastikan semua data yang dimasukkan valid dan sesuai dengan identitas staff yang
                                    sebenarnya.
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- Nama Staff -->
                        <div class="col-12">
                            <label for="add_name" class="form-label fw-semibold">
                                <i class="fas fa-user me-1 text-primary"></i>
                                Nama Lengkap Staff
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text"
                                    class="form-control border-start-0 @error('name') is-invalid @enderror"
                                    id="add_name" name="name" value="{{ old('name') }}"
                                    placeholder="Masukkan nama lengkap staff" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label for="add_email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1 text-primary"></i>
                                Alamat Email
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email"
                                    class="form-control border-start-0 @error('email') is-invalid @enderror"
                                    id="add_email" name="email" value="{{ old('email') }}"
                                    placeholder="contoh@email.com" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Email akan digunakan untuk login ke sistem
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="add_password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1 text-primary"></i>
                                Password
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password"
                                    class="form-control border-0 @error('password') is-invalid @enderror"
                                    id="add_password" name="password" placeholder="Minimal 8 karakter" required>
                                <button type="button" class="btn btn-outline-secondary border-start-0"
                                    id="toggleAddPassword">
                                    <i class="fas fa-eye" id="addPasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Password Strength Indicator -->
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%">
                                </div>
                            </div>
                            <small class="form-text text-muted" id="passwordHelp">
                                <i class="fas fa-shield-alt me-1"></i>Gunakan kombinasi huruf, angka, dan simbol
                            </small>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="col-md-6">
                            <label for="add_password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-lock me-1 text-primary"></i>
                                Konfirmasi Password
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-0" id="add_password_confirmation"
                                    name="password_confirmation" placeholder="Ulangi password" required>
                                <button type="button" class="btn btn-outline-secondary border-start-0"
                                    id="toggleAddPasswordConfirm">
                                    <i class="fas fa-eye" id="addPasswordConfirmIcon"></i>
                                </button>
                            </div>
                            <small class="form-text" id="passwordMatch">
                                <i class="fas fa-check-circle text-muted me-1"></i>
                                <span class="text-muted">Password harus sama</span>
                            </small>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="alert alert-warning border-0 bg-light-warning mt-4">
                        <div class="d-flex align-items-start">
                            <div class="alert-icon me-3">
                                <i class="fas fa-exclamation-triangle fa-lg text-warning"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading mb-2">Persyaratan Password</h6>
                                <ul class="list-unstyled mb-0 small">
                                    <li><i class="fas fa-check text-success me-2"></i>Minimal 8 karakter</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Kombinasi huruf besar dan kecil
                                    </li>
                                    <li><i class="fas fa-check text-success me-2"></i>Mengandung angka</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Konfirmasi password harus sama
                                    </li>
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
                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                        <i class="fas fa-save me-1"></i>Simpan Staff
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

    .progress-bar {
        transition: all 0.3s ease;
    }

    .alert-icon {
        flex-shrink: 0;
    }

    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
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
        const addPasswordInput = document.getElementById('add_password');
        const addPasswordConfirmInput = document.getElementById('add_password_confirmation');
        const passwordStrengthBar = document.getElementById('passwordStrength');
        const passwordHelp = document.getElementById('passwordHelp');
        const passwordMatch = document.getElementById('passwordMatch');
        const submitBtn = document.getElementById('submitBtn');

        // Toggle password visibility
        function setupPasswordToggle(toggleBtnId, inputId, iconId) {
            const toggleBtn = document.getElementById(toggleBtnId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (toggleBtn && input && icon) {
                toggleBtn.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);

                    if (type === 'text') {
                        icon.className = 'fas fa-eye-slash';
                        toggleBtn.setAttribute('title', 'Sembunyikan password');
                    } else {
                        icon.className = 'fas fa-eye';
                        toggleBtn.setAttribute('title', 'Tampilkan password');
                    }
                });
            }
        }

        // Setup password toggles
        setupPasswordToggle('toggleAddPassword', 'add_password', 'addPasswordIcon');
        setupPasswordToggle('toggleAddPasswordConfirm', 'add_password_confirmation', 'addPasswordConfirmIcon');

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = [];

            // Length check
            if (password.length >= 8) {
                strength += 25;
            } else {
                feedback.push('Minimal 8 karakter');
            }

            // Uppercase check
            if (/[A-Z]/.test(password)) {
                strength += 25;
            } else {
                feedback.push('Huruf besar');
            }

            // Lowercase check
            if (/[a-z]/.test(password)) {
                strength += 25;
            } else {
                feedback.push('Huruf kecil');
            }

            // Number or special character check
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) {
                strength += 25;
            } else {
                feedback.push('Angka atau simbol');
            }

            return {
                strength,
                feedback
            };
        }

        // Update password strength indicator
        function updatePasswordStrength() {
            const password = addPasswordInput.value;
            const result = checkPasswordStrength(password);

            // Update progress bar
            passwordStrengthBar.style.width = result.strength + '%';

            // Update colors based on strength
            passwordStrengthBar.className = 'progress-bar';
            if (result.strength < 50) {
                passwordStrengthBar.classList.add('bg-danger');
            } else if (result.strength < 75) {
                passwordStrengthBar.classList.add('bg-warning');
            } else {
                passwordStrengthBar.classList.add('bg-success');
            }

            // Update help text
            if (password.length === 0) {
                passwordHelp.innerHTML =
                    '<i class="fas fa-shield-alt me-1"></i>Gunakan kombinasi huruf, angka, dan simbol';
                passwordHelp.className = 'form-text text-muted';
            } else if (result.feedback.length > 0) {
                passwordHelp.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Butuh: ' + result
                    .feedback.join(', ');
                passwordHelp.className = 'form-text text-danger';
            } else {
                passwordHelp.innerHTML = '<i class="fas fa-check-circle me-1"></i>Password kuat!';
                passwordHelp.className = 'form-text text-success';
            }
        }

        // Check password match
        function checkPasswordMatch() {
            const password = addPasswordInput.value;
            const confirmPassword = addPasswordConfirmInput.value;

            if (confirmPassword.length === 0) {
                passwordMatch.innerHTML =
                    '<i class="fas fa-check-circle text-muted me-1"></i><span class="text-muted">Password harus sama</span>';
                addPasswordConfirmInput.classList.remove('is-valid', 'is-invalid');
            } else if (password === confirmPassword && password.length >= 8) {
                passwordMatch.innerHTML =
                    '<i class="fas fa-check-circle text-success me-1"></i><span class="text-success">Password cocok!</span>';
                addPasswordConfirmInput.classList.remove('is-invalid');
                addPasswordConfirmInput.classList.add('is-valid');
            } else {
                passwordMatch.innerHTML =
                    '<i class="fas fa-times-circle text-danger me-1"></i><span class="text-danger">Password tidak cocok</span>';
                addPasswordConfirmInput.classList.remove('is-valid');
                addPasswordConfirmInput.classList.add('is-invalid');
            }
        }

        // Validate form
        function validateForm() {
            const name = document.getElementById('add_name').value.trim();
            const email = document.getElementById('add_email').value.trim();
            const password = addPasswordInput.value;
            const confirmPassword = addPasswordConfirmInput.value;

            const isNameValid = name.length > 0;
            const isEmailValid = email.length > 0 && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            const isPasswordValid = password.length >= 8 && checkPasswordStrength(password).strength === 100;
            const isPasswordMatch = password === confirmPassword;

            const isFormValid = isNameValid && isEmailValid && isPasswordValid && isPasswordMatch;

            submitBtn.disabled = !isFormValid;

            if (isFormValid) {
                submitBtn.classList.remove('btn-secondary');
                submitBtn.classList.add('btn-primary');
            } else {
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-secondary');
            }
        }

        // Event listeners
        addPasswordInput.addEventListener('input', function() {
            updatePasswordStrength();
            checkPasswordMatch();
            validateForm();
        });

        addPasswordConfirmInput.addEventListener('input', function() {
            checkPasswordMatch();
            validateForm();
        });

        document.getElementById('add_name').addEventListener('input', validateForm);
        document.getElementById('add_email').addEventListener('input', validateForm);

        // Reset form when modal is hidden
        document.getElementById('addStaffModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('addStaffForm').reset();
            passwordStrengthBar.style.width = '0%';
            passwordStrengthBar.className = 'progress-bar';
            passwordHelp.innerHTML =
                '<i class="fas fa-shield-alt me-1"></i>Gunakan kombinasi huruf, angka, dan simbol';
            passwordHelp.className = 'form-text text-muted';
            passwordMatch.innerHTML =
                '<i class="fas fa-check-circle text-muted me-1"></i><span class="text-muted">Password harus sama</span>';
            submitBtn.disabled = true;

            // Remove validation classes
            document.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                el.classList.remove('is-valid', 'is-invalid');
            });
        });
    });
</script>
