<!-- Login Modal -->
<div class="modal {{ session('show_login_modal') ? 'show' : '' }}" id="loginModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Login to Your Account</h5>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login-staff') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email"
                        value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password"
                        required>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<script>
    // Auto-show modal if there are validation errors
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('show_login_modal'))
            openModal();
        @endif
    });

    function openModal() {
        document.getElementById('loginModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('loginModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('loginModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
