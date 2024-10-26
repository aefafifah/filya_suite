<?php
session_start(); // Mulai sesi

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah form telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil dan memvalidasi input
    $namaPengadu = $_SESSION['nama'] ?? ''; // Pastikan ini sesuai
    $noTeleponPengadu = $_SESSION['nomor_telpon'] ?? ''; // Pastikan ini sesuai
    $userId = $_SESSION['user_id'] ?? ''; // Tambahkan ini untuk menghindari undefined key warning
    $tanggalMenginap = $_POST['tanggalMenginap'];
    $tanggalMelaporkan = $_POST['tanggalMelaporkan'];
    $tempatKerusakan = $_POST['tempatKerusakan'];
    $jenisMasalah = $_POST['jenisMasalah'];
    $deskripsiMasalah = $_POST['deskripsiMasalah'];
    $pilihKategori = $_POST['pilihKategori'];

    // Validasi tanggal
    if ($tanggalMenginap > $tanggalMelaporkan) {
        // Redirect with error message
        header("Location: fasilitas.php?status=error");
        exit();
    }

    // Menyiapkan statement
    $stmt = $conn->prepare("INSERT INTO fasilitas ( nama_pengadu, no_telepon_pengadu, tanggal_menginap, tanggal_melaporkan, tempat_kerusakan, jenis_masalah, deskripsi_masalah_fasilitas, pilih_kategori_fasilitas) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $namaPengadu, $noTeleponPengadu, $tanggalMenginap, $tanggalMelaporkan, $tempatKerusakan, $jenisMasalah, $deskripsiMasalah, $pilihKategori);

    // Menjalankan statement
    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: eyyo2.php?status=success");
    } else {
        // Redirect with error message
        header("Location: eyyo2.php?status=error");
    }

    $stmt->close(); // Menutup statement
}
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

$conn->close(); // Menutup koneksi

