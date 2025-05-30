<!-- CSS untuk Modal tanpa JavaScript -->
<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        display: none;
    }

    .modal-overlay:target {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }

    .modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        text-decoration: none;
        font-size: 24px;
        color: #666;
        z-index: 1;
    }

    .modal-close:hover {
        color: #000;
        text-decoration: none;
    }
</style>

<!-- Modal Edit Pelayanan - CSS Only -->
<div id="editServiceModal-{{ $service->id ?? 'template' }}" class="modal-overlay">
    <div class="modal-container">
        <a href="#" class="modal-close">&times;</a>

        <div class="modal-header" style="padding: 20px 20px 10px 20px; border-bottom: 1px solid #dee2e6;">
            <h5 class="modal-title" style="margin: 0; color: #007bff;">
                <i class="fas fa-edit"></i> Edit Pelayanan
            </h5>
        </div>

        <form action="{{ route('service.edit-data', $service->id ?? 0) }}" method="POST">
            @csrf

            <div class="modal-body" style="padding: 20px;">
                <div class="mb-3">
                    <label for="edit_name_{{ $service->id ?? 'template' }}" class="form-label">
                        Nama Pelayanan <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="edit_name_{{ $service->id ?? 'template' }}" name="name"
                        value="{{ old('name', $service->name ?? '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="edit_description_{{ $service->id ?? 'template' }}" class="form-label">
                        Deskripsi Pelayanan <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        id="edit_description_{{ $service->id ?? 'template' }}" name="description" rows="3" required>{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="edit_price_{{ $service->id ?? 'template' }}" class="form-label">
                        Harga Pelayanan <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                            id="edit_price_{{ $service->id ?? 'template' }}" name="price"
                            value="{{ old('price', $service->price ?? '') }}" required min="0">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edit_duration_{{ $service->id ?? 'template' }}" class="form-label">
                        Durasi Pelayanan (Menit) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('duration') is-invalid @enderror"
                            id="edit_duration_{{ $service->id ?? 'template' }}" name="duration"
                            value="{{ old('duration', $service->duration ?? '') }}" required min="1">
                        <span class="input-group-text">Menit</span>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Peringatan:</strong> Perubahan data pelayanan akan mempengaruhi semua booking yang
                    menggunakan pelayanan ini.
                </div>
            </div>

            <div class="modal-footer"
                style="padding: 10px 20px 20px 20px; border-top: 1px solid #dee2e6; display: flex; justify-content: space-between;">
                <a href="#" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
