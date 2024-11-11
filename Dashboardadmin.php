<?php
session_start();

// Redirect ke login.php jika pengguna belum login
if (!isset($_SESSION['nama']) || !isset($_SESSION['usertype'])) {
    header("Location: login.php");
    exit();
}

$nama = $_SESSION['nama'];
$nomor_telpon = $_SESSION['nomor_telpon'];
$nomor_telpon = $_SESSION['nomor_telpon'] ?? '';
$alamat = $_SESSION['alamat'] ?? '';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
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
            width: 500px;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .main-card h2 {
            font-family: 'Barlow', sans-serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .circular-progress {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: conic-gradient(#6DC5D1 0% 80%, #5E93BE 0%);
            margin: 0 auto 20px;
        }

        .circular-progress.orange {
            background: conic-gradient(#FDE49E 0% 62%, #FEAF00 0%);
        }

        .percentage {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Barlow', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .progress-row {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .progress-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            margin: 0 10px;
        }

        .content {
            display: none; /* Initially hide all content sections */
        }

        .content.active {
            display: block; /* Show the active content section */
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
            </div>

            <!-- Dashboard -->
            <div class="col-md-10 dashboard">
                <div class="main-card">
                    <h2>Filya Suite Progress</h2>
                    <div id="dashboardContent" class="content active">
                        <!-- Dashboard Content Here -->
                        <p>Welcome to the dashboard!</p>
                    </div>
                    <div id="performanceReportContent" class="content">
                        <!-- Performance Report Content Here -->
                        <p>Performance Report Content.</p>
                    </div>
                    <div id="facilitiesReportContent" class="content">
                        <!-- Facilities Report Content Here -->
                        <p>Facilities Report Content.</p>
                    </div>
                    <div id="locationReportContent" class="content">
                        <!-- Location Report Content Here -->
                        <p>Location Report Content.</p>
                    </div>
                    <div id="employeeDataContent" class="content">
                        <!-- Employee Data Content Here -->
                        <p>Employee Data Content.</p>
                    </div>
                    <div id="villaDataContent" class="content">
                        <!-- Villa Data Content Here -->
                        <p>Villa Data Content.</p>
                    </div>

                    <!-- Progress Circles -->
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

    <script>
        function showContent(contentId) {
            // Hide all content sections
            const contents = document.querySelectorAll('.content');
            contents.forEach(content => content.classList.remove('active'));

            // Show the selected content section
            document.getElementById(contentId).classList.add('active');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>