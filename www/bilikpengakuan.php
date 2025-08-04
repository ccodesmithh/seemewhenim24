<?php
session_start();
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
} else {
    header("Location: login.php");

}
include 'conn.php'; // Include koneksi database
include '../config/global-config.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilik Pengakuan</title>
    <?= $icon ?>
    <link rel="stylesheet" href="../css/bilikpengakuan.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>

</head>
<body>
    <nav class="navbar">
        <a href="../www/ruangtamu.php" class="nav-logo"><img src="../img/logo.png" alt="" sizes="100px" width="100rem" /></a>
        <div class="navbar-nav">
            <a href="ruangtamu.php">Ruang Tamu</a>
            <a href="#">Test</a>
            <a href="#">Test</a>
            <a href="#">Test</a>
            <a href="#">Test</a>
            <a href="#">Test</a>
            <div class="settings">
                <?php if ($login['role'] == 'Admin') : ?>
                    <a href="write-bp.php"><i class="bx bx-pencil" id="write"></i></a>
                <?php endif; ?>
                <a href="account.php"><i class='bx  bx-user'  id="user"></i> </a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="header">
            <h1>Bilik Pengakuan</h1>
            <p id="bar">|</p>
            <p>Segala yang janggal di hatiku, tertuang di sini. Mungkin suasananya akan agak gelap pada tiap lembarnya.</p>
        </div>
        <hr class="bar">
        <div class="content">
            <h1>Bagian I</h1>
            <div class="bp-list">
                <?php
                    $query = "SELECT * FROM bilik_pengakuan WHERE bagian = 'I' AND status = 'uploaded' ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)): ?>
                            <div class='bp-item' onclick="location.href='inside_bp.php?judul=<?= $row['judul'] ?>'">
                                <div class="bp-header" style="margin-bottom: 10px;">
                                    <h2><?= htmlspecialchars($row['judul']) ?></h2>
                                    <h5>Halaman <?= htmlspecialchars($row['halaman']) ?> ditulis oleh <?= htmlspecialchars($row['penulis']) ?></h5>
                                    <span class='date'><?= date('d M Y', strtotime($row['tanggal'])) ?></span>
                                </div>
                                <p class="bp-content"><?= htmlspecialchars($row['isi']) ?></p>
                                <a href="inside_bp.php?id=<?=$row['id']?>" style="margin-top: 10px;">Read more..</a>
                            </div>
                        <?php endwhile;
                    } else {
                        echo "<p style='margin-top: 1rem;'>Aku masih belum siap untuk mengungkapkan apapun. Akan segera kukabari bila aku sudah siap. Sekarang, apa mungkin kamu mau masuk ke ruangan lain?</p>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>