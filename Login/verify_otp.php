<?php
session_start();

$error = '';

if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    header('Location: forgot_password.php');
    exit();
}

if (isset($_POST['submit'])) {
    $otp = trim($_POST['otp']);
    
    if ($otp == $_SESSION['otp']) {
        header('Location: reset_password.php');
        exit();
    } else {
        $error = 'Kode OTP salah';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<div class="form-container">
        <form action="verify_otp.php" method="POST">
            <h2>Verifikasi OTP</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="form-group">
                <input type="text" name="otp" placeholder="Masukkan Kode OTP" id="otp" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Verifikasi</button>
        </form>
    </div>
</body>
</html>
