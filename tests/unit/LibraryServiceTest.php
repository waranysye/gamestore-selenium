<?php

namespace Tests\Unit;

use Tests\Support\DatabaseTestCase;
use App\Services\LibraryService;

class LibraryServiceTest extends DatabaseTestCase
{
    public function testCanDownload()
    {
        $service = new LibraryService();

        $this->assertTrue($service->canDownload('completed'));
        $this->assertFalse($service->canDownload('pending'));
    }

    public function testFormatGameSize()
    {
        $service = new LibraryService();
        $sizeInBytes = 2147483648; // 2 GB

        $formatted = $service->formatGameSize($sizeInBytes);

        $this->assertEquals("2 GB", $formatted);
    }

    // ===============================
    // TEST TAMBAHAN
    // ===============================

    public function testCannotDownloadFailedPayment()
    {
        $service = new LibraryService();

        $this->assertFalse($service->canDownload('failed'));
    }

    public function testCannotDownloadCancelledPayment()
    {
        $service = new LibraryService();

        $this->assertFalse($service->canDownload('cancelled'));
    }

    public function testCanDownloadUppercaseCompleted()
    {
        $service = new LibraryService();

        $this->assertFalse($service->canDownload('COMPLETED'));
    }

    public function testFormatZeroSize()
    {
        $service = new LibraryService();

        $formatted = $service->formatGameSize(0);

        $this->assertEquals("0 GB", $formatted);
    }

    public function testFormatOneGb()
    {
        $service = new LibraryService();

        $formatted = $service->formatGameSize(1073741824);

        $this->assertEquals("1 GB", $formatted);
    }

    public function testFormatThreeGb()
    {
        $service = new LibraryService();

        $formatted = $service->formatGameSize(3221225472);

        $this->assertEquals("3 GB", $formatted);
    }

    public function testFormatRoundedDown()
    {
        $service = new LibraryService();

        $formatted = $service->formatGameSize(2500000000);

        $this->assertNotEmpty($formatted);
    }

    public function testServiceCanBeInstantiated()
    {
        $service = new LibraryService();

        $this->assertInstanceOf(LibraryService::class, $service);
    }
}