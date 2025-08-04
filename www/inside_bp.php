<?php
session_start();
include 'conn.php';
include '../config/global-config.php';

if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
} else {
    header("Location: login.php");

}

if (!isset($_GET['judul'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$judul = intval($_GET['judul']); // amankan ID
$query = "SELECT * FROM bilik_pengakuan WHERE judul = $judul AND status = 'uploaded'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Data tidak ditemukan atau belum diupload.";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['judul']) ?></title>
    <link rel="stylesheet" href="../css/inside_bp.css">
    <?= $icon ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    
</head>
<body>

    <div class="container">
        <h1><?= htmlspecialchars($data['judul']) ?></h1>

        <div class="header">
            <p>Ditulis oleh <?=htmlspecialchars($data['penulis'])?></p>
            <p>Pada <?= date('d M Y', strtotime($data['tanggal'])) ?></p>
            <?php if ($login['role'] == 'Admin') : ?>
                <a href="edit-bp.php?id=<?=$data['id']?>"><i class="bx bx-edit" id="edit" style="text-decoration: none; color: white; margin-top: 0.3rem;"></i></a>
            <?php endif; ?>        

        </div>
        <p id="content"><?= nl2br(htmlspecialchars($data['isi'])) ?></p>
        <div class="ft-bp">
            <h4>BG. <?= htmlspecialchars($data['bagian']) ?></h4>
            <a href="bilikpengakuan.php" style="text-decoration: none;"><h4>Bilik Pengakuan</h4></a>
            <h4><?= htmlspecialchars($data['halaman']) ?></h4>
        </div>
    </div>
</body>
</html>
