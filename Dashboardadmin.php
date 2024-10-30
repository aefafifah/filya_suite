<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filya Suite Progress</title>
    <!-- Menghubungkan CSS Bootstrap dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menghubungkan font Barlow dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Menghubungkan font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <!-- Menghubungkan ikon Bootstrap dari CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        /* Gaya umum untuk body */
        body {
            font-family: 'Arial', sans-serif; /* Mengatur font umum untuk halaman */
            background-color: #fafafa; /* Mengatur warna latar belakang */
        }

        /* Gaya untuk Sidebar */
        .sidebar {
            background-color: #FFFFFF; /* Mengatur warna latar belakang sidebar */
            height: 100vh; /* Mengatur tinggi sidebar sesuai tinggi viewport */
            padding: 20px; /* Memberikan padding di dalam sidebar */
        }

        .sidebar h3 {
            font-family: 'Poppins', sans-serif; /* Mengatur font untuk judul di sidebar */
            font-weight: bold; /* Mengatur ketebalan font */
            font-size: 36px; /* Mengatur ukuran font */
            color: #DD761C; /* Mengatur warna font menjadi putih */
            margin-bottom: 30px; /* Memberikan margin bawah untuk spasi */
        }

        .sidebar a {
            text-decoration: none; /* Menghapus garis bawah pada tautan */
            font-weight: bold; /* Mengatur ketebalan font pada tautan */
            display: block; /* Mengatur tautan sebagai blok */
            padding: 10px 0; /* Memberikan padding atas dan bawah */
            color: #DD761C; /* Mengatur warna font menjadi putih */
            transition: background 0.3s; /* Efek transisi saat hover */
            margin-bottom: 15px; /* Menambahkan margin untuk spasi antar tautan */
        }

        .sidebar a:hover {
            background-color: #ff9800; /* Mengatur warna latar belakang saat hover */
        }

        /* Gaya untuk area Dashboard dengan gambar latar belakang */
        .dashboard {
            background-image: url('blubrown.jpg'); /* Menentukan gambar latar belakang */
            background-size: cover; /* Menutupi seluruh area dengan gambar */
            background-position: center; /* Mengatur posisi gambar di tengah */
            background-repeat: no-repeat; /* Menghindari pengulangan gambar */
            padding: 50px; /* Memberikan padding di dalam dashboard */
            height: 100vh; /* Mengatur tinggi dashboard sesuai tinggi viewport */
            display: flex; /* Mengatur tampilan menggunakan flexbox */
            justify-content: center; /* Memusatkan konten secara horizontal */
            align-items: center; /* Memusatkan konten secara vertikal */
            position: relative; /* Menetapkan posisi relatif untuk elemen */
        }

        /* Layer semi-transparan di atas gambar latar belakang */
        .dashboard::before {
            content: ''; /* Konten kosong untuk layer */
            position: absolute; /* Menetapkan posisi absolut untuk layer */
            top: 0; left: 0; right: 0; bottom: 0; /* Menutupi seluruh area */
            background-color: #FDE49E; /* Mengatur warna latar belakang layer */
            opacity: 0.7; /* Mengatur transparansi layer */
            z-index: 1; /* Menempatkan layer di atas gambar latar */
        }

        /* Gaya untuk kartu utama */
        .main-card {
            background-color: white; /* Mengatur warna latar belakang kartu menjadi putih */
            border-radius: 10px; /* Memberikan sudut melengkung pada kartu */
            box-shadow: 10px 10px 0px 0px #F57C00; /* Menambahkan bayangan pada kartu */
            width: 500px; /* Mengatur lebar kartu */
            height: auto; /* Mengatur tinggi otomatis */
            display: flex; /* Mengatur tampilan menggunakan flexbox */
            flex-direction: column; /* Mengatur arah flex menjadi kolom */
            justify-content: space-between; /* Memberikan ruang antara konten */
            text-align: center; /* Mengatur perataan teks di tengah */
            padding: 20px; /* Memberikan padding di dalam kartu */
            position: relative; /* Menetapkan posisi relatif untuk kartu */
            z-index: 2; /* Menempatkan kartu di atas layer */
        }

        .main-card h2 {
            font-family: 'Barlow', sans-serif; /* Mengatur font untuk judul di kartu */
            font-size: 24px; /* Mengatur ukuran font */
            font-weight: 700; /* Mengatur ketebalan font */
            margin-bottom: 20px; /* Memberikan margin bawah untuk spasi */
        }

        /* Gaya untuk lingkaran progress */
        .circular-progress {
            position: relative; /* Menetapkan posisi relatif untuk lingkaran */
            width: 120px; /* Mengatur lebar lingkaran */
            height: 120px; /* Mengatur tinggi lingkaran */
            border-radius: 50%; /* Mengatur lingkaran dengan border-radius */
            background: conic-gradient(#5BA0A9 0% 80%, #745A5A 0%); /* Mengatur warna lingkaran */
            margin: 0 auto 20px; /* Mengatur margin untuk pusat dan spasi bawah */
        }

        .circular-progress.orange {
            background: conic-gradient( #FDE49E 0% 62%, #FEAF00 0%); /* Mengatur warna khusus untuk lingkaran dengan kelas orange */
        }

        .percentage {
            position: absolute; /* Menetapkan posisi absolut untuk persentase */
            top: 0; left: 0; /* Mengatur posisi ke sudut kiri atas */
            width: 100%; height: 100%; /* Mengatur lebar dan tinggi penuh */
            display: flex; /* Mengatur tampilan menggunakan flexbox */
            justify-content: center; /* Memusatkan konten secara horizontal */
            align-items: center; /* Memusatkan konten secara vertikal */
            font-family: 'Barlow', sans-serif; /* Mengatur font untuk persentase */
            font-size: 24px; /* Mengatur ukuran font */
            font-weight: 700; /* Mengatur ketebalan font */
            color: #333; /* Mengatur warna font untuk persentase */
        }

        /* Gaya khusus untuk tata letak 2x2 */
        .progress-row {
            display: flex; /* Mengatur tampilan menggunakan flexbox */
            justify-content: space-around; /* Memberikan ruang antar kolom */
            margin-bottom: 20px; /* Menambahkan margin bawah untuk spasi */
        }

        .progress-col {
            display: flex; /* Mengatur tampilan menggunakan flexbox */
            flex-direction: column; /* Mengatur arah flex menjadi kolom */
            align-items: center; /* Memusatkan konten secara horizontal */
            flex: 1; /* Mengatur flex item untuk mengambil ruang yang sama */
            margin: 0 10px; /* Menambahkan margin kiri dan kanan untuk spasi */
        }

        .progress-col.orange {
            flex: 1; /* Mengatur flex item dengan kelas orange untuk mengambil ruang yang sama */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h3>Halo Admin</h3>
                <!-- Tautan menu di sidebar -->
                <a href="#"><i class="bi bi-emoji-smile"></i> Data Laporan Kinerja</a>
                <a href="#"><i class="bi bi-easel2"></i> Data Laporan Fasilitas</a>
                <a href="#"><i class="bi bi-hand-thumbs-up"></i> Data Laporan Tempat</a>
                <a href="#"><i class="bi bi-person-circle"></i> Data Pegawai</a>
                <a href="#"><i class="bi bi-houses"></i> Data Villa</a>
            </div>

            <!-- Dashboard -->
            <div class="col-md-10 dashboard">
                <div class="main-card">
                    <h2>Filya Suite Progress</h2>
                    
                    <!-- Tata letak lingkaran progress -->
                    <div class="progress-row">
                        <div class="progress-col orange">
                            <div class="circular-progress">
                                <div class="percentage">80%</div> <!-- Menampilkan persentase -->
                            </div>
                            <p>Kinerja Pegawai</p> <!-- Keterangan untuk progress -->
                        </div>
                        <div class="progress-col">
                            <div class="circular-progress orange">
                                <div class="percentage">62%</div> <!-- Menampilkan persentase -->
                            </div>
                            <p>Fasilitas</p> <!-- Keterangan untuk progress -->
                        </div>
                    </div>

                    <div class="progress-row">
                        <div class="progress-col orange">
                            <div class="circular-progress">
                                <div class="percentage">80%</div> <!-- Menampilkan persentase -->
                            </div>
                            <p>Total Villa dipakai</p> <!-- Keterangan untuk progress -->
                        </div>
                        <div class="progress-col">
                            <div class="circular-progress orange">
                                <div class="percentage">62%</div> <!-- Menampilkan persentase -->
                            </div>
                            <p>Tempat</p> <!-- Keterangan untuk progress -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menghubungkan JS Bootstrap dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>