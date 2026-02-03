<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Tahoma, Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: #fff;
            padding: 30px;
            width: 100%;
            max-width: 350px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1e4fd6;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }

        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>

<div class="card">
    <h2>تسجيل الدخول</h2>

    <form method="POST" action="{{ route('login.check') }}">
        @csrf
        <input type="password" name="password" placeholder="أدخل كلمة المرور" >
        <button type="submit">دخول</button>
    </form>

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif
</div>

</body>
</html>
