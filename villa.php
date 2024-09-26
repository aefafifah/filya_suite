<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Villa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-dibooking {
            background-color: #f8d7da; /* Merah Muda */
            color: #721c24; /* Warna teks merah tua */
        }
        .status-tersedia {
            background-color: #d4edda; /* Hijau Muda */
            color: #155724; /* Warna teks hijau tua */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Status Villa</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Villa</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Contoh data
                $data = [
                    ['id' => 1, 'nama' => 'Sweet', 'keterangan' => 'Bangunan Villa yang dibangun dengan nuansa sweet', 'status' => 'Dibooking'],
                    ['id' => 2, 'nama' => 'Cozy', 'keterangan' => 'Bangunan Villa yang dibangun dengan nuansa Cozy', 'status' => 'Tersedia'],
                    ['id' => 3, 'nama' => 'Charming', 'keterangan' => 'Bangunan Villa yang dibangun dengan nuansa Charming', 'status' => 'Dibooking'],
                    ['id' => 4, 'nama' => 'Dreamy', 'keterangan' => 'Bangunan Villa yang dibangun dengan nuansa Dreamy', 'status' => 'Tersedia'],
                ];

                // Menampilkan data ke dalam tabel
                foreach ($data as $row) {
                    $statusClass = $row['status'] === 'Dibooking' ? 'status-dibooking' : 'status-tersedia';
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['keterangan']}</td>
                            <td class='{$statusClass}'>{$row['status']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
