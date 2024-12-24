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


if (isset($_POST['guest']) && $_POST['guest'] === 'true') {
    $_SESSION['user_id'] = null;
    $_SESSION['usertype'] = 'guest';
    unset($_SESSION['nama']);
    header('Location: userhome.php');
    exit();
}

// Login pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['guest'])) {
    $identifier = mysqli_real_escape_string($data, $_POST["identifier"]);
    $password = $_POST["password"];


    $query = "SELECT * FROM users WHERE email = ? OR nomor_telpon = ?";
    $stmt = $data->prepare($query);
    $stmt->bind_param('ss', $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            $_SESSION["nama"] = $row["nama"];
            $_SESSION["usertype"] = $row["usertype"]; // Simpan user_type di session
            $_SESSION["nomor_telpon"] = $row["nomor_telpon"];
            $_SESSION["email"] = $row["email"];


            if ($_SESSION["usertype"] === "admin") {
                header("location:Dashboardadmin.php");
            } else {
                header("location:userhome.php");
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




<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
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
            width: 380px;
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

        .form-check-label,
        .forgot-password,
        .register {
            font-size: 12px;
            color: #777;
        }

        .forgot-password a,
        .register a {
            color: #ff8c00;
            text-decoration: none;
        }

        .forgot-password a:hover,
        .register a:hover {
            text-decoration: underline;
        }

        .form-check-input {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <div class="active">LOGIN</div>
            <div onclick="window.location.href='register.php'">REGISTRASI</div>
        </div>
        <div class="card-body">
            <h2>SELAMAT DATANG!!</h2>
            <p class="text-center"><b>KAMI SENANG BERTEMU DENGAN ANDA KEMBALI</b></p>
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email atau Nomor Telepon</label>
                    <input type="text" id="email" name="identifier" class="form-control"
                        placeholder="Masukkan email atau nomor telepon" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Masukkan password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">MASUKKAN AKUN ANDA</button>
            </form>
            <form action="index.php" method="POST">
                <input type="hidden" name="guest" value="true">
                <button type="submit" class="btn btn-primary">LOGIN SEBAGAI TAMU</button>
            </form>
            <p class="register text-center mt-3"><b>Apakah Anda Sudah Mempunyai Akun?</b> <a href="register.php"><b>Registrasi</b></a></p>
        </div>
    </div>
    </div>
    </div>
</body>

</html>
