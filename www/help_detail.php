<?php
session_start();

// Data validation

include 'conn.php';
include '../config/global-config.php';


$idtag = intval($_GET['q']);
$query = "SELECT * FROM help WHERE idtag = '$idtag'";
$result = mysqli_query($conn, $query);

// ======================== //
// debug
// if (!$result || mysqli_num_rows($result) == 0) {
//     echo "Data tidak ditemukan atau belum diupload.";
//     exit;
// }
// ======================== //

$data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul'] ?></title>
    <?= $icon ?>
    <link rel="stylesheet" href="../css/help_detail.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
            
        <div class="back-button" onclick="location.href='help.php'">
            <i class="bx bx-arrow-left-stroke"></i>
            <p>Kembali ke Beranda Bantuan</p>
        </div>
        <div class="data-wraper">
            <h1><?= $data['judul'] ?></h1>
            <div class="data">
                    <?= $data['isi']?>
            </div>

        </div>
        <hr>
        <div class="feedback">
            <strong>Apakah artikel ini bermanfaat?</strong>
            <p><a href="">Ya</a> | <a href="">Tidak</a></p>
        </div>

        <div class="footer">
            <div class="needhelp">
                <h1>Butuh bantuan lagi?</h1>
                <button onclick="location.href='contact.php'">Hubungi kami</button>
            </div>
            <hr>
            <div class="footer-content">
                <p>&copy; 2023 Seemewhenim24. All rights reserved.</p>
                <br>
                <p>Ketentuan Penggunaan</p>
                <p>Privasi</p>
                <p>Informasi Perusahaan</p>
            </div>
        </div>

    </div>

</body>