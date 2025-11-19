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

        .login-box button:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }

        /* ==== LOADING SPINNER ==== */
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: #0B1E36;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(8px);
            transition: opacity 0.5s ease;
        }

        .loading-overlay.loading-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loading-overlay.active {
            display: flex;
            opacity: 1;
        }

        .loader {
            width: 80px;
            height: 80px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top: 4px solid #ffffff;
            border-right: 4px solid #4895ef;
            border-bottom: 4px solid #ffffff;
            border-left: 4px solid #4895ef;
            border-radius: 50%;
            animation: spin 1.2s linear infinite;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            position: relative;
        }

        .loader::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 4px solid transparent;
            border-top: 4px solid #4895ef;
            border-radius: 50%;
            animation: spin 2s linear infinite reverse;
        }

        .loader::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 4px solid transparent;
            border-top: 4px solid #ffffff;
            border-radius: 50%;
            animation: spin 3s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            margin-top: 30px;
            font: 600 17px 'Poppins', sans-serif;
            color: #ffffff;
            text-align: center;
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

    <!-- Loading Spinner Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader"></div>
        <p class="loading-text">Sedang memproses login...</p>
    </div>

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

            <button type="submit" id="loginButton">Login</button>
        </form>

        <div class="footer">
            Copyright by Kelompok 1 - Manajemen Proyek
        </div>
    </div>

    <script>
        // Loading Spinner saat Login
        (function() {
            const form = document.querySelector('form');
            const loginButton = document.getElementById('loginButton');
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Pastikan loading overlay hidden by default
            loadingOverlay.classList.remove('active');

            // Hide spinner jika ada error (ketika page reload dengan error)
            if (document.querySelector('.error')) {
                loadingOverlay.classList.remove('active');
                loginButton.disabled = false;
                loginButton.textContent = 'Login';
            }

            form.addEventListener('submit', function(e) {
                // Validasi form dulu
                const loginInput = document.querySelector('input[name="login"]');
                const passwordInput = document.querySelector('input[name="password"]');

                if (loginInput.value.trim() === '' || passwordInput.value.trim() === '') {
                    // Jika form kosong, jangan tampilkan loading
                    e.preventDefault();
                    return false;
                }

                // Show loading spinner
                loadingOverlay.classList.add('active');
                
                // Disable button
                loginButton.disabled = true;
                loginButton.textContent = 'Memproses...';
            });
        })();

        // Anti Back/Forward Browser untuk Login Page
        (function(){
            // Jika user sudah login, tetap di halaman login (jangan auto redirect)
            // Ini memungkinkan user untuk login kembali jika forward dari dashboard
            
            // Tambahkan entry baru di history untuk prevent back button
            history.pushState(null, null, location.href);

            // Handle ketika user tekan back/forward button
            window.onpopstate = function(event) {
                // Push state lagi untuk prevent back
                history.pushState(null, null, location.href);
            };

            // Prevent back button dengan menambahkan state setiap kali page load
            window.addEventListener('load', function() {
                history.pushState(null, null, location.href);
            });
        })();
    </script>
</body>

</html>
