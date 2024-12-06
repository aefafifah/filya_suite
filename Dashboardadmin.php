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
    header("Location: login.php");
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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fafafa;
        }

        .sidebar {
            background-color: #FFFFFF;
            height: 100vh;
            padding: 20px;
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
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #FDE49E;
            opacity: 0.7;
            z-index: 1;
        }

        .main-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 10px 10px 0px 0px #F57C00;
            width: 800px;
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .chart-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .chart-wrapper {
            width: 250px;
            margin: 20px;
            height: 200px;
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
