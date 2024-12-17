<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$id = $_GET['id'];
$sql = "SELECT * FROM tempat WHERE id_pengaduan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pengadu = $_POST['nama_pengadu'];
    $no_telepon_pengadu = $_POST['no_telepon_pengadu'];
    $tanggal_menginap = $_POST['tanggal_menginap'];
    $jenis_masalah = $_POST['jenis_masalah'];
    $deskripsi_masalah = $_POST['deskripsi_masalah'];
    $waktu_pengaduan = $_POST['waktu_pengaduan'];
    $file_bukti = $_POST['file_bukti'];
    $sql_update = "UPDATE tempat SET 
                    nama_pengadu=?, 
                    no_telepon_pengadu=?,
                    tanggal_menginap=?,
                    jenis_masalah=?,
                    deskripsi_masalah=?,
                    waktu_pengaduan=?,
                    file_bukti=?
                   WHERE id_pengaduan = ?";

    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssssssi", $nama_pengadu, $no_telepon_pengadu, $tanggal_menginap, $jenis_masalah, $deskripsi_masalah, $waktu_pengaduan, $file_bukti, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diupdate'); window.location.href = '../DashboardTempt.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Laporan Tempat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
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
    <div class="container">
        <h2>Edit Data Laporan Tempat</h2>
        <div class="blur-bg"></div>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_pengadu" class="form-label">Nama Pengadu</label>
                <select class="form-control" name="nama_pengadu" id="nama_pengadu" required>
                    <?php
                    $user_query = "SELECT nama FROM users";
                    $user_result = $conn->query($user_query);
                    while ($user = $user_result->fetch_assoc()) {
                        $selected = ($user['nama'] == $row['nama_pengadu']) ? 'selected' : '';
                        echo "<option value='{$user['nama']}' $selected>{$user['nama']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="no_telepon_pengadu" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="no_telepon_pengadu" name="no_telepon_pengadu"
                    value="<?php echo $row['no_telepon_pengadu']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_menginap" class="form-label">Tanggal Menginap</label>
                <input type="date" class="form-control" id="tanggal_menginap" name="tanggal_menginap"
                    value="<?php echo $row['tanggal_menginap']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_masalah" class="form-label">Kategori Masalah</label>
                <input type="text" class="form-control" id="jenis_masalah" name="jenis_masalah"
                    value="<?php echo $row['jenis_masalah']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi_masalah" class="form-label">Deskripsi Masalah</label>
                <textarea class="form-control" id="deskripsi_masalah" name="deskripsi_masalah"
                    required><?php echo $row['deskripsi_masalah']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="waktu_pengaduan" class="form-label">Tanggal Melaporkan</label>
                <input type="date" class="form-control" id="waktu_pengaduan" name="waktu_pengaduan"
                    value="<?php echo $row['waktu_pengaduan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="file_bukti" class="form-label">File Bukti</label>
                <input type="text" class="form-control" id="file_bukti" name="file_bukti"
                    value="<?php echo $row['file_bukti']; ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="../DashboardTempt.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</body>

</html>

<?php
$conn->close();
?>