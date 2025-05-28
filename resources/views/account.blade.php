<!DOCTYPE html>
<html>
<head>
    <title>Account Page</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #0e0f23;
        }

        .background {
            background-image: url('images/auth_background.png'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 40px;
        }

        .logo img {
            height: 50px;
        }

        .account-box {
            background: white;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        .account-box h1 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #333;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            padding-left: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-style: italic;
            box-sizing: border-box;
        }

        button {
            background: black;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="account-box">
            <h1>Welcome, {{ $account->username }}</h1>

            <form method="POST" action="/account/update">
                @csrf

                <div class="input-group">
                    <label>Username:</label>
                    <input type="text" name="username" value="{{ $account->username }}" required>
                </div>

                <div class="input-group">
                    <label>New Password (optional):</label>
                    <input type="password" name="password">
                </div>

                <button type="submit">Update Account</button>
            </form>
        </div>
    </div>
</body>
</html>
