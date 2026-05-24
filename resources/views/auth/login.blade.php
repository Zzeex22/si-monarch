<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Si-MONARCH</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="login-box">
        <h2>Si-MONARCH</h2>
        <p>Sistem Informasi Manajemen Proyek & Arsip</p>

        @error('username')
            <div class="error-msg">{{ $message }}</div>
        @enderror

        <form action="{{ url('/login') }}" method="POST">
            @csrf 
            
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>

</body>
</html>