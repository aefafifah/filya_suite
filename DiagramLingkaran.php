<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filya Suite Progress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link font Barlow dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Link font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <!-- Link Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fafafa;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: #F57C00;
            height: 100vh;
            padding: 20px;
        }

        .sidebar h3 {
            font-family: 'Poppins', sans-serif; /* Menggunakan font Poppins */
            font-weight: bold; /* Gaya bold */
            font-size: 36px; /* Ukuran font 36px */
            color: #fff;
            margin-bottom: 30px;
        }

        .sidebar a {
            text-decoration: none;
            font-weight: bold;
            display: block;
            padding: 10px 0;
            color: #fff;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #ff9800;
        }

        /* Dashboard area dengan gambar latar */
        .dashboard {
            background-image: url('blubrown.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 50px;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .dashboard::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #FDE49E; /* Warna overlay */
            opacity: 0.7; /* Sesuaikan transparansi jika perlu */
            z-index: 1; /* Pastikan overlay berada di atas gambar */
        }

        /* Persegi besar styling dengan background shadow ke kiri dan bawah */
        .main-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 10px 10px 0px 0px #F57C00; /* Background warna oranye di kiri bawah */
            width: 500px; /* Adjust size as needed */
            height: auto; /* Buat tinggi otomatis untuk konten */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            padding: 20px;
            position: relative;
            z-index: 2; /* Pastikan konten berada di atas overlay */
        }

        /* Styling untuk tulisan Filya Suite Progress dengan font Barlow */
        .main-card h2 {
            font-family: 'Barlow', sans-serif; /* Menggunakan font Barlow */
            font-size: 24px; /* Ukuran font 24px */
            font-weight: 700; /* Gaya bold */
            margin-bottom: 20px;
        }

        /* Circular progress bar */
        .circular-progress {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: conic-gradient(#4db6ac 0% 80%, #a2847d 0%);
            margin: 0 auto 20px;
        }

        .circular-progress.orange {
            background: conic-gradient(#ff9800 0% 62%, #a2847d 0%);
        }

        .percentage {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Barlow', sans-serif; /* Menggunakan font Barlow */
            font-size: 24px;
            font-weight: 700; /* Gaya bold */
            color: #333;
        }

        /* Custom styling for 2x2 layout */
        .progress-row {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .progress-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1; /* Menjadikan kolom fleksibel */
            margin: 0 10px; /* Margin di sini agar lebih seimbang */
        }

        .progress-col.orange {
            flex: 1; /* Memperlebar elemen oranye */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h3>Halo Admin</h3>
                <a href="#"><i class="bi bi-emoji-smile"></i> Data Laporan Kinerja</a> <!-- Ikon diubah di sini -->
                <a href="#"><i class="bi bi-easel2"></i> Data Laporan Fasilitas</a>
                <a href="#"><i class="bi bi-hand-thumbs-up"></i> Data Laporan Tempat</a>
                <a href="#"><i class="bi bi-person-circle"></i> Data Pegawai</a> <!-- Menambahkan ikon di sini -->
                <a href="#"><i class="bi bi-houses"></i> Data Villa</a> <!-- Menambahkan ikon di sini -->
            </div>

            <!-- Dashboard -->
            <div class="col-md-10 dashboard">
                <div class="main-card">
                    <!-- Judul di bagian atas dengan font Barlow -->
                    <h2>Filya Suite Progress</h2>
                    
                    <!-- Diagram lingkaran 2x2 -->
                    <div class="progress-row">
                        <div class="progress-col orange">
                            <div class="circular-progress">
                                <div class="percentage">80%</div>
                            </div>
                            <p>Kinerja Pegawai</p>
                        </div>
                        <div class="progress-col">
                            <div class="circular-progress orange">
                                <div class="percentage">62%</div>
                            </div>
                            <p>Fasilitas</p>
                        </div>
                    </div>

                    <div class="progress-row">
                        <div class="progress-col orange">
                            <div class="circular-progress">
                                <div class="percentage">80%</div>
                            </div>
                            <p>Total Villa dipakai</p>
                        </div>
                        <div class="progress-col">
                            <div class="circular-progress orange">
                                <div class="percentage">62%</div>
                            </div>
                            <p>Tempat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>