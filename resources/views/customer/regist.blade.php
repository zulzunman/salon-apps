<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Layanan Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 0 auto;
        }

        .form-title {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-control:focus {
            border-color: #212529;
            box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.25);
        }

        .btn-primary {
            background-color: #212529;
            border-color: #212529;
        }

        .btn-primary:hover {
            background-color: #1a1e21;
            border-color: #1a1e21;
        }

        .form-label {
            font-weight: 500;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1 class="form-title">Pendaftaran Layanan</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.add-data') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="service_id" class="form-label">Pelayanan</label>
                    <select class="form-select" name="service_id" id="service_id" required>
                        <option value="">Pilih Pelayanan</option>
                        @foreach ($services as $item)
                            <option value="{{ $item->id }}"
                                {{ old('service_id') == $item->id || $selectedServiceId == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} - {{ $item->duration }} Menit - Rp
                                {{ number_format($item->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="booking_time_id" class="form-label">Jam Layanan</label>
                    <select class="form-select" name="booking_time_id" id="booking_time_id" required>
                        <option value="">Pilih Jam</option>
                        @foreach ($times as $item)
                            <option value="{{ $item->id }}"
                                {{ old('booking_time_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->time }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('home-page') }}" class="text-decoration-none">Kembali ke Halaman Utama</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
