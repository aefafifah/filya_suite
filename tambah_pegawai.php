<?php
// Sertakan file koneksi ke database
require_once 'koneksi.php';

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Pastikan $conn tersedia dan bukan null
    if (!$conn) {
        die("Koneksi ke database tidak ditemukan.");
    }

    // Menggunakan mysqli_real_escape_string untuk mengamankan data input
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $hari = mysqli_real_escape_string($conn, $_POST['hari']);
    $waktu_shift = mysqli_real_escape_string($conn, $_POST['waktu_shift']);
    $tinggi = mysqli_real_escape_string($conn, $_POST['tinggi']);
    $tubuh = mysqli_real_escape_string($conn, $_POST['tubuh']);
    $kulit = mysqli_real_escape_string($conn, $_POST['kulit']);
    $rambut = mysqli_real_escape_string($conn, $_POST['rambut']);

    // Query untuk menambahkan data pegawai ke dalam database
    $query = "INSERT INTO pegawai (nama, jabatan, hari, waktu_shift, tinggi, tubuh, kulit, rambut) 
              VALUES ('$nama', '$jabatan', '$hari', '$waktu_shift', '$tinggi', '$tubuh', '$kulit', '$rambut')";

    // Eksekusi query dan periksa apakah berhasil
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data pegawai berhasil ditambahkan'); window.location.href='Dashboarddatapegawai.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data pegawai: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            background-image: url('blubrown.jpg');
            font-family: Arial, sans-serif;
        }

        .blur-bg {
            background-image: url('blubrown.jpg');
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
    <h2 class="text-center mb-4">Tambah Data Pegawai</h2>
    <div class="blur-bg"></div>
    <form action="" method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
                <select name="jabatan" class="form-control mb-2" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Resepsionis">Resepsionis</option>
                    <option value="House Keeper">House Keeper</option>
                    <option value="Security">Security</option>
                </select>
                <select name="hari" class="form-control mb-2" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
                <input type="time" name="waktu_shift" class="form-control mb-2" required>
            </div>
            <div class="col-md-6">
                <select name="tinggi" class="form-control mb-2" required>
                    <option value="">Pilih Tinggi</option>
                    <option value="pendek">Pendek</option>
                    <option value="sedang">Sedang</option>
                    <option value="tinggi">Tinggi</option>
                    <option value="sangat tinggi">Sangat Tinggi</option>
                </select>
                <select name="tubuh" class="form-control mb-2" required>
                    <option value="">Pilih Tubuh</option>
                    <option value="kurus">Kurus</option>
                    <option value="sedang">Sedang</option>
                    <option value="berisi">Berisi</option>
                    <option value="gemuk">Gemuk</option>
                </select>
                <select name="kulit" class="form-control mb-2" required>
                    <option value="">Pilih Warna Kulit</option>
                    <option value="cerah">Cerah</option>
                    <option value="sawo matang">Sawo Matang</option>
                    <option value="gelap">Gelap</option>
                    <option value="sangat cerah">Sangat Cerah</option>
                    <option value="sangat gelap">Sangat Gelap</option>
                </select>
                <input type="text" name="rambut" class="form-control mb-2" placeholder="Warna Rambut" required>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="Dashboarddatapegawai.php" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Tambah Pegawai</button>
        </div>
    </form>
</div>
</body>
</html>
