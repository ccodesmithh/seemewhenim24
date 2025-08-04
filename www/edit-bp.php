<?php
session_start();
include 'conn.php';
include '../config/global-config.php';


if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM bilik_pengakuan WHERE id = $id AND status = 'uploaded'";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Data tidak ditemukan atau belum diupload.";
    exit;
}
$data = mysqli_fetch_assoc($result);


// Proses submit
if (isset($_POST['submit'])) {
    $judul = trim($_POST['judul']);
    $penulis = $_SESSION['login']['username'];
    $bagian = trim($_POST['bagian']);
    $isi = trim($_POST['isi']);
    $tanggal = date('Y-m-d H:i:s');
    $status = 'uploaded';

    $_SESSION['form'] = $_POST;

    if (empty($judul) || empty($bagian) || empty($isi)) {
        $_SESSION['error'] = 'Semua field harus diisi.';
    } else {
        $query = "UPDATE bilik_pengakuan 
                      SET judul = '$judul', penulis = '$penulis', 
                          bagian = '$bagian', isi = '$isi', tanggal = '$tanggal', status = '$status' 
                      WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                unset($_SESSION['form']);
                $_SESSION['berhasil'] = 'Tulisan berhasil diperbarui.';
                header("Location: edit-bp.php?id=$id");
                exit;
            } else {
                $_SESSION['error'] = 'Gagal memperbarui tulisan.';
            }
    }
}

// Proses kembali
if (isset($_POST['back'])) {
    header("Location: inside_bp.php?judul=$judul");
    echo'<scirpt> console.log("CLICK!") </script>';
    exit;
}

// Proses Soft Delete
if (isset($_POST['delete'])) {
    $delete_query = "UPDATE bilik_pengakuan SET status = 'deleted' WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['berhasil'] = 'Tulisan berhasil dihapus.';
        header("Location: bilikpengakuan.php");
        exit;
    } else {
        $_SESSION['error'] = 'Gagal menghapus tulisan.';
        header("Location: edit-bp.php?id=$id");
        exit;
    }
}

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
                    text: "Semua progress yang belum disimpan mungkin akan hilang.",
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['judul'])?></title>
    <link rel="icon" href="../img/logo.png">
    <link rel="stylesheet" href="../css/write-bp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <div class="back">
        <i class='bx bx-chevron-left'></i>
        <h3 class="btn-back" style="cursor: pointer;"><u>Kembali</u></h3>
    </div>


    <form action=""method="post" id="form-back" style="display: none;">
        <input type="hidden" name="back" value="1">
    </form>

    <form action="" method="post" id="form-delete" style="display: none;">
        <input type="hidden" name="delete" value="1">
    </form>

    <div class="header">
        <h1>Ubah Perasaanmu</h1>
        <p id="bar">|</p>
        <p>Kau tak perlu takut untuk mengubah apa yang kamu mau.</p>
    </div>
    <hr class="bar">


        <div class="container">
        <form action="" method="post">
            <label for="">Apa Judul Tulisanmu?</label>
            <input type="text" name="judul" placeholder="Judul" required 
                   value="<?= $data['judul']?>">

            <label for="">Bagian ke Berapa Tulisan Ini?</label>
            <select name="bagian" id="bagian">
                <?php
                $selected = $data['bagian'];
                foreach (['I', 'II', 'III', 'IV', 'V', 'VI'] as $opt) {
                    $sel = ($selected === $opt) ? 'selected' : '';
                    echo "<option value=\"$opt\" $sel>$opt</option>";
                }
                ?>
            </select>

            <label for="">Apa Yang Mau Kau Tulis?</label>
            <textarea name="isi" placeholder="Isi" required><?=$data['isi']?></textarea>

            <button type="submit" name="submit">Posting</button>
            <button type="button" name="delete" class="btn-delete">Hapus</button>

        </form>
        <script>
            document.querySelector('.btn-delete').addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu tidak akan bisa mengembalikan tulisan ini setelah dihapus.",
                showCancelButton: true,
                confirmButtonColor: 'rgb(0, 13, 255)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus tulisan ini',
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

        </script>

</body>
</html>