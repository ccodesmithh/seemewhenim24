<?php
// jalanin session
// session_start() harus ada di paling atas
// jika ada output sebelum session_start() maka akan error
// karena session_start() harus dipanggil sebelum ada output apapun
// biar bisa pake variabel session
session_start();
if(isset($_SESSION['login'])) {
    $_SESSION['sudah_login'] = true; // menandakan bahwa user sudah login
    $_SESSION['berhasil'];
    header('Location: ruangtamu.php'); // jika sudah login, redirect ke index.php
    exit;
}

// Global config
include '../config/global-config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
        <h2>Masuk Ke Rumah</h2>
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
        <?php if(isset($_SESSION['Berhasil'])): ?>
            <script>
                Swal.fire({
                    title: 'Bagus!',
                    text: '<?= $_SESSION['Berhasil'] ?>',
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
            unset($_SESSION['Berhasil']); // hapus session login_error setelah ditampilkan

        ?>



        <form action="" method="post">
            <label>Dari Mana Kamu?</label>
            <input type="email" name="email" class="form-input" placeholder="Masukan Email" required>
            <label>Bawakah Kau Kunci Rumahku?</label>
            <input type="password" name="password" class="form-input" placeholder="Masukan Password" required>
            <button class="btn-login" name="submit">Login</button>
            <p>Belum daftar? <a href="signin.php">Daftar sebagai tamu</a></p>
        </form>
        <hr class="bar2">

    </div>

    <?php

        

        include 'conn.php'; // include file koneksi database

        // ketika tombol dengan name submit diklik
        if (isset($_POST['submit'])) { // Cek apakah tombol submit ditekan
            $password = $_POST['password'];
            $email = $_POST['email'];

            if (!empty($password) && !empty($email)) {
                $query = "SELECT * FROM login WHERE email='$email' AND password='$password' AND deleted=0 LIMIT 1";
                $sql = mysqli_query($conn, $query);
                $login = mysqli_fetch_assoc($sql);

                if ($login) {
                    if ($login['status'] === 'ok' && $login['is_login'] == 0) {
                        $_SESSION['berhasil'] = 'Berhasil masuk ke Ruang Tamu';
                        mysqli_query($conn, "UPDATE login SET is_login = '1' WHERE id = '". $login['id'] . "'" );
                        $_SESSION['login'] = $login;
                        header('Location: ruangtamu.php');
                        exit();

                    } elseif ($login['status'] === 'banned') {
                        $bannedUntil = $login['banned_until'];

                        if (!empty($bannedUntil) && $bannedUntil !== '0000-00-00 00:00:00' && strtotime($bannedUntil)) {
                            $formattedDate = date('d-m-Y H:i', strtotime($bannedUntil));

                            // Hitung selisih waktu saat ini dengan waktu banned_until
                            $now = new DateTime(); // waktu saat ini
                            $bannedDate = new DateTime($bannedUntil); // waktu banned
                            $interval = $now->diff($bannedDate); // hitung selisih waktu
                            $remainingDays = $interval->days; // ambil total hari selisih

                            
                            // Jika banned masih berlaku
                            if ($bannedDate > $now) {
                                $remainingText = " (masih $remainingDays hari lagi)";
                            } else {
                                $remainingText = " (banned telah lewat)";
                            }

                        } else {
                            $formattedDate = '[tanggal tidak tersedia]';
                            $remainingText = '';
                        }

                        if ($remainingDays <= 0) {
                            $idUser = $login['id'];
                            // Hapus status banned
                            $updateQuery = "UPDATE login SET status='ok', banned_until=NULL WHERE id='$idUser'";
                            mysqli_query($conn, $updateQuery);
                            $_SESSION['berhasil'] = 'Akunmu telah dibebaskan dari status banned. Silakan masuk kembali.';
                            exit();
                        }

                        $_SESSION['login_error'] = 'Akunmu telah dibanned karena melanggar Ketentuan Penggunaan SMWI24. Sampai: ' . $formattedDate . $remainingText . '. Jika anda merasa ini sebuah kesalahan, mohon hubungi kami.';
                        header('Location: login.php');
                        exit();
                    } else if ($login['is_login'] == 1) {
                        $_SESSION['login_error'] = "Akunmu sedang digunakan di perangkat lain, harap logout terlebih dahulu. Bila kamu tidak merasa login di perangkat lain, lakukan pergantian password di Safe Dashboard sesegera mungkin dan isolasi akunmu! Anda bisa mengakses Safe Dashboard dengan mengklik tombol Bantuan di bawah. ";  
                        header('Location: login.php');
                        exit();
                    } else {
                        $_SESSION['login_error'] = 'Kegiatan yang anda lakukan tidak diperbolehkan, silakan baca ketentuan penggunaan SMWI24.';
                        header('Location: login.php');
                        exit();
                    }

                } else {
                    $_SESSION['login_error'] = 'Kamu tidak ada di daftar tamuku. Pastikan kamu mengisi data dengan benar.';
                    header('Location: login.php');
                    exit();
                }
            }
        }
        //MEOWW :3


    ?>


</body>
</html>