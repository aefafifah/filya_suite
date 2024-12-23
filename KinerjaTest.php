<?php

use PHPUnit\Framework\TestCase;

class KinerjaTest extends TestCase
{
    private $mockDatabase;
    private $mockStmt;
    private $mockResult;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock koneksi database (mysqli)
        $this->mockDatabase = $this->createMock(mysqli::class);

        // Mock prepared statement (mysqli_stmt)
        $this->mockStmt = $this->createMock(mysqli_stmt::class);

        // Mock result set (mysqli_result)
        $this->mockResult = $this->createMock(mysqli_result::class);
    }

    public function testLaporanKinerjaBerhasil()
    {
        // Simulasi query berhasil
        $this->mockStmt->method('execute')->willReturn(true);
        $this->mockStmt->method('get_result')->willReturn($this->mockResult);

        // Mock koneksi database mengembalikan statement
        $this->mockDatabase
            ->method('prepare')
            ->willReturn($this->mockStmt);

        // Panggil fungsi pengujian
        $result = $this->laporKinerja([
            'nama_pengadu' => 'John Doe',
            'tanggal_melaporkan' => '2024-12-25',
            'nomor_telpon' => '081234567890',
            'tanggal_menginap' => '2024-12-24',
            'deskripsi_masalah' => 'Masalah layanan',
            'jenis_masalah' => 'Pelayanan Tidak Memuaskan',
            'ciri_ciri' => 'sedang, berisi, sawo matang, hitam, oval',
            'file_bukti' => 'path/to/image.jpg'
        ]);

        // Verifikasi hasil
        $this->assertEquals(['status' => 'success'], $result);
    }

    public function testLaporanKinerjaGagal()
    {
        // Simulasi query gagal
        $this->mockStmt->method('execute')->willReturn(false);
        $this->mockStmt->method('get_result')->willReturn(false);

        // Mock koneksi database mengembalikan statement
        $this->mockDatabase
            ->method('prepare')
            ->willReturn($this->mockStmt);

        // Panggil fungsi pengujian
        $result = $this->laporKinerja([
            'nama_pengadu' => 'John Doe',
            'tanggal_melaporkan' => '2024-12-25',
            'nomor_telpon' => '081234567890',
            'tanggal_menginap' => '2024-12-24',
            'deskripsi_masalah' => 'Masalah layanan',
            'jenis_masalah' => 'Pelayanan Tidak Memuaskan',
            'ciri_ciri' => 'sedang, berisi, sawo matang, hitam, oval',
            'file_bukti' => 'path/to/image.jpg'
        ]);

        // Verifikasi hasil
        $this->assertEquals(['status' => 'failed'], $result);
    }

    private function laporKinerja($data)
    {
        // Simulasi pemisahan ciri-ciri
        list($tinggi, $tubuh, $kulit, $rambut, $wajah) = explode(", ", $data['ciri_ciri']);

        // Simulasi query SQL
        $sql = "INSERT INTO kinerja (nama_pengadu, tanggal_melapor, no_telepon_pengadu, tanggal_menginap, deskripsi_masalah, jenis_masalah, tinggi, tubuh, kulit, rambut, wajah, file_bukti) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mockDatabase->prepare($sql);
        $stmt->bind_param(
            'ssssssssssss',
            $data['nama_pengadu'],
            $data['tanggal_melaporkan'],
            $data['nomor_telpon'],
            $data['tanggal_menginap'],
            $data['deskripsi_masalah'],
            $data['jenis_masalah'],
            $tinggi,
            $tubuh,
            $kulit,
            $rambut,
            $wajah,
            $data['file_bukti']
        );

        if ($stmt->execute()) {
            return ['status' => 'success'];
        }

        return ['status' => 'failed'];
    }
}
