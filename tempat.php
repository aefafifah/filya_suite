<?php
// Memulai proses jika ada data yang dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengamankan inputan
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $stay_date = isset($_POST['stay_date']) ? htmlspecialchars(trim($_POST['stay_date'])) : '';
    $report_date = isset($_POST['report_date']) ? htmlspecialchars(trim($_POST['report_date'])) : '';
    $description = isset($_POST['description']) ? htmlspecialchars(trim($_POST['description'])) : '';
    $damage_location = isset($_POST['damage_location']) ? htmlspecialchars(trim($_POST['damage_location'])) : '';
    $category = isset($_POST['category']) ? htmlspecialchars(trim($_POST['category'])) : '';

    // Mengambil data file upload
    $image = isset($_FILES['image-upload']) ? $_FILES['image-upload'] : null;

    // Variabel untuk pengecekan status upload
    $uploadOk = 1;
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Mengecek apakah file adalah gambar
    if ($image) {
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            $error_message = "File ini bukan gambar.";
            $uploadOk = 0;
        }

        // Mengecek ukuran file
        if ($image["size"] > 2000000) {
            $error_message = "Maaf, file Anda terlalu besar.";
            $uploadOk = 0;
        }

        // Mengecek tipe file
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $error_message = "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
            $uploadOk = 0;
        }

        // Proses upload jika semua pengecekan lulus
        if ($uploadOk == 1) {
            if (move_uploaded_file($image["tmp_name"], $target_file)) {
                $success_message = "File " . htmlspecialchars(basename($image["name"])) . " telah berhasil diunggah.";
            } else {
                $error_message = "Maaf, terjadi kesalahan saat mengunggah file Anda.";
            }
        }
    }

    // Jika tidak ada error, lanjutkan ke pengecekan database
    if (!isset($error_message)) {
        // Koneksi ke database
        $servername = "localhost";
        $username = "root"; 
        $password = "";
        $dbname = "filya_suite"; 

        // Membuat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Memeriksa koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Mengecek apakah nama dan nomor telepon ada di tabel users
        $stmt_check = $conn->prepare("SELECT nama FROM users WHERE nomor_telpon = ? AND nama = ?");
        $stmt_check->bind_param("ss", $phone, $name);
        $stmt_check->execute();
        $stmt_check->store_result();

        // Tambahkan nama dan nomor telepon hanya jika tidak ada
        if ($stmt_check->num_rows == 0) {
            // Menambahkan nama dan nomor telepon ke tabel users jika belum ada
            $stmt_insert_user = $conn->prepare("INSERT INTO users (nama, nomor_telpon) VALUES (?, ?)");
            $stmt_insert_user->bind_param("ss", $name, $phone);
            if (!$stmt_insert_user->execute()) {
                $error_message = "Error menambahkan nomor telepon ke tabel users: " . $stmt_insert_user->error;
            }
            $stmt_insert_user->close();
        }
        $stmt_check->close();

        // Jika tidak ada error pada penambahan user, lanjutkan menambahkan data ke tabel tempat
        if (!isset($error_message)) {
            $stmt = $conn->prepare("INSERT INTO tempat (nama_pengadu, no_telepon_pengadu, tanggal_menginap, nomor_kamar, jenis_masalah, deskripsi_masalah, file_bukti, waktu_pengaduan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $name, $phone, $stay_date, $damage_location, $category, $description, $target_file, $report_date);

            if ($stmt->execute()) {
                $success_message = "Data berhasil disimpan!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            // Menutup koneksi  
            $stmt->close();
        }

        // Menutup koneksi
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tempat</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400&display=swap" rel="stylesheet">
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
            z-index: 2; /* Pastikan form muncul di atas blur */
            width: 90%;
            max-width: 800px; /* Max width untuk kontainer */
        }

        h1 {
            color: #DD761C;
            font-size: 64px;
            text-align: center;
            margin-top: 100px; /* Menambahkan margin atas untuk jarak dari atas */
            margin-bottom: 20px; /* Menjaga jarak dengan form */
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
            height: auto; /* Menyesuaikan tinggi textarea */
        }

        /* CSS untuk kolom tempat kerusakan */
        #damage_location {
            width: 390px; /* Atur lebar kolom sesuai kebutuhan */
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
        <h1>LAPORAN TEMPAT</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div>
                    <label for="name">Nama Pengadu:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="report_date">Tanggal Melaporkan:</label>
                    <input type="date" id="report_date" name="report_date" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="phone">Nomor Telepon:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div>
                    <label for="stay_date">Tanggal Menginap:</label>
                    <input type="date" id="stay_date" name="stay_date" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="description">Deskripsi Masalah:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div>
                    <label for="category">Kategori Fasilitas:</label>
                    <select id="category" name="category" required>
                        <option value="Kerusakan villa">Kerusakan villa</option>
                        <option value="Perawatan yang kurang">Perawatan yang kurang</option>
                        <option value="Suasana villa">Suasana villa</option>
                        <option value="Merasa tidak aman">Merasa tidak aman</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="damage_location">Tempat Kerusakan:</label>
                    <input type="text" id="damage_location" name="damage_location" required>
                </div>
            </div>

            <div class="upload-container">
                <label for="image-upload">Bukti Masalah:</label>
                <input type="file" id="image-upload" name="image-upload" required>
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
</html>