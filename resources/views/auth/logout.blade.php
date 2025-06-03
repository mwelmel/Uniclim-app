<!DOCTYPE html>
<html>
<head>
    <title>Logout Page</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #0e0f23;
        }

        .background {
            background-image: url('{{ asset('images/auth_background.png') }}'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
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
    <form id="logout-form" action="/logout" method="POST" style="display:none;">
        <!-- csrf token jika pakai laravel -->
    </form>

    <button onclick="confirmLogout()">Logout</button>

    <script>
        function confirmLogout() {
            console.log("confirmLogout dipanggil");
            if (confirm("Anda yakin ingin logout?")) {
                document.getElementById('logout-form').submit();
            } else {
                alert("Logout dibatalkan");
            }
        }
    </script>
</body>
</html>
