<?php
require_once 'koneksi.php'; // Pastikan koneksi database terhubung.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai</title>
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
        }

        .sidebar {
            width: 300px;
            background-color: #fff;
            height: 100vh;
            padding: 20px;
            color: #DD761C;
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
            flex: 1;
            padding: 30px 20px;
            background-color: #FDE49E;
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
            background-color: #FDE49E;
            opacity: 0.7;
            z-index: 1;
        }

        .main-content h1 {
            position: relative;
            z-index: 2;
            font-family: 'Baloo 2', cursive;
            font-size: 2.5rem;
            font-weight: bold;
            color: black;
            margin-bottom: 90px;
        }

        /* Button Tambah Pegawai */
        .btn-tambah {
            position: absolute;
            top: 30px;
            left: 20px;
            z-index: 2;
        }

        /* Tabel */
        .table-table-striped {
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

    <!-- Konten Utama -->
    <div class="main-content">
        <h1><strong>Data Pegawai</strong></h1>

        <!-- Button Tambah Pegawai di pojok kiri atas -->
        <a href="tambah_pegawai.php" class="btn btn-primary btn-tambah">Tambah Pegawai</a>

        <!-- Tabel Data Pegawai -->
        <table class="table-table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Hari</th>
                    <th>Waktu Shift</th>
                    <th>Tinggi</th>
                    <th>Tubuh</th>
                    <th>Warna Kulit</th>
                    <th>Warna Rambut</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($conn) {
                    $query = "SELECT * FROM pegawai"; // Sesuaikan nama tabel Anda.
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0):
                        while ($pegawai = mysqli_fetch_assoc($result)):
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($pegawai['nama']); ?></td>
                                <td><?= htmlspecialchars($pegawai['jabatan']); ?></td>
                                <td><?= htmlspecialchars($pegawai['hari']); ?></td>
                                <td><?= htmlspecialchars($pegawai['waktu_shift']); ?></td>
                                <td><?= htmlspecialchars($pegawai['tinggi']); ?></td>
                                <td><?= htmlspecialchars($pegawai['tubuh']); ?></td>
                                <td><?= htmlspecialchars($pegawai['kulit']); ?></td>
                                <td><?= htmlspecialchars($pegawai['rambut']); ?></td>
                                <td class="text-center">
                                    <a href="proses_datapegawai/edit.php?id=<?= $pegawai['id_pegawai']; ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="proses_datapegawai/delete.php?id=<?= $pegawai['id_pegawai']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        endwhile;
                    else:
                        ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data pegawai.</td>
                        </tr>
                        <?php
                    endif;
                } else {
                    echo "<tr><td colspan='9' class='text-center'>Koneksi database tidak tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>