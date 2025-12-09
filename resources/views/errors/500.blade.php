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
@include('errors.layout', [
    'title' => '500',
    'message' => 'Server lagi ngambek 😭\nTolong coba lagi nanti.',
    'video' => 'errors/500.mp4'
])
</body>
</html>
