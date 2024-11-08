<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "filya_suite";
$nama = $_SESSION['nama'];

// Koneksi ke database
$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("Connection error");
}

// Memeriksa apakah sesi login tersedia
if (!isset($_SESSION['email']) && !isset($_SESSION['nomor_telpon'])) {
    header("Location: login.php"); // Jika tidak login, arahkan ke login
    exit();
}

// Mengambil data email atau nomor telepon dari sesi
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$nomor_telpon = isset($_SESSION['nomor_telpon']) ? $_SESSION['nomor_telpon'] : null;

// Query untuk memeriksa pemesanan berdasarkan email atau nomor telepon pengguna
$query = "
    SELECT id, nama_pemesan, email, villa_id, jumlah_orang, tanggal_checkin,
    tanggal_checkout, created_at
    FROM pemesanan
    WHERE email = ? OR email = (
        SELECT email FROM users WHERE nomor_telpon = ?
    )
";

$stmt = mysqli_prepare($data, $query);
mysqli_stmt_bind_param($stmt, "ss", $email, $nomor_telpon);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data_tersedia = mysqli_num_rows($result) > 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan Saya - Filya Suite</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        :root {
            --primary-color: #f7d76e;
            --secondary-color: #DD761C;
            --highlight-color: #ff8c00;
            --text-color: #333;
        }

        body {
            display: flex;
            background-color: #f0f0f0;
            color: var(--text-color);
            min-height: 100vh;
            transition: opacity 0.5s ease;
        }

        body.fade-out {
            opacity: 0;
        }

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


        .content {
            flex: 1;
            padding: 20px;
            background-image: url('abcd.jpg');
            background-size: cover;
            background-position: center;
        }

        .content h1 {
            color: var(--highlight-color);
            font-size: 36px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-container th,
        .table-container td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table-container th {
            background-color: var(--primary-color);
            color: var(--text-color);
        }

        .table-container tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2 class="user-greeting">Halo, <?php echo htmlspecialchars($nama); ?>!</h2>
        <a onclick="smoothRedirect('userhome.php')" class="menu-item">
            <img src="https://img.icons8.com/material-outlined/24/000000/home--v2.png" alt="Home Icon" />
            Halaman Utama
        </a>
        <a onclick="smoothRedirect('data_laporan.php')" class="menu-item">
            <img src="https://img.icons8.com/ios/24/000000/happy--v1.png" alt="Report Icon" />
            Data Laporan Saya
        </a>
        <a onclick="smoothRedirect('data_booking.php')" class="menu-item">
            <img src="https://img.icons8.com/material-outlined/24/000000/booking.png" alt="Booking Icon" />
            Data Booking Saya
        </a>
    </div>
    <div class="content">
        <h1>DATA BOOKING SAYA</h1>
        <div class="table-container">
            <?php if ($data_tersedia): ?>
                <table>
                    <tr>
                        <th>Id Pemesanan</th>
                        <th>Nama Pemesan</th>
                        <th>email Pemesan</th>
                        <th>Id Villa</th>
                        <th>Jumlah Orang</th>
                        <th>Tanggal Check In</th>
                        <th>Tanggal Check Out</th>
                        <th>Tanggal Pemesanan</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['nama_pemesan']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['villa_id']) ?></td>
                            <td><?= htmlspecialchars($row['jumlah_orang']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_checkin']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_checkout']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <p>Belum ada Kamar villa yang anda booking</p>
                    <p>Bosen di rumah aja dan kerja melulu???</p>
                    <p>Ingin liburan plus staycation enak dan nyaman? divilla Filya Suite? ajaa<br>
                        Yuk Liburan staycation di FillyaSuite dengan full senyum
                        Segera pilih kamar idamanmu di <a href="booking.php">sini</a>, dan Nikmati
                        villa FillyaSuite dengan nyaman, dan dengan pelayanan yang memuaskan<br>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
        function smoothRedirect(url) {
            document.body.classList.add("fade-out");
            setTimeout(() => {
                window.location.href = url;
            }, 300); // Waktu transisi
        }

        // Fade-in effect for page load or reload
        window.addEventListener("pageshow", (event) => {
            if (event.persisted || event.type === "pageshow") {
                document.body.classList.remove("fade-out");
            }
        });

        // Menghapus fade-out saat halaman pertama kali dimuat
        window.addEventListener("load", () => {
            document.body.classList.remove("fade-out");
        });
    </script>
</body>

</html>
