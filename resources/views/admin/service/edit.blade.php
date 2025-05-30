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

            <form id="editServiceForm" action="#" method="POST">
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
                    <div class="alert alert-warning" id="edit-warning-alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Peringatan:</strong> Perubahan data pelayanan akan mempengaruhi semua booking yang
                        menggunakan pelayanan ini.
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
</style>
