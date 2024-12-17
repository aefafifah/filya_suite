<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}



$sql = "SELECT * FROM tempat";
$result = $conn->query($sql);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $id_pengaduan = $_POST['id_pengaduan'];

    // Update status di database
    $stmt = $conn->prepare("UPDATE tempat SET status = ? WHERE id_pengaduan = ?");
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
    <title>Data Laporan Tempat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

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
            min-height: 100vh;
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
            background-color: #fef3d4;
            color: #DD761C;
        }

        .menu-item.active {
            background-color: #fef3d4;
            font-weight: bold;
        }

        .main-content {
            flex: 1;
            padding: 30px 20px;
            background-color: #FDE49E;
            margin-left: 250px;
            text-align: center;
            background-image: url('blubrown.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
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
            margin-bottom: 90px;
            margin-top: 50px;
        }

        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
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

        img {
            max-width: 50px;
            height: auto;
        }
    </style>
</head>

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
        <a href="DashbordFasilitas.php" class="menu-item">
            <i class="fas fa-chalkboard"></i> Data Laporan Fasilitas
        </a>

        <a href="DashboardTempt.php" class="menu-item active">
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


<div class="main-content">
    <h1><strong>Data Laporan Tempat</strong></h1>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Pengadu</th>
                    <th>Nomor Telepon</th>
                    <th>Tanggal Menginap</th>
                    <th>Nomor Kamar</th>
                    <th>Deskripsi Masalah</th>
                    <th>Tanggal Melaporkan</th>
                    <th>File Bukti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo isset($row['nama_pengadu']) ? $row['nama_pengadu'] : ''; ?></td>
                            <td><?php echo isset($row['no_telepon_pengadu']) ? $row['no_telepon_pengadu'] : ''; ?></td>
                            <td><?php echo isset($row['tanggal_menginap']) ? $row['tanggal_menginap'] : ''; ?></td>
                            <td><?php echo isset($row['nomor_kamar']) ? $row['nomor_kamar'] : ''; ?></td>
                            <td><?php echo isset($row['deskripsi_masalah']) ? $row['deskripsi_masalah'] : ''; ?></td>
                            <td><?php echo isset($row['waktu_pengaduan']) ? $row['waktu_pengaduan'] : ''; ?></td>
                            <td>
                                <?php if (!empty($row['file_bukti'])): ?>
                                    <a href="<?php echo isset($row['file_bukti']) ? $row['file_bukti'] : ''; ?>" target="">Lihat
                                        Bukti</a>
                                <?php else: ?>
                                    Tidak Ada Bukti
                                <?php endif; ?>
                            </td>

                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id_pengaduan"
                                        value="<?php echo htmlspecialchars($row['id_pengaduan']); ?>">
                                    <select name="status" class="form-select">
                                        <option value="Diterima" <?php echo ($row['status'] == 'Diterima') ? 'selected' : ''; ?>>
                                            Diterima</option>
                                        <option value="Ditolak" <?php echo ($row['status'] == 'Ditolak') ? 'selected' : ''; ?>>
                                            Ditolak</option>
                                        <option value="Diproses" <?php echo ($row['status'] == 'Diproses') ? 'selected' : ''; ?>>
                                            Diproses</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary mt-2">Update</button>
                                </form>
                            </td>

                            <td>
                                <a href="proses_tempat/edit.php?id=<?php echo $row['id_pengaduan']; ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="proses_tempat/delete.php?id=<?php echo $row['id_pengaduan']; ?>"
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
</div>
</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>