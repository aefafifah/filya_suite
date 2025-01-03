<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("ID tidak valid.");
}
$stmt = $conn->prepare("SELECT * FROM fasilitas WHERE id_pengaduan = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$fasilitas = $result->fetch_assoc();
$stmt->close();

if (!$fasilitas) {
    die("Data tidak ditemukan.");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pengadu = $_POST['nama_pengadu'];
    $no_telepon_pengadu = $_POST['no_telepon_pengadu'];
    $tanggal_menginap = $_POST['tanggal_menginap'];
    $tanggal_melaporkan = $_POST['tanggal_melaporkan'];
    $tempat_kerusakan = $_POST['tempat_kerusakan'];
    $jenis_masalah = $_POST['jenis_masalah'];
    $deskripsi_masalah_fasilitas = $_POST['deskripsi_masalah_fasilitas'];
    $pilih_kategori_fasilitas = $_POST['pilih_kategori_fasilitas'];
    $stmt = $conn->prepare("UPDATE fasilitas SET 
        nama_pengadu = ?, 
        no_telepon_pengadu = ?, 
        tanggal_menginap = ?, 
        tanggal_melaporkan = ?, 
        tempat_kerusakan = ?, 
        jenis_masalah = ?, 
        deskripsi_masalah_fasilitas = ?, 
        pilih_kategori_fasilitas = ? 
        WHERE id_pengaduan = ?");

    $stmt->bind_param(
        "ssssssssi",
        $nama_pengadu,
        $no_telepon_pengadu,
        $tanggal_menginap,
        $tanggal_melaporkan,
        $tempat_kerusakan,
        $jenis_masalah,
        $deskripsi_masalah_fasilitas,
        $pilih_kategori_fasilitas,
        $id
    );

    if ($stmt->execute()) {
        header("Location: ../DashbordFasilitas.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Laporan Fasilitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
                    body {
                background-color: #f3f4f6;
                background-image: url('../blubrown.jpg');
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
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
                box-sizing: border-box;
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
                display: block;
                margin-bottom: 5px;
            }
            
            .form-control {
                width: 100%;
                border: 1px solid #ced4da;
                border-radius: 6px;
                padding: 10px;
                font-size: 16px;
                transition: border-color 0.3s ease, box-shadow 0.3s ease;
                margin-bottom: 15px;
                box-sizing: border-box;
            }
            
            .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                outline: none;
            }
            
            .btn-primary {
                background-color: #28a745;
                border: none;
                color: #ffffff;
                font-size: 16px;
                padding: 10px 20px;
                border-radius: 6px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            
            .btn-primary:hover {
                background-color: #218838;
            }
            
            .btn-secondary {
                background-color: #6c757d;
                border: none;
                color: #ffffff;
                font-size: 16px;
                padding: 10px 20px;
                border-radius: 6px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            
            .btn-secondary:hover {
                background-color: #5a6268;
            }
            
            /* Gaya untuk tombol biru */
            .btn-blue {
                background-color: #007bff; /* Warna biru */
                border: none;
                color: #ffffff;
                font-size: 16px;
                padding: 10px 20px;
                border-radius: 6px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            
            .btn-blue:hover {
                background-color: #0056b3; /* Warna biru lebih gelap saat hover */
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
        <h2>Edit Data Laporan Fasilitas</h2>
        <div class="blur-bg"></div>
        <form method="post">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label for="nama_pengadu" class="form-label">Nama Pengadu</label>
                        <input type="text" class="form-control" name="nama_pengadu"
                            value="<?php echo htmlspecialchars($fasilitas['nama_pengadu']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telepon_pengadu" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="no_telepon_pengadu"
                            value="<?php echo htmlspecialchars($fasilitas['no_telepon_pengadu']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_menginap" class="form-label">Tanggal Menginap</label>
                        <input type="date" class="form-control" name="tanggal_menginap"
                            value="<?php echo htmlspecialchars($fasilitas['tanggal_menginap']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_melaporkan" class="form-label">Tanggal Melaporkan</label>
                        <input type="date" class="form-control" name="tanggal_melaporkan"
                            value="<?php echo htmlspecialchars($fasilitas['tanggal_melaporkan']); ?>" required>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label for="tempat_kerusakan" class="form-label">Tempat Kerusakan</label>
                        <input type="text" class="form-control" name="tempat_kerusakan"
                            value="<?php echo htmlspecialchars($fasilitas['tempat_kerusakan']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_masalah" class="form-label">Jenis Masalah</label>
                        <input type="text" class="form-control" name="jenis_masalah"
                            value="<?php echo htmlspecialchars($fasilitas['jenis_masalah']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_masalah_fasilitas" class="form-label">Deskripsi Masalah</label>
                        <textarea class="form-control" name="deskripsi_masalah_fasilitas"
                            required><?php echo htmlspecialchars($fasilitas['deskripsi_masalah_fasilitas']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="pilih_kategori_fasilitas" class="form-label">Kategori Fasilitas</label>
                        <input type="text" class="form-control" name="pilih_kategori_fasilitas"
                            value="<?php echo htmlspecialchars($fasilitas['pilih_kategori_fasilitas']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <a href="../DashbordFasilitas.php" class="btn-secondary">Kembali</a>
                <button type="submit" class="btn-blue">Update</button>
            </div>
        </form>
    </div>
</body>

</html>
