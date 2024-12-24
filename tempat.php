<?php
session_start();

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";
$data = mysqli_connect($servername, $username, $password, $dbname);

if (!$data) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


if (!isset($_SESSION['nomor_telpon']) && !isset($_SESSION['email'])) {
    // For guests
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
    $tanggalMenginap = htmlspecialchars(trim($_POST['tanggalMenginap']));
    $report_date = htmlspecialchars(trim($_POST['report_date']));
    $description = htmlspecialchars(trim($_POST['description']));
    $damage_location = htmlspecialchars(trim($_POST['damage_location']));
    $category = htmlspecialchars(trim($_POST['category']));


    $tanggalMenginapDate = new DateTime($tanggalMenginap);
    $reportDate = new DateTime($report_date);
    $currentDate = new DateTime();

    if ($reportDate < $tanggalMenginapDate) {
        die("Tanggal laporan tidak boleh lebih awal dari tanggal menginap.");
    }

    if ($tanggalMenginapDate > $currentDate) {
        die("Tanggal menginap tidak boleh lebih dari hari ini.");
    }


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

    // Tambahkan data laporan ke tabel tempat
    $stmt = $data->prepare("INSERT INTO tempat (nama_pengadu, no_telepon_pengadu, tanggal_menginap, nomor_kamar, jenis_masalah, deskripsi_masalah, file_bukti, waktu_pengaduan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nama_pengguna, $nomor_telpon, $tanggalMenginap, $damage_location, $category, $description, $target_file, $report_date);

    if ($stmt->execute()) {
        header("Location: tempat.php?status=success");
        exit();
    } else {
        error_log("Error saat menyimpan laporan: " . $stmt->error);
        header("Location: tempat.php?status=error");
        exit();
    }

}
$data->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tempat</title>
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
            width: 95%;
            max-width: 850px;
        }

        h1 {
            color: #DD761C;
            font-size: 64px;
            text-align: center;
            margin-top: 40px;
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
            margin-bottom: 20px;
        }

        .form-row div {
            flex: 1;
            margin-right: 20px;
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
            height: 55px;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 55px;
            resize: none;
        }

        #image-upload {
            height: 55px;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            height: 50px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .button-container button {
            width: 130px;
        }

        .button-container .back-button {
            background-color: white;
            color: #DD761C;
        }

        .button-container .submit-button {
            background-color: #DD761C;
            color: white;
        }

        input[type="text"],
        input[type="tel"],
        input[type="date"],
        textarea,
        select {
            width: calc(100% + 20px);
            margin-bottom: 10px;
        }

        #image-upload {
            width: calc(100% + 20px);
            margin-bottom: 10px;
        }

        .form-row {
            gap: 20px;
        }
    </style>

</head>

<body>
    <div class="blur-bg"></div>

    <div class="form-container">
        <h1>LAPORAN TEMPAT</h1>
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
                    <textarea id="name" name="name" required><?php echo $nama_pengguna; ?></textarea>
                </div>
                <div>
                    <label for="report_date">Tanggal Melaporkan:</label>
                    <input type="date" id="report_date" name="report_date" required>
                </div>
            </div>

            <!-- Baris Nomor Telepon dan Tanggal Menginap -->
            <div class="form-row">
                <div>
                    <label for="phone">Nomor Telpon:</label>
                    <textarea id="phone" name="phone" readonly required><?php echo htmlspecialchars($nomor_telpon, ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div>
                    <label for="tanggalMenginap">Tanggal Menginap:</label>
                    <input type="date" id="tanggalMenginap" name="tanggalMenginap" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="description">Deskripsi Masalah:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div>
                    <label for="category">Kategori Masalah:</label>
                    <select id="category" name="category" required>
                        <option value="Kerusakan Bangunan">Kerusakan Bangunan</option>
                        <option value="Kebersihan Villa">Kebersihan Villa</option>
                        <option value="Perawatan yang Kurang">Perawatan yang Kurang</option>
                        <option value="Suasana Villa Merasa Tidak Aman atau Lainnya">Suasana Villa Merasa Tidak Aman
                            atau Lainnya</option>
                        <option value="Perbedaan Kondisi Properti dengan Foto Properti di Iklan">Perbedaan Kondisi
                            Properti dengan Foto Properti di Iklan</option>
                        <option value="Masalah Aksesibilitas">Masalah Aksesibilitas</option>
                        <option value="Kenyamanan pada Waktu Penginapan">Kenyamanan pada Waktu Penginapan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="image-upload">Bukti Masalah:</label>
                    <input type="file" class="form-control" id="image-upload" name="image-upload" accept="image/*"
                        required>
                </div>
                <div>
                    <label for="damage_location">Nomor Kamar:</label>
                    <select id="damage_location" name="damage_location" required>
                        <option value="Dreamy">Dreamy</option>
                        <option value="Fancy">Fancy</option>
                        <option value="Charming">Charming</option>
                    </select>
                </div>
            </div>

            <div class="button-container">
                <button type="button" onclick="window.location.href='userhome.php';">Kembali</button>
                <button type="submit" class="submit-button">Submit</button>
            </div>
        </form>
    </div>
</body>

<script>
    const checkInInput = document.getElementById('tanggalMenginap');
    const reportInput = document.getElementById('report_date');


    function validateDates() {

        let tanggalMenginap = new Date(checkInInput.value);
        let report_date = new Date(reportInput.value);
        let currentDate = new Date();

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

    checkInInput.addEventListener('input', validateDates);
    reportInput.addEventListener('input', validateDates);
</script>

</html>
