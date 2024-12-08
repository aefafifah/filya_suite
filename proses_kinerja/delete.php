<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menghapus data laporan berdasarkan ID
$id = $_GET['id'];
$sql = "DELETE FROM kinerja WHERE id_pengaduan = $id";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil dihapus.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
header("Location: ../DashbordKinerja.php"); // Redirect ke halaman utama setelah penghapusan
exit();
?>
