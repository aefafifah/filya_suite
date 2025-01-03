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
        $id_pengaduan = $stmt->insert_id;

       
        $query = "SELECT id_pegawai, nama, jabatan
                  FROM pegawai
                  WHERE tinggi = ? AND tubuh = ? AND kulit = ? AND rambut = ? AND wajah = ?
                  LIMIT 1";
        $stmt_select = $conn->prepare($query);
        $stmt_select->bind_param("sssss", $tinggi, $tubuh, $kulit, $rambut, $wajah);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        if ($result->num_rows > 0) {
            $pegawai = $result->fetch_assoc();
            $v_id_pegawai = $pegawai['id_pegawai'];
            $v_nama = $pegawai['nama'];
            $v_jabatan = $pegawai['jabatan'];

           
            $update_query = "UPDATE kinerja
                             SET id_pegawai = ?, nama_pegawai = ?, jabatan_pegawai = ?
                             WHERE id_pengaduan = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("issi", $v_id_pegawai, $v_nama, $v_jabatan, $id_pengaduan);
            $stmt_update->execute();
        }

        header("Location: kinerja.php?status=success");
        exit();
    } else {
        header("Location: kinerja.php?status=error");
        exit();
    }
}

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
    <div class="upload-container">
                        <label for="uploadBukti">Upload Bukti:</label>
                        <input type="file" class="form-control" id="uploadBukti" name="uploadBukti" accept="image/*"
                            required>
                        <!-- <small class="form-text text-muted">Upload bukti dalam format gambar (JPG, PNG, etc.).</small> -->
        </div>
        <div>
            <label for="features">Ciri-Ciri:</label>
            <select id="features" name="features" required>
                <?php foreach ($ciri_ciri_options as $option): ?>
                    <option value="<?php echo htmlspecialchars(implode(', ', $option), ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars(implode(', ', $option), ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
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
