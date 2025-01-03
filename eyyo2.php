<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "filya_suite";
$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


if (!isset($_SESSION['nomor_telpon']) && !isset($_SESSION['email'])) {

    $nama_pengguna = "Tamu";
    $usertype = "guest";
    $nomor_telpon = "";
} else {

    $email = $_SESSION['email'] ?? null;
    $nama_pengguna = $_SESSION['nama'] ?? null;
    $nomor_telpon = $_SESSION['nomor_telpon'] ?? null;
    $usertype = $_SESSION['usertype'];
}


$query = "
SELECT id, nama_pemesan, email, villa_id, jumlah_orang, tanggal_checkin,
    tanggal_checkout, created_at
    FROM pemesanan
    WHERE email = ? OR email = (
        SELECT email FROM users WHERE nomor_telpon = ?
    )
";

$stmt = mysqli_prepare($data, $query);
mysqli_stmt_bind_param($stmt, "ss", $email, $nomor_telpon);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data_tersedia = mysqli_num_rows($result) > 0;

$stmt->close();
mysqli_close($data);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan</title>

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
                gap: 20px;
            }

            .form-row div {
                flex: 1;
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
                width: 100%;
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
        margin-top: 30px; 
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

            .form-row-wide {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
        </style>
    </head>
</head>

<body>
    <!-- Blurred background -->
    <div class="blur-bg"></div>

    <!-- Form section overlay -->
    <div class="form-container">
        <h1>LAPORAN FASILITAS</h1>


        <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Pengaduan berhasil dikirim!',
                    text: 'Terima kasih atas laporan anda.',
                    showConfirmButton: true
                }).then(function() {
                    window.location.href = 'userhome.php'; // Arahkan ke halaman userhome.php setelah menutup notifikasi
                });
            </script>";
            } elseif ($_GET['status'] == 'error') {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan!',
                    text: 'Silakan coba lagi.',
                    showConfirmButton: true
                });
            </script>";
            }
        }
        ?>

<form method="POST" action="fasilitas.php" enctype="multipart/form-data">
    <div class="form-row">
        <!-- Kolom Kiri -->
        <div>
            <label for="namaPengadu">Nama Pengadu:</label>
            <textarea class="form-control" id="namaPengadu" name="namaPengadu" rows="3" placeholder="Masukkan nama anda" required ><?php echo $nama_pengguna; ?></textarea>
        </div>
        <div>
            <label for="tanggalMelaporkan">Tanggal Melaporkan:</label>
            <input type="date" class="form-control" id="tanggalMelaporkan" name="tanggalMelaporkan" required>
        </div>
    </div>

    <div class="form-row">
        <!-- Kolom Kanan -->
        <div>
            <label for="noTeleponPengadu">No Telepon Pengadu:</label>
            <textarea class="form-control" id="noTeleponPengadu" name="noTeleponPengadu" rows="3" placeholder="Masukkan nomor anda" required <?php if ($usertype === 'guest'): ?><?php echo ''; ?><?php else: ?> <?php endif; ?>><?php echo $nomor_telpon; ?></textarea>
        </div>
        <div>
            <label for="tanggalMenginap">Tanggal Menginap:</label>
            <input type="date" class="form-control" id="tanggalMenginap" name="tanggalMenginap" required>
        </div>
    </div>

    <div class="form-row">
        <!-- Kolom Kiri -->
        <div style="flex: 1;">
            <label for="deskripsiMasalah">Deskripsi Masalah:</label>
            <textarea class="masalah-form-control" id="deskripsiMasalah" name="deskripsiMasalah" rows="6" placeholder="Deskripsikan masalah yang terjadi" required></textarea>

            <label for="tempatKerusakan">Tempat Kerusakan:</label>
            <textarea class="masalah-form-control" id="tempatKerusakan" name="tempatKerusakan" rows="6" placeholder="Lokasi Kerusakan" required></textarea>
        </div>

        <!-- Kolom Kanan -->
        <div style="flex: 1;">
            <label for="jenisMasalah">Jenis Masalah:</label>
            <select class="form-select" id="jenisMasalah" name="jenisMasalah" required>
                <option selected disabled>Pilih Jenis Masalah</option>
                <option value="Wifi">Wifi</option>
                <option value="Air Conditioner">Air Conditioner</option>
                <option value="Water Heater">Water Heater</option>
                <option value="Wastafel">Wastafel</option>
                <option value="Bed">Bed</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            <label for="pilihKategori">Pilih Kategori:</label>
            <select class="form-select" id="pilihKategori" name="pilihKategori" required>
                <option selected disabled>Pilih Kategori</option>
                <option value="Fasilitas yang dijanjikan tidak tersedia">Fasilitas yang dijanjikan tidak tersedia</option>
                <option value="Fasilitas tidak berfungsi">Fasilitas tidak berfungsi</option>
                <option value="Kualitas fasilitas buruk">Kualitas fasilitas buruk</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <!-- Upload Bukti -->
        <div style="flex: 1;">
            <label for="uploadBukti">Upload Bukti:</label>
            <input type="file" class="form-control" id="uploadBukti" name="uploadBukti" accept="image/*" required>
        </div>
    </div>

    <div class="button-container">
        <!-- Tombol Back -->
        <button type="button" class="back-button" onclick="window.location.href='userhome.php';">Kembali</button>
        <!-- Tombol Submit -->
        <button type="submit" class="submit-button">Submit</button>
    </div>
</form>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    const checkInInput = document.getElementById('tanggalMenginap');
    const reportInput = document.getElementById('tanggalMelaporkan');


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
