<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

$conn = new mysqli($servername, $username, $password, $dbname);
$query = "SELECT DISTINCT tinggi, tubuh, kulit, rambut, wajah FROM pegawai";
$result = $conn->query($query);

$ciri_ciri_options = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $ciri_ciri_options[] = [
            'tinggi' => $row['tinggi'],
            'tubuh' => $row['tubuh'],
            'kulit' => $row['kulit'],
            'rambut' => $row['rambut'],
            'wajah' => $row['wajah']
        ];
    }
}

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


if (!isset($_SESSION['nomor_telpon']) && !isset($_SESSION['email'])) {

    $nama_pengguna = "Tamu";
    $usertype = "guest";
    $nomor_telpon = "";
} else {

    $nama_pengguna = $_SESSION['nama'] ?? '';
    $nomor_telpon = $_SESSION['nomor_telpon'] ?? '';
    $usertype = $_SESSION['usertype'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengguna = $_SESSION['nama'] ?? 'Guest';


    $nomor_telpon = $_SESSION['nomor_telpon'] ?? ($_POST['noTelepon'] ?? 'Tidak Tersedia');
    $tanggal_melaporkan = $_POST['report_date'];
    $tanggal_menginap = $_POST['tanggalMenginap'];
    $deskripsi_masalah = $_POST['description'];
    $jenis_masalah = $_POST['category'];
    $ciri_ciri = $_POST['features'];
    $bukti_masalah = null;


    $uploadOk = 1;
    $target_dir = "uploads/";
    $image = $_FILES['image-upload'];
    $target_file = $target_dir . uniqid() . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($image) {
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            die("File ini bukan gambar.");
        }
        if ($image["size"] > 2000000) {
            die("Maaf, file Anda terlalu besar.");
        }
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            die("Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.");
        }
        if (!move_uploaded_file($image["tmp_name"], $target_file)) {
            die("Terjadi kesalahan saat mengunggah file.");
        }
    }





    list($tinggi, $tubuh, $kulit, $rambut, $wajah) = explode(", ", $ciri_ciri);

    $stmt = $conn->prepare("INSERT INTO kinerja (nama_pengadu, tanggal_melapor, no_telepon_pengadu, tanggal_menginap, deskripsi_masalah, jenis_masalah, tinggi, tubuh, kulit, rambut, wajah, file_bukti) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssss", $nama_pengguna, $tanggal_melaporkan, $nomor_telpon, $tanggal_menginap, $deskripsi_masalah, $jenis_masalah, $tinggi, $tubuh, $kulit, $rambut, $wajah, $target_file);

    if ($stmt->execute()) {
        header("Location: kinerja.php?status=success");
        exit();
    } else {
        header("Location: kinerja.php?status=error");
        exit();
    }


}


// $nama_pengguna = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : '';
// $nomor_telpon = isset($_SESSION['nomor_telpon']) ? htmlspecialchars($_SESSION['nomor_telpon']) : '';
// $email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
// $usertype = $_SESSION['usertype'];



