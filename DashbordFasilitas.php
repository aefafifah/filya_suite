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
// Konfigurasi Pagination
$limit = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Halaman saat ini
$page = max($page, 1); // Pastikan halaman minimal adalah 1
$offset = ($page - 1) * $limit; // Offset untuk query

// Menghitung Total Data
$total_query = "SELECT COUNT(*) AS total FROM fasilitas";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_data = $total_row['total'];

// Hitung Total Halaman
$total_pages = ceil($total_data / $limit);

// Mengambil data dari database dengan limit dan offset
$sql = "SELECT * FROM fasilitas LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Proses update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $id_pengaduan = $_POST['id_pengaduan'];

    // Update status di database
    $stmt = $conn->prepare("UPDATE fasilitas SET status = ? WHERE id_pengaduan = ?");
    $stmt->bind_param("si", $new_status, $id_pengaduan);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']); // Refresh halaman setelah update
        exit();
    } else {
        echo "Gagal mengupdate status.";
    }

    $stmt->close();
}
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
            /* z-index: 2; */
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
            overflow-y: auto;
            margin-top: 90px;
            z-index: 2;
            position: relative;
            max-height: 500px;
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
            border-collapse: collapse;
            table-layout: auto;
        }


        th,
        td {
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

        th:last-child,
        td:last-child {
            width: 150px;
            text-align: center;

        }
    </style>
</head>

<body>

<div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h2>Halo Admin</h2>
                <a href="Dashboardadmin.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="DashbordKinerja.php"><i class="fas fa-smile"></i> Data Laporan Kinerja</a>
                <a href="DashbordFasilitas.php"><i class="fas fa-chalkboard"></i> Data Laporan Fasilitas</a>
                <a href="DashboardTempt.php"><i class="fas fa-thumbs-up"></i> Data Laporan Tempat</a>
                <a href="Dashboarddatapegawai.php"><i class="fas fa-user"></i> Data Pegawai</a>
                <a href="datavilla.php"><i class="fas fa-building"></i> Data Villa</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
                        <th>Bukti Gambar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($result) && $result->num_rows > 0): ?>
                        <?php while ($fasilitas = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo isset($fasilitas['nama_pengadu']) ? $fasilitas['nama_pengadu'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['no_telepon_pengadu']) ? $fasilitas['no_telepon_pengadu'] : ''; ?>
                                </td>
                                <td><?php echo isset($fasilitas['tanggal_menginap']) ? $fasilitas['tanggal_menginap'] : ''; ?>
                                </td>
                                <td><?php echo isset($fasilitas['tanggal_melaporkan']) ? $fasilitas['tanggal_melaporkan'] : ''; ?>
                                </td>
                                <td><?php echo isset($fasilitas['tempat_kerusakan']) ? $fasilitas['tempat_kerusakan'] : ''; ?>
                                </td>
                                <td><?php echo isset($fasilitas['jenis_masalah']) ? $fasilitas['jenis_masalah'] : ''; ?></td>
                                <td><?php echo isset($fasilitas['deskripsi_masalah_fasilitas']) ? $fasilitas['deskripsi_masalah_fasilitas'] : ''; ?>
                                </td>
                                <td><?php echo isset($fasilitas['pilih_kategori_fasilitas']) ? htmlspecialchars($fasilitas['pilih_kategori_fasilitas']) : ''; ?>
                                </td>
                                <td>
                                    <?php if (!empty($fasilitas['bukti_gambar'])): ?>
                                        <a href="<?php echo htmlspecialchars($fasilitas['bukti_gambar']); ?>" target="_blank">Lihat
                                            Bukti</a>
                                    <?php else: ?>
                                        Tidak ada bukti
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_pengaduan"
                                            value="<?php echo htmlspecialchars($fasilitas['id_pengaduan']); ?>">
                                        <select name="status" class="form-select">
                                            <option value="Diterima" <?php echo ($fasilitas['status'] == 'Diterima') ? 'selected' : ''; ?>>Diterima</option>
                                            <option value="Ditolak" <?php echo ($fasilitas['status'] == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                            <option value="Diproses" <?php echo ($fasilitas['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-primary mt-2">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="proses_fasilitas/edit.php?id=<?php echo $fasilitas['id_pengaduan']; ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="proses_fasilitas/delete.php?id=<?php echo $fasilitas['id_pengaduan']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">Tidak ada data ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-4">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>