<?php
require('koneksi.php');
session_start();

$error = '';

// Mengecek apakah session username tersedia atau tidak
if (isset($_SESSION['username'])) {
    header('Location: admin/admindesa/index.php');
    exit(); // Tambahkan exit setelah redirect
}

// Mengecek apakah form disubmit atau tidak
if (isset($_POST['submit'])) {
    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($con, $username);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($con, $password);

    if (!empty(trim($username)) && !empty(trim($password))) {
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($con, $query);
        $rows = mysqli_num_rows($result);

        if ($rows != 0) {
            $hash = mysqli_fetch_assoc($result)['password'];
            if (password_verify($password, $hash)) {
                $_SESSION['username'] = $username;
                header('Location: admin/admindesa/index.php');
                exit(); // Tambahkan exit setelah redirect
            } else {
                $error = 'Password salah';
            }
        } else {
            $error = 'User tidak ditemukan atau password salah';
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- custom css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section class="container">
    <div class="login-wrapper">
        <div class="login-container">
            <div class="row no-gutters">
                <div class="col-12 col-md-6">
                    <form class="form-container" action="login.php" method="POST">
                        <h2 class="text-center">DESA PADAMULYA</h2>
                        <!-- Display error message if exists -->
                        <?php if ($error): ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= isset($username) ? $username : '' ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Masukkan Password">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">LOGIN</button>
                        <a href="register.php" class="btn btn-outline-primary">REGISTER</a>
                        <div class="text-center mt-2">
                            <a href="forgot_password.php" class="text-secondary">Forgot Password?</a>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-6 d-none d-md-block">
                    <div class="login-image">
                        <img src="padamulya.jpg" class="img-fluid" alt="Padamulya Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
