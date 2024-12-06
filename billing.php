<?php
$host = 'localhost';
$dbname = 'filya_suite';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


$guestName = isset($_GET['guest_name']) ? htmlspecialchars($_GET['guest_name']) : '';
$guestEmail = isset($_GET['guest_email']) ? htmlspecialchars($_GET['guest_email']) : '';
$selectedVilla = isset($_GET['selected_villa']) ? htmlspecialchars($_GET['selected_villa']) : '';
$guestNumber = isset($_GET['guest_number']) ? (int)$_GET['guest_number'] : 0;
$checkinDate = isset($_GET['checkin_date']) ? htmlspecialchars($_GET['checkin_date']) : '';
$checkoutDate = isset($_GET['checkout_date']) ? htmlspecialchars($_GET['checkout_date']) : '';
$pricePerGuest = 190; //harga 
$totalAmount = $pricePerGuest * $guestNumber; // Hitung total

// convert rupiah 
$totalFormatted = "Rp. " . number_format($totalAmount * 15000, 0, ',', '.'); // Misal 1 USD = 15,000 IDR
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .billing-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            text-align: center;
            z-index: 2;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .inner-box {
            background-color: #DFECF6;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #ff7a00;
            margin-top: 10px;
        }
        .btn-orange {
            background-color: #ff7a00;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
            width: 100%;
        }
        .btn-orange:hover {
            background-color: #e56a00;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="billing-container">
        <h2>Total Tagihan</h2>
        <div class="inner-box">
            <div class="d-flex justify-content-between">
                <span>Nama</span>
                <span><?php echo $guestName; ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Email</span>
                <span><?php echo $guestEmail; ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Villa</span>
                <span><?php echo $selectedVilla; ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Jumlah orang</span>
                <span><?php echo $guestNumber; ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tanggal</span>
                <span><?php echo "$checkinDate - $checkoutDate"; ?></span>
            </div>
            <div class="d-flex justify-content-between total-amount">
                <span>Total</span>
                <span><?php echo $totalFormatted; ?></span>
            </div>
        </div>

        <a href="payment.php?guest_name=<?php echo urlencode($guestName); ?>&guest_email=<?php echo urlencode($guestEmail); ?>&selected_villa=<?php echo urlencode($selectedVilla); ?>&guest_number=<?php echo urlencode($guestNumber); ?>&checkin_date=<?php echo urlencode($checkinDate); ?>&checkout_date=<?php echo urlencode($checkoutDate); ?>" class="btn btn-orange">Pilih Metode Pembayaran</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
