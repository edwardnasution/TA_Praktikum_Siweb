<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="login-container">
        <div class="login-card">
            <div class="login-profile-icon">
                <i class="fas fa-user"></i>
            </div>

            <h3 class="text-center mb-4" style="color: #fff;"><b>Masuk</b></h3>

            @if(session('error'))
            <div class="alert alert-danger text-center" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <span class="input-group-text-login">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autocomplete="off" value="{{ $saved_username ?? '' }}">
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text-login">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>

                <div class="login-links-row">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input-custom" id="remember" name="remember" {{ !empty($saved_username) ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember" style="color: #fff;">Ingat saya</label>
                    </div>
                    <a href="#" class="login-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn btn-primary-login w-100 mt-3">LOGIN</button>
            </form>
        </div>
    </div>

</body>

</html>