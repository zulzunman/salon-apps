<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Data Staff</h1>

    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td><a href="{{ route('staff.form-edit', $item->id) }}">Edit data</a></td>
                <form action="{{ route('staff.delete-data', $item->id) }}" method="POST" style="display:inline;">
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