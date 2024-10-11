<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Layanan *858#</title>
    <script>
        function navigateMenu(value) {
            if (value >= 1 && value <= 4) {
                const pages = {
                    1: 'cekpulsa',
                    2: 'transfer',
                    3: 'paketinternet',
                    4: 'info'
                };
                window.location.href = pages[value] + '.php';
            } else {
                alert('Silakan pilih nomor yang valid (1-4).');
            }
        }
    </script>
    <style>
        ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0;           /* Remove padding */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Layanan *858#</h1>
        <p>Pilih layanan:</p>
        <ul>
            <li>1. Cek Pulsa</li>
            <li>2. Transfer Pulsa</li>
            <li>3. Paket Internet</li>
            <li>4. Informasi Lainnya</li>
        </ul>
        <input type="number" id="menu" min="1" max="4" placeholder="Masukkan nomor (1-4)" onchange="navigateMenu(this.value)">
    </div>
</body>
</html>
