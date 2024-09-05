<?php
require('koneksi.php');
session_start();

$error = '';

if (!isset($_SESSION['email'])) {
    header('Location: forgot_password.php');
    exit();
}

if (isset($_POST['submit'])) {
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = $_SESSION['email'];

    if (empty($new_password) || empty($confirm_password)) {
        $error = 'Password tidak boleh kosong';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok';
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
        
        if (mysqli_query($con, $query)) {
            session_unset();
            session_destroy();
            header('Location: login.php');
            exit();
        } else {
            $error = 'Terjadi kesalahan, coba lagi';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div class="form-container">
        <form action="reset_password.php" method="POST">
            <h2>Reset Password</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="form-group">
                <input type="password" name="new_password" placeholder="Masukkan Password Baru" id="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Konfirmasi Password" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
</body>
</html>
