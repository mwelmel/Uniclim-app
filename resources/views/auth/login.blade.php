<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | UniClim</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="background">
        <div class="logo">
            <img src="{{ asset('images/Logo UniCLim.png') }}" alt="UniClim Logo">
        </div>

        <div class="login-box">
            <h2>Log in</h2>
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
                </div>
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" id="password" required>
                    <i class="fa fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
                @if ($errors->any())
                    <div class="error-message">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="options">
                    <label><input type="checkbox" name="remember"> Remember Me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit">Log in</button>
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
