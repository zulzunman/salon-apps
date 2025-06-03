<!-- Modal Tambah Pelayanan -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">
                    <i class="fas fa-plus-circle"></i> Tambah Pelayanan Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('service.add-data') }}" method="post" id="addServiceForm"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_name" class="form-label">Nama Pelayanan <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="add_name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="add_description" class="form-label">Deskripsi Pelayanan <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="add_description" name="description"
                            rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="add_price" class="form-label">Harga Pelayanan <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                id="add_price" name="price" value="{{ old('price') }}" required min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="add_duration" class="form-label">Durasi Pelayanan (Menit) <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                id="add_duration" name="duration" value="{{ old('duration') }}" required min="1">
                            <span class="input-group-text">Menit</span>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="add_picture" class="form-label">Gambar Pelayanan</label>
                        <input type="file" class="form-control @error('picture') is-invalid @enderror"
                            id="add_picture" name="picture" accept="image/jpeg,image/jpg,image/png">
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Format yang didukung: JPEG, JPG, PNG. Maksimal 10 MB.
                        </div>
                        @error('picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Preview gambar -->
                        <div id="add-picture-preview" class="mt-2" style="display: none;">
                            <div class="card" style="width: 200px;">
                                <img id="add-picture-preview-img" src="#" class="card-img-top"
                                    style="height: 150px; object-fit: cover;" alt="Preview">
                                <div class="card-body p-2">
                                    <small class="text-muted">Preview Gambar</small>
                                    <button type="button" class="btn btn-sm btn-outline-danger float-end"
                                        id="add-remove-picture">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Pastikan semua field wajib (*) sudah diisi dengan benar.
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
        // Real-time validation for add form
        const addPriceField = document.getElementById('add_price');
        const addDurationField = document.getElementById('add_duration');
        const addPictureField = document.getElementById('add_picture');

        if (addPriceField) {
            addPriceField.addEventListener('input', function() {
                const value = parseInt(this.value);

                // Reset classes
                this.classList.remove('is-valid', 'is-invalid');

                if (value > 0) {
                    this.classList.add('is-valid');
                } else if (this.value !== '') {
                    this.classList.add('is-invalid');
                }
            });
        }

        if (addDurationField) {
            addDurationField.addEventListener('input', function() {
                const value = parseInt(this.value);

                // Reset classes
                this.classList.remove('is-valid', 'is-invalid');

                if (value > 0) {
                    this.classList.add('is-valid');
                } else if (this.value !== '') {
                    this.classList.add('is-invalid');
                }
            });
        }

        // Picture preview functionality for add form
        if (addPictureField) {
            addPictureField.addEventListener('change', function(e) {
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

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                }
            });
        }

        // Remove picture preview for add form
        const addRemovePictureBtn = document.getElementById('add-remove-picture');
        if (addRemovePictureBtn) {
            addRemovePictureBtn.addEventListener('click', function() {
                document.getElementById('add_picture').value = '';
                document.getElementById('add-picture-preview').style.display = 'none';
            });
        }

        // Format price input (remove non-numeric characters except for first digit)
        if (addPriceField) {
            addPriceField.addEventListener('keypress', function(e) {
                // Allow only numbers
                if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Escape', 'Enter'].includes(
                        e.key)) {
                    e.preventDefault();
                }
            });
        }

        if (addDurationField) {
            addDurationField.addEventListener('keypress', function(e) {
                // Allow only numbers
                if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Escape', 'Enter'].includes(
                        e.key)) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
