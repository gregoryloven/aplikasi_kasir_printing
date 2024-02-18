<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Logo -->
    <link rel="icon" href="{{ asset('logo.jpeg') }}" type="image/jpeg" width="10px" height="10px">

    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
        }

        body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
        }

        .hero-banner {
            background-image: url('{{ asset('background.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh; /* Menyesuaikan tinggi hero banner */
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding-top: 20px; /* Menambahkan padding atas */
        }

        .hero-banner .container {
            padding: 0; /* Hapus padding default */
        }

        .hero-banner img {
            max-width: 100%; /* Pastikan gambar logo tidak melebihi lebar kontainer */
            height: auto; /* Pertahankan rasio aspek */
            margin-bottom: 20px; /* Tambahkan beberapa ruang di bawah logo */
        }
        .btn-login {
            margin-top: 430px; /* Menambahkan margin atas untuk memberikan jarak dari elemen di atasnya */
        }

    </style>
</head>
<body class="antialiased">
    <div class="hero-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if (Route::has('login'))
                        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                            @auth
                                <a href="{{ url('/product') }}" class="btn btn-primary font-weight-bold" style="font-size: 24px; padding: 16px 32px;">Home</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-warning font-weight-bold btn-login" style="font-size: 24px; padding: 16px 32px;">Log in</a>
                                <!-- Jika Anda ingin menampilkan tombol pendaftaran, tambahkan kode berikut -->
                                <!-- <a href="{{ route('register') }}" class="btn btn-secondary ml-4">Register</a> -->
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
