<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Paket Internet</title>

  
    <script>
        function navigate(value) {
            if (value === '0') {
                window.location.href = 'index.php'; // Redirect to main menu
            }
        }
    </script>
</head>
<body>

<h1>Paket Internet</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paket = $_POST['paket'];
    $paketDetails = [
        "1gb_1hari" => "1GB / 1 Hari - Rp 10.000",
        "5gb_7hari" => "5GB / 7 Hari - Rp 50.000",
        "10gb_30hari" => "10GB / 30 Hari - Rp 100.000"
    ];
    
    echo "<p>Anda telah memilih paket: <strong>{$paketDetails[$paket]}</strong></p>";
    echo "<p>Terima kasih telah membeli paket internet!</p>";
    echo "<div class='input-container'>";
    echo "<p>Ketik 0 untuk kembali ke menu utama atau pilih paket lain:</p>";
    echo "<input type='number' min='0' placeholder='0' oninput='navigate(this.value)'>";
    echo "</div>";
    
} else {
?>

<p>Pilih paket internet:</p>
<form method="POST" action="">
    <label for="paket">Paket:</label>
    <select name="paket" id="paket" required>
        <option value="1gb_1hari">1GB / 1 Hari - Rp 10.000</option>
        <option value="5gb_7hari">5GB / 7 Hari - Rp 50.000</option>
        <option value="10gb_30hari">10GB / 30 Hari - Rp 100.000</option>
    </select>
    <input type="submit" value="Pilih Paket">
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