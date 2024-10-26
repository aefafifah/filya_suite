<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Villa</title>
    <!-- Link ke Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Link ke Font Baloo -->
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #fff;
            height: 100vh;
            padding: 20px;
            color: #DD761C;
        }
        .sidebar h2 {
            margin-bottom: 30px;
            color: #DD761C;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #DD761C;
            padding: 10px;
            margin-bottom: 15px;
            transition: background 0.3s;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #f0c669;
        }
        .sidebar i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Konten Utama */
        .main-content {
            flex: 1;
            padding: 30px 20px; /* Mengatur padding agar selaras */
            background-color: #FDE49E;
            text-align: center;
            background-image: url('blubrown.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }
        
        /* Overlay */
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

        /* Menjaga elemen tetap di atas overlay */
        .labels, .data-row, h1 {
            position: relative;
            z-index: 2;
        }

        .main-content h1 {
            font-family: 'Baloo 2', cursive;
            margin: 0; /* Menghapus margin atas agar selaras */
            font-size: 2.5rem;
            font-weight: bold;
            color: #DD761C;
        }
        
        .labels, .data-row {
            display: flex;
            color: #DD761C;
            margin-bottom: 20px;
            padding: 10px 0;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            justify-content: space-between;
        }
        
        .labels {
            font-weight: bold;
            background-color: transparent;
            box-shadow: none;
        }
        
        .nama-villa, .kuota, .keterangan, .icon {
            width: 20%;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Halo, Admin</h2>
        <a href="#"><i class="fas fa-home"></i> Dashboard</a>
        <a href="#"><i class="fas fa-smile"></i> Data Laporan Kinerja</a>
        <a href="#"><i class="fas fa-chalkboard"></i> Data Laporan Fasilitas</a>
        <a href="#"><i class="fas fa-thumbs-up"></i> Data Laporan Tempat</a>
        <a href="#"><i class="fas fa-user"></i> Data Pegawai</a>
        <a href="#"><i class="fas fa-building"></i> Data Villa</a>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <h1><strong>Data Villa</strong></h1>
        
        <?php
        $villaData = [
            ['nama_villa' => 'Villa Fancy', 'kuota' => 5, 'keterangan' => 'Aktif'],
            ['nama_villa' => 'Villa Dreamy', 'kuota' => 5, 'keterangan' => 'Aktif'],
            ['nama_villa' => 'Villa Charming', 'kuota' => 5, 'keterangan' => 'Aktif'],
        ];
        ?>

        <!-- Menampilkan Data Villa -->
        <div class="labels">
            <div class="nama-villa">Nama Villa</div>
            <div class="kuota">Kuota</div>
            <div class="keterangan">Keterangan</div>
            <div class="icon">Edit</div>
        </div>
        
        <?php foreach ($villaData as $villa): ?>
            <div class="data-row">
                <div class="nama-villa"><?php echo htmlspecialchars($villa['nama_villa']); ?></div>
                <div class="kuota"><?php echo htmlspecialchars($villa['kuota']); ?></div>
                <div class="keterangan"><?php echo htmlspecialchars($villa['keterangan']); ?></div>
                <div class="icon"><i class="fas fa-pencil-alt"></i></div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
