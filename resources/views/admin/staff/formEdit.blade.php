<!-- Modal Edit Staff -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStaffModalLabel">
                    <i class="fas fa-edit"></i> Edit Data Staff
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="editStaffForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama Staff <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name"
                            name="name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="edit_email"
                            name="email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password Baru
                            <small class="text-muted">(Biarkan kosong jika tidak ingin mengganti password)</small>
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="edit_password" name="password">
                            <button type="button" class="btn btn-outline-secondary" id="toggleEditPassword">
                                <i class="fas fa-eye" id="editPasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimal 8 karakter jika ingin mengganti password.</div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="edit_password_confirmation"
                                name="password_confirmation">
                            <button type="button" class="btn btn-outline-secondary" id="toggleEditPasswordConfirm">
                                <i class="fas fa-eye" id="editPasswordConfirmIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Jika password diubah, staff harus login ulang dengan password baru</li>
                            <li>Biarkan field password kosong jika tidak ingin mengubah password</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility for edit form
        const toggleEditPassword = document.getElementById('toggleEditPassword');
        const editPasswordInput = document.getElementById('edit_password');
        const editPasswordIcon = document.getElementById('editPasswordIcon');

        if (toggleEditPassword && editPasswordInput && editPasswordIcon) {
            toggleEditPassword.addEventListener('click', function() {
                const type = editPasswordInput.getAttribute('type') === 'password' ? 'text' :
                'password';
                editPasswordInput.setAttribute('type', type);

                if (type === 'text') {
                    editPasswordIcon.className = 'fas fa-eye-slash';
                } else {
                    editPasswordIcon.className = 'fas fa-eye';
                }
            });
        }

        // Toggle password confirmation visibility for edit form
        const toggleEditPasswordConfirm = document.getElementById('toggleEditPasswordConfirm');
        const editPasswordConfirmInput = document.getElementById('edit_password_confirmation');
        const editPasswordConfirmIcon = document.getElementById('editPasswordConfirmIcon');

        if (toggleEditPasswordConfirm && editPasswordConfirmInput && editPasswordConfirmIcon) {
            toggleEditPasswordConfirm.addEventListener('click', function() {
                const type = editPasswordConfirmInput.getAttribute('type') === 'password' ? 'text' :
                    'password';
                editPasswordConfirmInput.setAttribute('type', type);

                if (type === 'text') {
                    editPasswordConfirmIcon.className = 'fas fa-eye-slash';
                } else {
                    editPasswordConfirmIcon.className = 'fas fa-eye';
                }
            });
        }

        // Real-time password validation for edit form
        const editPasswordField = document.getElementById('edit_password');
        const editPasswordConfirmField = document.getElementById('edit_password_confirmation');

        if (editPasswordField && editPasswordConfirmField) {
            function validateEditPasswords() {
                const password = editPasswordField.value;
                const confirmPassword = editPasswordConfirmField.value;

                // Reset classes
                editPasswordField.classList.remove('is-valid', 'is-invalid');
                editPasswordConfirmField.classList.remove('is-valid', 'is-invalid');

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
                        } else {
                            editPasswordConfirmField.classList.add('is-invalid');
                        }
                    }
                } else {
                    // If password is empty, confirmation should also be empty
                    if (confirmPassword.length > 0) {
                        editPasswordConfirmField.classList.add('is-invalid');
                    }
                }
            }

            editPasswordField.addEventListener('input', validateEditPasswords);
            editPasswordConfirmField.addEventListener('input', validateEditPasswords);
        }

        // Clear password fields when modal is opened for edit
        const editModal = document.getElementById('editStaffModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function() {
                // Clear password fields when opening edit modal
                const passwordField = document.getElementById('edit_password');
                const passwordConfirmField = document.getElementById('edit_password_confirmation');

                if (passwordField) passwordField.value = '';
                if (passwordConfirmField) passwordConfirmField.value = '';

                // Reset password field types to password
                if (passwordField) passwordField.setAttribute('type', 'password');
                if (passwordConfirmField) passwordConfirmField.setAttribute('type', 'password');

                // Reset icons
                const passwordIcon = document.getElementById('editPasswordIcon');
                const passwordConfirmIcon = document.getElementById('editPasswordConfirmIcon');

                if (passwordIcon) passwordIcon.className = 'fas fa-eye';
                if (passwordConfirmIcon) passwordConfirmIcon.className = 'fas fa-eye';
            });
        }
    });
</script>
