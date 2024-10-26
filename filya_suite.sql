-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 08:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filya_suite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `tanggal_progress` date NOT NULL,
  `status_laporan` enum('Diterima','Diproses','Ditolak','Selesai') NOT NULL,
  `bukti_progres` text DEFAULT NULL,
  `keterangan_progres` text DEFAULT NULL,
  `id_laporan` int(11) DEFAULT NULL,
  `waktu_update` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`tanggal_progress`, `status_laporan`, `bukti_progres`, `keterangan_progres`, `id_laporan`, `waktu_update`) VALUES
('2024-09-22', 'Ditolak', 'upload.img', 'lu ngarang ya bro', 1, '2024-09-22 16:21:10');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `nama_pengadu` varchar(255) NOT NULL,
  `no_telepon_pengadu` varchar(15) NOT NULL,
  `tanggal_menginap` date NOT NULL,
  `tanggal_melaporkan` date NOT NULL,
  `tempat_kerusakan` text NOT NULL,
  `jenis_masalah` enum('Wifi','Air Conditioner','Water Heater','Wastafel','Bed','Lainnya') NOT NULL,
  `deskripsi_masalah_fasilitas` text NOT NULL,
  `pilih_kategori_fasilitas` enum('Fasilitas yang dijanjikan tidak tersedia','Fasilitas tidak berfungsi','Kualitas fasilitas buruk','Lainnya') NOT NULL,
  `id_pengaduan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`nama_pengadu`, `no_telepon_pengadu`, `tanggal_menginap`, `tanggal_melaporkan`, `tempat_kerusakan`, `jenis_masalah`, `deskripsi_masalah_fasilitas`, `pilih_kategori_fasilitas`, `id_pengaduan`) VALUES
('filya ', '0800000111', '2024-09-04', '2024-09-21', 'kamar', 'Wastafel', 'wastafel macet brooo', 'Kualitas fasilitas buruk', 1),
('test', '0111111999', '2024-10-16', '2024-10-24', 'Kolam Renang', 'Wifi', 'ganyala lelet ', 'Fasilitas tidak berfungsi', 2),
('pass', '12345', '2024-10-18', '2024-10-26', 'Villa', 'Water Heater', 'ga anget', 'Fasilitas tidak berfungsi', 3),
('responsiii', '0000', '2024-10-18', '2024-10-19', 'Parkiran', 'Lainnya', 'Parkiran sempiiit ', 'Fasilitas yang dijanjikan tidak tersedia', 5),
('responsiii', '0000', '2024-10-09', '2024-10-12', 'Parkiran', 'Lainnya', 'Parkir ga luass blaaasss', 'Fasilitas yang dijanjikan tidak tersedia', 6);

-- --------------------------------------------------------

--
-- Table structure for table `kinerja`
--

CREATE TABLE `kinerja` (
  `id_pengaduan` int(11) NOT NULL,
  `nama_pengadu` varchar(255) NOT NULL,
  `no_telepon_pengadu` varchar(15) NOT NULL,
  `tanggal_menginap` date NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `nama_pegawai` varchar(255) NOT NULL,
  `jabatan_pegawai` enum('Resepsionis','House Keeper','Security') NOT NULL,
  `waktu_kejadian` datetime NOT NULL,
  `jenis_masalah` enum('Pelayanan Lambat','Sikap Tidak Profesional','Pelayanan Tidak Ramah','Sikap Karyawan Buruk','Pelayanan Tidak Memuaskan','Tidak Tersedia Saat Dibutuhkan','Lainnya') NOT NULL,
  `deskripsi_masalah` text NOT NULL,
  `file_bukti` varchar(255) DEFAULT NULL,
  `tinggi` enum('pendek','sedang','tinggi','sangat tinggi') NOT NULL,
  `tubuh` enum('kurus','sedang','berisi','gemuk') NOT NULL,
  `kulit` enum('cerah','sawo matang','gelap','sangat cerah','sangat gelap') NOT NULL,
  `rambut` varchar(50) NOT NULL,
  `wajah` enum('oval','bulat','persegi','lonjong','segitiga') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kinerja`
--

