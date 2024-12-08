<?php
$host = "localhost"; // Host database
$username = "root"; // Username database
$password = ""; // Password database (sesuaikan jika perlu)
$dbname = "filya_suite"; // Nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari database
$sql = "SELECT * FROM villa"; // Ganti 'villas' dengan nama tabel Anda yang sebenarnya
$result = $conn->query($sql);
?>

<?php
// Menutup koneksi database
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan Villa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            display: flex;
            height: 100vh;
        }

        .sidebar {
    background-color: #ffffff; 
    width: 250px;
    padding: 1.5em;
    height: 100vh; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    color: #DD761C;
    display: flex;
    flex-direction: column;
    position: fixed; 
    top: 0; 
    left: 0; 
    overflow-y: auto; 
    z-index: 1000; 
}

.sidebar-header {
    margin-bottom: 2em;
    text-align: center;
}

.sidebar-header h2 {
    font-size: 1.5em;
    font-weight: bold;
    color: #DD761C;
    margin-top: 70px;
}

.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 1.5em;
}

.menu-item {
    display: flex;
    align-items: center;
    font-size: 1em;
    text-decoration: none;
    color: #DD761C;
    padding: 0.8em 1em;
    border-radius: 10px;
    transition: background-color 0.3s, color 0.3s;
}

.menu-item i {
    margin-right: 0.8em;
    font-size: 1.2em;
}

.menu-item:hover {
    background-color: #fef3d4; /* Warna hover */
    color: #DD761C;
}

.menu-item.active {
    background-color: #fef3d4; /* Warna latar item aktif */
    font-weight: bold;
}

        /* Main Content */
        .main-content {
            margin-left: 300px;
            padding: 30px 20px;
            background-color: #FDE49E;
            background-image: url('blubrown.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
            height: 100%;
            width: 100%;
        }

        /* Overlay */
        .main-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(253, 228, 158, 0.7);
            z-index: 1;
        }

        /* Keep elements above overlay */
        .main-content h1 {
            position: relative;
            z-index: 2;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            font-size: 2.5rem;
            font-weight: bold;
            color: black;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
            margin-top: 90px;
            z-index: 2;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: black;
        }

        th {
            background-color: #f0c669;
            font-weight: bold;
            color: black;
        }

        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>


               <!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Halo, Admin</h2>
    </div>
    <n class="sidebar-menu">
        <a href="Dashboardadmin.php" class="menu-item">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="DashbordKinerja.php" class="menu-item">
            <i class="fas fa-smile"></i> Data Laporan Kinerja
        </a>
        <a href="DashbordFasilitas.php" class="menu-item active">
    <i class="fas fa-chalkboard"></i> Data Laporan Fasilitas
</a>

        <a href="DashboardTempt.php" class="menu-item">
            <i class="fas fa-thumbs-up"></i> Data Laporan Tempat
        </a>
        <a href="Dashboarddatapegawai.php" class="menu-item">
            <i class="fas fa-user"></i> Data Pegawai
        </a>
        <a href="datavilla.php" class="menu-item">
            <i class="fas fa-building"></i> Data Villa
        </a>
    <div class="sidebar-footer">
        <a href="logout.php" class="menu-item">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>


    <!-- Main Content -->
    <div class="main-content">
        <h1><strong>Data Villa</strong></h1>

        <div class="table-responsive">
        <table>
    <thead>
        <tr>
            <th>Nama Villa</th>
            <th>Kuota</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nama_villa'] . "</td>";
                echo "<td>" . $row['kuota'] . "</td>";
                echo "<td>" . $row['keterangan'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>
                    <a href='proses_villa/edit.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>
                        <i class='fas fa-pencil-alt'></i>
                    </a>
                    <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>
                        <i class='fas fa-trash-alt'></i>
                    </a>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
        }
        ?>
    </tbody>
</table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>