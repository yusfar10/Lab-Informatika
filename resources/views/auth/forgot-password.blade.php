<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LogoInformatics.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7f7f7;
        }

        .box {
            max-width: 450px;
            margin: 80px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .wa-btn {
            background: #25D366;
            color: #fff;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
        }

        .links a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="box">
        <h3 class="fw-bold">Lupa Password?</h3>
        <p class="text-muted">
            Untuk mereset password, silakan hubungi Admin melalui WhatsApp.
        </p>

        <a href="https://wa.me/6281224159432?text=Halo%20Admin,%20saya%20lupa%20password.%20Tolong%20bantu%20reset."
            class="wa-btn" target="_blank">
            Hubungi Admin via WhatsApp
        </a>

        <div class="links">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</body>

</html>