$conn->close();
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kinerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.8/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.8/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            width: 100vw;
            height: 100vh;
            margin: 0;
            font-family: 'Outfit', sans-serif;
            color: #FDE49E;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .blur-bg {
            background-image: url('bglogin-register.jpg');
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

        .form-container {
            padding: 40px;
            border-radius: 10px;
            position: relative;
            z-index: 2;
            width: 90%;
            max-width: 800px;
        }

        h1 {
            color: #DD761C;
            font-size: 64px;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            display: block;
            margin: 10px 0 5px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-row div {
            flex: 1;
            margin-right: 30px;
        }

        .form-row div:last-child {
            margin-right: 0;
        }

        input[type="text"],
        input[type="tel"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            height: 50px;
            padding: 10px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
        }

        textarea {
            height: 110px;
        }

        button,
        .upload-button {
            height: 45px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .upload-button {
            width: 200px;
            margin-top: 10px;
        }

        .button-container {
            text-align: right;
            margin-top: 20px;
        }

        .button-container .back-button {
            width: 120px;
            background-color: white;
            color: #DD761C;
            display: inline-block;
            margin-right: 10px;
        }

        .button-container .submit-button {
            width: 120px;
            background-color: #DD761C;
            color: white;
            display: inline-block;
        }

        button:hover {
            opacity: 0.8;
        }

        .message {
            color: white;
            text-align: center;
            margin-top: 20px;
        }

        .upload-container {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="blur-bg"></div>

    <div class="form-container">
        <h1>LAPORAN KINERJA</h1>
        <?php
        $status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
        if ($status === 'success') {
            echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Pengaduan berhasil dikirim!',
            text: 'Terima kasih atas laporan Anda.',
            showConfirmButton: true
        }).then(function() {
            window.location.href = 'userhome.php';
        });
    </script>";
        } elseif ($status === 'error') {
            echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan!',
            text: 'Silakan coba lagi.',
            showConfirmButton: true
        });
    </script>";
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div>
                    <label for="name">Nama Pengadu:</label>
                    <textarea id="name" name="name" required readonly><?php echo $nama_pengguna; ?></textarea>
                </div>
                <div>
                    <label for="report_date">Tanggal Melaporkan:</label>
                    <input type="date" id="report_date" name="report_date" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="phone">Nomor Telpon:</label>
                    <textarea id="phone" name="phone" required readonly><?php echo $nomor_telpon; ?></textarea>
                </div>
                <div>
                    <label for="tanggalMenginap">Tanggal Menginap:</label>
                    <input type="date" id="tanggalMenginap" name="tanggalMenginap" required>
                </div>
            </div>

            <div class="form-row">
                <div style="flex: 1;">
                    <label for="description">Deskripsi Masalah:</label>
                    <textarea id="description" name="description" rows="6" required></textarea>
                </div>
                <div style="flex: 1;">
                    <label for="category">Jenis Masalah:</label>
                    <select id="category" name="category" required>
                        <option value="Sikap Tidak Profesional">Sikap Tidak Profesional</option>
                        <option value="Pelayanan Tidak Ramah">Pelayanan Tidak Ramah</option>
                        <option value="Pelayanan Tidak Memuaskan">Pelayanan Tidak Memuaskan</option>
                        <option value="Tidak Tersedia saat dibutuhkan">Tidak Tersedia saat dibutuhkan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>


                </div>
            </div>

            <div class="form-row">
                <label for="image-upload">Bukti Masalah:</label>
                <input type="file" id="image-upload" class="form-control" name="image-upload" accept="image/*" required>
                <label for="features">Ciri-Ciri:</label>
                <select id="features" name="features" required>
                    <?php

                    foreach ($ciri_ciri_options as $option) {
                        echo "<option value=\"{$option['tinggi']}, {$option['tubuh']}, {$option['kulit']}, {$option['rambut']}, {$option['wajah']}\">";
                        echo "{$option['tinggi']}, {$option['tubuh']}, {$option['kulit']}, {$option['rambut']}, {$option['wajah']}";
                        echo "</option>";
                    }
                    ?>
                </select>
            </div>



            <div class="button-container">
                <button type="button" onclick="window.location.href='userhome.php';">Kembali</button>
                <button type="submit" class="submit-button">Submit</button>
            </div>
        </form>

        <?php if (isset($success_message)): ?>
            <div class="message"><?php echo $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="message"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </div>
</body>
<script>

    const checkInInput = document.getElementById('tanggalMenginap');
    const reportInput = document.getElementById('report_date');


    function validateDates() {

        let tanggalMenginap = new Date(checkInInput.value);
        let report_date = new Date(reportInput.value);
        let currentDate = new Date();

        // Validasi jika tanggal laporan lebih dari tanggal menginap
        if (report_date && tanggalMenginap && report_date < tanggalMenginap) {
            Swal.fire({
                icon: 'error',
                title: 'Tanggal Laporan Tidak Valid',
                text: 'Tanggal laporan tidak boleh lebih awal dari tanggal menginap!',
            });
            return;
        }

        // Validasi jika tanggal menginap lebih dari tanggal saat ini
        if (tanggalMenginap && tanggalMenginap > currentDate) {
            Swal.fire({
                icon: 'error',
                title: 'Tanggal Menginap Tidak Valid',
                text: 'Tanggal menginap tidak boleh lebih dari tanggal saat ini!',
            });
            return;
        }
    }

    // Tambahkan event listener untuk memeriksa setiap kali input tanggal berubah
    checkInInput.addEventListener('input', validateDates);
    reportInput.addEventListener('input', validateDates);
</script>

</html>