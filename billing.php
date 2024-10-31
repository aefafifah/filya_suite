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

        .progress-bar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 60%; /* Mengurangi panjang garis */
            position: relative;
            z-index: 2;
            margin-bottom: 20px;
            padding: 0; /* Menghilangkan padding */
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 0; /* Mulai dari ujung kiri */
            right: 0; /* Ujung kanan garis */
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

        .step-circle 1{

        }

        .step-circle.inactive {
            background-color: #fff;
            border: 2px solid #ff7a00;
            color: #ff7a00;
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

    <!-- Progress Bar outside the billing container -->
    <div class="progress-bar-container">
        <div class="progress-line"></div>
        <div class="step">
            <div class="step-circle 1">1</div>
            <span>Billing</span>
        </div>
        <div class="step" style="margin-left: auto;">
            <div class="step-circle inactive">2</div>
            <span>Payment</span>
        </div>
        <div class="step" style="margin-left: auto;">
            <div class="step-circle inactive">3</div>
            <span>Confirmation</span>
        </div>
    </div>

    <!-- Billing Container -->
    <div class="billing-container">
        <h2>Total Tagihan</h2>
        <div class="inner-box">
            <div class="d-flex justify-content-between">
                <span>Nama</span>
                <span>Cust</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Email</span>
                <span>cust@gmail.com</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Villa</span>
                <span>Fancy</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Jumlah orang</span>
                <span>5</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tanggal</span>
                <span>20-21 Januari 2025</span>
            </div>
            <div class="d-flex justify-content-between total-amount">
                <span>Total</span>
                <span>Rp. 500.000</span>
            </div>
        </div>

        <a href="payment.php" class="btn btn-orange">Pilih Metode Pembayaran</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
