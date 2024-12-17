<?php
session_start(); // Mulai sesi

if (!isset($_SESSION['nomor_telpon']) && !isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "filya_suite";

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $password, $db);


if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nama = $_SESSION['nama'];
$usertype = $_SESSION['usertype'];
$nomor_telpon = $_SESSION['nomor_telpon'];


$sql = "SELECT email FROM users WHERE nomor_telpon = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomor_telpon);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

// Tutup koneksi database
$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villa Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #ff6700;
        }

        .hero {
            background: url('assets/bg-1.png') no-repeat center center/cover;
            height: 95vh;
        }

        .head {
            font-size: 6.5rem;
        }

        .villa-section {
            text-align: center;
            padding: 40px 0;
        }

        .villa-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 20px;
            color: #333333;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .villa-card:hover {
            transform: scale(1.05);
        }

        .villa-card img {
            border-radius: 20px;
            height: 250px;
            object-fit: cover;
        }

        .villa-name {
            font-weight: bold;
            margin-top: 15px;
        }

        .villa-price {
            color: #ff6700;
            font-weight: bold;
        }

        .booking {
            background: url('assets/bg-2.png') no-repeat center center/cover;
            position: relative;
            min-height: 400px;
            justify-content: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(221, 118, 28, 0.48);
            z-index: 1;
        }

        .booking-form {
            background: rgba(255, 255, 255, 0.7);
            padding: 20px;
            border-radius: 15px;
            max-width: 400px;
            margin: auto;
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <div class="hero p-5 row align-items-center" style="position: relative; overflow: hidden;">
        <section class="container-fluid">
            <div class="text-center row align-items-center" style="position: relative; z-index: 1;">
                <h1 class="head text-light fw-bold">Buat Momentmu di sini!</h1>
                <form id="search-form" class="row justify-content-center g-2 mt-4">
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="villa-name"
                            placeholder="Scroll ke bawah untuk cari villa">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="checkin" placeholder="Tanggal Check-in"
                            onfocus="(this.type='date')" onblur="setPlaceholder(this, 'Check-in')">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="checkout" placeholder="Tanggal Check-out"
                            onfocus="(this.type='date')" onblur="setPlaceholder(this, 'Checkout')">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="guest-count">
                            <option selected>Jumlah Tamu</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn w-100" style="background-color: #ff6700; color: white;"
                            onclick="checkAvailability()">Booking</button>
                    </div>
                </form>
            </div>
            <div
                style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 0;">
            </div>
        </section>
    </div>

    <!-- Villas Section -->
    <div class="container p-5">
        <div class="container villa-section">
            <h1 class="fw-bold text-light">Villa Kita</h1>
            <h2 class="fw-bold text-light">Klik untuk pilih villa</h2>
            <div class="row justify-content-center mt-4">
                <div class="col-md-4 col-sm-6 mb-4" onclick="selectVilla('Dreamy')">
                    <div class="villa-card">
                        <img src="assets/bg-1.png" alt="Villa Dreamy" class="img-fluid">
                        <div class="villa-name">Dreamy</div>
                        <div class="villa-price">$990/malam</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4" onclick="selectVilla('Charming')">
                    <div class="villa-card">
                        <img src="assets/bg-1.png" alt="Villa Charming" class="img-fluid">
                        <div class="villa-name">Charming</div>
                        <div class="villa-price">$990/malam</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4" onclick="selectVilla('Fancy')">
                    <div class="villa-card">
                        <img src="assets/bg-1.png" alt="Villa Fancy" class="img-fluid">
                        <div class="villa-name">Fancy</div>
                        <div class="villa-price">$990/malam</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Booking Form Section -->
    <div class="booking p-5" id="booking-section" style="display: none;">
        <div class="overlay"></div>
        <section class="container">
            <div class="booking-form">
                <h3 class="text-center">$190 per Malam</h3>
                <form id="booking-form" method="get">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input class="form-control"
                        name="guest_name"
                        id="guest-name"
                        value="<?php echo htmlspecialchars($nama); ?>"
                        required readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control"
                        name="guest_email"
                        id="guest-email"
                        value="<?php echo htmlspecialchars($email); ?>"
                        required readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Villa</label>
                        <input type="text" name="selected_villa" id="selected-villa" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah orang</label>
                        <input type="number" name="guest_number" id="guest-number" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Check-in</label>
                        <input type="date" name="booking_checkin" id="booking-checkin" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Checkout</label>
                        <input type="date" name="booking_checkout" id="booking-checkout" class="form-control" readonly>
                    </div>
                    <button type="button" class="btn w-100" style="background-color: #ff6700; color: white;"
                        onclick="submitBooking()">Booking Sekarang</button>

                </form>


            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setPlaceholder(element, placeholderText) {
            if (element.value === '') {
                element.type = 'text';
                element.placeholder = placeholderText;
            }
        }
        // Fungsi untuk memvalidasi tanggal
function validateDates() {
    const checkinDate = document.getElementById('checkin').value;
    const checkoutDate = document.getElementById('checkout').value;
    const today = new Date().toISOString().split('T')[0]; // Tanggal hari ini dalam format YYYY-MM-DD

    if (checkinDate < today) {
        Swal.fire('Tanggal Tidak Valid!', 'Tanggal check-in tidak boleh sebelum hari ini.', 'error');
        document.getElementById('checkin').value = ''; // Reset input check-in
        return false;
    }

    if (checkoutDate && checkoutDate <= checkinDate) {
        Swal.fire('Tanggal Tidak Valid!', 'Tanggal check-out harus setelah tanggal check-in.', 'error');
        document.getElementById('checkout').value = ''; // Reset input check-out
        return false;
    }

    return true;
}

// Tambahkan event listener untuk memvalidasi tanggal
document.getElementById('checkin').addEventListener('change', validateDates);
document.getElementById('checkout').addEventListener('change', validateDates);

// Highlight Rentang Tanggal
function highlightDateRange() {
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;

    if (checkin && checkout) {
        const checkinDate = new Date(checkin);
        const checkoutDate = new Date(checkout);

        const days = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24));
        Swal.fire({
            title: 'Rentang Tanggal Dipilih',
            text: `Anda memilih rentang ${days} hari antara ${checkin} dan ${checkout}.`,
            icon: 'info'
        });
    }
}