INSERT INTO `kinerja` (`id_pengaduan`, `nama_pengadu`, `no_telepon_pengadu`, `tanggal_menginap`, `id_pegawai`, `nama_pegawai`, `jabatan_pegawai`, `waktu_kejadian`, `jenis_masalah`, `deskripsi_masalah`, `file_bukti`, `tinggi`, `tubuh`, `kulit`, `rambut`, `wajah`) VALUES
(1, 'filya ', '0800000111', '2024-09-04', 1, 'budi ', 'House Keeper', '2024-09-04 16:18:35', 'Pelayanan Tidak Memuaskan', 'jutek banget namanya budi', 'upload.img', 'sedang', 'sedang', 'sawo matang', 'cepak', 'segitiga');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` enum('Resepsionis','House Keeper','Security') NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `waktu_shift` time NOT NULL,
  `tinggi` enum('pendek','sedang','tinggi','sangat tinggi') NOT NULL,
  `tubuh` enum('kurus','sedang','berisi','gemuk') NOT NULL,
  `kulit` enum('cerah','sawo matang','gelap','sangat cerah','sangat gelap') NOT NULL,
  `rambut` varchar(50) NOT NULL,
  `wajah` enum('oval','bulat','persegi','lonjong','segitiga') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama`, `jabatan`, `hari`, `waktu_shift`, `tinggi`, `tubuh`, `kulit`, `rambut`, `wajah`) VALUES
(1, 'budi ', 'House Keeper', 'Rabu', '08:15:06', 'sedang', 'sedang', 'sawo matang', 'cepak', 'segitiga');

-- --------------------------------------------------------

--
-- Table structure for table `tempat`
--

