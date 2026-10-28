<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Headway College ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0D47A1;
            --secondary-color: #1565C0;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0D47A1 0%, #1565C0 50%, #42A5F5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 14px;
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            padding: 28px 24px;
            text-align: center;
        }

        .login-header h4 {
            margin: 0;
            font-weight: 700;
        }

        .login-body {
            padding: 26px;
            background: #fff;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .btn-login {
            background: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 10px;
        }

        .btn-login:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }
    </style>
</head>
<body>
<div class="card login-card">
    <div class="login-header">
        <div class="mb-2"><i class="fas fa-graduation-cap fa-2x"></i></div>
        <h4>Headway College ERP</h4>
        <small>Admin Login</small>
    </div>

    <div class="login-body">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required
                    autofocus
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                >
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
    </div>
</div>
</body>
</html>
