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
    header('location:userhome.php'); // Alihkan ke halaman home
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

            // Arahkan ke halaman sesuai dengan user_type
            if ($_SESSION["usertype"] === "admin") {
                header("location:adminhome.php");
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-image: url('bglogin-register.jpg');
            background-size: cover;
            /* background-position: center; */
            background-repeat: no-repeat; 
            height: 100vh;
        }
        .mb-3{
            color: white;
        }
        .p .text-center {
            color :white;
        }

        .text-center {
    text-align: center; /* Center-aligns text */
    margin-top: 20px; /* Adds space above the container */
}

.btn-light {
    background-color: #f8f9fa; /* Light background color */
    color: #343a40; /* Dark text color */
    border: 1px solid #ced4da; /* Border color */
    border-radius: 5px; /* Rounded corners */
    padding: 10px 20px; /* Padding for the button */
    font-size: 16px; /* Font size */
    transition: background-color 0.3s, color 0.3s; /* Transition effects */
}

.btn-light:hover {
    background-color: #e2e6ea; /* Darker shade on hover */
    color: #212529; /* Darker text color on hover */
}

p {
    margin-top: 15px; /* Space between button and paragraph */
    font-size: 14px; /* Font size for paragraph */
    color : white;
}

a {
    color: white;
    text-decoration: none; /* Removes underline from links */
}

a:hover {
    text-decoration: underline; /* Underline on hover for links */
}

    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- <div class="card shadow"> -->
                <!-- <div class="card-body"> -->
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
            <!-- </div> -->
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

</body>
</html>
