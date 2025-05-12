<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Data Pelanggan</h1>

    <table>
        <tr>
            <th>No Antrean</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Pelayanan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->queue_number }}</td>
                <td>{{ $customer->customer->name }}</td>
                <td>{{ $customer->customer->email }}</td>
                <td>{{ $customer->service->name }}</td>
                @if ($customer->status == 'PENDING')
                    <td>Menunggu</td>
                @elseif ($customer->status == 'CALLING')
                    <td>Dipanggil</td>
                @elseif ($customer->status == 'SERVING')
                    <td>Dilayani</td>
                @endif

                @if ($customer->status == 'PENDING')
                    <form action="{{ route('register.calling', $customer->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <td>
                            <button type="submit" class="btn btn-sm btn-primary">Panggil</button>
                        </td>
                    </form>
                @elseif ($customer->status == 'CALLING')
                    <form action="{{ route('register.serving', $customer->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <td>
                            <button type="submit" class="btn btn-sm btn-primary">Melayani</button>
                        </td>
                    </form>
                @elseif ($customer->status == 'SERVING')
                    <form action="{{ route('register.complete', $customer->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <td>
                            <button type="submit" class="btn btn-sm btn-primary">Selesai</button>
                        </td>
                    </form>
                @endif
            </tr>
        @endforeach
    </table>
</body>
</html>