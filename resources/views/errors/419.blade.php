<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 | Page Expired</title>

    <!-- Bootstrap -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
        rel="stylesheet">
    
    <style>
        body {
            background: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .error-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 400px;
        }
        .error-code {
            font-size: 70px;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 10px;
        }
        .btn-refresh {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="error-card">
        <div class="error-code">Aduh, sesi kamu kedaluwarsa!</div>
        <h4>Page Expired</h4>
        <p class="text-muted">Sepertinya kamu terlalu lama mikir… atau mungkin lagi ngopi ☕
Yuk refresh dulu biar semangat lagi!</p>

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-refresh">
            Kembali
        </a>
        <a href="/" class="btn btn-primary btn-refresh">
            Kembali ke Beranda
        </a>
    </div>

</body>
</html>
