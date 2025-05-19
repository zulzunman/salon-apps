<!DOCTYPE html>
<html>
<head>
    <title>Informasi Pemanggilan Pelanggan</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Informasi Pemanggilan Pelanggan</h1>
        </div>

        <div class="content">
            <p>Halo, <strong>{{ $name }}</strong></p>

            <p>Waktu Pelayanan <strong>{{ $time }}</strong></p>
            <p>Nama Pelayanan <strong>{{ $service }}</strong></p>
            <p><strong>Sekarang giliran anda</strong></p>

        <div class="footer">
        </div>
    </div>
</body>
</html>