CREATE TABLE `tempat` (
  `id_pengaduan` int(11) NOT NULL,
  `nama_pengadu` varchar(255) NOT NULL,
  `no_telepon_pengadu` varchar(15) NOT NULL,
  `tanggal_menginap` date NOT NULL,
  `nomor_kamar` varchar(10) NOT NULL,
  `jenis_masalah` enum('Kerusakan Bangunan','Kebersihan Villa','Perawatan yang Kurang','Suasana Villa, Merasa Tidak Aman atau Lainnya','Perbedaan Kondisi Properti dengan Foto Properti di Iklan','Masalah Aksesibilitas','Kenyamanan pada Waktu Penginapan','Lainnya') NOT NULL,
  `deskripsi_masalah` text NOT NULL,
  `waktu_pengaduan` datetime DEFAULT current_timestamp(),
  `file_bukti` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tempat`
--

INSERT INTO `tempat` (`id_pengaduan`, `nama_pengadu`, `no_telepon_pengadu`, `tanggal_menginap`, `nomor_kamar`, `jenis_masalah`, `deskripsi_masalah`, `waktu_pengaduan`, `file_bukti`) VALUES
(1, 'filya ', '0800000111', '2024-09-04', '10A', 'Perawatan yang Kurang', 'kolam renangnya warna ijo ', '2024-09-21 16:14:54', 'upload.img ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `nama` varchar(255) NOT NULL,
  `nomor_telpon` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('admin','user') DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`nama`, `nomor_telpon`, `alamat`, `password`, `usertype`, `email`) VALUES
('filya ', '0800000111', '', 'password', 'admin', 'admin@filya.com'),
('filyaas', '11111111', 'filyaasuite', '$2y$10$ZCcHQmZl8cSATV0n2y05M.z.KweVDzqhmLxFv9tKyEo94piHyUz92', 'admin', 'filyasuite@admin.com'),
('fix', '7890', 'indo', '$2y$10$mCilX8mk3A3W.E7Nzagqnu3ba.k/1ArWmkrXIXhmjbOFCBx5cWNsC', 'user', 'fix@com'),
('pass', '12345', 'qwerty', '$2y$10$Q/sMfU4JPP7bYy9UWE.5ouceWzR8oz8wDQTSB7eeiKB8ofvrhGidO', 'user', 'pass@com'),
('responsi', '11111', 'bumi', '$2y$10$QJ5MTRajutx4ElbHVm2kQ.SXv4M7gP8DRPOzT/S/cRoo6C88z9uZK', 'user', 'responsi@gmail.com'),
('responsiii', '0000', 'bumi ', '$2y$10$R6QLVLlz8sRS3OTu8YoIf.xGl0CUBerK574I9WfnR4q89ZT2bF5Bq', 'user', 'responsii@gmail.com'),
('suite', '0999888666', 'bumi', 'password', 'user', ''),
('test', '0111111999', 'alamat', 'password', 'user', 'test@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `villa`
--

CREATE TABLE `villa` (
  `id` int(11) NOT NULL,
  `nama_villa` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('tersedia','tidak tersedia','dalam pemeliharaan') NOT NULL DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD KEY `fk_laporan` (`id_laporan`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD UNIQUE KEY `id_pengaduan` (`id_pengaduan`),
  ADD KEY `fk_namapengadu` (`nama_pengadu`),
  ADD KEY `fk_notelp` (`no_telepon_pengadu`);

--
-- Indexes for table `kinerja`
--
ALTER TABLE `kinerja`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `fk_nama` (`nama_pengadu`),
  ADD KEY `fk_no_telpon` (`no_telepon_pengadu`),
  ADD KEY `fk_jabatan` (`jabatan_pegawai`),
  ADD KEY `fk_tinggibadan` (`tinggi`),
  ADD KEY `fk_tubuh` (`tubuh`),
  ADD KEY `fk_rambut` (`rambut`),
  ADD KEY `fk_kulit` (`kulit`),
  ADD KEY `fk_wajah` (`wajah`),
  ADD KEY `fk_idpegawai` (`nama_pegawai`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD UNIQUE KEY `jabatan` (`jabatan`),
  ADD UNIQUE KEY `tinggi` (`tinggi`,`tubuh`,`kulit`,`rambut`,`wajah`),
  ADD UNIQUE KEY `tubuh` (`tubuh`),
  ADD UNIQUE KEY `rambut` (`rambut`),
  ADD UNIQUE KEY `kulit` (`kulit`),
  ADD UNIQUE KEY `wajah` (`wajah`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `tempat`
--
ALTER TABLE `tempat`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `fk_nama_pengadu` (`nama_pengadu`),
  ADD KEY `fk_notelpon` (`no_telepon_pengadu`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`nama`),
  ADD UNIQUE KEY `nomor_telpon` (`nomor_telpon`);

--
-- Indexes for table `villa`
--
ALTER TABLE `villa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_villa_id` (`nama_villa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kinerja`
--
ALTER TABLE `kinerja`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tempat`
--
ALTER TABLE `tempat`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `villa`
--
ALTER TABLE `villa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_laporan` FOREIGN KEY (`id_laporan`) REFERENCES `fasilitas` (`id_pengaduan`),
  ADD CONSTRAINT `fk_laporan_tempat` FOREIGN KEY (`id_laporan`) REFERENCES `tempat` (`id_pengaduan`),
  ADD CONSTRAINT `fk_laporanadu` FOREIGN KEY (`id_laporan`) REFERENCES `kinerja` (`id_pengaduan`);

--
-- Constraints for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD CONSTRAINT `fk_namapengadu` FOREIGN KEY (`nama_pengadu`) REFERENCES `users` (`nama`),
  ADD CONSTRAINT `fk_notelp` FOREIGN KEY (`no_telepon_pengadu`) REFERENCES `users` (`nomor_telpon`);

--
-- Constraints for table `kinerja`
--
ALTER TABLE `kinerja`
  ADD CONSTRAINT `fk_idpegawai` FOREIGN KEY (`nama_pegawai`) REFERENCES `pegawai` (`nama`),
  ADD CONSTRAINT `fk_jabatan` FOREIGN KEY (`jabatan_pegawai`) REFERENCES `pegawai` (`jabatan`),
  ADD CONSTRAINT `fk_kulit` FOREIGN KEY (`kulit`) REFERENCES `pegawai` (`kulit`),
  ADD CONSTRAINT `fk_nama` FOREIGN KEY (`nama_pengadu`) REFERENCES `users` (`nama`),
  ADD CONSTRAINT `fk_no_telpon` FOREIGN KEY (`no_telepon_pengadu`) REFERENCES `users` (`nomor_telpon`),
  ADD CONSTRAINT `fk_rambut` FOREIGN KEY (`rambut`) REFERENCES `pegawai` (`rambut`),
  ADD CONSTRAINT `fk_tinggibadan` FOREIGN KEY (`tinggi`) REFERENCES `pegawai` (`tinggi`),
  ADD CONSTRAINT `fk_tubuh` FOREIGN KEY (`tubuh`) REFERENCES `pegawai` (`tubuh`),
  ADD CONSTRAINT `fk_wajah` FOREIGN KEY (`wajah`) REFERENCES `pegawai` (`wajah`);

--
-- Constraints for table `tempat`
--
ALTER TABLE `tempat`
  ADD CONSTRAINT `fk_nama_pengadu` FOREIGN KEY (`nama_pengadu`) REFERENCES `users` (`nama`),
  ADD CONSTRAINT `fk_notelpon` FOREIGN KEY (`no_telepon_pengadu`) REFERENCES `users` (`nomor_telpon`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
