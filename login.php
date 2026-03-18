<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}

$error = false;

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        
        header("Location: index.php");
        exit;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <!-- Ikon Profil Tengah Atas -->
        <div class="login-profile-icon">
            <i class="fas fa-user"></i>
        </div>

<h3 class="text-center mb-4" style="color: #fff;"><b>Masuk</b></h3>

        <?php if ($error) : ?>
            <div class="alert alert-danger" role="alert">
                Username atau Password salah!
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- Username dengan Ikon Kiri -->
            <div class="input-group mb-3">
                <span class="input-group-text-login">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required autocomplete="off">
            </div>
            
            <!-- Password dengan Ikon Kiri -->
            <div class="input-group mb-3">
                <span class="input-group-text-login">
                    <i class="fas fa-lock"></i>
                </span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>

            <!-- Checkbox Remember Me & Lupa Password -->
            <div class="login-links-row">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input-custom" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
                <a href="#" class="login-link">Lupa password?</a>
            </div>
            
            <button type="submit" name="login" class="btn btn-primary-login w-100">LOGIN</button>
        </form>
    </div>
</div>

</body>
</html>
