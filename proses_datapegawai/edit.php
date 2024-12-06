<?php
// Sertakan file koneksi ke database
include '../koneksi.php';

// Periksa apakah ID pegawai tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data pegawai berdasarkan ID
    $query = "SELECT * FROM pegawai WHERE id_pegawai = '$id'";
    $result = mysqli_query($conn, $query);

    // Periksa apakah data pegawai ditemukan
    if (mysqli_num_rows($result) > 0) {
        $pegawai = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Data pegawai tidak ditemukan.'); window.location.href='Dashboarddatapegawai.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID pegawai tidak ditemukan.'); window.location.href='Dashboarddatapegawai.php';</script>";
    exit();
}

// Proses update data pegawai jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $hari = mysqli_real_escape_string($conn, $_POST['hari']);
    $waktu_shift = mysqli_real_escape_string($conn, $_POST['waktu_shift']);
    $tinggi = mysqli_real_escape_string($conn, $_POST['tinggi']);
    $tubuh = mysqli_real_escape_string($conn, $_POST['tubuh']);
    $kulit = mysqli_real_escape_string($conn, $_POST['kulit']);
    $rambut = mysqli_real_escape_string($conn, $_POST['rambut']);

    // Query untuk update data pegawai
    $query = "UPDATE pegawai SET 
              nama = '$nama', 
              jabatan = '$jabatan', 
              hari = '$hari', 
              waktu_shift = '$waktu_shift', 
              tinggi = '$tinggi', 
              tubuh = '$tubuh', 
              kulit = '$kulit', 
              rambut = '$rambut' 
              WHERE id_pegawai = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data pegawai berhasil diupdate'); window.location.href='../Dashboarddatapegawai.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data pegawai: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 2rem;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Data Pegawai</h2>
        <form action="" method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="nama" class="form-control mb-2" value="<?= htmlspecialchars($pegawai['nama']); ?>" required>
                    <select name="jabatan" class="form-control mb-2" required>
                        <option value="Resepsionis" <?= $pegawai['jabatan'] == 'Resepsionis' ? 'selected' : ''; ?>>Resepsionis</option>
                        <option value="House Keeper" <?= $pegawai['jabatan'] == 'House Keeper' ? 'selected' : ''; ?>>House Keeper</option>
                        <option value="Security" <?= $pegawai['jabatan'] == 'Security' ? 'selected' : ''; ?>>Security</option>
                    </select>
                    <select name="hari" class="form-control mb-2" required>
                        <option value="Senin" <?= $pegawai['hari'] == 'Senin' ? 'selected' : ''; ?>>Senin</option>
                        <option value="Selasa" <?= $pegawai['hari'] == 'Selasa' ? 'selected' : ''; ?>>Selasa</option>
                        <option value="Rabu" <?= $pegawai['hari'] == 'Rabu' ? 'selected' : ''; ?>>Rabu</option>
                        <option value="Kamis" <?= $pegawai['hari'] == 'Kamis' ? 'selected' : ''; ?>>Kamis</option>
                        <option value="Jumat" <?= $pegawai['hari'] == 'Jumat' ? 'selected' : ''; ?>>Jumat</option>
                        <option value="Sabtu" <?= $pegawai['hari'] == 'Sabtu' ? 'selected' : ''; ?>>Sabtu</option>
                        <option value="Minggu" <?= $pegawai['hari'] == 'Minggu' ? 'selected' : ''; ?>>Minggu</option>
                    </select>
                    <input type="time" name="waktu_shift" class="form-control mb-2" value="<?= htmlspecialchars($pegawai['waktu_shift']); ?>" required>
                </div>
                <div class="col-md-6">
                    <select name="tinggi" class="form-control mb-2" required>
                        <option value="pendek" <?= $pegawai['tinggi'] == 'pendek' ? 'selected' : ''; ?>>Pendek</option>
                        <option value="sedang" <?= $pegawai['tinggi'] == 'sedang' ? 'selected' : ''; ?>>Sedang</option>
                        <option value="tinggi" <?= $pegawai['tinggi'] == 'tinggi' ? 'selected' : ''; ?>>Tinggi</option>
                        <option value="sangat tinggi" <?= $pegawai['tinggi'] == 'sangat tinggi' ? 'selected' : ''; ?>>Sangat Tinggi</option>
                    </select>
                    <select name="tubuh" class="form-control mb-2" required>
                        <option value="kurus" <?= $pegawai['tubuh'] == 'kurus' ? 'selected' : ''; ?>>Kurus</option>
                        <option value="sedang" <?= $pegawai['tubuh'] == 'sedang' ? 'selected' : ''; ?>>Sedang</option>
                        <option value="berisi" <?= $pegawai['tubuh'] == 'berisi' ? 'selected' : ''; ?>>Berisi</option>
                        <option value="gemuk" <?= $pegawai['tubuh'] == 'gemuk' ? 'selected' : ''; ?>>Gemuk</option>
                    </select>
                    <select name="kulit" class="form-control mb-2" required>
                        <option value="cerah" <?= $pegawai['kulit'] == 'cerah' ? 'selected' : ''; ?>>Cerah</option>
                        <option value="sawo matang" <?= $pegawai['kulit'] == 'sawo matang' ? 'selected' : ''; ?>>Sawo Matang</option>
                        <option value="gelap" <?= $pegawai['kulit'] == 'gelap' ? 'selected' : ''; ?>>Gelap</option>
                        <option value="sangat cerah" <?= $pegawai['kulit'] == 'sangat cerah' ? 'selected' : ''; ?>>Sangat Cerah</option>
                        <option value="sangat gelap" <?= $pegawai['kulit'] == 'sangat gelap' ? 'selected' : ''; ?>>Sangat Gelap</option>
                    </select>
                    <input type="text" name="rambut" class="form-control mb-2" value="<?= htmlspecialchars($pegawai['rambut']); ?>" required>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="Dashboarddatapegawai.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update Pegawai</button>
            </div>
        </form>
    </div>
</body>

</html>
