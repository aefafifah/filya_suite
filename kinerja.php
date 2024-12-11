<?php
session_start(); // Mulai sesi
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filya_suite";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['nomor_telpon']) && !isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

// Proses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengadu = $_POST['name'];
    $tanggal_melaporkan = $_POST['report_date'];
    $nomor_telepon = $_POST['phone'];
    $tanggal_menginap = $_POST['stay_date'];
    $deskripsi_masalah = $_POST['description'];
    $jenis_masalah = $_POST['category'];
    $ciri_ciri = $_POST['features'];
    $bukti_masalah = null;

    // Memproses file upload
    if (isset($_FILES['image-upload']) && $_FILES['image-upload']['error'] == 0) {
        $bukti_masalah = file_get_contents($_FILES['image-upload']['tmp_name']);
    } else {
        $bukti_masalah = null;
    }

    // Query untuk menyimpan data
    $stmt = $conn->prepare("INSERT INTO laporan (nama_pengadu, tanggal_melaporkan, nomor_telepon, tanggal_menginap, deskripsi_masalah, jenis_masalah, ciri_ciri, bukti_masalah) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nama_pengadu, $tanggal_melaporkan, $nomor_telepon, $tanggal_menginap, $deskripsi_masalah, $jenis_masalah, $ciri_ciri, $bukti_masalah);

    if ($stmt->execute()) {
        $success_message = "Laporan berhasil dikirim!";
    } else {
        $error_message = "Gagal mengirim laporan: " . $conn->error;
    }

    $stmt->close();
}

$nama_pengguna = isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : '';
$nomor_telpon = isset($_SESSION['nomor_telpon']) ? htmlspecialchars($_SESSION['nomor_telpon']) : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
$usertype = $_SESSION['usertype'];
// Koneksi ke database

$query = "
SELECT id, nama_pemesan, email, villa_id, jumlah_orang, tanggal_checkin,
    tanggal_checkout, created_at
    FROM pemesanan
    WHERE email = ? OR email = (
        SELECT email FROM users WHERE nomor_telpon = ?
    )
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $email, $nomor_telpon);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data_tersedia = mysqli_num_rows($result) > 0;

$ranges = []; // Menyimpan rentang tanggal
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ranges[] = [
            'checkin' => $row['tanggal_checkin'],
            'checkout' => $row['tanggal_checkout']
        ];
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
            height: 110px; /* Increase the height of the textarea here */
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

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div>
                    <label for="name">Nama Pengadu:</label>
                    <textarea id="name" name="name"  required readonly><?php echo $nama_pengguna; ?></textarea>
                </div>
                <div>
                    <label for="report_date">Tanggal Melaporkan:</label>
                    <input type="date" id="report_date" name="report_date" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="phone">Nomor Telepon:</label>
                    <textarea id="phone" name="phone"  required readonly><?php echo $nomor_telpon; ?></textarea>
                </div>
                <div>
                    <label for="tanggalMenginap">Tanggal Menginap:</label>
                    <input type="date" id="tanggalMenginap" name="tanggalMenginap" required>
                </div>
            </div>

            <div class="form-row">
                <div style="flex: 1;">
                    <label for="description">Deskripsi Masalah:</label>
                    <textarea id="description" name="description" rows="6" required></textarea> <!-- You can change the number of rows here -->
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
                    <!-- Dropdown Ciri-Ciri placed inside the same column -->
                    <label for="features">Ciri-Ciri:</label>
                    <select id="features" name="features" required>
                        <option value="Pendek, Kurus, Sawo Matang, Oval, Gelombang">Pendek, Kurus, Sawo Matang, Oval, Gelombang</option>
                        <option value="Sedang, Sedang, Cerah, Bulat, Lurus">Sedang, Sedang, Cerah, Bulat, Lurus</option>
                        <option value="Tinggi, Berisi, Gelap, Persegi, Keriting">Tinggi, Berisi, Gelap, Persegi, Keriting</option>
                        <option value="Sangat Tinggi, Gemuk, Sangat Cerah, Lonjong, Panjang">Sangat Tinggi, Gemuk, Sangat Cerah, Lonjong, Panjang</option>
                        <option value="Sedang, Berisi, Sawo Matang, Segitiga, Bergelombang">Sedang, Berisi, Sawo Matang, Segitiga, Bergelombang</option>
                    </select>
                </div>
            </div>

            <div class="upload-container">
                <label for="image-upload">Bukti Masalah:</label>
                <input type="file" id="image-upload" name="image-upload" accept="image/*" required>
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

        // Highlight valid ranges ketika input difokuskan
        dateInput.addEventListener("focus", function () {
            // Tambahkan style warna biru muda ke tanggal valid
            const picker = this;
            const minDates = ranges.map(range => new Date(range.checkin));
            const maxDates = ranges.map(range => new Date(range.checkout));

            picker.addEventListener("input", function () {
                const calendar = document.querySelector("input[type='date']");
                if (calendar) {
                    // Highlight valid dates in blue
                    const validDates = [];
                    ranges.forEach(range => {
                        const start = new Date(range.checkin);
                        const end = new Date(range.checkout);
                        while (start <= end) {
                            validDates.push(new Date(start).toISOString().split("T")[0]);
                            start.setDate(start.getDate() + 1);
                        }
                    });

                    const cells = calendar.shadowRoot.querySelectorAll(".day"); // Misal shadow DOM
                    cells.forEach(cell => {
                        if (validDates.includes(cell.getAttribute("data-date"))) {
                            cell.style.backgroundColor = "#add8e6"; // Biru muda
                        }
                    });
                }
            });
        });

        // Ketika tanggal dipilih
        dateInput.addEventListener("change", function () {
            const selectedDate = this.value;
            let isValid = ranges.some(range =>
                selectedDate >= range.checkin && selectedDate <= range.checkout
            );

            if (!isValid) {
                // Nonaktifkan klik tanggal jika invalid
                alert("Tanggal tidak valid dalam rentang yang tersedia.");
                this.value = ""; // Reset input jika tanggal di luar rentang
            } else {
                this.style.color = "#ffffff"; // Warna teks putih
                this.blur(); // Tutup inputan setelah memilih
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        const ranges = <?php echo json_encode($ranges); ?>;
        setAllowedDates("tanggalMenginap", ranges);
    });
</script>
</html>
