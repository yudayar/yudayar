<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require('koneksi.php');
session_start();

$error = '';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    
    if (!empty($email)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($con, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;

            
            $mail = new PHPMailer(true);

            try {
                
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'smyarproductions@gmail.com';   
                $mail->Password   = 'gmxl sjyq yopg lpqh';         
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;                           
                
                $mail->setFrom('no-reply@yourdomain.com', 'Yuda Arif Rahman');
                $mail->addAddress($email);

                
                $mail->isHTML(true);
                $mail->Subject = 'OTP Reset Password';
                $mail->Body    = "Untuk Melakukan Reset Password Gunakan Kode OTP Ini: <b>$otp</b>";

                $mail->send();
                
                header('Location: verify_otp.php');
                exit();
            } catch (Exception $e) {
                $error = "Gagal mengirim email. Error: {$mail->ErrorInfo}";
            }

        } else {
            $error = 'Email tidak ditemukan';
        }
    } else {
        $error = 'Email tidak boleh kosong';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="form-container">
        <form action="forgot_password.php" method="POST">
            <h2>Lupa Password</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="form-group">
                <div class="input-button-wrapper">
                    <input type="email" name="email" placeholder="Masukkan Email Terdaftar" id="email" class="form-control" required>
                    <button type="submit" name="submit" class="btn btn-primary">Kirim OTP</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
