<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Informasi Lainnya</title>
 
   
    <script>
        function toggleDetail(value) {
            const details = ['promoDetail', 'kuotaDetail', 'pulsaDetail'];
            if (value === '0') {
                window.location.href = 'index.php'; // Redirect to main menu
            } else {
                details.forEach((id, index) => {
                    document.getElementById(id).style.display = (index + 1 === parseInt(value)) ? 'block' : 'none';
                });
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Informasi Lainnya</h1>
    <p>Masukkan nomor untuk mendapatkan informasi:</p>

    <div class="info-item" onclick="toggleDetail(1)">1. Promo Terbaru</div>
    <div id="promoDetail" class="info-detail">
        <p>Diskon hingga 50% untuk paket tertentu! Cek website kami untuk info lebih lanjut.</p>
    </div>

    <div class="info-item" onclick="toggleDetail(2)">2. Kuota Internet</div>
    <div id="kuotaDetail" class="info-detail">
        <p>Kuota Anda saat ini: 3GB. Jangan lupa untuk mengisi ulang sebelum habis!</p>
    </div>

    <div class="info-item" onclick="toggleDetail(3)">3. Penggunaan Pulsa</div>
    <div id="pulsaDetail" class="info-detail">
        <p>Penggunaan pulsa Anda bulan ini: Rp 25.000. Anda bisa mengatur penggunaan agar lebih efisien.</p>
    </div>

    <div class="input-container">
        <p>Atau ketik nomor (0 untuk menu utama, 1-3 untuk informasi):</p>
        <input type="number" min="0" max="3" placeholder="0-3" oninput="toggleDetail(this.value)">
    </div>

    <div class="back-button">
        <a href="index.php" class="info-item">Kembali ke Menu Utama</a>
    </div>
</div>

</body>
</html>
