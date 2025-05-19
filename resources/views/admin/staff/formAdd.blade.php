<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tambah data</h1>
    <form action="{{ route('staff.add-data') }}" method="post">
        @csrf
        <label for="name">Nama</label>
        <input type="text" name="name">
        <label for="email">Email</label>
        <input type="text" name="email">
        <label for="password">Password</label>
        <input type="text" name="password">
        <label for="password_confirmation">Password Konfirmasi</label>
        <input type="text" name="password_confirmation">
        <button type="submit">Submit</button>
    </form>
</body>
</html>