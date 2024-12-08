<?php
include '../koneksi.php'; // Include the database connection

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the employee data from the database
    $query = "DELETE FROM pegawai WHERE id_pegawai = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: ../Dashboarddatapegawai.php"); // Redirect to the main page
        exit;
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
