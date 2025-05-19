<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tambah data</h1>
    <form action="{{ route('service.add-data') }}" method="post">
        @csrf
        <label for="name">Nama Pelayanan</label>
        <input type="text" name="name">
        <label for="price">Harga Pelayanan</label>
        <input type="text" name="price">
        <label for="duration">Durasi Pelayanan</label>
        <input type="text" name="duration">
        <button type="submit">Submit</button>
    </form>

</body>
</html>