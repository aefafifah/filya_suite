<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Redirect ke login.php jika pengguna belum login
if (!isset($_SESSION['nama']) || !isset($_SESSION['usertype'])) {
    header("Location: index.php");
    exit();
}

$nama = $_SESSION['nama'];
$nomor_telpon = $_SESSION['nomor_telpon'] ?? '';
$alamat = $_SESSION['alamat'] ?? '';

// Mengambil data kategori laporan
$sql = "SELECT kategori, COUNT(*) AS jumlah
        FROM (
            SELECT 'kinerja' AS kategori, id_pengaduan AS id FROM kinerja
            UNION ALL
            SELECT 'tempat' AS kategori, id_pengaduan AS id FROM tempat
            UNION ALL
            SELECT 'fasilitas' AS kategori, id_pengaduan AS id FROM fasilitas
        ) AS laporan
        GROUP BY kategori";

$result = $conn->query($sql);
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[$row['kategori']] = $row['jumlah'];
    }
}

// Mengambil data status villa secara langsung dari database
$sqlVilla = "SELECT status, COUNT(*) AS jumlah FROM villa GROUP BY status";
$resultVilla = $conn->query($sqlVilla);

// Initialize villa data in case no data is returned
$data['villa_tersedia'] = 0;  // Set default to 0 if no data found
$data['villa_tidak_tersedia'] = 0;  // Set default to 0 if no data found

if ($resultVilla->num_rows > 0) {
    while ($row = $resultVilla->fetch_assoc()) {
        if ($row['status'] == 'tersedia') {
            $data['villa_tersedia'] = $row['jumlah'];
        } elseif ($row['status'] == 'tidak tersedia') {
            $data['villa_tidak_tersedia'] = $row['jumlah'];
        }
    }
} else {
    echo "Tidak ada data villa.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Umum */
body {
    font-family: 'Arial', sans-serif;
    background-color: #fafafa;
    margin: 0;
    padding: 0;
    display: flex; /* Agar sidebar dan dashboard tersusun horizontal */
    min-height: 100vh; /* Pastikan body memenuhi layar */
}

/* Sidebar */
.sidebar {
    background-color: #ffffff;
    width: 270px;
    padding: 2em;
    height: 100vh;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    color: #DD761C;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
}

/* Adjusting 'Halo, Admin' alignment */
.sidebar-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 2em;
}

.sidebar-header h2 {
    font-size: 1.8em;
    font-weight: bold;
    color: #DD761C;
    margin-bottom: 0.5em;
}

.sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 1em;
}

