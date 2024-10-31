<?php
// Database connection
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

// AJAX Data
$data = json_decode(file_get_contents('php://input'), true);
$step = $data['step']; // 'check' or 'book'
$villaName = strtolower($data['villaName']);
$checkinDate = $data['checkinDate'];
$checkoutDate = $data['checkoutDate'];
$guestCount = $data['guestCount'];

// Fetch villa data
$stmt = $pdo->prepare("SELECT * FROM villa WHERE LOWER(nama_villa) = :villaName AND status = 'tersedia'");
$stmt->execute(['villaName' => $villaName]);
$villa = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if villa is found and quota is sufficient
if (!$villa) {
    echo json_encode(['status' => 'villa_not_found', 'message' => 'Villa not available.']);
    exit;
}

if ($villa['kuota'] < $guestCount) {
    echo json_encode(['status' => 'quota_not_enough', 'message' => "Only {$villa['kuota']} spots left."]);
    exit;
}

// If step is "check", stop here and confirm availability
if ($step === 'check') {
    echo json_encode(['status' => 'success', 'message' => 'Villa available!']);
    exit;
}

// If step is "book", proceed with booking
$guestName = $data['nama'] ?? ''; // Name of the guest
$guestEmail = $data['email'] ?? ''; // Email of the guest

// Insert booking data into the pemesanan table
$stmt = $pdo->prepare("INSERT INTO pemesanan (nama_pemesan, email, villa_id, jumlah_orang, tanggal_checkin, tanggal_checkout) VALUES (:nama_pemesan, :email, :villa_id, :jumlah_orang, :checkin, :checkout)");
$stmt->execute([
    'nama_pemesan' => $guestName,
    'email' => $guestEmail,
    'villa_id' => $villa['id'],
    'jumlah_orang' => $guestCount,
    'checkin' => $checkinDate,
    'checkout' => $checkoutDate,
]);

// Update villa quota
$stmt = $pdo->prepare("UPDATE villa SET kuota = kuota - :guestCount WHERE id = :villa_id");
$stmt->execute([
    'guestCount' => $guestCount,
    'villa_id' => $villa['id'],
]);

echo json_encode(['status' => 'success', 'message' => 'Booking successful!']);
