<?php
// jalanin session
// session_start() harus ada di paling atas
// jika ada output sebelum session_start() maka akan error
// karena session_start() harus dipanggil sebelum ada output apapun
// biar bisa pake variabel session
session_start();
if(isset($_SESSION['new_user'])) {
    $_SESSION['sudah_buat_akun'] = true; // set session sudah buat akun
    header('Location: login.php'); 
}

include '../config/global-config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <?= $icon ?>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Montserrat:ital,wght@0,300;1,300&display=swap');
        * {
            box-sizing: border-box;
            font-family: EB Garamond;
        }

        body {
            display: flex; 
            justify-content: center;
            background-color: rgb(222, 224, 234);

        }

        .container {
           position: absolute;
           top: 20%;
           bottom: 20%;
           animation: fadeIn 1.5s ease-in-out;
        }

        .form-input {
            width: 100%;
            padding: 10px 50px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-size: 16px;
            transition: 0.5s;
            background-color:  rgb(212, 214, 225);
            animation: fadeIn 1s ease-in-out;
        }

        .form-input::placeholder {
            text-align: center;
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            animation: fadeIn 2s ease-in-out;
        }

        .form-input:focus {
            outline: none;
            border: 2px solid rgb(96, 102, 215);
            box-shadow: 0 0 5px rgb(96, 102, 215);
        }
        .btn-login {
            width: 100%;
            padding: 10px 20px;
            background-color:rgb(0, 13, 255);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.5s;
            animation: fadeIn 1s ease-in-out;
        }
        .btn-login:hover {
            background-color: rgb(32, 43, 255);
            box-shadow: 0 0 10px rgb(0, 13, 255);
            text-shadow: 0 0 10px rgb(255, 255, 255);
            transition: 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />

</head>
<body>
    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
    </script>
    
    <div class="container">
        <h2>Pendaftaran Tamu</h2>
        <hr class="bar">


        <?php if(isset($_SESSION['login_error'])): ?>
            <script>
                Swal.fire({
                    title: 'Oops...',
                    text: '<?= $_SESSION['login_error'] ?>',
                    showConfirmButton: true,
                    confirmButtonText: 'Baiklah',
                    confirmButtonColor: 'rgb(0, 13, 255)',
                    footer: '<a href="help.php">Butuh Bantuan?</a>',
                    background: 'rgb(238, 238, 238)',
                    color: 'black',
                showClass: {
                    popup: `
                    animate__animated
                    animate__fadeIn
                    `

                },
                hideClass: {
                    popup: `
                    animate__animated
                    animate__fadeOut
                    `
                }
                });

            </script>
        <?php 
            endif;
            unset($_SESSION['login_error']); // hapus session login_error setelah ditampilkan
        ?>
        <?php if(isset($_SESSION['popupBerhasil'])): ?>
            <script>
                Swal.fire({
                    title: 'Bagus!',
                    text: '<?= $_SESSION['popupBerhasil'] ?>',
                    showConfirmButton: true,
                    confirmButtonText: 'Baiklah',
                    confirmButtonColor: 'rgb(0, 13, 255)',
                    background: 'rgb(238, 238, 238)',
                    color: 'black',
                showClass: {
                    popup: `
                    animate__animated
                    animate__fadeIn
                    `

                },
                hideClass: {
                    popup: `
                    animate__animated
                    animate__fadeOut
                    `
                }
                });
            </script>
        <?php 
            endif;
            unset($_SESSION['popupBerhasil']); // hapus session login_error setelah ditampilkan
        ?>
       
        <form action="" method="post">
            <label>Siapa Namamu?</label>
            <input type="" name="name" class="form-input" placeholder="Buat Nama" required>
            <label>Sepertinya Aku Butuh Alamatmu</label>
            <input type="email" name="email" class="form-input" placeholder="Masukan Email" required>
            <label>Gembok Pintunya!</label>
            <input type="password" name="password" class="form-input" placeholder="Buat Password" required>
            <label>Konfirmasi Gembokmu</label>
            <input type="password" name="konfirm_password" class="form-input" placeholder="Buat Password" required>
            <button class="btn-login" name="submit">Daftar</button>
            <p>Sudah pernah menjadi tamu? <a href="login.php">Masuk</a></p>
        </form>
        <hr class="bar2">

    </div>

    <?php

        include 'conn.php';

        // ketika tombol dengan name submit diklik
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $konfirm_password = $_POST['konfirm_password'];
            $role = 'Tamu'; // role default untuk tamu
            $deleted = 0; // status deleted default 0

            // cek apakah password dan konfirmasi password sama
            if ($_POST['password'] != $_POST['konfirm_password']) {
                $_SESSION['login_error'] = "Password tidak sama";
                header('Location: signin.php');
                exit;
            }
            // cek apakah semua field sudah diisi
            if (empty($name) || empty($email) || empty($password) || empty($konfirm_password)) {
                $_SESSION['login_error'] = "Semua field harus diisi";
                header('Location: signin.php');
                exit;
            }

            // cek apakah email sudah terdaftar
            $result = mysqli_query($conn, "SELECT * FROM login WHERE email='$email'");
            if (mysqli_num_rows($result) > 0) {
               $_SESSION['login_error'] = "Email sudah terdaftar";
               header('Location: signin.php');
               exit;
            }

            // jika email belum terdaftar, simpan data ke database
            // Generate Random Code
            $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $randomChar = str_shuffle($char);
            $sp_code = substr($randomChar, 0, 6);

            $query = mysqli_query($conn, "INSERT INTO login (username, email, password, role, sp_code, deleted, status, is_login) VALUES ('$name', '$email', '$password', '$role', '$sp_code', $deleted, 'ok', '0')");

            if ($query) {
                $_SESSION['new_user'] = true; // set session new_user
                $_SESSION['popupBerhasil'] = "Kamu berhasil mendaftar! Silakan masuk. catat kode rahasiamu, kamu akan membutuhkannya nanti (Kode sekali pakai): " . $sp_code;

            } else {
                $_SESSION['login_error'] = "Gagal mendaftar!";
                header('Location: signin.php');
                exit;
            }
        }


    ?>
</body>
</html>