.menu-item {
    display: flex;
    align-items: center;
    font-size: 1.1em;
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

/* Dashboard */
.dashboard {
    margin-left: 270px;
    padding: 40px;
    background-image: url('blubrown.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    gap: 40px;
    position: relative;
}

/* Dashboard content card adjustments */
.dashboard .main-card {
    background-color: white;
    border-radius: 15px;
    box-shadow: 10px 10px 10px 0px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 1000px;
    padding: 30px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Chart container for donut diagrams */
.chart-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Adjust grid for better spacing */
    gap: 30px; /* Increase gap for better spacing between charts */
}

.chart-wrapper {
    width: 100%;
    height: 250px;
    position: relative;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
}

.dashboard h3 {
    font-size: 1.6em;
    margin-bottom: 20px;
    color: #333;
}

.dashboard::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #FDE49E;
    opacity: 0.8; /* Sedikit lebih gelap agar kontras dengan teks */
    z-index: 1;
}



/* Responsivitas */
@media (max-width: 768px) {
    .dashboard {
        margin-left: 0; /* Sidebar hilang pada layar kecil */
        padding: 20px;
    }

    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        box-shadow: none;
    }

    .sidebar-header {
        margin-top: 20px;
    }

    .sidebar-menu {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 0.5em;
        justify-content: center;
    }

    .menu-item {
        flex: 1 1 auto;
        padding: 0.5em;
        text-align: center;
    }

    .main-card {
        width: 100%;
    }

    .chart-wrapper {
        width: 100%;
        max-width: 300px;
    }
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
        <a href="Dashboardadmin.php" class="menu-item active">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="DashbordKinerja.php" class="menu-item">
            <i class="fas fa-smile"></i> Data Laporan Kinerja
        </a>
        <a href="DashbordFasilitas.php" class="menu-item">
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

            <!-- Dashboard -->
            <div class="col-md-10 dashboard">
                <div class="main-card">
                    <h2>Filya Suite Progress</h2>
                    <div class="chart-container">
                        <!-- Chart for Kinerja -->
                        <div class="chart-wrapper">
                            <canvas id="kinerjaChart"></canvas>
                        </div>

                        <!-- Chart for Tempat -->
                        <div class="chart-wrapper">
                            <canvas id="tempatChart"></canvas>
                        </div>

                        <!-- Chart for Fasilitas -->
                        <div class="chart-wrapper">
                            <canvas id="fasilitasChart"></canvas>
                        </div>

                        <!-- Chart for Villa Tersedia -->
                        <div class="chart-wrapper">
                            <canvas id="villaTersediaChart"></canvas>
                        </div>

                        <!-- Chart for Villa Tidak Tersedia -->
                        <div class="chart-wrapper">
                            <canvas id="villaTidakTersediaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Plugin untuk menambahkan teks di tengah
        Chart.register({
            id: 'centerText',
            beforeDraw(chart) {
                const { width, height, ctx } = chart;
                const dataset = chart.data.datasets[0];
                const value = dataset.data[0]; // Ambil nilai pertama
                
                ctx.save();
                ctx.font = "bold 16px Arial";
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = dataset.backgroundColor[0]; // Warna teks sesuai grafik
                ctx.fillText(`${value}%`, width / 2, height / 2); // Teks di tengah
                ctx.restore();
            }
        });

        // Data dari PHP
        const data = {
            kinerja: <?= isset($data['kinerja']) ? $data['kinerja'] : 0 ?>,
            tempat: <?= isset($data['tempat']) ? $data['tempat'] : 0 ?>,
            fasilitas: <?= isset($data['fasilitas']) ? $data['fasilitas'] : 0 ?>,
            villa_tersedia: <?= isset($data['villa_tersedia']) ? $data['villa_tersedia'] : 0 ?>,
            villa_tidak_tersedia: <?= isset($data['villa_tidak_tersedia']) ? $data['villa_tidak_tersedia'] : 0 ?>
        };

        const total = Object.values(data).reduce((a, b) => a + b, 0);

        // Fungsi untuk membuat chart dengan judul dan angka di tengah
        function createChartWithTitle(element, percentage, label, colors, title) {
            new Chart(element, {
                type: 'doughnut',
                data: {
                    labels: [label, "Lainnya"],
                    datasets: [{
                        data: [percentage, 100 - percentage],
                        backgroundColor: colors
                    }]
                },
                options: {
                    cutout: '75%', // Ukuran lubang di tengah
                    plugins: {
                        legend: { display: false }, // Sembunyikan legenda
                        title: { // Tambahkan judul
                            display: true,
                            text: title,
                            font: {
                                size: 16,
                                weight: 'bold',
                            },
                            color: '#333',
                            padding: {
                                top: 10,
                                bottom: 10,
                            }
                        },
                        centerText: {} // Aktifkan plugin untuk teks di tengah
                    }
                }
            });
        }

        // Membuat semua chart dengan judul dan angka di tengah
        createChartWithTitle(
            document.getElementById('kinerjaChart'),
            Math.round((data.kinerja / total) * 100),
            "Kinerja",
            ["#6DC5D1", "#E0E0E0"],
            "Laporan Kinerja"
        );
        createChartWithTitle(
            document.getElementById('tempatChart'),
            Math.round((data.tempat / total) * 100),
            "Tempat",
            ["#FDE49E", "#E0E0E0"],
            "Laporan Tempat"
        );
        createChartWithTitle(
            document.getElementById('fasilitasChart'),
            Math.round((data.fasilitas / total) * 100),
            "Fasilitas",
            ["#FEB941", "#E0E0E0"],
            "Laporan Fasilitas"
        );
        createChartWithTitle(
            document.getElementById('villaTersediaChart'),
            Math.round((data.villa_tersedia / total) * 100),
            "Villa Tersedia",
            ["#FDE49E", "#E0E0E0"],
            "Villa Tersedia"
        );
        createChartWithTitle(
            document.getElementById('villaTidakTersediaChart'),
            Math.round((data.villa_tidak_tersedia / total) * 100),
            "Villa Tidak Tersedia",
            ["#DD761C", "#E0E0E0"],
            "Villa Tidak Tersedia"
        );
    </script>

</body>
</html>
