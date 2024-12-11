<?php
session_start();

// Redirect ke login.php jika pengguna belum login
if (!isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

$nama = $_SESSION['nama'] ?? 'Tamu';  // Menangani pengguna tamu
$nomor_telpon = $_SESSION['nomor_telpon'] ?? '';
$alamat = $_SESSION['alamat'] ?? '';


// Cek jika pengguna adalah tamu
$isGuest = $_SESSION['usertype'] === 'guest';
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filya Suite</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: stretch;
            transition: opacity 0.5s ease;
        }

        /* Fade-out effect for page transition */
        body.fade-out {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        /* Main container */
        .container {
            display: flex;
            width: 100%;
            height: 100%;
        }

        /* Sidebar */
        .sidebar {
            background-color: #f7d76e;
            width: 20%;
            padding: 2em;
            color: #f07126;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }   

        .sidebar h2 {
            font-size: 1.8em;
            margin-bottom: 2em;
            font-weight: bold;
            color: #DD761C;
        }

        /* Tambahkan kelas khusus untuk "Halo User" yaitu menyamakan
        baris dengan menu */
        .user-greeting {
            font-size: 1.8em;
            font-weight: bold;
            color: #DD761C;
            padding: 0.8em 1em;
            /* padding agar selaras dengan menu */
            margin-bottom: 1.5em;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            /* selaras dengan menu */
        }

        .menu-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5em;
            font-size: 1.2em;
            text-decoration: none;
            color: #DD761C;
            position: relative;
            padding: 0.8em 1em;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
            cursor: pointer;

        }

        /*pemberian jarak antar menu ke simbol*/
        .menu-item img {
            margin-right: 0.6em;
            /* Tambah jarak antara ikon dan teks */
            width: 24px;
            height: 24px;
        }

        .menu-item:hover {
            background-color: #FFFFFF;
            color: #DD761C;
        }

        .menu-item:hover::before {
            content: '';
            position: absolute;
            left: -14px;
            width: 8px;
            height: 8px;
            background-color: #FFFFFF;
            border-radius: 50%;
        }

        /* Main content */
        .content {
            position: relative;
            width: 80%;
            background-image: url('abcd.jpg');
            background-size: cover;
            background-position: center;
            padding: 2em;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: #f07126;
            overflow: hidden;
            height: 100vh;
        }

        .content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }

        .content h1,
        .button-container {
            position: relative;
            z-index: 2;
        }

        .content h1 {
            top: 20%;
            font-size: 2.5em;
            margin-bottom: 1.5em;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 0.5em;
            width: 180px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

        }

        .button {
            background-color: #f07126;
            color: #fff;
            border: none;
            padding: 0.6em 1.8em;
            font-size: 1em;
            cursor: pointer;
            border-radius: 25px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s, color 0.3s;
        }

        .button:hover {
            background-color: #FDE49E;
            color: #DD761C;
        }

        /* Extra buttons styling and hover effects */
        .extra-buttons {
            overflow: hidden;
            max-height: 0;
            transition: max-height 1s ease;
            display: flex;
            flex-direction: column;
            gap: 0.5em;
        }

        .extra-buttons.show {
            max-height: 300px;
        }

        .extra-button {
            background-color: #f7d76e;
            color: #DD761C;
            border: none;
            padding: 0.6em 1.8em;
            font-size: 1em;
            border-radius: 25px;
            text-align: center;
            width: 100%;
            cursor: pointer;
            position: relative;
            transition: background-color 0.3s, color 0.3s;
        }

        .extra-button:hover {
            background-color: #FFFFFF;
            color: #DD761C;
        }

        .extra-button:hover::before {
            content: '';
            position: absolute;
            left: -10px;
            width: 8px;
            height: 8px;
            background-color: #FFFFFF;
            border-radius: 50%;
        }
        /* Flashing animation for triggered effect */
        @keyframes flash {
            0%, 100% { background-color: #f7d76e; }
            50% { background-color: #FFD700; } /* Warna flash */
        }
        .flash-triggered {
            animation: flash 0.5s ease-in-out infinite;
        }
    </style>
</head>

<body>
    <div class="container">
    <div class="sidebar">
    <h2 class="user-greeting">Halo, <?php echo htmlspecialchars($nama); ?>!</h2>
    <a onclick="smoothRedirect('userhome.php')" class="menu-item">
        <img src="https://img.icons8.com/material-outlined/24/000000/home--v2.png" alt="Home Icon" />
        Halaman Utama
    </a>
    
    <?php if (!$isGuest): ?>
        <a onclick="smoothRedirect('data_laporan.php')" class="menu-item">
            <img src="https://img.icons8.com/ios/24/000000/happy--v1.png" alt="Report Icon" />
            Data Laporan Saya
        </a>
        <a onclick="smoothRedirect('data_booking.php')" class="menu-item">
            <img src="https://img.icons8.com/?size=100&id=4027&format=png&color=000000" alt="Booking Icon" />
            Data Booking Saya
        </a>
    <?php endif; ?>
    
    <a onclick="smoothRedirect('logout.php')" class="menu-item">
        <img src="https://img.icons8.com/?size=100&id=2444&format=png&color=000000" alt="Logout Icon" />
        Logout
    </a>
    </div>
        <!-- Main Content -->
        <div class="content">
            <h1>Selamat Datang Di Filya Suite</h1>
            <div class="button-container">
                <button class="button" onclick="toggleExtraButtons()">Adukan Laporan</button>
                <button class="button" onclick="handleBooking()">Booking Villa</button>

                <div class="extra-buttons" id="extraButtons">
                    <button class="extra-button" onclick="smoothRedirect('eyyo2.php')">Laporan Fasilitas</button>
                    <button class="extra-button" onclick="smoothRedirect('kinerja.php')">Laporan Kinerja</button>
                    <button class="extra-button" onclick="smoothRedirect('tempat.php')">Laporan Tempat</button>
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
            if (document.body.classList.contains("fade-out")) {
                document.body.classList.remove("fade-out");
            }
        });
        function toggleExtraButtons(show = false) {
            const extraButtons = document.getElementById("extraButtons");
            if (show) {
                extraButtons.classList.add("show");
            } else {
                extraButtons.classList.toggle("show");
            }
        }

        function smoothRedirect(url) {
            document.body.classList.add("fade-out");
            setTimeout(() => {
                window.location.href = url;
            }, 300); // Waktu transisi
        }

        window.addEventListener("pageshow", (event) => {
            if (event.persisted || event.type === "pageshow") {
                document.body.classList.remove("fade-out");
            }
        });

        window.addEventListener("load", () => {
            document.body.classList.remove("fade-out");

// Periksa apakah showExtra ada di URL
const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('showExtra')) {
                toggleExtraButtons(true); // Tampilkan ekstra tombol
                const extraButtons = document.querySelectorAll(".extra-button");
                extraButtons.forEach(button => button.classList.add("flash-triggered"));
                
                // Hentikan efek flash setelah 3 detik
                setTimeout(() => {
                    extraButtons.forEach(button => button.classList.remove("flash-triggered"));
                }, 3000);
            }
        });

        function handleBooking() {
    const isGuest = <?php echo json_encode($isGuest); ?>; // Mendapatkan status guest dari PHP

    if (isGuest) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: 'Anda harus daftar sebagai user terlebih dahulu.',
            confirmButtonText: 'Daftar',
            showCancelButton: true,
            cancelButtonText: 'Tutup',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'register.php';  // Arahkan ke halaman register
            }
        });
    } else {
        smoothRedirect('booking.php');  // Lanjutkan ke halaman booking jika bukan guest
    }
}

    </script>
</body>

</html>