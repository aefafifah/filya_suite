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
            height: 100%;
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
            z-index: 2;
            position: relative;
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
                        <input type="text" class="form-control" id="villa-name" placeholder="Cari Villamu">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="checkin" placeholder="Tanggal Check-in" onfocus="(this.type='date')" onblur="setPlaceholder(this, 'Check-in')">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="checkout" placeholder="Tanggal Check-out" onfocus="(this.type='date')" onblur="setPlaceholder(this, 'Checkout')">
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
                        <button type="button" class="btn w-100" style="background-color: #ff6700; color: white;" onclick="checkAvailability()">Booking</button>
                    </div>
                </form>
            </div>
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 0;"></div>
        </section>
    </div>

    <!-- Villas Section -->
    <div class="container p-5">
        <div class="container villa-section">
            <h1 class="fw-bold text-light">Villa Kita</h1>
            <div class="row justify-content-center mt-4">
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="villa-card">
                        <img src="assets/bg-1.png" alt="Villa Dreamy" class="img-fluid">
                        <div class="villa-name">Villa Dreamy</div>
                        <div class="villa-price">$990/malam</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="villa-card">
                        <img src="assets/bg-1.png" alt="Villa Charming" class="img-fluid">
                        <div class="villa-name">Villa Charming</div>
                        <div class="villa-price">$990/malam</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="villa-card">
                        <img src="assets/bg-1.png" alt="Villa Fancy" class="img-fluid">
                        <div class="villa-name">Villa Fancy</div>
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
                <form id="booking-form">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" id="guest-name" placeholder="Masukkan nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="guest-email" placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Villa</label>
                        <input type="text" id="selected-villa" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah orang</label>
                        <input type="number" id="guest-number" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Check-in</label>
                        <input type="date" id="booking-checkin" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Checkout</label>
                        <input type="date" id="booking-checkout" class="form-control" readonly>
                    </div>
                    <button type="button" class="btn w-100" style="background-color: #ff6700; color: white;" onclick="submitBooking()">Booking Sekarang</button>
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
    const villaName = document.getElementById('villa-name').value.toLowerCase();
    const checkinDate = document.getElementById('checkin').value;
    const checkoutDate = document.getElementById('checkout').value;
    const guestCount = parseInt(document.getElementById('guest-count').value);

    fetch('handle_booking.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            step: 'check',  // Initial step for availability check
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
            Swal.fire('Kuota Tidak Cukup', data.message, 'error');
        } else if (data.status === 'success') {
            Swal.fire('Berhasil!', 'Villa tersedia, lanjutkan pemesanan.', 'success').then(() => {
                // Show the booking section
                const bookingSection = document.getElementById('booking-section');
                bookingSection.style.display = 'block';

                // Populate the booking form with details
                document.getElementById('selected-villa').value = villaName; // Ensure you have an input with this ID in your form
                document.getElementById('selected-checkin').value = checkinDate; // Ensure this input exists
                document.getElementById('selected-checkout').value = checkoutDate; // Ensure this input exists
                document.getElementById('selected-guest-count').value = guestCount; // Ensure this input exists
            });
        }
    })
    .catch(error => console.error('Error:', error));
}

function submitBooking() {
    const guestName = document.getElementById('guest-name').value;
    const guestEmail = document.getElementById('guest-email').value;
    const villaName = document.getElementById('villa-name').value.toLowerCase();
    const checkinDate = document.getElementById('checkin').value;
    const checkoutDate = document.getElementById('checkout').value;
    const guestCount = parseInt(document.getElementById('guest-count').value);

    fetch('handle_booking.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            step: 'book',  // Final step for booking
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
            Swal.fire('Booking Berhasil!', 'Terima kasih telah memesan!', 'success');
        }
    })
    .catch(error => console.error('Error:', error));
}

</script>


        
    </script>
</body>

</html>
