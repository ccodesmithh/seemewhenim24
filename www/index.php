<?php
session_start();
include '../config/global-config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wordsmith House</title>
    <?= $icon ?>
</head>
<link rel="stylesheet" href="../css/style.css">
<body>
    <div class="container">
        <div class="head">
            <h4>Pasific</h4>
        </div>j
        <hr class="bar">
        <div class="title">
            <h3>Selamat Datang</h3>
        </div>
        <div>
            <acronym title="Masuk ke Ruang Tamu">
                <a href="login.php" onclick="destroySession()"c>
                    <p class="p">
                        Tak peduli darimanapun kau berasal, kursi kecil <br> untukmu telah ku siapkan di Ruang Tamu.
                    </p>
                </a>
            </acronym>
        </div>
        <hr class="bar2">
    </div>

    <script>
        destroySession = () => {
            <?php
            session_unset();
            session_destroy();
            ?>
        }
    </script>
</body>
</html>