<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 | Akses Ditolak</title>
    <style>
        body { background: #fff3cd; font-family: Poppins; display: flex; justify-content: center; align-items: center; height: 100vh; margin:0; }
        .box-error { text-align: center; }
        .code { font-size: 120px; color: #856404; font-weight: bold; }
        .desc { color: #856404; }
    </style>
</head>
<body>
    <div class="box-error">
        <div class="code">Eits, jangan nakal!</div>
        <p class="desc">Kamu tidak punya kartu akses ke ruangan ini 😜</p>
        <a href="{{ url('/') }}">Kembali</a>
    </div>
</body>
</html>
