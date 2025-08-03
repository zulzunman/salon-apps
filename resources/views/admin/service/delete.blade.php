<!-- Delete Service Modal -->
<div class="modal fade" id="deleteServiceModal" tabindex="-1" aria-labelledby="deleteServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title d-flex align-items-center" id="deleteServiceModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Konfirmasi Hapus Pelayanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <div class="mx-auto d-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-circle mb-3"
                        style="width: 80px; height: 80px;">
                        <i class="fas fa-trash-alt fa-2x text-danger"></i>
                    </div>

                    <h5 class="mb-3 text-dark">Apakah Anda yakin ingin menghapus data pelayanan ini?</h5>

                    <!-- Service Info Display -->
                    <div class="alert alert-light border mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="service-icon me-3">
                                <i class="fas fa-concierge-bell fa-2x text-primary"></i>
                            </div>
                            <div class="text-start">
                                <div class="fw-bold text-dark" id="delete-service-name">-</div>
                                <small class="text-muted">Nama Pelayanan</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning border-warning bg-warning bg-opacity-10 mb-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle text-warning me-2"></i>
                            <small class="text-warning mb-0">
                                <strong>Data yang sudah dihapus tidak dapat dikembalikan!</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>

                <!-- Delete Form -->
                <form id="deleteServiceForm" method="POST" class="d-inline">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger px-4" id="confirmDeleteButton">
                        <i class="fas fa-trash-alt me-2"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Styles for Delete Modal -->
<style>
    #deleteServiceModal .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    #deleteServiceModal .modal-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }

    #deleteServiceModal .modal-body {
        padding: 2rem 1.5rem;
    }

    #deleteServiceModal .modal-footer {
        padding: 1rem 1.5rem 1.5rem;
        background-color: #f8f9fa;
    }

    #deleteServiceModal .service-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(13, 110, 253, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #deleteServiceModal .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        min-width: 120px;
    }

    #deleteServiceModal .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    #deleteServiceModal .btn-danger:hover {
        background-color: #bb2d3b;
        border-color: #b02a37;
    }

    #deleteServiceModal .btn-secondary:hover {
        background-color: #5c636a;
        border-color: #565e64;
    }

    #deleteServiceModal .alert {
        border-radius: 10px;
        border: 1px solid;
    }

    #deleteServiceModal .alert-light {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Animation for modal appearance */
    #deleteServiceModal.fade .modal-dialog {
        transform: scale(0.8) translateY(-50px);
        transition: all 0.3s ease;
    }

    #deleteServiceModal.show .modal-dialog {
        transform: scale(1) translateY(0);
    }

    /* Loading state for delete button */
    #confirmDeleteButton.loading {
        pointer-events: none;
        position: relative;
    }

    #confirmDeleteButton.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top: 2px solid #fff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        #deleteServiceModal .modal-body {
            padding: 1.5rem 1rem;
        }

        #deleteServiceModal .modal-footer {
            padding: 1rem;
            flex-direction: column;
            gap: 0.5rem;
        }

        #deleteServiceModal .btn {
            width: 100%;
            min-width: auto;
        }

        #deleteServiceModal .service-icon {
            width: 50px;
            height: 50px;
        }

        #deleteServiceModal .service-icon i {
            font-size: 1.5rem;
        }
    }
</style>

<!-- JavaScript for Delete Modal Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteServiceModal');
        const deleteForm = document.getElementById('deleteServiceForm');
        const serviceNameElement = document.getElementById('delete-service-name');
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');

        // Handle delete button clicks from main table
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-btn') || e.target.closest('.delete-btn')) {
                e.preventDefault();

                const button = e.target.classList.contains('delete-btn') ? e.target : e.target.closest(
                    '.delete-btn');
                const serviceId = button.getAttribute('data-id');
                const serviceName = button.getAttribute('data-name');
                const form = button.closest('form');

                // Update modal content
                if (serviceNameElement) {
                    serviceNameElement.textContent = serviceName || 'Pelayanan';
                }

                // Update form action
                if (deleteForm && form) {
                    deleteForm.action = form.action;
                }

                // Show modal
                const modalInstance = new bootstrap.Modal(deleteModal);
                modalInstance.show();
            }
        });

        // Handle form submission with loading state
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                // Add loading state
                confirmDeleteButton.classList.add('loading');
                confirmDeleteButton.disabled = true;

                const originalHTML = confirmDeleteButton.innerHTML;
                confirmDeleteButton.innerHTML = '<span style="opacity: 0;">Menghapus...</span>';

                // If form validation fails, restore button state after 3 seconds
                setTimeout(() => {
                    if (confirmDeleteButton.classList.contains('loading')) {
                        confirmDeleteButton.classList.remove('loading');
                        confirmDeleteButton.disabled = false;
                        confirmDeleteButton.innerHTML = originalHTML;
                    }
                }, 3000);
            });
        }

        // Reset modal when hidden
        if (deleteModal) {
            deleteModal.addEventListener('hidden.bs.modal', function() {
                // Reset form and button state
                if (confirmDeleteButton) {
                    confirmDeleteButton.classList.remove('loading');
                    confirmDeleteButton.disabled = false;
                    confirmDeleteButton.innerHTML = '<i class="fas fa-trash-alt me-2"></i>Ya, Hapus';
                }

                // Reset service name
                if (serviceNameElement) {
                    serviceNameElement.textContent = '-';
                }

                // Reset form action
                if (deleteForm) {
                    deleteForm.action = '';
                }
            });
        }
    });
</script>
