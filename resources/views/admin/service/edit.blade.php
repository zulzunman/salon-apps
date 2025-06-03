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
                            <i class="fas fa-image me-1"></i> Gambar Pelayanan
                        </label>

                        <div class="row">
                            <!-- Current Picture Column -->
                            <div class="col-md-6">
                                <div id="current-picture" class="picture-container current-picture"
                                    style="display: none;">
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
                        <div class="mt-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <input type="file" class="form-control @error('picture') is-invalid @enderror"
                                    id="edit_picture" name="picture" accept="image/*"
                                    onchange="previewEditImage(this)">
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Format: JPG, JPEG, PNG, GIF | Maksimal: 10MB |
                                <span class="text-primary fw-bold">Kosongkan jika tidak ingin mengubah gambar</span>
                            </div>
                            @error('picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

    /* Picture container styles */
    .picture-container {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
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
        border-radius: 6px;
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

    /* Input group styling */
    .input-group-text {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        border: none;
    }

    .form-text {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 4px;
        border-left: 3px solid #007bff;
        margin-top: 8px;
        font-size: 0.875rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .picture-container {
            margin-bottom: 15px;
        }

        .picture-img {
            height: 100px;
        }
    }
</style>
