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

$sql = "DELETE FROM fasilitas WHERE id_pengaduan = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../DashbordFasilitas.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
