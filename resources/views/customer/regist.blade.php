<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Layanan Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            max-width: 700px;
            margin: 0 auto;
        }

        .form-title {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            position: relative;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        .queue-number {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }

            100% {
                transform: scale(1);
            }
        }

        .queue-number h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .queue-number p {
            font-size: 1.1rem;
            margin-bottom: 0;
            opacity: 0.9;
        }

        .booking-info {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }

        .booking-info h5 {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .booking-detail {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #333;
        }

        .booking-detail i {
            color: #667eea;
            margin-right: 10px;
            width: 20px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .alert {
            border-radius: 15px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }

        .service-option {
            padding: 15px;
            border-radius: 12px;
            border: 2px solid #e9ecef;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .service-option:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .service-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .service-details {
            font-size: 0.9rem;
            color: #666;
        }

        .service-price {
            font-weight: 600;
            color: #667eea;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                margin: 10px;
            }

            .queue-number h3 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1 class="form-title">
                <i class="bi bi-person-plus me-2"></i>
                Form Pendaftaran
            </h1>

            <!-- Queue Number Display -->
            <div class="queue-number">
                <h3>
                    <i class="bi bi-hash me-2"></i>
                    {{ $queueNumber }}
                </h3>
                <p>
                    <i class="bi bi-calendar-date me-2"></i>
                    Nomor Antrian Anda Hari Ini
                </p>
            </div>

            <!-- Booking Information Display -->
            <div class="booking-info">
                <h5><i class="bi bi-info-circle me-2"></i>Informasi Booking Anda</h5>
                <div class="booking-detail">
                    <i class="bi bi-scissors"></i>
                    <span>Layanan: <strong>{{ $selectedService->name }}</strong></span>
                </div>
                <div class="booking-detail">
                    <i class="bi bi-info-circle"></i>
                    <span>{{ $selectedService->description }}</span>
                </div>
                <div class="booking-detail">
                    <i class="bi bi-clock-history"></i>
                    <span>Durasi: <strong>{{ $selectedService->duration }} menit</strong></span>
                </div>
                <div class="booking-detail">
                    <i class="bi bi-tag"></i>
                    <span>Harga: <strong>Rp {{ number_format($selectedService->price, 0, ',', '.') }}</strong></span>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="bi bi-exclamation-triangle me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.add-data') }}" method="post">
                @csrf

                <!-- Hidden fields for booking data -->
                <input type="hidden" name="service_id" value="{{ $selectedService->id }}">

                <div class="mb-4">
                    <label for="name" class="form-label">
                        <i class="bi bi-person me-2"></i>Nama Lengkap
                    </label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap Anda" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-2"></i>Alamat Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        placeholder="contoh@email.com" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>
                        Konfirmasi Pendaftaran
                    </button>
                </div>

                <div class="text-center mt-4">
                    <span class="mx-3">|</span>
                    <a href="{{ route('home-page') }}" class="back-link">
                        <i class="bi bi-house me-1"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
