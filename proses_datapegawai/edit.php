<?php
include '../koneksi.php'; // Include the database connection

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch employee data based on the provided ID
    $query = "SELECT * FROM data_pegawai WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $pegawai = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $hari = $_POST['hari'];
    $waktu_shift = $_POST['waktu_shift'];
    $tinggi = $_POST['tinggi'];
    $berat_badan = $_POST['berat_badan'];
    $warna_kulit = $_POST['warna_kulit'];
    $warna_rambut = $_POST['warna_rambut'];
    $bentuk_wajah = $_POST['bentuk_wajah'];

    // Update the employee data in the database
    $query = "UPDATE data_pegawai SET 
                nama='$nama', 
                jabatan='$jabatan', 
                hari='$hari', 
                waktu_shift='$waktu_shift', 
                tinggi='$tinggi', 
                berat_badan='$berat_badan', 
                warna_kulit='$warna_kulit', 
                warna_rambut='$warna_rambut', 
                bentuk_wajah='$bentuk_wajah' 
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: ../Dashboarddatapegawai.php"); // Redirect to the main page
        exit;
    } else {
        echo "Gagal mengupdate data.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            background-image: url('../blubrown.jpg');
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 900px; /* Lebarkan container */
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
        <h2>Edit Data Pegawai</h2>
        <form method="POST">
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($pegawai['nama']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= htmlspecialchars($pegawai['jabatan']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="hari" class="form-label">Hari</label>
                        <input type="text" class="form-control" id="hari" name="hari" value="<?= htmlspecialchars($pegawai['hari']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_shift" class="form-label">Waktu Shift</label>
                        <input type="text" class="form-control" id="waktu_shift" name="waktu_shift" value="<?= htmlspecialchars($pegawai['waktu_shift']); ?>" required>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tinggi" class="form-label">Tinggi</label>
                        <input type="number" class="form-control" id="tinggi" name="tinggi" value="<?= htmlspecialchars($pegawai['tinggi']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="berat_badan" class="form-label">Berat Badan</label>
                        <input type="number" class="form-control" id="berat_badan" name="berat_badan" value="<?= htmlspecialchars($pegawai['berat_badan']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="warna_kulit" class="form-label">Warna Kulit</label>
                        <input type="text" class="form-control" id="warna_kulit" name="warna_kulit" value="<?= htmlspecialchars($pegawai['warna_kulit']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="warna_rambut" class="form-label">Warna Rambut</label>
                        <input type="text" class="form-control" id="warna_rambut" name="warna_rambut" value="<?= htmlspecialchars($pegawai['warna_rambut']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="bentuk_wajah" class="form-label">Bentuk Wajah</label>
                        <input type="text" class="form-control" id="bentuk_wajah" name="bentuk_wajah" value="<?= htmlspecialchars($pegawai['bentuk_wajah']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="../Dashboarddatapegawai.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</body>
</html>