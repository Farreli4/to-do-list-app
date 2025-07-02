<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>To-Do List App</title>
    <style>
        /* Reset default style */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Full page background and center content */
        body {
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Container style */
        .container {
            text-align: center;
            color: #fff;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.25);
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 600px;
        }

        /* Title styling */
        .title {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        /* Subtitle styling */
        .subtitle {
            font-size: 1.2rem;
            margin-bottom: 40px; /* Ditambah margin agar ada jarak ke tombol */
        }

        /* === PERUBAHAN CSS DIMULAI DI SINI === */

        /* Container untuk grup tombol */
        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px; /* Jarak antar tombol */
            flex-wrap: wrap; /* Agar tombol tidak rusak di layar kecil */
        }

        /* Button styling (Tombol utama) */
        .btn {
            text-decoration: none;
            color: #fff;
            background-color: #ff4081;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
            border: 2px solid transparent;
        }

        .btn:hover {
            background-color: #e91e63;
        }

        /* Styling untuk tombol sekunder (Register) */
        .btn.btn-secondary {
            background-color: transparent;
            border-color: #fff;
        }

        .btn.btn-secondary:hover {
            background-color: #fff;
            color: #ff4081;
        }
        /* === PERUBAHAN CSS SELESAI === */

    </style>
</head>
<body>
<div class="container">
    <h1 class="title">Welcome to To-Do List App</h1>
    <p class="subtitle">Organize your day efficiently and stay productive</p>

    <div class="button-group">
        {{-- Logika Blade: Tampilkan tombol berbeda jika user sudah login atau belum --}}

        @guest
        {{-- Tampilan untuk tamu (belum login) --}}
        <a href="{{ route('login') }}" class="btn">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
        @endguest

        @auth
        {{-- Tampilan untuk user yang sudah login --}}
        <a href="{{ route('todos.index') }}" class="btn">Go to My Dashboard</a>
        @endauth
    </div>
</div>
</body>
</html>
