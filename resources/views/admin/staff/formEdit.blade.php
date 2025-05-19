<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Edit data</h1>
    <form action="{{ route('staff.edit-data', $data->id) }}" method="post">
        @csrf
        <label for="name">Nama Staff</label>
        <input type="text" name="name" value="{{ $data->name }}">
        <label for="email">Email</label>
        <input type="text" name="email" value="{{ $data->email }}">
        <label for="password">Password</label>
        <input type="text" name="password">
        <label for="password_confirmation">Password Konfirmasi</label>
        <input type="text" name="password_confirmation">
        <button type="submit">Submit</button>
    </form>
</body>
</html>