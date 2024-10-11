<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
  
    <title>Cek Pulsa</title>
    
    <script>
        function navigate(value) {
            if (value === '0') {
                window.location.href = 'index.php'; // Redirect to main menu
            }
        }
    </script>
</head>
<body>

<h1>Cek Pulsa</h1>

<?php
// Simulasi cek pulsa
$saldo = 50000; // contoh saldo
echo "<p>Saldo Anda saat ini adalah: <strong>Rp " . number_format($saldo, 0, ',', '.') . "</strong></p>";
?>

<div class="input-container">
    <p>Ketik 0 untuk kembali ke menu utama:</p>
    <input type="number" min="0" placeholder="0" oninput="navigate(this.value)">
</div>

<div class="back-button">
    <a href="index.php" class="info-item">Kembali ke Menu Utama</a>
</div>

</body>
</html>
