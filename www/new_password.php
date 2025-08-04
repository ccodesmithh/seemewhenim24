<?php
session_start();
include '../config/global-config.php';


if (isset($_POST['logout'])) {
    session_destroy(); 
    header("Location: login.php");
    exit;
}

// Cek login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}else {
    $login = $_SESSION['login'];
}

// SweetAlert handler
function show_alert($type, $message) {
    $message = htmlspecialchars($message, ENT_QUOTES);
    if ($type === 'error') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Oops...',
                    text: '$message',
                    confirmButtonText: 'Baiklah',
                    confirmButtonColor: 'rgb(0, 13, 255)',
                    footer: '<a href=\"#\">Butuh Bantuan?</a>',
                    background: 'rgb(238, 238, 238)',
                    color: 'black',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut'
                    }
                });
            });
        </script>";
    } elseif ($type === 'success') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: '$message',
                    background: 'rgba(200, 202, 252, 0.82)',
                    color: 'black',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut'
                    }
                });
            });
        </script>";
    }
}

// Tampilin ini pokoknya kalo ada session error atau berhasil
if (isset($_SESSION['error'])) {
    show_alert('error', $_SESSION['error']);
    unset($_SESSION['error']);
}
if (isset($_SESSION['berhasil'])) {
    show_alert('success', $_SESSION['berhasil']);
    unset($_SESSION['berhasil']);
}

?>

<?php
include 'conn.php';
if (isset($_POST['submit'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Kunci barumu tidak sesuai dengan konfirmasi kunci baru. Silakan coba lagi.";
        header("Location: new_password.php");
        exit;
    }

    $validasiPassword = mysqli_query($conn, "SELECT * FROM login WHERE id = '" . $_SESSION['login']['id'] . "'");
    $data = mysqli_fetch_assoc($validasiPassword);
    if ($data['password'] !== $old_password) {
        $_SESSION['error'] = "Kunci lama tidak sesuai.";
        header("Location: new_password.php");
        exit;
    } else {
        $updatePassword = mysqli_query($conn, "UPDATE login SET password = '$new_password' WHERE id = '" . $_SESSION['login']['id'] . "'");
        if ($updatePassword) {
            $_SESSION['berhasil'] = "Kunci berhasil diubah.";
            header("Location: new_password.php");
            exit;
        } else {
            $_SESSION['error'] = "Gagal mengubah kunci. Silakan coba lagi.";
            header("Location: new_password.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Safe</title>
    <?= $icon ?>

    <link rel="stylesheet" href="../css/profile_edit.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
<link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
<link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>

</head>
<body>
    <?php include 'conn.php' ?>
    <div class="container">
        <div class="back">
            <i class='bx  bx-chevron-left'  ></i> 
            <a href="profile_edit.php"><h3>Kembali ke Pengeditan Profil</h3></a>
        </div>
        <h1>Ganti Password</h1>
        <p>Harap berhati-hati, jagalah kuncimu baik-baik.</p>
            <form action="" method="post">
                <div class="profile">
                    <label for="">Kunci Lama</label>
                    <input type="password" name="old_password" id="old_password" class="form-input" placeholder="Masukan password lamamu" required>
                    <label for="">Kunci Baru</label>
                    <input type="password" name="new_password" id="new_password" class="form-input" placeholder="Masukan password barumu" required>
                    <label for="">Konfirmasi Kunci Baru</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-input" placeholder="Konfirmasi password barumu" required>

                </div>
                <hr class="garis">
                <div class="buttons">
                    <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
                </div>

            </form>
