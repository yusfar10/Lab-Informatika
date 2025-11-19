<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 | Server Error</title>

    <style>
        body { background: #f8d7da; font-family: Poppins, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box-error { text-align: center; }
        .code { font-size: 120px; font-weight: bold; color: #dc3545; }
        .desc { font-size: 18px; color: #721c24; margin-bottom: 20px; }
        a { padding: 10px 20px; background: #dc3545; color: white; text-decoration: none; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="box-error">
        <div class="code">Waduh, servernya lagi ngamuk!</div>
        <p class="desc">Tenang… kita lagi nenangin dia dulu. Coba balik lagi nanti ya. </p>
        <a href="{{ url('/') }}">Kembali ke Beranda</a>
    </div>
</body>
</html>
