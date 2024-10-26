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
            padding: 20px;
            background-color: #FDE49E;
            text-align: center;
        }
        .main-content h1 {
            font-family: 'Baloo 2', cursive;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .labels, .data-row {
            display: flex;
            color: #DD761C; /* Warna teks */
            margin-bottom: 20px;
            padding: 10px 0; /* Jarak vertikal */
            background-color: #fff; /* Latar belakang */
            border-radius: 5px; /* Sudut membulat */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Bayangan */
            justify-content: space-between; /* Memastikan elemen tersebar merata */
        }
        .labels {
            font-weight: bold;
            background-color: transparent; /* Tidak ada latar belakang */
            box-shadow: none; /* Menghilangkan bayangan */
        }
        .nama-villa, .kuota, .keterangan, .icon {
            width: 20%; /* Menjaga lebar yang konsisten */
            text-align: center; /* Perataan tengah */
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
        // Data villa baru
        $villaData = [
            [
                'nama_villa' => 'Villa Fancy',
                'kuota' => 5,
                'keterangan' => 'Aktif'
            ],
            [
                'nama_villa' => 'Villa Dreamy',
                'kuota' => 5,
                'keterangan' => 'Aktif'
            ],
            [
                'nama_villa' => 'Villa Charming',
                'kuota' => 5,
                'keterangan' => 'Aktif'
            ],
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
                <div class="nama-villa">
                    <?php echo htmlspecialchars($villa['nama_villa']); ?>
                </div>
                <div class="kuota">
                    <?php echo htmlspecialchars($villa['kuota']); ?>
                </div>
                <div class="keterangan">
                    <?php echo htmlspecialchars($villa['keterangan']); ?>
                </div>
                <div class="icon"><i class="fas fa-pencil-alt"></i></div> <!-- Ikon pensil -->
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
