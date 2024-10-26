<?php
session_start();

// Pastikan user telah login
if (!isset($_SESSION['usertype'])) {
    header("location:login.php");
    exit();
}

// Ambil tipe user dari session
$usertype = $_SESSION['usertype'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-dark-blue {
            background-color: #003366; /* Warna biru tua */
        }
        .navbar-dark .navbar-nav .nav-link {
            color: white; /* Warna tulisan navbar */
        }
        .navbar-dark .navbar-brand {
            color: white; /* Warna tulisan brand */
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: white; /* Warna saat hover */
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FilyaSuite</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <?php if ($usertype == 'user'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                <?php endif; ?>
                <?php if ($usertype == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Admin Dashboard</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <?php if ($usertype == 'guest'): ?>
                        <h1 class="display-4 text-primary">Selamat datang Tamu!</h1>
                        <p class="text-center">Anda login sebagai tamu. Beberapa fitur mungkin dibatasi.</p>
                        <div class="text-center">
                            <a href="register.php" class="btn btn-primary">Daftar sekarang</a>
                        </div>
                    <?php elseif ($usertype == 'user'): ?>
                        <h1 class="display-4 text-primary">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h1>
                        <p class="text-center">Anda login sebagai pengguna terdaftar.</p>
                    <?php elseif ($usertype == 'admin'): ?>
                        <h1 class="display-4 text-primary">Selamat datang, Admin <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h1>
                        <p class="text-center">Anda login sebagai admin.</p>
                        <div class="text-center">
                            <a href="adminhome.php" class="btn btn-secondary">Go to Admin Dashboard</a>
                        </div>
                    <?php else: ?>
                        <h1 class="display-4 text-primary">Halo!</h1>
                        <p class="text-center">Anda login sebagai <?php echo htmlspecialchars($usertype); ?>.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <button onclick="window.location.href='eyyo2.php'" style="padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
    Laporan Fasilitas
</button>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
