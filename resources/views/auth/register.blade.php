<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
        .container{
            background: #fff;
            padding: 30px;
            width: 100%;
            max-width: 350px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
            text-align: center;
        }
        .btn{
            margin-top: 10px;
            width: 100%;

    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>
<body>

    <div class="container">

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input label="Name"  name="name"  />
        </div>
        <div>
            <x-input label="Email" type="email" name="email"  />
        </div>
        <div>
            <x-input  label="password" type="password" name="password"  />
        </div>
        <div>
            <x-input label="Confirmation Password" type="password"  name="password_confirmation"  />
        </div>
        <button class="btn btn-primary" type="submit" > Register </button>
        <a href="{{ route('login.form') }}" class="btn btn-primary" > Login </a>

    </form>
    </div>

</body>
</html>
