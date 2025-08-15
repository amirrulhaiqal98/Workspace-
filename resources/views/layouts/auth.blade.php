<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    
    <style>
        .auth-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/login_page.jpeg') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.3;
            z-index: -1;
        }
        
        .login-page {
            background: transparent !important;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .login-box {
            width: 400px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            padding: 20px;
        }
        
        .card {
            background: transparent;
            border: none;
            box-shadow: none;
        }
        
        .login-logo a {
            color: #007bff;
            font-size: 2rem;
            font-weight: bold;
            text-decoration: none;
        }
        
        .login-box-msg {
            color: #6c757d;
            font-weight: 500;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="auth-background"></div>
    <div class="login-box">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>