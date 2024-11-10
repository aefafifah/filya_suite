<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menghapus data berdasarkan ID
$id = $_GET['id'];
$sql = "DELETE FROM tempat WHERE id_pengaduan = $id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data berhasil dihapus'); window.location.href = '../DashboardTempt.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
