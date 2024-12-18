<?php
session_start(); 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $namaPengadu = $_SESSION['nama'] ?? 'Guest'; 
    
   
    $noTeleponPengadu = $_SESSION['nomor_telpon'] ?? ($_POST['noTelepon'] ?? 'Tidak Tersedia'); 

    $tanggalMenginap = $_POST['tanggalMenginap'] ?? '';
    $tanggalMelaporkan = $_POST['tanggalMelaporkan'] ?? '';
    $tempatKerusakan = $_POST['tempatKerusakan'] ?? '';
    $jenisMasalah = $_POST['jenisMasalah'] ?? '';
    $deskripsiMasalah = $_POST['deskripsiMasalah'] ?? '';
    $pilihKategori = $_POST['pilihKategori'] ?? '';

    
    if (empty($tanggalMenginap) || empty($tanggalMelaporkan) || empty($tempatKerusakan) || empty($jenisMasalah) || empty($deskripsiMasalah) || empty($pilihKategori)) {
        header("Location: fasilitas.php?status=error&message=emptyFields");
        exit();
    }

    $currentDate = date("Y-m-d"); 

  
    // if ($tanggalMenginap > $currentDate) {
    //     header("Location: fasilitas.php?status=error&message=dateExceedsCurrentDate");
    //     exit();
    // }

   
    // if ($tanggalMelaporkan > $tanggalMenginap) {
    //     header("Location: fasilitas.php?status=error&message=invalidReportDate");
    //     exit();
    // }

    $targetFilePath = null;
    if (isset($_FILES['uploadBukti']) && $_FILES['uploadBukti']['error'] == 0) {
        $targetDir = "uploads/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

       
        $fileName = uniqid() . '-' . basename($_FILES["uploadBukti"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png');


        if (in_array($fileType, $allowedTypes)) {
         
            if (!move_uploaded_file($_FILES["uploadBukti"]["tmp_name"], $targetFilePath)) {
                header("Location: fasilitas.php?status=error&message=uploadFailed");
                exit();
            }
        } else {
            header("Location: fasilitas.php?status=error&message=unsupportedFileType");
            exit();
        }
    }


    $stmt = $conn->prepare("INSERT INTO fasilitas (nama_pengadu, no_telepon_pengadu, tanggal_menginap, tanggal_melaporkan, tempat_kerusakan, jenis_masalah, deskripsi_masalah_fasilitas, pilih_kategori_fasilitas, bukti_gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $namaPengadu, $noTeleponPengadu, $tanggalMenginap, $tanggalMelaporkan, $tempatKerusakan, $jenisMasalah, $deskripsiMasalah, $pilihKategori, $targetFilePath);

    
    if ($stmt->execute()) {
        header("Location: eyyo2.php?status=success");
    } else {
        header("Location: fasilitas.php?status=error&message=dbInsertFailed");
    }
    $stmt->close(); 
}

$conn->close(); 
?>
