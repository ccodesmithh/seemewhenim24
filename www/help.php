<?php
session_start();
include 'conn.php'; // Include the database connection file
include '../config/global-config.php';



// Search functionality
if (isset($_GET['search'])) {
    $input = trim($_GET['search']);
    $input = mysqli_real_escape_string($conn, $input);
    $query = "SELECT * FROM help WHERE topik LIKE '%$input%' OR judul LIKE '%$input%' OR isi LIKE '%$input%' ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $search_results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $search_results = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan SMWI24</title>
    <?= $icon ?>
    <link rel="stylesheet" href="../css/help.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="header">
        <h1 id="header">Pusat Bantuan</h1>
        <p id="bar">|</p>
        <p>Beri tahu kami bila kamu tak nyaman di sini.</p>
    </div>
    <hr class="bar">
    <h1 id="head">Apa yang bisa ku bantu?</h1>
    <div class="container">
        <div class="searchbarcontainer">
            <form action="" method="GET" class="search" id="searchbarform">
                <input type="text" id="searchbar" placeholder="Perlu bantuan?" name="search">
                <button id="searchbtn" type="search"><i class='bx bx-search'></i></button>
            </form>
        </div>
        <div class="reccontent">
            <h3>Direkomendasikan untukmu: </h3>
            <p><a href="">Cara menjaga keamanan akun</a>, <a href="">Kontrol konten di SMWI24</a>, </p>
        </div>

        <!-- Search Results Section -->
        <div class="result">
            <?php if (isset($_GET['search']) && !empty($input) && !empty($search_results)): ?>
                <h3 style="margin-top:2rem;">Hasil Pencarian untuk: "<span><?= htmlspecialchars($_GET['search']) ?></span>".</h3>
                <?php foreach ($search_results as $row): ?>
                    <div class="result-item" onclick="location.href='help_detail.php?q=<?= $row['idtag'] ?>'">
                        <h4><?= htmlspecialchars( $row['judul']) ?></h4>

                    </div>
                <?php endforeach; ?>
            <?php elseif (isset($_GET['search']) && !empty($input)): ?>
                <div class="negative-results">
                    <h3>Tidak ada hasil yang cocok untuk pencarian: "<span><?= htmlspecialchars($_GET['search']) ?></span>".</h3>
                    <div class="negative-results-content">
                        <h3>Saran:</h3>
                        <ul>
                            <li>Periksa ejaan kata kunci Anda.</li>
                            <li>Coba gunakan kata kunci yang lebih umum.</li>
                            <li>Pastikan topik yang Anda cari relevan dengan SMWI24.</li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="browse">
            <a href="#topics-section" style="text-decoration:none; color: #333;"><p>Jelajahi Artikel Cepat</p></a>
            <i class="bx bx-arrow-down-stroke"></i>
        </div>
        <div class="topics-container" id="topics-section">
            <div class="akun">
                <div class="topics-header">
                    <i class="bx bx-user"></i>
                    <h3>Akun</h3> 
                </div>
                <hr style="width: 100%; margin-top: 1rem; border: 1px solid #ccc;">
                <div class="topicscontent">
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Pengaturan Akun</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara memperbarui informasi akun SMWI24</p>
                        </div>
                        <div class="topicsdropcontent" onclick="location.href='safe_dashboard_welcome.php'">
                            <i class="bx bx-article"></i>
                            <p>Safe Dashboard</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara memperbarui password akun SMWI24</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara menghapus akun SMWI24</p>
                        </div>
                    </div>
                    <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">                    
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Keanggotaan</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara daftar menjadi penulis.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Kartu hadiah SMWI24.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara menghapus meotde pembayaran (p+).</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara menemukan tanggal penagihan (p+).</p>
                        </div>
                    </div>
                </div>
                <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">
            </div>
        </div>
        <div class="topics-container" id="topics-section" style="margin-top: -2rem;">
            <div class="akun">
                <div class="topics-header">
                    <i class="bx bx-gear"></i>
                    <h3>Pemecah Masalah</h3> 
                </div>
                <hr style="width: 100%; margin-top: 1rem; border: 1px solid #ccc;">
                <div class="topicscontent">
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Masalah Akun</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Tidak dapat masuk ke SMWI24</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>SMWI24 meminta untuk mendaftar ketika mencoba masuk</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>SMWI24 menginformasikan bahwa akun sedang digunakan</p>
                        </div>

                    </div>
                    <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">                    
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Masalah Penagihan</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>SMWI24 menampilkan pesan "Akunmu diubah menjadi Tamu karena terdapat masalah dengan pembayaran terakhirmu".</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Tagihan tak dikenali atau tanpa izin SMWI24.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Menerima tagihan keanggotaan Penulis (atau lebih tinggi) dua kali.</p>
                        </div>
                    </div>
                    <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">                    
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Kode Kesalahan</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>SMWI24 tidak berfungsi.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Kesalahan ruang BP-2-5.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Kesalahan ruang RTu-800-3.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Kesalahan ruang RTg-101.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Kesalahan ruang P-113.</p>
                        </div>
                    </div>
                    <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">                    
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Masalah Penulisan</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Mengatasi tidak dapat menulis.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Tulisan tidak tersimpan.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Gagal menghapus tulisan.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Tulisan tidak dapat diposting.</p>
                        </div>
                    </div>
                    <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">                    
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Masalah Membaca</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Tulisan tidak muncul (Bilik Pengakuan).</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Buku tidak dapat dibaca (Released).</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>SMWI24 menampilkan "Kamu tidak diperbolehkan masuk!" dengan keanggotaan Penulis atau lebih tinggi (Released).</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Browser tidak didukung.</p>
                        </div>
                    </div>
                    
                    
                </div>
                
                <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">
            </div>
        </div>
        <div class="topics-container" id="topics-section" style="margin-top: -2rem;">
            <div class="akun">
                <div class="topics-header">
                    <i class="bx bx-rocket"></i>
                    <h3>Memulai</h3> 
                </div>
                <hr style="width: 100%; margin-top: 1rem; border: 1px solid #ccc;">
                <div class="topicscontent">
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Bergabung ke SMWI24</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Apa itu SMWI24?</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara berpartisipasi.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Mulai menggunakan SMWI24.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Paket dan Harga.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Anggota Ekstra.</p>
                        </div>
                    </div>
                    <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">                    
                    <div class="topic-head" onclick="dropdown(this)">
                        <h4>Konfigurasi Perangkat</h4>
                        <i class="bx bx-chevron-down"></i>
                    </div>
                    <div class="accountdd" id="dropdown">
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Pesyaratan sistem dan browser yang didukung SMWI24.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara menggunakan SMWI24 di ponsel atau tablet Android.</p>
                        </div>
                        <div class="topicsdropcontent">
                            <i class="bx bx-article"></i>
                            <p>Cara menggunakan SMWI24 di iPhone atau iPad.</p>
                        </div>
                    </div>
                </div>
                <hr class="bottomhr" style="width: 100%; border: 1px solid #ccc;">
            </div>
        </div>

    </div>
    <script>
        function dropdown(clickedElement) {
            const content = clickedElement.nextElementSibling;
            const icon = clickedElement.querySelector("i");
            
            if (content.style.display === "block") {
                content.style.display = "none";
                icon.classList.remove("bx-chevron-up");
                icon.classList.add("bx-chevron-down");

            } else {
                content.style.display = "block";
                icon.classList.remove("bx-chevron-down");
                icon.classList.add("bx-chevron-up");
            }
        }
    </script>
</body>
</html>