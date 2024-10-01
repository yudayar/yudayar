<html>
<head>
    <title>Add Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .fadeOut {
            animation: fadeOut 1s forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }

        input[type="text"], select {
            width: calc(100% - 20px);
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 15px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-top: 5px;
            color: #333;
            text-decoration: none;
            font-size: 15px;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            margin-top: 20px;
            color: red;
            animation: slideIn 0.5s ease-in-out;
        }

        .success-message {
            margin-top: 20px;
            color: green;
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

    </style>
</head>

<body>
    <div class="form-container" id="form-container">
        <h2>Create / Edit Data</h2>

        <?php
        if (isset($_POST['Submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];

            // Include config file
            include_once("config.php");

            // Cek apakah email atau nomor HP sudah ada
            $check_query = "SELECT * FROM users WHERE email='$email' OR mobile='$mobile'";
            $check_result = mysqli_query($mysqli, $check_query);
            
            if (mysqli_num_rows($check_result) > 0) {
                // Jika data sudah ada
                echo "<p class='error-message'>Data sudah ada, gunakan email atau nomor HP yang berbeda!</p>";
            } else {
                // Insert the data into the database
                $result = mysqli_query($mysqli, "INSERT INTO users(name, email, mobile) VALUES('$name', '$email', '$mobile')");
                
                // Success message
                echo "<p class='success-message'>Tambah data berhasil</p>";
            }
        }
        ?>

        <form action="add.php" method="post" name="form1" onsubmit="return validateForm()">
            <input type="text" name="name" placeholder="Nama" id="name">
            <input type="text" name="email" placeholder="Email" id="email">
            <input type="text" name="mobile" placeholder="Mobile" id="mobile">
            <input type="submit" name="Submit" value="Simpan Data">
        </form>
        <div class="error-message" id="error-message"></div>
        <a href="index.php">Home</a>
    </div>

    <script>
        function validateForm() {
            // Ambil elemen form
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var mobile = document.getElementById("mobile").value;
            var errorMessage = document.getElementById("error-message");
            var formContainer = document.getElementById("form-container");

            // Cek apakah semua field diisi
            if (name == "" || email == "" || mobile == "") {
                // Tampilkan pesan error
                errorMessage.textContent = "Harap isi semua field!";
                return false; // Mencegah form dikirim
            }

            // Animasi fade out form setelah submit berhasil
            formContainer.classList.add('fadeOut');

            // Jika semua field diisi, izinkan form dikirim
            return true;
        }
    </script>
</body>
</html>
