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
    <title>Admin</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script src="path/to/anime.iife.min.js"></script>
</head>
<body>
    <section class="layout">
        <div class="sidebar">
            <img src="../img/logo.png" alt="" sizes="100px" width="90rem">
            <hr>
            <div class="dashboard">
                <h4>Dashboard</h4>
            </div>
        </div>
        <div class="body">
            2   

        </div>
    </section>
</body>
</html>