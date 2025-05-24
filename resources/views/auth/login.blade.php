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
            <form>
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" placeholder="Password" id="password">
                    <i class="fa fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
                <div class="options">
                    <label><input type="checkbox"> Remember Me</label>
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
