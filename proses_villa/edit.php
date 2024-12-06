<?php
// Koneksi ke database
$host = "localhost"; // Host database
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "filya_suite"; // Nama database Anda

$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan ID dari URL
$id = $_GET['id'];

// Mengambil data villa berdasarkan ID
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

// Jika form disubmit, perbarui data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_villa = $_POST['nama_villa'];
    $kuota = $_POST['kuota'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];

    // Update data ke database
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
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Data Villa</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_villa" class="form-label">Nama Villa</label>
                <input type="text" class="form-control" id="nama_villa" name="nama_villa" value="<?php echo $nama_villa; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kuota" class="form-label">Kuota</label>
                <input type="number" class="form-control" id="kuota" name="kuota" value="<?php echo $kuota; ?>" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" required><?php echo $keterangan; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="tersedia" <?php if ($status == 'tersedia') echo 'selected'; ?>>Tersedia</option>
                    <option value="tidak tersedia" <?php if ($status == 'tidak tersedia') echo 'selected'; ?>>Tidak Tersedia</option>
                    <option value="dalam pemeliharaan" <?php if ($status == 'dalam pemeliharaan') echo 'selected'; ?>>Dalam Pemeliharaan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Data</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
