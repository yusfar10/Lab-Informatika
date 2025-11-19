<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informatics Lab</title>
    <link rel="icon" type="image" href="{{ asset('images/LogoInformatics.png') }}">

    <style>
        /* ==== RESET & GLOBAL ==== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #0B1E36;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* ==== CARD LOGIN ==== */
        .login-box {
            background: #fff;
            width: 360px;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-box img {
            width: 64px;
            margin-bottom: 10px;
        }

        .login-box h1 {
            font-size: 22px;
            color: #0B1E36;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .login-box p {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 20px;
        }

        /* ==== FORM ==== */
        .login-box form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .login-box input {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border 0.2s ease;
        }

        .login-box input:focus {
            border-color: #2563eb;
            outline: none;
        }

        .login-box .links {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .login-box .links a {
            color: #2563eb;
            text-decoration: none;
        }

        .login-box .links a:hover {
            text-decoration: underline;
        }

        .login-box button {
            background-color: #2563eb;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-box button:hover {
            background-color: #1e40af;
        }

        /* ==== ERROR MESSAGE ==== */
        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 8px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 10px;
        }

        /* ==== COPYRIGHT ==== */
        .footer {
            font-size: 11px;
            color: #9ca3af;
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 420px) {
            .login-box {
                width: 90%;
                padding: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="login-box">
        <img src="/images/logo.png" alt="Logo">
        <h1>Welcome Kosma!</h1>
        <p>Jangan lupa cek pengumuman untuk info terbaru ya!</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <input type="text" name="login" placeholder="Email atau Username" value="{{ old('login') }}" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="links">
                <a href="{{ route('guest.dashboard') }}">Login as Guest</a>
                <a href="{{ route('password.request') }}">Lupa Password?</a>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="footer">
            Copyright by Kelompok 1 - Manajemen Proyek
        </div>
    </div>

</body>

</html>
