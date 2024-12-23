<?php

use PHPUnit\Framework\TestCase;

class TambahPegawaiTest extends TestCase
{
    private $mockDatabase;
    private $mockStmt;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock koneksi database (mysqli)
        $this->mockDatabase = $this->createMock(mysqli::class);

        // Mock prepared statement (mysqli_stmt)
        $this->mockStmt = $this->createMock(mysqli_stmt::class);
    }

    public function testTambahPegawaiBerhasil()
    {
        // Simulasi query berhasil
        $this->mockStmt->method('execute')->willReturn(true);

        // Mock koneksi database mengembalikan statement
        $this->mockDatabase
            ->method('prepare')
            ->willReturn($this->mockStmt);

        // Panggil fungsi pengujian
        $result = $this->tambahPegawai([
            'nama' => 'John Doe',
            'jabatan' => 'Resepsionis',
            'hari' => 'Senin',
            'waktu_shift' => '09:00',
            'tinggi' => 'sedang',
            'tubuh' => 'berisi',
            'kulit' => 'sawo matang',
            'rambut' => 'hitam',
        ]);

        // Verifikasi hasil
        $this->assertEquals(['status' => 'success'], $result);
    }

    public function testTambahPegawaiGagal()
    {
        // Simulasi query gagal
        $this->mockStmt->method('execute')->willReturn(false);

        // Mock koneksi database mengembalikan statement
        $this->mockDatabase
            ->method('prepare')
            ->willReturn($this->mockStmt);

        // Panggil fungsi pengujian
        $result = $this->tambahPegawai([
            'nama' => 'John Doe',
            'jabatan' => 'Resepsionis',
            'hari' => 'Senin',
            'waktu_shift' => '09:00',
            'tinggi' => 'sedang',
            'tubuh' => 'berisi',
            'kulit' => 'sawo matang',
            'rambut' => 'hitam',
        ]);

        // Verifikasi hasil
        $this->assertEquals(['status' => 'failed'], $result);
    }

    private function tambahPegawai($data)
    {
        // Simulasi query SQL
        $sql = "INSERT INTO pegawai (nama, jabatan, hari, waktu_shift, tinggi, tubuh, kulit, rambut) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mockDatabase->prepare($sql);
        $stmt->bind_param(
            'ssssssss',
            $data['nama'],
            $data['jabatan'],
            $data['hari'],
            $data['waktu_shift'],
            $data['tinggi'],
            $data['tubuh'],
            $data['kulit'],
            $data['rambut']
        );

        if ($stmt->execute()) {
            return ['status' => 'success'];
        }

        return ['status' => 'failed'];
    }
}
