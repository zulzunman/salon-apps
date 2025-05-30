<!-- Modal Tambah Staff -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">
                    <i class="fas fa-user-plus"></i> Tambah Staff Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('staff.add-data') }}" method="post" id="addStaffForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_name" class="form-label">Nama Staff <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="add_name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="add_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="add_email"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="add_password" class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="add_password" name="password" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggleAddPassword">
                                <i class="fas fa-eye" id="addPasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="add_password_confirmation" class="form-label">Konfirmasi Password <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="add_password_confirmation"
                                name="password_confirmation" required>
                            <button type="button" class="btn btn-outline-secondary" id="toggleAddPasswordConfirm">
                                <i class="fas fa-eye" id="addPasswordConfirmIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Pastikan password minimal 8 karakter dan konfirmasi password sama
                        dengan password.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility for add form
        const toggleAddPassword = document.getElementById('toggleAddPassword');
        const addPasswordInput = document.getElementById('add_password');
        const addPasswordIcon = document.getElementById('addPasswordIcon');

        if (toggleAddPassword && addPasswordInput && addPasswordIcon) {
            toggleAddPassword.addEventListener('click', function() {
                const type = addPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                addPasswordInput.setAttribute('type', type);

                if (type === 'text') {
                    addPasswordIcon.className = 'fas fa-eye-slash';
                } else {
                    addPasswordIcon.className = 'fas fa-eye';
                }
            });
        }

        // Toggle password confirmation visibility for add form
        const toggleAddPasswordConfirm = document.getElementById('toggleAddPasswordConfirm');
        const addPasswordConfirmInput = document.getElementById('add_password_confirmation');
        const addPasswordConfirmIcon = document.getElementById('addPasswordConfirmIcon');

        if (toggleAddPasswordConfirm && addPasswordConfirmInput && addPasswordConfirmIcon) {
            toggleAddPasswordConfirm.addEventListener('click', function() {
                const type = addPasswordConfirmInput.getAttribute('type') === 'password' ? 'text' :
                    'password';
                addPasswordConfirmInput.setAttribute('type', type);

                if (type === 'text') {
                    addPasswordConfirmIcon.className = 'fas fa-eye-slash';
                } else {
                    addPasswordConfirmIcon.className = 'fas fa-eye';
                }
            });
        }

        // Real-time password validation
        const addPasswordField = document.getElementById('add_password');
        const addPasswordConfirmField = document.getElementById('add_password_confirmation');

        if (addPasswordField && addPasswordConfirmField) {
            function validatePasswords() {
                const password = addPasswordField.value;
                const confirmPassword = addPasswordConfirmField.value;

                // Reset classes
                addPasswordField.classList.remove('is-valid', 'is-invalid');
                addPasswordConfirmField.classList.remove('is-valid', 'is-invalid');

                // Validate password length
                if (password.length >= 8) {
                    addPasswordField.classList.add('is-valid');
                } else if (password.length > 0) {
                    addPasswordField.classList.add('is-invalid');
                }

                // Validate password confirmation
                if (confirmPassword.length > 0) {
                    if (password === confirmPassword && password.length >= 8) {
                        addPasswordConfirmField.classList.add('is-valid');
                    } else {
                        addPasswordConfirmField.classList.add('is-invalid');
                    }
                }
            }

            addPasswordField.addEventListener('input', validatePasswords);
            addPasswordConfirmField.addEventListener('input', validatePasswords);
        }
    });
</script>
