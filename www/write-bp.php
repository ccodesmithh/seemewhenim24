<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
$login = $_SESSION['login'];
if ($login['role'] !== 'Admin') {
    header("Location: bilikpengakuan.php");
    exit;
}

include 'conn.php'; // Koneksi database
include '../config/global-config.php';


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
                    footer: '<a href=\"help.php\">Butuh Bantuan?</a>',
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

// Alert handling
if (isset($_SESSION['error'])) {
    show_alert('error', $_SESSION['error']);
    unset($_SESSION['error']);
} elseif (isset($_SESSION['berhasil'])) {
    show_alert('success', $_SESSION['berhasil']);
    unset($_SESSION['berhasil']);
    unset($_SESSION['form']);
} else {
    unset($_SESSION['form']);
}

// Proses submit
if (isset($_POST['submit'])) {
    $judul = trim($_POST['judul']);
    $penulis = $_SESSION['login']['username'];
    $halaman = trim($_POST['halaman']);
    $bagian = trim($_POST['bagian']);
    $isi = trim($_POST['isi']);
    $tanggal = date('Y-m-d H:i:s');
    $status = 'uploaded';

    $_SESSION['form'] = $_POST;

    if (empty($judul) || empty($halaman) || empty($bagian) || empty($isi)) {
        $_SESSION['error'] = 'Semua field harus diisi.';
    } else {
        $check_query = "SELECT * FROM bilik_pengakuan WHERE halaman = '$halaman' AND status = 'uploaded'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $_SESSION['error'] = 'Halaman ini sudah ada! Silakan pilih halaman lain.';
        } else {
            $query = "INSERT INTO bilik_pengakuan (judul, penulis, halaman, bagian, isi, tanggal, status) 
                      VALUES ('$judul', '$penulis', '$halaman', '$bagian', '$isi', '$tanggal', '$status')";
            if (mysqli_query($conn, $query)) {
                unset($_SESSION['form']);
                $_SESSION['berhasil'] = 'Tulisan berhasil diposting.';
                header("Location: write-bp.php");
                exit;
            } else {
                $_SESSION['error'] = 'Gagal memposting tulisan.';
            }
        }
    }
}

if (isset($_POST['back'])) {
    header("Location: bilikpengakuan.php");
    echo'<scirpt> console.log("CLICK!") </script>';
    exit;
}

?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formFields = document.querySelectorAll('input[name="judul"], input[name="halaman"], textarea[name="isi"]');
        const btnBack = document.querySelector('.btn-back');
        const backForm = document.getElementById('form-back');

        function isFormFilled() {
            return Array.from(formFields).some(field => field.value.trim() !== '');
        }

        btnBack.addEventListener('click', function () {
            if (isFormFilled()) {
                Swal.fire({
                    title: 'Keluar dari halaman?',
                    text: "Semua progress yang belum disimpan akan hilang.",
                    showCancelButton: true,
                    confirmButtonColor: 'rgb(0, 13, 255)',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, keluar',
                    cancelButtonText: 'Tidak, tetap di sini',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        backForm.submit(); // Lanjutkan ke halaman sebelumnya
                    }
                });
            } else {
                backForm.submit(); // Langsung pergi kalau form kosong
            }
        });
    });
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tulis</title>
    <?= $icon ?>
    <link rel="stylesheet" href="../css/write-bp.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
</head>
<body>
    <div class="back">
        <i class='bx bx-chevron-left'></i>
        <h3 class="btn-back" style="cursor: pointer;"><u>Kembali</u></h3>
    </div>


    <form action=""method="post" id="form-back">
        <input type="hidden" name="back" value="1">
    </form>

    <div class="header">
        <h1>Akui Perasaanmu</h1>
        <p id="bar">|</p>
        <p>Kau tak perlu takut mengungkapkan apa yang menjadi bayangan dalam hidupmu.</p>
    </div>
    <hr class="bar">

    <div class="container">
        <form action="" method="post">
            <label for="">Apa Judul Tulisanmu?</label>
            <input type="text" name="judul" placeholder="Judul" required 
                   value="<?= htmlspecialchars($_SESSION['form']['judul'] ?? '') ?>">

            <label for="">Halaman ke Berapa Ini? </label>
            <input type="number" name="halaman" placeholder="Halaman" required 
                   value="<?= htmlspecialchars($_SESSION['form']['halaman'] ?? '') ?>">

            <label for="">Bagian ke Berapa Tulisan Ini?</label>
            <select name="bagian" id="bagian">
                <?php
                $selected = $_SESSION['form']['bagian'] ?? '';
                foreach (['I', 'II', 'III', 'IV', 'V', 'VI'] as $opt) {
                    $sel = ($selected === $opt) ? 'selected' : '';
                    echo "<option value=\"$opt\" $sel>$opt</option>";
                }
                ?>
            </select>

            <label for="">Apa Yang Mau Kau Tulis?</label>
            <textarea name="isi" placeholder="Isi" required><?= htmlspecialchars($_SESSION['form']['isi'] ?? '') ?></textarea>

            <button type="submit" name="submit">Posting</button>
        </form>
    </div>
</body>
</html>
