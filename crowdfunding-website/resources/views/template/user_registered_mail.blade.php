<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <h1>Mail Register</h1>
    <p>Selamat, bapak / ibu {{ $name }} telah terdaftar di aplikasi kami.<br>
        Silahkan masukkan kode OTP berikut untuk melakukan verifikasi pendaftaran.
    </p>
    <h2>{{ $kode_otp }}</h2>
</body>

</html>