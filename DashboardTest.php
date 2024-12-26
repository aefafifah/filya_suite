<?php
use PHPUnit\Framework\TestCase;

class DashboardTest extends TestCase
{
    private $conn;

    // Mock mysqli connection
    protected function setUp(): void
    {
        $this->conn = $this->createMock(mysqli::class);
    }

    // Test for the logic of fetching the data from the database and generating chart data
    public function testVillaStatusData()
    {
        // Test data for villa status and counts
        $villaData = [
            ['status' => 'tersedia', 'jumlah' => 5],
            ['status' => 'tidak tersedia', 'jumlah' => 3]
        ];

        // Mocking the result of the query for villa status
        $villaResult = $this->createMock(mysqli_result::class);

        // We simulate the fetch_assoc method to return the predefined data
        $villaResult->method('fetch_assoc')
            ->willReturnOnConsecutiveCalls(
                $villaData[0], // First call returns 'tersedia' status
                $villaData[1], // Second call returns 'tidak tersedia' status
                null            // End of result set
            );

        // Mocking the query method to return the mock result set
        $this->conn->method('query')->willReturn($villaResult);

        // Simulate the actual logic of querying for villa data
        $sqlVilla = "SELECT status, COUNT(*) AS jumlah FROM villa GROUP BY status";
        $resultVilla = $this->conn->query($sqlVilla);

        // Initialize villa data in case no data is returned
        $data = [];
        $data['villa_tersedia'] = 0;
        $data['villa_tidak_tersedia'] = 0;

        // Loop through the result set and populate data array
        while ($row = $resultVilla->fetch_assoc()) {
            if ($row['status'] == 'tersedia') {
                $data['villa_tersedia'] = $row['jumlah'];
            } elseif ($row['status'] == 'tidak tersedia') {
                $data['villa_tidak_tersedia'] = $row['jumlah'];
            }
        }

        // Assertions to verify the data was correctly populated
        $this->assertArrayHasKey('villa_tersedia', $data);
        $this->assertArrayHasKey('villa_tidak_tersedia', $data);
        $this->assertEquals(5, $data['villa_tersedia']);
        $this->assertEquals(3, $data['villa_tidak_tersedia']);
    }

    // Test for the calculation of the chart data
    public function testChartDataCalculation()
    {
        // Sample data that would come from the database
        $data = [
            'kinerja' => 5,
            'tempat' => 3,
            'fasilitas' => 2,
            'villa_tersedia' => 7,
            'villa_tidak_tersedia' => 4
        ];

        $total = array_sum($data);

        // Check that the total is correctly calculated
        $this->assertEquals(21, $total);

        // Check chart percentage calculations and round to avoid precision issues
        $this->assertEquals(round(5 / 21 * 100, 2), round(($data['kinerja'] / $total) * 100, 2));
        $this->assertEquals(round(3 / 21 * 100, 2), round(($data['tempat'] / $total) * 100, 2));
        $this->assertEquals(round(2 / 21 * 100, 2), round(($data['fasilitas'] / $total) * 100, 2));
        $this->assertEquals(round(7 / 21 * 100, 2), round(($data['villa_tersedia'] / $total) * 100, 2));
        $this->assertEquals(round(4 / 21 * 100, 2), round(($data['villa_tidak_tersedia'] / $total) * 100, 2));
    }
}
?>
