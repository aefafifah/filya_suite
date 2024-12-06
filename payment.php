<?php
// Ambil data dari URL query string
$guestName = isset($_GET['guest_name']) ? $_GET['guest_name'] : '';
$guestEmail = isset($_GET['guest_email']) ? $_GET['guest_email'] : '';
$selectedVilla = isset($_GET['selected_villa']) ? $_GET['selected_villa'] : '';
$guestNumber = isset($_GET['guest_number']) ? $_GET['guest_number'] : 0;
$checkinDate = isset($_GET['checkin_date']) ? $_GET['checkin_date'] : '';
$checkoutDate = isset($_GET['checkout_date']) ? $_GET['checkout_date'] : '';

// Membuat pesan untuk WhatsApp
$waMessage = urlencode("Hallo, saya Pelanggan ingin melakukan Pembayaran Offline\n\nKonfirmasi Pemesanan Villa di Filya Suite:\n\nNama: $guestName\nEmail: $guestEmail\nVilla: $selectedVilla\nJumlah orang: $guestNumber\nTanggal: $checkinDate - $checkoutDate");

// Membuat link WhatsApp
$waLink = "https://wa.me/6281217332804?text=$waMessage";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: url('bluebrown.jpg') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: relative;
            color: #333;
            margin: 0;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(109, 197, 209, 0.6);
            z-index: 1;
        }

        .container-wrapper {
            display: flex;
            gap: 20px;
            z-index: 2;
            width: 100%;
            max-width: 800px;
            align-items: stretch;
        }

        .box {
            flex: 1;
            background-color: rgba(221, 235, 245, 0.7);
            border-radius: 10px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .box-header {
            background-color: #FDE49E;
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            color: #DD761C;
            padding-left: 10px;
        }

        .content {
            padding: 20px;
            height: 469px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .form-label {
            width: 400px;
            text-align: left;
            margin-bottom: 5px;
        }

        .payment-input,
        .text-input {
            width: 400px;
            height: 50px;
            border-radius: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            margin-top: 10px;
        }

        .upload-button {
            background-color: #DD761C;
            color: #fff;
            border: none;
            border-radius: 20px;
            width: 400px;
            height: 50px;
            font-size: 16px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-button:hover {
            background-color: #c9661a;
        }

        .pay-button {
            background-color: #DD761C;
            color: #fff;
            border: none;
            border-radius: 20px;
            width: 181.5px;
            height: 50px;
            font-size: 16px;
            margin-top: 20px;
        }

        .pay-button:hover {
            background-color: #c9661a;
        }

        .progress-bar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 600px;
            margin: 20px 0;
            position: relative;
            z-index: 2;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background-color: #ff7a00;
            z-index: -1;
            transform: translateY(-50%);
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #ff7a00;
            font-weight: bold;
            position: relative;
            z-index: 2;
        }

        .step-circle {
            width: 24px;
            height: 24px;
            background-color: #ff7a00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            margin-bottom: 5px;
            transform: translateY(8px);
        }

        .step-circle.inactive {
            background-color: #fff;
            border: 2px solid #ff7a00;
            color: #ff7a00;
        }

        .step.active .step-circle {
            background-color: #ff7a00;
            color: #fff;
        }

        .container-wrapper {
            padding: 20px;
        }

        .custom-header {
            background-color: #FDE49E;
            padding: 15px;
        }

        .custom-btn {
            background-color: #DD761C;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
        }

        .custom-btn:hover {
            background-color: #c86c1e;
        }
    </style>

</head>

<body>
    <div class="overlay"></div>
    <!-- Progress Bar -->
    <div class="progress-bar-container">
        <div class="progress-line"></div>
        <div class="step active" id="step1">
            <div class="step-circle active">1</div>
            <span>Billing</span>
        </div>
        <div class="step active" id="step2">
            <div class="step-circle active">2</div>
            <span>Payment</span>
        </div>
        <div class="step" id="step3">
            <div class="step-circle inactive">3</div>
            <span>Confirmation</span>
        </div>
    </div>
    <div class="container-wrapper">
        <!-- Payment Information Section -->
        <div class="box">
            <div class="card">
                <div class="card-header custom-header">
                    <h5 class="mb-0 text-center">Informasi Pembayaran</h5>
                </div>
                <div class="card-body mb-3 ">
                    <ul class="list-unstyled">
                        <li class="mb-4 mt-3 text-center">
                            <i class="bi bi-bank"></i>
                            BANK BRI: 00000 00000
                        </li>
                        <li class="mb-4 text-center">
                            <i class="bi bi-bank"></i>
                            BCA: 00000 00000
                        </li>
                        <li class="mb-4 text-center">
                            <i class="bi bi-bank"></i>
                            Mandiri: 00000 00000
                        </li>
                        <li class="mb-4 text-center">
                            <i class="bi bi-wallet2"></i>
                            OVO: 00000 00000
                        </li>
                        <li class="mb-4 text-center">
                            <i class="bi bi-wallet2"></i>
                            GoPay: 00000 00000
                        </li>
                    </ul>
                    <a href="<?php echo $waLink; ?>" class="btn custom-btn mb-4 mt-3 w-100" target="_blank">Klik di sini
                        untuk Pembayaran Offline</a>
                </div>
            </div>
        </div>

        <!-- Payment Form Section -->
        <div class="box">
            <div class="card">
                <div class="card-header custom-header">
                    <h5 class="mb-0 text-center">Bayar di sini</h5>
                </div>
                <div class="card-body mb-2">
                    <form id="paymentForm">
                        <div class="mb-3">
                            <label for="paymentType" class="form-label">Jenis Pembayaran</label>
                            <select class="form-select" id="paymentType" required>
                                <option selected disabled value="">Pilih Jenis Pembayaran</option>
                                <option value="1">Transfer Bank</option>
                                <option value="2">OVO</option>
                                <option value="3">GoPay</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="asalbank" class="form-label">Asal Pembayaran</label>
                            <input type="text" id="asalbank" class="form-control" placeholder="Masukkan asal pembayaran"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="transferProof" class="form-label">Upload Bukti Transfer</label>
                            <input type="file" id="transferProof" accept="image/*" required class="form-control">
                            <div class="mb-3">

                                <div class="text-center mt-3">
                                    <button type="button" id="payButton"
                                        class="btn custom-btn mb-3 mt-4 w-100">Bayar</button>
                                </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('payButton').addEventListener('click', function () {
            const paymentType = document.getElementById('paymentType').value;
            const asalbank = document.getElementById('asalbank').value;
            const transferProof = document.getElementById('transferProof').files.length;

            if (paymentType === "Pilih Jenis Pembayaran") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Jenis Pembayaran!',
                    text: 'Silakan pilih jenis pembayaran sebelum melanjutkan.',
                });
                return;
            }

            if (asalbank.trim() === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Asal Pembayaran Kosong!',
                    text: 'Silakan masukkan asal pembayaran.',
                });
                return;
            }

            if (transferProof === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Bukti Transfer Tidak Ada!',
                    text: 'Silakan upload bukti transfer.',
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: 'Apakah Anda yakin ingin melanjutkan pembayaran?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Bayar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Pembayaran Berhasil!', 'Terima kasih telah melakukan pembayaran.', 'success');
                    window.location.href = 'userhome.php';
                }
            });
        });
        document.getElementById("payButton").addEventListener("click", function () {
            const steps = document.querySelectorAll(".step");
            steps.forEach(step => {
                step.classList.add("active");
                step.querySelector(".step-circle").classList.remove("inactive");
                step.querySelector(".step-circle").classList.add("active");
            });
        });
    </script>
</body>

</html>