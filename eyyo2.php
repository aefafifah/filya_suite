<?php
session_start(); // Mulai sesi

$host = "localhost";
$user = "root";
$password = "";
$db = "filya_suite";

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_SESSION['nomor_telpon']) && !isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$nama_pengguna = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : '';
$nomor_telpon = isset($_SESSION['nomor_telpon']) ? htmlspecialchars($_SESSION['nomor_telpon']) : '';
$usertype = $_SESSION['usertype'];

$sql = "SELECT tanggal_checkin, tanggal_checkout FROM pemesanan WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$ranges = []; // Menyimpan rentang tanggal
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ranges[] = [
            'checkin' => $row['tanggal_checkin'],
            'checkout' => $row['tanggal_checkout']
        ];
    }
}

$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        label.form-label {
            color: #FDE49E;
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
            pointer-events: none;
        }

        .form-overlay {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }

        .container-form {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 80px;
            min-height: calc(100vh - 100px);
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            display: flex;
            width: 800px;
        }

        .form-column {
            flex: 1;
            padding: 20px;
        }

        .form-control,
        .form-select {
            width: 100%;
            height: 78px;
            border-radius: 20px;
        }

        .btn-custom {
            background-color: #DD761C;
            color: #FDE49E;
            border: none;
            width: 100%;
            border-radius: 20px;
        }

        .btn-custom:hover {
            background-color: #FDE49E;
        }

        .btn-large {
            background-color: #DD761C;
            color: #FDE49E;
            width: 400px;
            height: 77px;
            border: none;
            font-size: 16px;
            border-radius: 20px;
        }

        .btn-small {
            background-color: white;
            color: #DD761C;
            width: 181.5px;
            height: 50px;
            border: 2px solid #DD761C;
            margin: 0 5px;
            border-radius: 20px;
        }

        .btn-small-submit {
            background-color: #DD761C;
            color: #FDE49E;
            width: 181.5px;
            height: 50px;
            border: none;
            margin: 0 5px;
            border-radius: 20px;
        }
        /* Cursor pointer untuk input date */
        #tanggalMenginap {
            cursor: pointer;
        }

        /* Ketika input tanggal disabled */
        #tanggalMenginap:disabled {
            background-color: #e0e0e0; /* Abu-abu */
            color: #a0a0a0;
            cursor: not-allowed;
        }

        /* Highlight valid range dengan warna biru muda */
        #tanggalMenginap:focus {
            outline: none; /* Hilangkan outline default */
            box-shadow: 0 0 5px #add8e6; /* Warna biru muda */
        }

        /* Warna biru tua untuk tanggal yang dipilih */
        #tanggalMenginap:focus:valid {
            background-color: #0000ff; /* Biru tua */
            color: #ffffff; /* Warna teks putih */
        }
    </style>
</head>

<body>

    <!-- Blurred background -->
    <div class="blur-bg"></div>

    <!-- Form section overlay -->
    <div class="container-form">
        <div class="form-overlay">

            <!-- Pesan Status -->
            <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'success') {
                    echo "<div class='alert alert-success text-center'>Pengaduan berhasil dikirim!</div>";
                } elseif ($_GET['status'] == 'error') {
                    echo "<div class='alert alert-danger text-center'>Terjadi kesalahan, silakan coba lagi.</div>";
                }
            }
            ?>

            <form method="POST" action="fasilitas.php" enctype="multipart/form-data">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="namaPengadu" class="form-label">Nama Pengadu</label>
                            <textarea class="form-control" id="namaPengadu" name="namaPengadu" rows="3" placeholder="Masukkan nama anda" required readonly><?php echo $nama_pengguna; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="noTeleponPengadu" class="form-label">No Telepon Pengadu</label>
                            <textarea class="form-control" id="noTeleponPengadu" name="noTeleponPengadu" rows="3" placeholder="Masukkan nomor anda" required readonly><?php echo $nomor_telpon; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tanggalMenginap" class="form-label">Tanggal Menginap</label>
                            <input type="date" class="form-control" id="tanggalMenginap" name="tanggalMenginap" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsiMasalah" class="form-label">Deskripsi Masalah</label>
                            <textarea class="form-control" id="deskripsiMasalah" name="deskripsiMasalah" rows="3" placeholder="Deskripsikan masalah yang terjadi" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="uploadBukti" class="form-label">Upload Bukti</label>
                            <input type="file" class="form-control" id="uploadBukti" name="uploadBukti" accept="image/*" required>
                            <small class="form-text text-muted">Upload bukti dalam format gambar (JPG, PNG, etc.).</small>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggalMelaporkan" class="form-label">Tanggal Melaporkan</label>
                            <input type="date" class="form-control" id="tanggalMelaporkan" name="tanggalMelaporkan" required>
                        </div>

                        <div class="mb-3">
                            <label for="tempatKerusakan" class="form-label">Tempat Kerusakan</label>
                            <input type="text" class="form-control" id="tempatKerusakan" name="tempatKerusakan" placeholder="Lokasi Kerusakan" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenisMasalah" class="form-label">Jenis Masalah</label>
                            <select class="form-select" id="jenisMasalah" name="jenisMasalah" required>
                                <option selected disabled>Pilih Jenis Masalah</option>
                                <option value="Wifi">Wifi</option>
                                <option value="Air Conditioner">Air Conditioner</option>
                                <option value="Water Heater">Water Heater</option>
                                <option value="Wastafel">Wastafel</option>
                                <option value="Bed">Bed</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pilihKategori" class="form-label">Pilih Kategori</label>
                            <select class="form-select" id="pilihKategori" name="pilihKategori" required>
                                <option selected disabled>Pilih Kategori</option>
                                <option value="Fasilitas yang dijanjikan tidak tersedia">Fasilitas yang dijanjikan tidak tersedia</option>
                                <option value="Fasilitas tidak berfungsi">Fasilitas tidak berfungsi</option>
                                <option value="Kualitas fasilitas buruk">Kualitas fasilitas buruk</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3 text-center">
                    <!-- Tombol Back -->
                    <button type="button" onclick="window.location.href='userhome.php';">Kembali</button>
                    <!-- Tombol Submit -->
                    <button type="submit" class="btn-small-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
        function setAllowedDates(inputId, ranges) {
            const dateInput = document.getElementById(inputId);

            if (ranges.length === 0) {
                // Tidak ada rentang tanggal
                dateInput.disabled = false; // Tetap bisa diklik
                dateInput.addEventListener("click", () => {
                    alert("Tidak ada tanggal yang tersedia untuk dipilih.");
                });
                return;
            }

            // Aktifkan input
            dateInput.disabled = false;

            // Highlight valid ranges
            dateInput.addEventListener("focus", function () {
                const minDates = ranges.map(range => range.checkin);
                const maxDates = ranges.map(range => range.checkout);
                alert(
                    `Pilih tanggal antara:\n` +
                    ranges
                        .map(
                            range => `- ${range.checkin} hingga ${range.checkout}`
                        )
                        .join("\n")
                );
            });

            // Validasi input
            dateInput.addEventListener("change", function () {
                const selectedDate = this.value;
                let isValid = ranges.some(range =>
                    selectedDate >= range.checkin && selectedDate <= range.checkout
                );

                if (!isValid) {
                    alert("Tanggal tidak valid dalam rentang yang tersedia.");
                    this.value = ""; // Reset input jika tanggal di luar rentang
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const ranges = <?php echo json_encode($ranges); ?>;
            setAllowedDates("tanggalMenginap", ranges);
        });
    </script>
</html>
