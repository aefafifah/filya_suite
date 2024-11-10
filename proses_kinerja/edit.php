<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan data laporan berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM laporan WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $laporan = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit;
}

// Memproses form edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengadu = $_POST['nama_pengadu'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $tanggal_menginap = $_POST['tanggal_menginap'];
    $tanggal_melaporkan = $_POST['tanggal_melaporkan'];
    $jenis_masalah = $_POST['jenis_masalah'];
    $deskripsi_masalah = $_POST['deskripsi_masalah'];
    $ciri_ciri = $_POST['ciri_ciri'];
    
    $sql = "UPDATE laporan SET 
            nama_pengadu='$nama_pengadu', 
            nomor_telepon='$nomor_telepon', 
            tanggal_menginap='$tanggal_menginap', 
            tanggal_melaporkan='$tanggal_melaporkan', 
            jenis_masalah='$jenis_masalah', 
            deskripsi_masalah='$deskripsi_masalah',
            ciri_ciri='$ciri_ciri'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui.";
        header("Location: ../DashbordKinerja.php"); // Kembali ke halaman utama
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Laporan Kinerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            background-image: url('../blubrown.jpg');
            font-family: Arial, sans-serif;
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
        <h2>Edit Data Laporan Kinerja</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_pengadu" class="form-label">Nama Pengadu</label>
                <input type="text" class="form-control" id="nama_pengadu" name="nama_pengadu" value="<?php echo $laporan['nama_pengadu']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?php echo $laporan['nomor_telepon']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_menginap" class="form-label">Tanggal Menginap</label>
                <input type="date" class="form-control" id="tanggal_menginap" name="tanggal_menginap" value="<?php echo $laporan['tanggal_menginap']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_melaporkan" class="form-label">Tanggal Melaporkan</label>
                <input type="date" class="form-control" id="tanggal_melaporkan" name="tanggal_melaporkan" value="<?php echo $laporan['tanggal_melaporkan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_masalah" class="form-label">Jenis Masalah</label>
                <input type="text" class="form-control" id="jenis_masalah" name="jenis_masalah" value="<?php echo $laporan['jenis_masalah']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi_masalah" class="form-label">Deskripsi Masalah</label>
                <textarea class="form-control" id="deskripsi_masalah" name="deskripsi_masalah" required><?php echo $laporan['deskripsi_masalah']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="ciri_ciri" class="form-label">Ciri-Ciri</label>
                <input type="text" class="form-control" id="ciri_ciri" name="ciri_ciri" value="<?php echo $laporan['ciri_ciri']; ?>" required>
            </div>
            <!-- Menukar urutan tombol -->
            <div class="d-flex justify-content-between">
                <a href="../DashbordKinerja.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>