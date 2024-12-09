<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "filya_suite";

session_start();

$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("Connection error");
}
    // Cek jika login sebagai tamu
if (isset($_GET['guest']) && $_GET['guest'] == 'true') {
    $_SESSION['user_id'] = null; // ID pengguna tamu bisa dibiarkan null
    $_SESSION['usertype'] = 'guest'; // Set usertype sebagai tamu
    unset($_SESSION['nama']); // Hapus nama jika sebelumnya diset
         // Alihkan ke halaman home
    exit(); // Hentikan eksekusi setelah header
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap email atau nomor telepon
    $identifier = mysqli_real_escape_string($data, $_POST["identifier"]); // Email atau nomor telepon
    $password = $_POST["password"]; // Password yang dimasukkan

    // Query untuk mendapatkan user berdasarkan email atau nomor telepon
    $sql = "SELECT * FROM users WHERE email='$identifier' OR nomor_telpon='$identifier'";
    $result = mysqli_query($data, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            $_SESSION["nama"] = $row["nama"];
            $_SESSION["usertype"] = $row["usertype"]; // Simpan user_type di session
            $_SESSION["nomor_telpon"] = $row["nomor_telpon"];
            $_SESSION["email"] = $row["email"];

            // Arahkan ke halaman sesuai dengan user_type
            if ($_SESSION["usertype"] === "admin") {
                header("location:Dashboardadmin.php");
            } else {
                header("location:userhome.php");
            }
            exit(); // Pastikan untuk menghentikan eksekusi script setelah redirect
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/login-register.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.85);
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 350px;
            position: absolute;
            top: 162px; 
            left: 70%; 
            transform: translateX(-20%);
        }
        .card-header {
            display: flex;
            justify-content: space-around;
            background-color: transparent;
            padding: 0;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
        }
        .card-header div {
            flex: 1;
            padding: 10px 0;
            text-align: center;
            font-weight: bold;
            color: #ffa500;
            background-color: #ffedcc;
            cursor: pointer;
        }
        .card-header .active {
            background-color: #ff8c00;
            color: white;
        }
        .card-body h2 {
            text-align: center;
            color: #ff8c00;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #ff8c00;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .btn-primary:hover {
            background-color: #e67e22;
        }
        .form-check-label, .forgot-password, .register {
            font-size: 12px;
            color: #777;
        }
        .forgot-password a, .register a {
            color: #ff8c00;
            text-decoration: none;
        }
        .forgot-password a:hover, .register a:hover {
            text-decoration: underline;
        }
        .form-check-input {
            margin-right: 5px;
        }
        .form-label{

        }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <div class="active">LOGIN</div>
        <div onclick="window.location.href='register.php'">REGISTER</div>
    </div>
    <div class="card-body">
        <h2>WELCOME BACK!!</h2>
        <p class="text-center">We are happy to see you again.</p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="mb-3">
                <label for="identifier" class="form-label">Email / No HP</label>
                <input type="text" class="form-control" name="identifier" id="identifier" required placeholder="Email atau Nomor Telepon">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">LOGIN TO YOUR ACCOUNT</button>
            <button type="button" class="btn btn-primary" onclick="window.location.href='login.php?guest=true'">LOGIN AS GUEST</button>
            <p class="register text-center mt-3">Don’t Have An Account? <a href="register.php">Register</a></p>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

