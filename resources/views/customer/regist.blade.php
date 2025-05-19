<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Pendaftaran Layanan</h1>

    <form action="{{ route('register.add-data') }}" method="post">
        @csrf
        <label for="name">Nama</label>
        <input type="text" id="name" name="name">
        <label for="email">Email</label>
        <input type="text" id="email" name="email">
        <label for="service_id">Pelayanan</label>
        <select name="service_id" id="service_id">
            <option value="">Pilih Pelayanan</option>
            @foreach ( $services as $item)
                <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->duration }} Menit</option>
            @endforeach
        </select>
        <select name="booking_time_id" id="booking_time_id">
            <option value="">Pilih Jam</option>
            @foreach ( $times as $item)
                <option value="{{ $item->id }}">{{ $item->time }}</option>
            @endforeach
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
</html>