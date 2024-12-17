<?php
$host = "localhost"; // Host database
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "filya_suite"; // Nama database Anda

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$id = $_GET['id'];
$sql = "SELECT * FROM villa WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama_villa = $row['nama_villa'];
    $kuota = $row['kuota'];
    $keterangan = $row['keterangan'];
    $status = $row['status'];
} else {
    echo "Data tidak ditemukan!";
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_villa = $_POST['nama_villa'];
    $kuota = $_POST['kuota'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];
    $update_sql = "UPDATE villa SET nama_villa = ?, kuota = ?, keterangan = ?, status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $nama_villa, $kuota, $keterangan, $status, $id);

    if ($update_stmt->execute()) {
        header("Location: ../datavilla.php"); // Redirect ke halaman utama setelah berhasil
        exit();
    } else {
        echo "Gagal memperbarui data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FDE49E;
            background-image: url('../blubrown.jpg');
            font-family: Arial, sans-serif;
        }

        .blur-bg {
            background-image: url('../blubrown.jpg');
            background-size: cover;
            background-position: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
        }

        .blur-bg::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(28, 24, 24, 0.7);
            z-index: 1;
        }

        .container {
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            margin: 50px auto;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        label {
            color: #555;
            font-weight: 500;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 6px;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .d-flex {
            display: flex;
            gap: 10px;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Data Villa</h2>
        <div class="blur-bg"></div>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_villa" class="form-label">Nama Villa</label>
                <input type="text" class="form-control" id="nama_villa" name="nama_villa"
                    value="<?php echo $nama_villa; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kuota" class="form-label">Kuota</label>
                <input type="number" class="form-control" id="kuota" name="kuota" value="<?php echo $kuota; ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan"
                    required><?php echo $keterangan; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="tersedia" <?php if ($status == 'tersedia')
                        echo 'selected'; ?>>Tersedia</option>
                    <option value="tidak tersedia" <?php if ($status == 'tidak tersedia')
                        echo 'selected'; ?>>Tidak
                        Tersedia</option>
                    <option value="dalam pemeliharaan" <?php if ($status == 'dalam pemeliharaan')
                        echo 'selected'; ?>>
                        Dalam Pemeliharaan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Data</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>