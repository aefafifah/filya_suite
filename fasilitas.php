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
    $namaPengadu = $_SESSION['nama'] ?? ''; // Pastikan sesuai dengan sesi nama
    $noTeleponPengadu = $_SESSION['nomor_telpon'] ?? ''; // Pastikan sesuai dengan sesi nomor telepon
    $tanggalMenginap = $_POST['tanggalMenginap'] ?? '';
    $tanggalMelaporkan = $_POST['tanggalMelaporkan'] ?? '';
    $tempatKerusakan = $_POST['tempatKerusakan'] ?? '';
    $jenisMasalah = $_POST['jenisMasalah'] ?? '';
    $deskripsiMasalah = $_POST['deskripsiMasalah'] ?? '';
    $pilihKategori = $_POST['pilihKategori'] ?? '';

    // Validasi input dasar
    if (empty($namaPengadu) || empty($noTeleponPengadu) || empty($tanggalMenginap) || empty($tanggalMelaporkan) || empty($tempatKerusakan) || empty($jenisMasalah) || empty($deskripsiMasalah) || empty($pilihKategori)) {
        header("Location: fasilitas.php?status=error&message=emptyFields");
        exit();
    }

    // Validasi tanggal
    if ($tanggalMenginap > $tanggalMelaporkan) {
        header("Location: fasilitas.php?status=error&message=InvalidDate");
        exit();
    }

    // Cek apakah file diunggah
    $targetFilePath = null;
    if (isset($_FILES['uploadBukti']) && $_FILES['uploadBukti']['error'] == 0) {
        $targetDir = "uploads/";

        // Buat folder uploads jika belum ada
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Tentukan nama file unik
        $fileName = uniqid() . '-' . basename($_FILES["uploadBukti"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Tentukan ekstensi yang diizinkan
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png');

        // Validasi ekstensi file
        if (in_array($fileType, $allowedTypes)) {
            // Pindahkan file ke folder tujuan
            if (!move_uploaded_file($_FILES["uploadBukti"]["tmp_name"], $targetFilePath)) {
                header("Location: fasilitas.php?status=error&message=uploadFailed");
                exit();
            }
        } else {
            header("Location: fasilitas.php?status=error&message=unsupportedFileType");
            exit();
        }
    }

    // Menyiapkan statement dengan kolom `bukti_gambar`
    $stmt = $conn->prepare("INSERT INTO fasilitas (nama_pengadu, no_telepon_pengadu, tanggal_menginap, tanggal_melaporkan, tempat_kerusakan, jenis_masalah, deskripsi_masalah_fasilitas, pilih_kategori_fasilitas, bukti_gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $namaPengadu, $noTeleponPengadu, $tanggalMenginap, $tanggalMelaporkan, $tempatKerusakan, $jenisMasalah, $deskripsiMasalah, $pilihKategori, $targetFilePath);

    // Menjalankan statement
    if ($stmt->execute()) {
        header("Location: eyyo2.php?status=success");
    } else {
        header("Location: fasilitas.php?status=error&message=dbInsertFailed");
    }
    $stmt->close(); // Menutup statement
}

$conn->close(); // Menutup koneksi
?>