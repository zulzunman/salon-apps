<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Report</title>
</head>
<body>
    <h1>DATA REPORT</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Staff</th>
                <th>Data pelayanan pelanggan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $user)
                @foreach ($user->registrations as $registration)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $registration->id }}</td>
                        <td>{{ $registration->status }}</td>
                        <td>{{ $registration->queue_number }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
