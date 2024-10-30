<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "filya_suite";

// Mulai sesi
session_start();

// Koneksi ke database
$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("Connection error");
}

// Cek jika login sebagai tamu
if (isset($_GET['guest']) && $_GET['guest'] == 'true') {
    $_SESSION['user_id'] = null;
    $_SESSION['usertype'] = 'guest';
    unset($_SESSION['nama']);
    
    // Cek usertype untuk menentukan redirect
    if ($_SESSION['usertype'] === 'user') {
        header('location:userhome.php');
    } else {
        echo "<script>alert('Akun guest tidak dapat mengakses halaman ini');</script>";
    }
    exit();
}

// Proses login jika metode permintaan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = mysqli_real_escape_string($data, $_POST["identifier"]);
    $password = $_POST["password"];

    // Query untuk mendapatkan user berdasarkan email atau nomor telepon
    $sql = "SELECT * FROM users WHERE email='$identifier' OR nomor_telpon='$identifier'";
    $result = mysqli_query($data, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION["nama"] = $row["nama"];
            $_SESSION["usertype"] = $row["usertype"];
            $_SESSION["nomor_telpon"] = $row["nomor_telpon"];

            // Arahkan ke halaman sesuai dengan user_type
            if ($_SESSION["usertype"] === "admin") {
                header("location:adminhome.php");
            } elseif ($_SESSION["usertype"] === "user") {
                header("location:userhome.php");
            } else {
                echo "<script>alert('Usertype tidak valid untuk akses');</script>";
            }
            exit();
        } else {
            echo "<script>alert('Password salah');</script>";
        }
    } else {
        echo "<script>alert('Email atau nomor telepon tidak ditemukan');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('bglogin-register.jpg');
            background-size: cover;
            background-repeat: no-repeat; 
            height: 100vh;
        }
        .mb-3 {
            color: white;
        }
        .text-center {
            text-align: center; 
            margin-top: 20px;
        }
        .btn-light {
            background-color: #f8f9fa; 
            color: #343a40; 
            border: 1px solid #ced4da; 
            border-radius: 5px; 
            padding: 10px 20px; 
            font-size: 16px; 
            transition: background-color 0.3s, color 0.3s; 
        }
        .btn-light:hover {
            background-color: #e2e6ea; 
            color: #212529; 
        }
        p {
            margin-top: 15px; 
            font-size: 14px; 
            color: white;
        }
        a {
            color: white;
            text-decoration: none; 
        }
        a:hover {
            text-decoration: underline; 
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="card-title text-center">Jadilah Bagian Penyempurnaan FilyaSuite</h1>
            <br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label">Email / No HP</label>
                    <input type="text" class="form-control" name="identifier" id="identifier" required placeholder="Email atau Nomor Telepon">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <button type="button" class="btn btn-light" onclick="window.location.href='login.php?guest=true'">Login as Guest</button>
                <p>Belum punya akun? <a href="register.php">Kuy daftar!</a></p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
