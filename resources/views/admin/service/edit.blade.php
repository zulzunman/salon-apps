<!-- Modal Edit Pelayanan -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">
                    <i class="fas fa-edit"></i> Edit Pelayanan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editServiceForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">
                            Nama Pelayanan <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">
                            Deskripsi Pelayanan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="edit_description" name="description"
                            rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="edit_price" class="form-label">
                            Harga Pelayanan <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                id="edit_price" name="price" value="{{ old('price') }}" required min="0">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_duration" class="form-label">
                            Durasi Pelayanan (Menit) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                id="edit_duration" name="duration" value="{{ old('duration') }}" required
                                min="1">
                            <span class="input-group-text">Menit</span>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Field Picture -->
                    <div class="mb-3">
                        <label for="edit_picture" class="form-label">
                            Gambar Pelayanan
                        </label>

                        <!-- Current Picture Display -->
                        <div id="current-picture" class="mb-2" style="display: none;">
                            <div class="card" style="max-width: 200px;">
                                <div class="card-body p-2">
                                    <small class="text-muted">Gambar Saat Ini:</small>
                                    <img id="current-picture-img" src="" alt=""
                                        class="img-thumbnail mt-1"
                                        style="width: 100%; height: 120px; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <input type="file" class="form-control @error('picture') is-invalid @enderror"
                            id="edit_picture" name="picture" accept="image/*" onchange="previewEditImage(this)">
                        <small class="text-muted">
                            Format yang didukung: JPG, JPEG, PNG, GIF. Maksimal 2MB.
                            <strong>Kosongkan jika tidak ingin mengubah gambar.</strong>
                        </small>
                        @error('picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Preview New Image -->
                        <div id="edit-picture-preview" class="mt-2" style="display: none;">
                            <div class="card" style="max-width: 200px;">
                                <div class="card-body p-2">
                                    <small class="text-muted">Preview Gambar Baru:</small>
                                    <img id="edit-preview-img" src="" alt="Preview" class="img-thumbnail mt-1"
                                        style="width: 100%; height: 120px; object-fit: cover;">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1 w-100"
                                        onclick="removeEditPreview()">
                                        <i class="fas fa-times"></i> Hapus Preview
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning" id="edit-warning-alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Peringatan:</strong> Perubahan data pelayanan akan mempengaruhi semua booking yang
                        menggunakan pelayanan ini.
                        <div class="mt-2">
                            <small>Alert ini akan hilang dalam <span id="countdown-timer">10</span> detik</small>
                            <div class="countdown-progress">
                                <div class="countdown-progress-bar" id="progress-bar"></div>
                            </div>
                        </div>
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
    // Function untuk preview gambar baru saat edit
    function previewEditImage(input) {
        const preview = document.getElementById('edit-picture-preview');
        const previewImg = document.getElementById('edit-preview-img');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validasi ukuran file (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
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

<style>
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

    /* Preview image styles */
    .card {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }

    #current-picture .card {
        background-color: #f8f9fa;
    }

    #edit-picture-preview .card {
        background-color: #e7f3ff;
        border-color: #007bff;
    }
</style>
