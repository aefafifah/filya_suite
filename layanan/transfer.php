<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Transfer Pulsa</title>

    
    <script>
        function navigate(value) {
            if (value === '0') {
                window.location.href = 'index.php'; // Redirect to main menu
            }
        }
    </script>
</head>
<body>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nomor_tujuan']) && isset($_POST['jumlah'])) {
    $nomor_tujuan = htmlspecialchars($_POST['nomor_tujuan']);
    $jumlah = htmlspecialchars($_POST['jumlah']);

    // Simulasi proses transfer pulsa
    echo "<div class='result'>";
    echo "<h3>Konfirmasi Transfer Pulsa</h3>";
    echo "Anda telah mentransfer Rp " . number_format($jumlah, 0, ',', '.') . " ke nomor $nomor_tujuan.";
    echo "<br>";
    echo "<p>Transfer berhasil!</p>";
    echo "<p>Terima kasih telah menggunakan layanan kami.</p>";
    echo "</div>";
    echo "<div class='input-container'>";
    echo "<p>Ketik 0 untuk kembali ke menu utama atau lanjutkan transfer:</p>";
    echo "<input type='number' min='0' placeholder='0' oninput='navigate(this.value)'>";
    echo "</div>";
} else {
?>

<h1>Transfer Pulsa</h1>
<p>Masukkan detail untuk transfer pulsa:</p>

<form method="POST" action="transfer.php">
    <label for="nomor_tujuan">Nomor Tujuan:</label>
    <input type="text" name="nomor_tujuan" id="nomor_tujuan" required>

    <label for="jumlah">Jumlah Pulsa (Rp):</label>
    <input type="number" name="jumlah" id="jumlah" required>

    <input type="submit" value="Transfer">

    
</form>

<div class="input-container">
    <p>Ketik 0 untuk kembali ke menu utama:</p>
    <input type="number" min="0" placeholder="0" oninput="navigate(this.value)">
</div>



<?php
}
?>

</body>
</html>
