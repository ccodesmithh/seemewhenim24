<?php
session_start();

include 'conn.php';
include '../config/global-config.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recovery Center</title>
    <?= $icon ?>
    <link rel="stylesheet" href="../css/safe_dashboard_welcome.css">
</head>
<body>
    <div class="header">
        <h1 id="header">Selamat Datang!</h1>
        <p id="bar">|</p>
        <p>Lupa password? Akun diambil alih? Kami siap membantumu!</p>
    </div>

    <form action="" method="post">
        <label>Masukan Emailmu</label>
        <input type="email" name="email" class="form-input" placeholder="Masukan Email" required>
        <label>Masukan Usernamemu</label>
        <input type="text" name="username" class="form-input" placeholder="Masukan Username" required>
        <label for="">Masukan Passwordmu</label>
        <input type="password" name="password" class="form-input" placeholder="Masukan Password" required>
        <label for="">Masukan kode sekali pakaimu</label>
        <input type="text" name="single-used-code" class="form-input" placeholder="Masukan kode" required>
        <button class="btn-login" name="submit">Login</button>
        <p>Tidak Tau Kode? <a href="help.php">Kami bisa membantu</a></p>
    </form>

</body>
</html>


<!-- This page is under development, please go back. <br>  <br>
<button onclick="location.href='help.php'">Go Back to Help page</button> <br>
<button onclick="location.href='ruangtamu.php'">Go Back to Main page</button> <br> <br>
&copy Copyrights 2025 See Me When Im 24 All Rights Reserved <br>
&copy Copyrights 2025 Pasific Studios All Rights Reserved <br> -->