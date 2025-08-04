<?php
session_start();
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
} else {
    header("Location: login.php");

}
include '../config/global-config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <?= $icon ?>    
    <link rel="stylesheet" href="../css/account.css">
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
            <a href="ruangtamu.php"><h3>Kembali ke Ruang Tamu</h3></a>
        </div>
        <h1>Akun</h1>
        <p>Semua data yang berkaitan denganmu ada di sini.</p>
        <div class="profile" onclick="location.href='profile_edit.php'">
            <h3 id="name"><?=$login['username']?></h3>
            <p id="role"><?=$login['role']?></p>
            <p id="desc">Edit info pribadi anda di sini.</p>
            <i class='bx  bx-chevron-right' id="arrow" ></i> 
        </div>
        <div class="about-role">
            <?php if ($login['role'] == 'Admin') : ?>
                <p>Kamu adalah admin, kamu bisa menggunakan fitur admin untuk mengelola konten. <br> Fitur khusus admin sedang dalam pengembangan.</p>
                <div class="profile" onclick="location.href='admin.php'">
                    <h3>Masuk ke Dashboard Admin</h3>
                    <p>Kamu bisa mengatur jalannya web di sini.</p>
                    <i class='bx  bx-chevron-right' id="arrow"></i> 
                </div>
                <?php endif ?>
        </div>

    </div>
    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };

    </script>
</body>
</html>