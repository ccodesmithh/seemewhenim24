<?php
session_start();
if (isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
} else {
    header("Location: login.php");

}
include 'conn.php'; // Include koneksi database
include '../config/global-config.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Tamu</title>
    <?=$icon?>

</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="../css/ruangtamu.css">
<link
rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
<link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
<link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>

<body>



    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
// ========================== //
// Pasific Labs & Learning | Push Notification | one feature a day, keep the bugs away :)
// ========================== //

// Struktur file
// project-folder/
// ├── ruangtamu.php               ← halaman utama
// ├── service-worker.js       ← file yang menerima notifikasi
// ├── save-subscription.php   ← menyimpan endpoint push ke database
// ├── send-push.php           ← mengirim notifikasi dari server (PHP)
// ├── composer.json           ← untuk install library WebPush
// └── database.sql            ← skema tabel langganan


    // Import the functions you need from the SDKs you need

    // import { initializeApp } from "https://www.gstatic.com/firebasejs/11.10.0/firebase-app.js";
    // import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.10.0/firebase-analytics.js";

    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // document.addEventListener('DOMContentLoaded', () => {

        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional

        // const firebaseConfig = {
        //     apiKey: "AIzaSyDpqdO323gMKGpVJkDS40MQsE_4orF7FkY",
        //     authDomain: "smwi24.firebaseapp.com",
        //     projectId: "smwi24",
        //     storageBucket: "smwi24.firebasestorage.app",
        //     messagingSenderId: "91288126447",
        //     appId: "1:91288126447:web:58f2cf21d3857fb7256c1a",
        //     measurementId: "G-QV3NW4RPL4"
        // };

        // Initialize Firebase

        // const app = initializeApp(firebaseConfig);

        // messaging.requestPermission().then(() => {
        //     return messaging.getToken({vapidKey: BOWPiYuI_b0y46wEmHXQbcazx5eJ7shFSkU6UYetgE35FPBS-dY4XmkecnoAkZ886ZJwyC3UvgyAfhQJR0il4Jw});
        // }).then((token) => {
        //     console.log("Token FCM:", token);
        // }).catch((err) => {
        //     console.error("gagal mendapatkan izin notif", err);
        // })

        // // Cek apakah browser mendukung Notification API
        // if (!("Notification" in window)) {
        //     alert("Browser kamu tidak mendukung notifikasi.");
        // } else if (Notification.permission === "granted") {
        //     // Jika sudah diizinkan sebelumnya
        //     showNotif();
        // } else if (Notification.permission !== "denied") {
        //     // Minta izin ke user
        //     Notification.requestPermission().then(permission => {
        //         if (permission === "granted") {
        //             showNotif();
        //         }
        //     });
        // }

    //     function showNotif() {
    //         new Notification("SMWI24", {
    //             body: "Push Notification Berhasil! -Yudha Ganteng",
    //             icon: "../img/logo.png" // kamu bisa ganti
    //         });
    //     }
    // });

    </script>



    <?php 
        if(isset($_SESSION['berhasil'])): ?>
            <script>
                const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
                });
                Toast.fire({
                showClass: {
                    popup: `
                    animate__animated
                    animate__fadeIn
                    `,
                },
                hideClass: {
                    popup: `
                    animate__animated
                    animate__fadeOut
                    `,
                },
                background: 'rgba(200, 202, 252, 0.82)',
                color: 'black',
                title: "<?= $_SESSION['berhasil'] ?>"
                });
            </script>
    <?php 
            endif;
            unset($_SESSION['berhasil']);
    ?>

    <nav class="navbar">
        <a href="../www/ruangtamu.php" class="nav-logo"><img src="../img/logo.png" alt="" sizes="100px" width="100rem" /></a>
        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#">Test</a>
            <a href="#">Test</a>
            <a href="#">Test</a>
            <a href="#">Test</a>
            <a href="#">Test</a>
            <a href="account.php"><i class='bx  bx-user'  id="user"></i> </a>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Ruang Tamu</h1>
            <p id="bar">|</p>
            <p>Selamat datang di rumahku, silakan jelajahi semua ruangan yang ada.</p>
        </div>
        <hr class="bar">
        <div class="content">
            <div class="card" onclick="location.href='bilikpengakuan.php'">
                <h2>Bilik Pengakuan</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Facere natus officiis eaque architecto laboriosam esse amet unde ex corrupti quasi. Officia, esse tempore. Asperiores magnam tempora id maiores, iure architecto.</p>
            </div>
            <div class="card" onclick="location.href='ruangtunggu.php'">
                <h2>Ruang Tunggu</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia aliquid voluptatibus voluptas saepe animi soluta, omnis illo aut, deleniti error minima. Ullam nesciunt excepturi laborum officiis ab sit molestias dolor?</p>
            </div>
            <div class="card">
                <h2>Ruang Tengah</h2>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Molestiae labore aliquam, soluta libero dolore voluptatem fugit porro! Consectetur dicta unde nobis nisi adipisci, nam aliquam distinctio non consequatur ratione doloribus!</p>
            </div>
            <div class="card">
                <h2>Released</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum architecto dignissimos veritatis quasi eaque autem, nemo quae excepturi suscipit nisi pariatur, labore hic nihil optio. Saepe aliquid iste sit doloremque.</p>
            </div>
            <div class="card">
                <h2>Upcoming Books</h2>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Neque odit ex consequuntur quibusdam sint consequatur illum obcaecati dolor iure. Nobis facere distinctio ut praesentium voluptate quidem ullam minus laudantium assumenda!</p>
            </div>
        </div>
        <hr class="bar" style="margin-top: 5rem;">
        <div class="about">
            <h1>About Pasific</h1>
            <br>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit earum pariatur perspiciatis facilis nam voluptatem vel. Vel dolore molestiae officia sed iusto nostrum reprehenderit nisi. Quod, commodi rerum laborum fugit itaque eveniet nulla quaerat sint iure pariatur minima, harum nobis? Explicabo ea minima pariatur animi atque asperiores consequuntur nulla. Deleniti dolorem laudantium dicta natus, distinctio necessitatibus inventore voluptatem molestias nobis facere ducimus voluptas quam ipsam suscipit dolor hic illum quas quod quia vero sint odio, rerum vitae? Inventore neque at magnam molestiae ducimus. Reiciendis doloremque ullam tenetur nemo distinctio, molestias molestiae dolorum possimus deserunt, reprehenderit cum quisquam adipisci, quaerat modi. Vero nesciunt minus qui voluptatum doloribus officiis animi odio quis? Maxime quis delectus, consequuntur quo nobis facere ex assumenda ut aspernatur deserunt esse qui inventore aliquid. Dolor, excepturi adipisci eum, sapiente nobis perspiciatis nemo sequi aliquam perferendis numquam, eveniet repudiandae dolore. Commodi neque ex quae praesentium maxime est et eaque quaerat vel ipsa. Voluptatum quae quas sit ratione, suscipit fugit error sed aspernatur exercitationem sint expedita enim earum. Atque, ipsa. Modi asperiores doloribus excepturi porro minima quas dolore molestiae, ratione ullam cupiditate magnam commodi doloremque illo similique ipsa velit odit. Dignissimos consectetur rem magni sint, quo maxime reprehenderit, inventore aut debitis reiciendis rerum eveniet modi, tempore repellat tenetur explicabo incidunt. Necessitatibus obcaecati explicabo atque ipsam culpa, ea quod. Aspernatur eum ipsam accusamus hic, quia praesentium cumque molestias maiores veniam veritatis nisi beatae, dolorum dolore voluptas et molestiae error iste. Sint rerum labore libero vitae praesentium voluptate! Rem adipisci impedit a dicta, veritatis obcaecati reprehenderit tempore vero, esse sapiente quasi odio perferendis delectus fugiat officia possimus maxime aperiam quam doloremque provident! Perferendis praesentium nemo similique quod architecto quam reprehenderit neque. Iusto nemo molestias dolore voluptatibus obcaecati odit corrupti, tempora consectetur totam cumque ipsa. Provident, veniam ullam at iste fugiat sequi quae eveniet dolore dicta, nihil suscipit architecto deleniti nobis pariatur quidem numquam quam nostrum tempora repellendus tenetur est. Excepturi, adipisci quia nulla id dolore incidunt, fuga illum facere iste nemo, eius ea vel! Voluptatum quis tempora beatae soluta eum ad, enim molestias quas sit perspiciatis quae libero repudiandae eius officiis ut officia. Quam maiores vero voluptatibus officia. Necessitatibus quibusdam exercitationem officia a mollitia commodi omnis nisi pariatur quam corporis eveniet, voluptatem repellendus perferendis. Perferendis tenetur repellat facere nostrum? Dolorem ratione facere officia perspiciatis quia numquam, quaerat doloribus unde quisquam optio illum odit laborum possimus veniam nisi dolores, rem quam aperiam atque! Ab ad voluptate impedit nam nisi rem dolor aliquid neque tempora soluta! Quos, sequi minima assumenda architecto placeat eum possimus esse voluptates beatae error accusantium tenetur ad culpa consectetur porro eaque adipisci quidem recusandae explicabo dignissimos facere veniam nisi provident. Sed unde corporis molestiae doloribus aspernatur iste libero cupiditate tenetur necessitatibus, quisquam eum voluptatibus animi neque laboriosam alias asperiores laborum pariatur eius veniam molestias quae! Quaerat, suscipit! Ex magni quod alias sed doloremque omnis laborum quos rem doloribus eveniet ipsam aliquid fuga natus, obcaecati ipsum ipsa iusto nobis molestias laudantium culpa! Voluptatibus, tenetur cupiditate animi assumenda quaerat voluptate odit ut!</p>
        </div>
        <hr class="bar" style="margin-top: 5rem;">
        <div class="footer">
            <img src="../img/logo.png" alt="" sizes="100px" width="100rem"/>
            <p>&copy 2025 See Me When I'm 24 All Rights Reserved</p>
        </div>
    </div>

    <?php
    if (isset($_SESSION['sudah_login'])): ?>
    <script>
        
        Swal.fire({
        title: 'Tunggu dulu!',
        text: 'Kamu sudah masuk ke Ruang Tamu!',
        showConfirmButton: true,
        confirmButtonText: 'Baiklah',
        confirmButtonColor: 'rgb(0, 13, 255)',
        background: 'rgba(200, 202, 252, 0.82)',
        color: 'black',

        showConfirmButton: true,
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
                }

        });

        
    </script>
    
    <?php endif; 
    unset($_SESSION['sudah_login']); // hapus session sudah_login setelah ditampilkan
    // AKU LELAAAHHHH mwehe :3 meow
    ?>
</body>
</html>
