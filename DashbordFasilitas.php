<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari database
$sql = "SELECT * FROM fasilitas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan Fasilitas</title>
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
            width: 300px;
            background-color: #fff;
            height: 100vh;
            padding: 20px;
            color: #DD761C;
            position: fixed;
            overflow-y: auto;
        }

        .sidebar h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            font-size: 36px;
            color: #DD761C;
            margin-bottom: 30px;
        }

        .sidebar a {
            text-decoration: none;
            font-weight: bold;
            display: block;
            padding: 10px 0;
            color: #DD761C;
            transition: background 0.3s;
            margin-bottom: 15px;
        }

        .sidebar a:hover {
            background-color: #ff9800;
        }

        .sidebar i {
            margin-right: 10px;
            font-size: 18px;
        }

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
        <h2>Halo Admin</h2>
        <a href="Dashboardadmin.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="DashbordKinerja.php"><i class="fas fa-smile"></i> Data Laporan Kinerja</a>
        <a href="DashbordFasilitas.php"><i class="fas fa-chalkboard"></i> Data Laporan Fasilitas</a>
        <a href="DashboardTempt.php"><i class="fas fa-thumbs-up"></i> Data Laporan Tempat</a>
        <a href="Dashboarddatapegawai.php"><i class="fas fa-user"></i> Data Pegawai</a>
        <a href="datavilla.php"><i class="fas fa-building"></i> Data Villa</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1><strong>Data Laporan Fasilitas</strong></h1>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Pengadu</th>
                        <th>Nomor Telepon</th>
                        <th>Tanggal Menginap</th>
                        <th>Tanggal Melaporkan</th>
                        <th>Tempat Kerusakan</th>
                        <th>Jenis Masalah</th>
                        <th>Deskripsi Masalah</th>
                        <th>Kategori Fasilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($result) && $result->num_rows > 0): ?>
                        <?php while($fasilitas = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo isset($fasilitas['nama_pengadu']) ? $fasilitas['nama_pengadu'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['no_telepon_pengadu']) ? $fasilitas['no_telepon_pengadu'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['tanggal_menginap']) ? $fasilitas['tanggal_menginap'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['tanggal_melaporkan']) ? $fasilitas['tanggal_melaporkan'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['tempat_kerusakan']) ? $fasilitas['tempat_kerusakan'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['jenis_masalah']) ? $fasilitas['jenis_masalah'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['deskripsi_masalah_fasilitas']) ? $fasilitas['deskripsi_masalah_fasilitas'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['pilih_kategori_fasilitas']) ? $fasilitas['pilih_kategori_fasilitas'] : ''; ?></td>
                                <td>
                                    <a href="proses_fasilitas/edit.php?id=<?php echo $fasilitas['id_pengaduan']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="proses_fasilitas/delete.php?id=<?php echo $fasilitas['id_pengaduan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">Tidak ada data ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
