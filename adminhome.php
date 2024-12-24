<?php
session_start();

// Cek apakah pengguna sudah login dan apakah mereka admin
if (!isset($_SESSION["nama"]) || $_SESSION["usertype"] !== 'admin') {
    header("location:index.php");
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "u976363923_filyasuite";
$password = "Bagus_2024";
$dbname = "u976363923_filyasuite";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

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

// Ambil data dari tabel fasilitas
$sql = "SELECT id_pengaduan, nama_pengadu, no_telepon_pengadu, tanggal_menginap, tanggal_melaporkan, tempat_kerusakan, jenis_masalah, deskripsi_masalah_fasilitas, pilih_kategori_fasilitas, bukti_gambar, status FROM fasilitas";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Home Page</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-dark-blue {
            background-color: #003366;
        }
        .nav-link {
            color: white;
        }
        .nav-link:hover {
            color: white;
        }
        .navbar-brand {
            color: white;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg bg-dark-blue">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FilyaSuite</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Manage Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h1 class="display-4 text-primary">Welcome to Admin Home Page</h1>
                    <p class="lead mt-4">Selamat datang, <?php echo htmlspecialchars($_SESSION["nama"]); ?>!</p>
                    <a href="index.php" class="btn btn-danger mt-3">Logout</a>
                    <p>login as <a href="userhome.php">user</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan Fasilitas -->
    <div class="mt-5">
        <h2 class="text-center">Daftar Laporan Fasilitas</h2>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Nama Pengadu</th>
                    <th>No Telepon</th>
                    <th>Tanggal Menginap</th>
                    <th>Tanggal Melaporkan</th>
                    <th>Tempat Kerusakan</th>
                    <th>Jenis Masalah</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Bukti Gambar</th>
                    <th>Status</th>
                    <th class = ps-6>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nama_pengadu']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['no_telepon_pengadu']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal_menginap']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal_melaporkan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tempat_kerusakan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jenis_masalah']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['deskripsi_masalah_fasilitas']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pilih_kategori_fasilitas']) . "</td>";
                        echo "<td><a href='" . htmlspecialchars($row['bukti_gambar']) . "' target='_blank'>Lihat Bukti</a></td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='id_pengaduan' value='" . htmlspecialchars($row['id_pengaduan']) . "'>
                                    <select name='status' class='form-select'>
                                        <option value='Diterima'" . ($row['status'] == 'Diterima' ? ' selected' : '') . ">Diterima</option>
                                        <option value='Ditolak'" . ($row['status'] == 'Ditolak' ? ' selected' : '') . ">Ditolak</option>
                                        <option value='Diproses'" . ($row['status'] == 'Diproses' ? ' selected' : '') . ">Diproses</option>
                                    </select>
                                    <button type='submit' name='update_status' class='btn btn-primary mt-2'>Update</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10' class='text-center'>Tidak ada laporan yang ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi
?>
