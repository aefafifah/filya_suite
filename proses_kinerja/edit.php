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
$sql = "SELECT * FROM kinerja WHERE id_pengaduan = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $laporan = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengadu = $_POST['nama_pengadu'];
    $no_telepon_pengadu = $_POST['no_telepon_pengadu'];
    $tanggal_menginap = $_POST['tanggal_menginap'];
    $id_pegawai = $_POST['id_pegawai'];
    $nama_pegawai = $_POST['nama_pegawai'];
    $jabatan_pegawai = $_POST['jabatan_pegawai'];
    $tanggal_melapor = $_POST['tanggal_melapor'];
    $jenis_masalah = $_POST['jenis_masalah'];
    $deskripsi_masalah = $_POST['deskripsi_masalah'];
    $file_bukti = $_POST['file_bukti'];
    $tinggi = $_POST['tinggi'];
    $tubuh = $_POST['tubuh'];
    $kulit = $_POST['kulit'];
    $rambut = $_POST['rambut'];
    $wajah = $_POST['wajah'];

    $sql = "UPDATE kinerja SET 
            nama_pengadu='$nama_pengadu', 
            no_telepon_pengadu='$no_telepon_pengadu', 
            tanggal_menginap='$tanggal_menginap', 
            id_pegawai='$id_pegawai', 
            nama_pegawai='$nama_pegawai', 
            jabatan_pegawai='$jabatan_pegawai', 
            tanggal_melapor='$tanggal_melapor', 
            jenis_masalah='$jenis_masalah', 
            deskripsi_masalah='$deskripsi_masalah', 
            file_bukti='$file_bukti', 
            tinggi='$tinggi', 
            tubuh='$tubuh', 
            kulit='$kulit', 
            rambut='$rambut', 
            wajah='$wajah'
            WHERE id_pengaduan=$id";

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
        <h2>Edit Data Laporan Kinerja</h2>
        <div class="blur-bg"></div>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_pengadu" class="form-label">Nama Pengadu</label>
                <input type="text" class="form-control" id="nama_pengadu" name="nama_pengadu"
                    value="<?php echo $laporan['nama_pengadu']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_telepon_pengadu" class="form-label">Nomor Telepon Pengadu</label>
                <input type="text" class="form-control" id="no_telepon_pengadu" name="no_telepon_pengadu"
                    value="<?php echo $laporan['no_telepon_pengadu']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_menginap" class="form-label">Tanggal Menginap</label>
                <input type="date" class="form-control" id="tanggal_menginap" name="tanggal_menginap"
                    value="<?php echo $laporan['tanggal_menginap']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_pegawai" class="form-label">ID Pegawai</label>
                <input type="number" class="form-control" id="id_pegawai" name="id_pegawai"
                    value="<?php echo $laporan['id_pegawai']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai"
                    value="<?php echo $laporan['nama_pegawai']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jabatan_pegawai" class="form-label">Jabatan Pegawai</label>
                <select class="form-control" id="jabatan_pegawai" name="jabatan_pegawai">
                    <option value="Resepsionis" <?php echo $laporan['jabatan_pegawai'] == 'Resepsionis' ? 'selected' : ''; ?>>Resepsionis</option>
                    <option value="House Keeper" <?php echo $laporan['jabatan_pegawai'] == 'House Keeper' ? 'selected' : ''; ?>>House Keeper</option>
                    <option value="Security" <?php echo $laporan['jabatan_pegawai'] == 'Security' ? 'selected' : ''; ?>>
                        Security</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="waktu_kejadian" class="form-label">Waktu Kejadian</label>
                <input type="datetime-local" class="form-control" id="waktu_kejadian" name="waktu_kejadian"
                    value="<?php echo $laporan['waktu_kejadian']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_masalah" class="form-label">Jenis Masalah</label>
                <select class="form-control" id="jenis_masalah" name="jenis_masalah">
                    <option value="Pelayanan Lambat" <?php echo $laporan['jenis_masalah'] == 'Pelayanan Lambat' ? 'selected' : ''; ?>>Pelayanan Lambat</option>
                    <option value="Sikap Tidak Profesional" <?php echo $laporan['jenis_masalah'] == 'Sikap Tidak Profesional' ? 'selected' : ''; ?>>Sikap Tidak Profesional</option>
                    <option value="Pelayanan Tidak Ramah" <?php echo $laporan['jenis_masalah'] == 'Pelayanan Tidak Ramah' ? 'selected' : ''; ?>>Pelayanan Tidak Ramah</option>
                    <option value="Sikap Karyawan Buruk" <?php echo $laporan['jenis_masalah'] == 'Sikap Karyawan Buruk' ? 'selected' : ''; ?>>Sikap Karyawan Buruk</option>
                    <option value="Pelayanan Tidak Memuaskan" <?php echo $laporan['jenis_masalah'] == 'Pelayanan Tidak Memuaskan' ? 'selected' : ''; ?>>Pelayanan Tidak Memuaskan</option>
                    <option value="Tidak Tersedia Saat Dibutuhkan" <?php echo $laporan['jenis_masalah'] == 'Tidak Tersedia Saat Dibutuhkan' ? 'selected' : ''; ?>>Tidak Tersedia Saat Dibutuhkan</option>
                    <option value="Lainnya" <?php echo $laporan['jenis_masalah'] == 'Lainnya' ? 'selected' : ''; ?>>
                        Lainnya</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="deskripsi_masalah" class="form-label">Deskripsi Masalah</label>
                <textarea class="form-control" id="deskripsi_masalah" name="deskripsi_masalah" rows="3"
                    required><?php echo $laporan['deskripsi_masalah']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="file_bukti" class="form-label">File Bukti</label>
                <input type="text" class="form-control" id="file_bukti" name="file_bukti"
                    value="<?php echo $laporan['file_bukti']; ?>">
            </div>
            <div class="mb-3">
                <label for="tinggi" class="form-label">Tinggi Badan</label>
                <select class="form-control" id="tinggi" name="tinggi">
                    <option value="pendek" <?php echo $laporan['tinggi'] == 'pendek' ? 'selected' : ''; ?>>Pendek</option>
                    <option value="sedang" <?php echo $laporan['tinggi'] == 'sedang' ? 'selected' : ''; ?>>Sedang</option>
                    <option value="tinggi" <?php echo $laporan['tinggi'] == 'tinggi' ? 'selected' : ''; ?>>Tinggi</option>
                    <option value="sangat tinggi" <?php echo $laporan['tinggi'] == 'sangat tinggi' ? 'selected' : ''; ?>>
                        Sangat Tinggi</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tubuh" class="form-label">Jenis Tubuh</label>
                <select class="form-control" id="tubuh" name="tubuh">
                    <option value="kurus" <?php echo $laporan['tubuh'] == 'kurus' ? 'selected' : ''; ?>>Kurus</option>
                    <option value="sedang" <?php echo $laporan['tubuh'] == 'sedang' ? 'selected' : ''; ?>>Sedang</option>
                    <option value="berisi" <?php echo $laporan['tubuh'] == 'berisi' ? 'selected' : ''; ?>>Berisi</option>
                    <option value="gemuk" <?php echo $laporan['tubuh'] == 'gemuk' ? 'selected' : ''; ?>>Gemuk</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="kulit" class="form-label">Warna Kulit</label>
                <select class="form-control" id="kulit" name="kulit">
                    <option value="cerah" <?php echo $laporan['kulit'] == 'cerah' ? 'selected' : ''; ?>>Cerah</option>
                    <option value="sawo matang" <?php echo $laporan['kulit'] == 'sawo matang' ? 'selected' : ''; ?>>Sawo
                        Matang</option>
                    <option value="gelap" <?php echo $laporan['kulit'] == 'gelap' ? 'selected' : ''; ?>>Gelap</option>
                    <option value="sangat cerah" <?php echo $laporan['kulit'] == 'sangat cerah' ? 'selected' : ''; ?>>
                        Sangat Cerah</option>
                    <option value="sangat gelap" <?php echo $laporan['kulit'] == 'sangat gelap' ? 'selected' : ''; ?>>
                        Sangat Gelap</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="rambut" class="form-label">Jenis Rambut</label>
                <input type="text" class="form-control" id="rambut" name="rambut"
                    value="<?php echo $laporan['rambut']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="wajah" class="form-label">Bentuk Wajah</label>
                <select class="form-control" id="wajah" name="wajah">
                    <option value="oval" <?php echo $laporan['wajah'] == 'oval' ? 'selected' : ''; ?>>Oval</option>
                    <option value="bulat" <?php echo $laporan['wajah'] == 'bulat' ? 'selected' : ''; ?>>Bulat</option>
                    <option value="persegi" <?php echo $laporan['wajah'] == 'persegi' ? 'selected' : ''; ?>>Persegi
                    </option>
                    <option value="lonjong" <?php echo $laporan['wajah'] == 'lonjong' ? 'selected' : ''; ?>>Lonjong
                    </option>
                    <option value="segitiga" <?php echo $laporan['wajah'] == 'segitiga' ? 'selected' : ''; ?>>Segitiga
                    </option>
                </select>
            </div>
            <div class="d-flex">
                <button type="submit" class="btn btn-primary">Update Laporan</button>
                <a href="../DashbordKinerja.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>