// Tambahkan validasi rentang saat kedua tanggal sudah dipilih
document.getElementById('checkin').addEventListener('change', highlightDateRange);
document.getElementById('checkout').addEventListener('change', highlightDateRange);

        // function checkAvailability() {
        // const villaName = document.getElementById('villa-name').value.toLowerCase();
        // const checkinDate = document.getElementById('checkin').value;
        // const checkoutDate = document.getElementById('checkout').value;
        // const guestCount = parseInt(document.getElementById('guest-count').value);

        // if (!villaName || !checkinDate || !checkoutDate || !guestCount) {
        //     Swal.fire('Field Kosong!', 'Silakan isi semua field yang diperlukan.', 'error');
        //     return;
        // }

        //     fetch('check_availability.php', {
        //         method: 'POST',
        //         headers: { 'Content-Type': 'application/json' },
        //         body: JSON.stringify({
        //             villaName: villaName,
        //             checkinDate: checkinDate,
        //             checkoutDate: checkoutDate,
        //             guestCount: guestCount
        //         })
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.status === 'villa_not_found') {
        //             Swal.fire('Villa Tidak Ditemukan', 'Silahkan scroll ke bawah dan lihat villa kita.', 'info');
        //         } else if (data.status === 'quota_not_enough') {
        //             Swal.fire('Kuota Tidak Cukup', 'Silahkan cari villa lain.', 'error');
        //         } else if (data.status === 'success') {
        //             Swal.fire('Berhasil!', data.message, 'success');
        //             document.getElementById('selected-villa').value = villaName;
        //             document.getElementById('guest-number').value = guestCount;
        //             document.getElementById('booking-checkin').value = checkinDate;
        //             document.getElementById('booking-checkout').value = checkoutDate;
        //             document.getElementById('booking-section').style.display = 'block';
        //             document.getElementById('booking-section').scrollIntoView({ behavior: 'smooth' });
        //         }
        //     })
        //     .catch(error => console.error('Error:', error));
        // }
        function checkAvailability() {
            const villaName = document.getElementById('villa-name').value;
            const checkinDate = document.getElementById('checkin').value;
            const checkoutDate = document.getElementById('checkout').value;
            const guestCount = document.getElementById('guest-count').value;

            if (!villaName || !checkinDate || !checkoutDate || !guestCount) {
                Swal.fire('Field Kosong!', 'Silakan isi semua field yang diperlukan.', 'error');
                return;
            }

            // Simulasi Fetch API (ganti dengan server Anda jika ada)
            fetch('handle_booking.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    step: 'check',  // Langkah awal untuk pengecekan
                    villaName: villaName,
                    checkinDate: checkinDate,
                    checkoutDate: checkoutDate,
                    guestCount: guestCount
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'villa_not_found') {
                        Swal.fire('Villa Tidak Ditemukan', 'Silahkan pilih villa lain.', 'info');
                    } else if (data.status === 'quota_not_enough') {
                        Swal.fire('Kuota Tidak Cukup', 'Silahkan coba villa lain.', 'error');
                    } else if (data.status === 'success') {
                        Swal.fire('Berhasil!', 'Villa tersedia, lanjutkan pemesanan.', 'success').then(() => {
                            // Tampilkan Booking Form
                            const bookingSection = document.getElementById('booking-section');
                            bookingSection.style.display = 'block';

                            // Isi formulir pemesanan secara otomatis
                            document.getElementById('selected-villa').value = villaName;
                            document.getElementById('guest-number').value = guestCount;
                            document.getElementById('booking-checkin').value = checkinDate;
                            document.getElementById('booking-checkout').value = checkoutDate;

                            // Scroll ke Booking Section
                            bookingSection.scrollIntoView({ behavior: 'smooth' });
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function submitBooking() {
            const guestName = document.getElementById('guest-name').value;
            const guestEmail = document.getElementById('guest-email').value;
            const villaName = document.getElementById('selected-villa').value;
            const checkinDate = document.getElementById('booking-checkin').value;
            const checkoutDate = document.getElementById('booking-checkout').value;
            const guestCount = document.getElementById('guest-number').value;

            if (!guestName || !guestEmail) {
                Swal.fire('Field Kosong!', 'Silakan lengkapi nama dan email Anda.', 'error');
                return;
            }

            // Kirim data ke server
            fetch('handle_booking.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    step: 'book',
                    nama: guestName,
                    email: guestEmail,
                    villaName: villaName,
                    checkinDate: checkinDate,
                    checkoutDate: checkoutDate,
                    guestCount: guestCount
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Booking Berhasil!', 'Terima kasih telah memesan!', 'success')
                            .then(() => {

                                window.location.href = `billing.php?guest_name=${encodeURIComponent(guestName)}&guest_email=${encodeURIComponent(guestEmail)}&selected_villa=${encodeURIComponent(villaName)}&guest_number=${encodeURIComponent(guestCount)}&checkin_date=${encodeURIComponent(checkinDate)}&checkout_date=${encodeURIComponent(checkoutDate)}`;
                            });
                    } else {
                        Swal.fire('Booking Gagal!', data.message || 'Silahkan coba lagi.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                });
        }


        function selectVilla(villaName) {
            document.getElementById('villa-name').value = villaName;
        }


    </script>



    </script>
</body>

</html>