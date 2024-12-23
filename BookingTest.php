<?php

use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    private $mockDatabase;
    private $mockStmt; 
  
    protected function setUp(): void
    {
        parent::setUp();

        
        $this->mockDatabase = $this->createMock(mysqli::class);

      
        $this->mockStmt = $this->createMock(mysqli_stmt::class);
    }

    public function testVillaNotFound()
    {
        
        $this->mockStmt->method('execute')->willReturn(true);
        $this->mockStmt->method('get_result')->willReturn(false);

        $result = $this->checkAvailability('NonExistingVilla', '2024-12-25', '2024-12-30', 2);
        $this->assertEquals(['status' => 'villa_not_found'], $result);
    }

    public function testQuotaNotEnough()
    {
        
        $this->mockStmt->method('execute')->willReturn(true);
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_assoc')->willReturn([
            'available_quota' => 1 
        ]);
        $this->mockStmt->method('get_result')->willReturn($mockResult);

        $result = $this->checkAvailability('Dreamy', '2024-12-25', '2024-12-30', 2);
        $this->assertEquals(['status' => 'quota_not_enough'], $result);
    }

    public function testVillaAvailable()
    {
        // Mocking the query result for "Villa Tersedia"
        $this->mockStmt->method('execute')->willReturn(true);
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_assoc')->willReturn([
            'available_quota' => 5 // Available quota is sufficient
        ]);
        $this->mockStmt->method('get_result')->willReturn($mockResult);

        $result = $this->checkAvailability('Dreamy', '2024-12-25', '2024-12-30', 2);
        $this->assertEquals(['status' => 'success'], $result);
    }

    private function checkAvailability($villaName, $checkinDate, $checkoutDate, $guestCount)
    {
        
        $sql = "SELECT available_quota FROM villas WHERE name = ? AND checkin_date <= ? AND checkout_date >= ?";
        $this->mockStmt->prepare($sql);
        $this->mockStmt->bind_param('sss', $villaName, $checkinDate, $checkoutDate);
        $this->mockStmt->execute();
        $result = $this->mockStmt->get_result();

        if (!$result) {
            return ['status' => 'villa_not_found'];
        }

        $villaData = $result->fetch_assoc();
        if ($villaData['available_quota'] < $guestCount) {
            return ['status' => 'quota_not_enough'];
        }

        return ['status' => 'success'];
    }
}
