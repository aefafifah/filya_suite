<?php

use PHPUnit\Framework\TestCase;

class FasilitasTest extends TestCase
{
    protected $mysqli;

    protected function setUp(): void
    {
        session_start();
   
        $_SESSION['nama'] = 'Test User';
        $_SESSION['nomor_telpon'] = '081234567890';
    
        $this->mysqli = new mysqli("localhost", "root", "", "filya_suite");
    
        if ($this->mysqli->connect_error) {
            die("Koneksi gagal: " . $this->mysqli->connect_error);
        }
    
        
        $this->mysqli->query("
            INSERT INTO users (nama, email, password, nomor_telpon)
            VALUES ('Test User', 'testuser@example.com', 'password123', '081234567890')
            ON DUPLICATE KEY UPDATE email=email
        ");
    }
    

    protected function tearDown(): void
    {
      
        $this->mysqli->close();

        
        session_unset();
        session_destroy();
    }

    public function testInsertFasilitas()
{
 
    $namaPengadu = $_SESSION['nama'];
    $noTeleponPengadu = $_SESSION['nomor_telpon'];

    $stmt = $this->mysqli->prepare("
        INSERT INTO fasilitas 
        (nama_pengadu, no_telepon_pengadu, tanggal_menginap, tanggal_melaporkan, tempat_kerusakan, jenis_masalah, deskripsi_masalah_fasilitas, pilih_kategori_fasilitas, bukti_gambar) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $tanggalMenginap = "2024-12-01";
    $tanggalMelaporkan = "2024-12-02";
    $tempatKerusakan = "Kamar 101";
    $jenisMasalah = "Wifi";
    $deskripsiMasalah = "Internet tidak berfungsi";
    $pilihKategori = "Fasilitas tidak berfungsi";
    $buktiGambar = "uploads/test-image.jpg";

    $stmt->bind_param("sssssssss", $namaPengadu, $noTeleponPengadu, $tanggalMenginap, $tanggalMelaporkan, $tempatKerusakan, $jenisMasalah, $deskripsiMasalah, $pilihKategori, $buktiGambar);

    $this->assertTrue($stmt->execute(), "Insert ke tabel fasilitas gagal");
    $stmt->close();

    // Verifikasi data di database
    $result = $this->mysqli->query("SELECT * FROM fasilitas WHERE nama_pengadu = 'Test User' AND tempat_kerusakan = 'Kamar 101'");
    $this->assertEquals(1, $result->num_rows, "Data tidak ditemukan di tabel fasilitas");

    $data = $result->fetch_assoc();
    $this->assertEquals("Test User", $data['nama_pengadu']);
    $this->assertEquals("081234567890", $data['no_telepon_pengadu']);
}

}
