<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konfirmasi Email</title>
</head>
<body>
    
    <p>Verifikasi email kau, {{ $user->fullname }}</p>
    <a href="{{ 'http://localhost:8000/confirmEmail/' . $user->verifyToken }}">Konfirmasi email</a>

</body>
</html>