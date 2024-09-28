<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Sesuaikan dengan password database Anda
$dbname = "filya_suite"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

<?php
// Query untuk mengambil data dari tabel fasilitas, kinerja, dan tempat
// Menyelaraskan jumlah kolom di setiap query SELECT

$sql_fasilitas = "SELECT nama_pengadu, jenis_masalah, pilih_kategori_fasilitas, deskripsi_masalah_fasilitas, 'fasilitas' AS jenis_laporan FROM fasilitas";
$sql_kinerja = "SELECT nama_pengadu, jenis_masalah, NULL AS pilih_kategori_fasilitas, deskripsi_masalah, 'kinerja' AS jenis_laporan FROM kinerja";
$sql_tempat = "SELECT nama_pengadu, jenis_masalah, NULL AS pilih_kategori_fasilitas, deskripsi_masalah, 'tempat' AS jenis_laporan FROM tempat";


// Menggabungkan semua query dengan UNION
$sql_union = "$sql_fasilitas UNION ALL $sql_kinerja UNION ALL $sql_tempat ORDER BY jenis_laporan DESC";

// Eksekusi query
$result = $conn->query($sql_union);
if (!$result) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>Data Pengaduan</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> 
<style> 
body, html { 
margin: 0; 
padding: 0; 
height: 100%; 
} 
.blur-bg { 
background-image: url('path_to_your_house_image.jpg'); 
background-size: cover; 
background-position: center; 
filter: blur(8px); 
position: fixed; 
top: 0; 
left: 0; 
width: 100%; 
height: 100vh; 
z-index: -1; 
} 
.data { 
background-color: rgba(255, 255, 255, 0.9); 
border-radius: 10px; 
padding: 20px; 
width: 90%; 
max-width: 1200px; 
margin: 50px auto; 
box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
position: relative; 
} 
</style> 
</head> 
<body> 
<div class="blur-bg"></div>

<div class="data">
    <h3 class="text-center">Data Pengaduan</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pengadu</th>
                <th>Jenis Laporan</th>
                <th>Jenis Masalah</th>
                <th>Kategori Masalah</th>
                <th>Deskripsi Masalah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mengecek apakah ada data
            if ($result->num_rows > 0) {
                // Menampilkan setiap baris data
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['nama_pengadu'] . "</td>
                            <td>" . $row['jenis_laporan'] . "</td>
                            <td>" . $row['jenis_masalah'] . "</td>
                            <td>" . ($row['pilih_kategori_fasilitas'] ?? '-') . "</td>
                            <td>" . $row['deskripsi_masalah_fasilitas'] . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Tidak ada data pengaduan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
