<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 | Halaman Tidak Ditemukan</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .box-error {
            text-align: center;
        }
        .code {
            font-size: 90px;
            font-weight: 700;
            color: #007bff;
            margin-bottom: -20px;
        }
        .title {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .desc {
            font-size: 16px;
            margin-bottom: 30px;
            color: #666;
        }
        .btn-home {
            padding: 10px 25px;
            background: #007bff;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }
        .btn-home:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
@include('errors.layout', [
    'title' => '404',
    'message' => 'Ups! Halaman yang kamu cari hilang ke dunia lain 🤯',
    'video' => 'errors/404.mp4'
])

</body>
</html>
