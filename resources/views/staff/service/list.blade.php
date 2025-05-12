<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Data Pelayanan</h1>

    <table>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Waktu (Menit)</th>
            <th>Aksi</th>
        </tr>
        @foreach ($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ $service->price }}</td>
                <td>{{ $service->duration }}</td>
                <td><a href="{{ route('service.form-edit', $service->id) }}">Edit data</a></td>
                <form action="{{ route('service.delete-data', $service->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <td>
                        <button type="submit" class="btn btn-sm btn-primary">Delete data</button>
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
</body>
</html>