<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "filya_suite";

$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("Connection error");
}

if (!isset($_SESSION['nomor_telpon'])) {
    header("Location: login.php");
    exit();
}

$nomor_telpon = $_SESSION['nomor_telpon'];

// Query untuk memeriksa laporan berdasarkan nomor telepon di tabel fasilitas, kinerja, dan tempat
$query = "
    SELECT 'fasilitas' AS kategori, tanggal_menginap, tanggal_melaporkan AS tanggal_laporan, jenis_masalah, deskripsi_masalah_fasilitas AS deskripsi
    FROM fasilitas WHERE no_telepon_pengadu = ?
    UNION
    SELECT 'kinerja' AS kategori, tanggal_menginap, waktu_kejadian AS tanggal_laporan, jenis_masalah, deskripsi_masalah AS deskripsi
    FROM kinerja WHERE no_telepon_pengadu = ?
    UNION
    SELECT 'tempat' AS kategori, tanggal_menginap, waktu_pengaduan AS tanggal_laporan, jenis_masalah, deskripsi_masalah AS deskripsi
    FROM tempat WHERE no_telepon_pengadu = ?
";

$stmt = mysqli_prepare($data, $query);
mysqli_stmt_bind_param($stmt, "sss", $nomor_telpon, $nomor_telpon, $nomor_telpon);
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
        }

        /* Sidebar */
        .sidebar {
            background-color: var(--primary-color);
            width: 20%;
            padding: 2em;
            color: var(--secondary-color);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }

        .sidebar h2, .user-greeting {
            font-size: 1.8em;
            margin-bottom: 2em;
            font-weight: bold;
            color: var(--secondary-color);
        }

        .menu-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5em;
            font-size: 1.2em;
            text-decoration: none;
            color: var(--secondary-color);
            position: relative;
            padding: 0.8em 1em;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .menu-item img {
            margin-right: 0.6em;
            width: 24px;
            height: 24px;
        }

        .menu-item:hover {
            background-color: #FFFFFF;
            color: var(--secondary-color);
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

        .table-container th, .table-container td {
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
            <h2> Halo User</h2>
            <a href="#" class="menu-item">
                <img src="https://img.icons8.com/material-outlined/24/000000/home--v2.png" alt="Home Icon" />
                Halaman Utama
            </a>
            <a href="data_laporan.php"   class="menu-item">
                <img src="https://img.icons8.com/ios/24/000000/happy--v1.png" alt="Report Icon" />
                Data Laporan Saya
            </a>
            <a href="#" class="menu-item">
                <img src="https://img.icons8.com/material-outlined/24/000000/booking.png" alt="Booking Icon" />
                Data Booking Saya
            </a>
        </div>
    <div class="content">
        <h1>DATA LAPORAN SAYA</h1>
        <div class="table-container">
            <?php if ($data_tersedia): ?>
                <table>
                    <tr>
                        <th>Kategori</th>
                        <th>Tanggal Menginap</th>
                        <th>Tanggal Laporan</th>
                        <th>Tempat/Objek</th>
                        <th>Jenis Masalah</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['kategori']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_menginap']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal_laporan']) ?></td>
                            <td><?= htmlspecialchars($row['tempat_objek']) ?></td>
                            <td><?= htmlspecialchars($row['jenis_masalah']) ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <div class="no-data">
                    <p>Tidak ada laporan yang ditemukan untuk nomor telepon Anda.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
