<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - {{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .error-card {
            background: #ffffff;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 500px;
        }
        .error-video {
            width: 200px;
            margin-bottom: 20px;
        }
        .error-title {
            font-size: 45px;
            font-weight: 800;
        }
        .error-message {
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="error-card">
        
        {{-- AREA VIDEO / GIF --}}
        @if(isset($video))
            <video autoplay loop muted class="error-video">
                <source src="{{ asset($video) }}" type="video/mp4">
            </video>
        @endif

        {{-- JUDUL ERROR --}}
        <h1 class="error-title">{{ $title }}</h1>

        {{-- PESAN ERROR --}}
        <p class="error-message mb-4">{{ $message }}</p>

        <a href="{{ url('/') }}" class="btn btn-primary px-4">Kembali</a>
    </div>

</body>
</html>
