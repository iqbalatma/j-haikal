<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>

    <link rel="shortcut icon" href="{{asset('dist/assets/compiled/svg/favicon.svg')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('dist/assets/compiled/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('dist/assets/compiled/css/app-dark.css')}}">
    <link rel="stylesheet" href="{{asset('dist/assets/compiled/css/auth.css')}}">
    <style>
        /* Tambahkan CSS untuk memposisikan form di tengah dengan box */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }

        #auth {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .auth-title {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .auth-subtitle {
            font-size: 16px;
            margin-bottom: 25px;
            color: #6c757d;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .text-center p {
            font-size: 14px;
        }
    </style>
</head>

<body>
<div id="auth">
    <div class="login-box">
        <img src="{{asset('assets/images/logo_1.png')}}" width="150px" alt="logo"/>
        <h1 class="auth-title mt-4">Lupa Password.</h1>
        <p class="auth-subtitle mb-5">Silahkan masukkan email untuk mengirimkan tautan reset password.</p>

        <x-alert></x-alert>
        <form action="{{route('forgot.password.request.forgot.password')}}" method="POST">
            @csrf
            <div class="form-group position-relative has-icon-left mb-4">
                <input type="email" class="form-control form-control-xl" placeholder="Email" name="email" value="{{old('email')}}">
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>

            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3" type="submit">Lupa Password</button>
            <a href="{{route('login')}}">
                <button class="btn btn-secondary btn-block btn-lg shadow-lg mt-3" type="button">Kembali Ke Halaman Login</button>
            </a>
        </form>
    </div>
</div>

<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
</body>

</html>
