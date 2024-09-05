<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMc6VI7dWrZmy4y64yQQYKVJZXFsm6ZX7R6ibkR" crossorigin="anonymous">

    <!-- custom css -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php
// menyertakan file program koneksi.php pada register
require('koneksi.php');
// inisialisasi session
session_start();

$error = '';
$validate = '';
if (isset($_SESSION['user'])) header('Location: ../halaman login/admin/admindesa/index.php');

// mengecek apakah data username yang diinputkan user kosong atau tidak
if (isset($_POST['submit'])) {
    // menghilangkan backslashes
    $username = stripslashes($_POST['username']);
    // cara sederhana mengamankan dari sql injection
    $username = mysqli_real_escape_string($con, $username);
    $name = stripslashes($_POST['name']);
    $name = mysqli_real_escape_string($con, $name);
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($con, $email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($con, $password);
    $repass = stripslashes($_POST['repassword']);
    $repass = mysqli_real_escape_string($con, $repass);

    // cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
    if (!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))) {
        // mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
        if ($password == $repass) {
            // memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
            if (cek_nama($username, $con) == 0) {
                // hashing password sebelum disimpan di database
                $pass = password_hash($password, PASSWORD_DEFAULT);
                // insert data ke database
                $query = "INSERT INTO users (username, name, email, password) VALUES ('$username', '$name', '$email', '$pass')";
                $result = mysqli_query($con, $query);

                // jika insert data berhasil maka akan menampilkan pesan dan diredirect ke halaman login.php
                if ($result) {
                    // Menampilkan animasi centang dan pesan sukses
                    echo "<div class='text-center animate__animated animate__fadeIn'>
                            <svg class='checkmark' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 52 52'>
                                <circle class='checkmark__circle' cx='26' cy='26' r='25' fill='none'/>
                                <path class='checkmark__check' fill='none' d='M14.1 27.2l7.1 7.2 16.7-16.8'/>
                            </svg>
                            <p>Register Berhasil! Mengalihkan ke halaman login...</p>
                          </div>";
                    
                    // Mengalihkan ke halaman login setelah beberapa detik
                    header("refresh:2;url=login.php");
                    exit(); // Tambahkan exit untuk menghentikan eksekusi skrip                
                } else {
                    $error = 'Register User Gagal !!';
                }
            } else {
                $error = 'Username sudah terdaftar !!';
            }
        } else {
            $validate = 'Password tidak sama !!';
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}

// fungsi untuk mengecek username apakah sudah terdaftar atau belum
function cek_nama($username, $con) {
    $nama = mysqli_real_escape_string($con, $username);
    $query = "SELECT * FROM users WHERE username = '$nama'";
    if ($result = mysqli_query($con, $query)) return mysqli_num_rows($result);
}
?>
<section class="container-fluid mb-4">
    <!-- justify-content-center untuk mengatur posisi form agar berada di tengah-tengah -->
    <section class="row justify-content-center">
        <section class="col-12 col-sm-6 col-md-4">
            <form class="form-container" action="register.php" method="POST">
                <h4 class="text-center font-weight-bold">Sign-Up</h4>
                <?php if ($error != '') { ?>
                    <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                <?php } ?>

                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="InputEmail" name="email" aria-describedby="emailHelp" placeholder="Masukkan email">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password">
                    <?php if ($validate != '') { ?>
                        <p class="text-danger"><?= $validate; ?></p>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="InputRePassword" name="repassword" placeholder="Re-Password">
                    <?php if ($validate != '') { ?>
                        <p class="text-danger"><?= $validate; ?></p>
                    <?php } ?>
                </div>
                <div class="button-container">
                    <button type="submit" name="submit" class="btn btn-register btn-block">Register</button>
                    <a href="login.php" class="btn btn-primary btn-block">
                        Login <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </form>
        </section>
    </section>
</section>

<!-- Bootstrap requirement jQuery pada posisi pertama, kemudian Popper.js, dan yang terakhir Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
