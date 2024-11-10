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
    $berat_badan = mysqli_real_escape_string($conn, $_POST['berat_badan']);
    $warna_kulit = mysqli_real_escape_string($conn, $_POST['warna_kulit']);
    $warna_rambut = mysqli_real_escape_string($conn, $_POST['warna_rambut']);
    $bentuk_wajah = mysqli_real_escape_string($conn, $_POST['bentuk_wajah']);

    // Query untuk menambahkan data pegawai ke dalam database
    $query = "INSERT INTO data_pegawai (nama, jabatan, hari, waktu_shift, tinggi, berat_badan, warna_kulit, warna_rambut, bentuk_wajah) 
              VALUES ('$nama', '$jabatan', '$hari', '$waktu_shift', '$tinggi', '$berat_badan', '$warna_kulit', '$warna_rambut', '$bentuk_wajah')";

    // Eksekusi query dan periksa apakah berhasil
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data pegawai berhasil ditambahkan'); window.location.href='Dashboarddatapegawai.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data pegawai: " . mysqli_error($conn) . "');</script>";
    }
}
?><!DOCTYPE html>
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

        input[type="text"] {
            font-size: 1rem;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
            margin-bottom: 15px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .row {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            input[type="text"] {
                font-size: 0.9rem;
            }
            button[type="submit"] {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Tambah Data Pegawai</h2>
    
    <form action="" method="POST" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
                <input type="text" name="jabatan" class="form-control mb-2" placeholder="Jabatan" required>
                <input type="text" name="hari" class="form-control mb-2" placeholder="Hari Shift" required>
                <input type="text" name="waktu_shift" class="form-control mb-2" placeholder="Waktu Shift" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="tinggi" class="form-control mb-2" placeholder="Tinggi" required>
                <input type="text" name="berat_badan" class="form-control mb-2" placeholder="Berat Badan" required>
                <input type="text" name="warna_kulit" class="form-control mb-2" placeholder="Warna Kulit" required>
                <input type="text" name="warna_rambut" class="form-control mb-2" placeholder="Warna Rambut" required>
                <input type="text" name="bentuk_wajah" class="form-control mb-2" placeholder="Bentuk Wajah" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Pegawai</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>