<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>

    <form action="{{ route('login-staff') }}" method="post">
        @csrf

        <label for="">Email</label>
        <input type="text" name="email">
        <label for="">Password</label>
        <input type="text" name="password">
        <button type="submit">Submit</button>
    </form>
</body>
</html>