<?php
session_start();
    $id = $_SESSION['login']['id'];
    include 'conn.php'; // Koneksi database
    include '../config/global-config.php';



if (isset($_POST['logout'])) {
    mysqli_query($conn, "UPDATE login SET is_login = '1' WHERE id = $id");
    session_destroy(); 
    header("Location: login.php");
    exit;
}

if (isset($_POST['delete'])) {
    $deleteQuery = mysqli_query($conn, "UPDATE login SET deleted = '1' WHERE id = $id");
    if ($deleteQuery) {
        session_destroy(); // Hapus session
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = 'Gagal menghapus akun. Silakan coba lagi.';
        header("Location: profile_edit.php");
        exit;
    }
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
                    icon: 'error',
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
    $id = $_SESSION['login']['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    // Validasi input
    $resultEmail = mysqli_query($conn, "SELECT * FROM login WHERE (username = '$username' OR email = '$email') AND id != $id");
    if (mysqli_num_rows($resultEmail) > 0) {
        $_SESSION['error'] = 'Username atau email sudah digunakan oleh akun lain.';
        header("Location: profile_edit.php");
        exit;
    } else {
        $updateEmailUsername = mysqli_query($conn, "UPDATE login SET username='$username', email='$email' WHERE id = $id");
        if ($updateEmailUsername) {
            
            $_SESSION['login']['username'] = $username;
            $_SESSION['login']['email'] = $email;  
            $_SESSION['berhasil'] = 'Username dan email berhasil diperbarui.';  
            header("Location: profile_edit.php");
            exit;        
        } else {
            $_SESSION['error'] = 'Gagal memperbarui username atau email.';
            header("Location: profile_edit.php");
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
    <title>Account</title>
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
            <a href="account.php"><h3>Kembali ke Pengaturan Akun</h3></a>
        </div>
        <h1>Edit Profil</h1>
        <p>Kamu bisa mengubah semua info profil sesuka hatimu, dan aku tetap mengenalmu.</p>
            <form action="" method="post">
                <div class="profile">
                    <label for="">Namamu</label>
                    <input type="text" name="username" id="name" value="<?= $login['username'] ?>" class="form-input"required>
                    <label for="">Alamatmu</label>
                    <input type="text" name="email" id="email" value="<?= $login['email'] ?>" class="form-input" required>

                </div>
                <hr class="garis">
                <div class="buttons">
                    <button type="submit" name="submit" class="btn-submit">Simpan Perubahan</button>
                    <button type="button" name="logout" class="btn-logout">Logout</button>
                    <button type="button" name="delete" class="btn-delete">Hapus Akun</button>
                    <a href="new_password.php"><button type="button" name="change-password" class="btn-change-password">Ganti Password</button></a>
                </div>


            </form>
    </div>
    <form id="form-delete" method="post" style="display: none;">
        <input type="hidden" name="delete" value="1">
    </form>
    <form id="form-logout" method="post" style="display: none;">
        <input type="hidden" name="logout" value="1">
    </form>

    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };

        
        document.querySelector('.btn-delete').addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu tidak akan bisa mengembalikan akunmu setelah dihapus.",
                showCancelButton: true,
                confirmButtonColor: 'rgb(0, 13, 255)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus akun saya',
                cancelButtonText: 'Tidak, batalkan',
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
                },

            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form to delete the account
                    document.getElementById('form-delete').submit();
                }
            });
        });
        
        document.querySelector('.btn-logout').addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan keluar dari akun ini.",
                showCancelButton: true,
                confirmButtonColor: 'rgb(0, 13, 255)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, keluar',
                cancelButtonText: 'Tidak, batalkan',
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
                },

            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form to logout
                    document.getElementById('form-logout').submit();
                }
            });
        });

    </script>

</body>
</html>