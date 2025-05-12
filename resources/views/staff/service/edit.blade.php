<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Edit data</h1>
    <form action="{{ route('service.edit-data', $service->id) }}" method="post">
        @csrf
        <label for="name">Nama Pelayanan</label>
        <input type="text" name="name" value="{{ $service->name }}">
        <label for="price">Harga Pelayanan</label>
        <input type="text" name="price" value="{{ $service->price }}">
        <label for="duration">Durasi Pelayanan</label>
        <input type="text" name="duration" value="{{ $service->duration }}">
        <button type="submit">Submit</button>
    </form>

</body>
</html>