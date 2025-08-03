<!-- Modal Delete Staff -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus Data
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="mx-auto d-flex align-items-center justify-content-center"
                        style="width: 80px; height: 80px; background-color: #fee2e2; border-radius: 50%;">
                        <i class="fas fa-trash-alt fa-2x text-danger"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h6 class="mb-3">Apakah Anda yakin ingin menghapus data staff ini?</h6>
                    <div class="alert alert-warning" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <div class="text-start">
                                <strong>Informasi Staff:</strong><br>
                                <span class="text-muted">Nama: </span><span id="staffName"
                                    class="fw-semibold"></span><br>
                                <span class="text-muted">Email: </span><span id="staffEmail" class="fw-semibold"></span>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-exclamation-circle text-warning me-1"></i>
                        <small>Data yang sudah dihapus tidak dapat dikembalikan!</small>
                    </p>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash-alt me-1"></i>
                        <span class="btn-text">Ya, Hapus Data</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 2rem 1.5rem;
    }

    .modal-footer {
        padding: 1.5rem;
        background-color: #f8f9fa;
    }

    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
        border-left: 4px solid #ffc107;
    }

    #confirmDeleteBtn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    .btn-secondary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
    }

    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.6);
    }
</style>

<script>
    // Fungsi untuk membuka modal delete
    function openDeleteModal(staffId, staffName, staffEmail, deleteUrl) {
        // Set data staff ke modal
        document.getElementById('staffName').textContent = staffName;
        document.getElementById('staffEmail').textContent = staffEmail;

        // Set form action URL
        document.getElementById('deleteForm').action = deleteUrl;

        // Show modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    // Handle form submission dengan loading state
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteForm');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        const btnText = confirmBtn.querySelector('.btn-text');
        const spinner = confirmBtn.querySelector('.spinner-border');

        deleteForm.addEventListener('submit', function(e) {
            // Show loading state
            confirmBtn.disabled = true;
            btnText.textContent = 'Menghapus...';
            spinner.classList.remove('d-none');

            // Optional: Add timeout to prevent infinite loading
            setTimeout(() => {
                if (confirmBtn.disabled) {
                    confirmBtn.disabled = false;
                    btnText.textContent = 'Ya, Hapus Data';
                    spinner.classList.add('d-none');
                }
            }, 10000); // 10 seconds timeout
        });

        // Reset button state when modal is hidden
        document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function() {
            confirmBtn.disabled = false;
            btnText.textContent = 'Ya, Hapus Data';
            spinner.classList.add('d-none');
        });
    });

    // Optional: Keyboard shortcut (Enter to confirm, Escape to cancel)
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('deleteModal');
        if (modal.classList.contains('show')) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('confirmDeleteBtn').click();
            }
        }
    });
</script>
