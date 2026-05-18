<?php

namespace Tests\Unit;

use Tests\Support\DatabaseTestCase;
use App\Services\CartService; // WAJIB: Panggil class service aslinya

class CartServiceTest extends DatabaseTestCase
{
    /**
     * Mengetes fungsi hitung total di CartService
     */
    public function testCalculateTotal()
    {
        $service = new CartService();
        
        // Simulasi data item dari database/model
        $items = [
            ['price' => 50000],
            ['price' => 150000]
        ];

        $total = $service->calculateTotal($items);

        // Memastikan hasil perhitungan benar
        $this->assertEquals(200000, $total);
    }

    /**
     * Mengetes fungsi format mata uang di CartService
     */
    public function testFormatRupiah()
    {
        $service = new CartService();
        
        $formatted = $service->formatRupiah(100000);

        $this->assertEquals("Rp 100.000", $formatted);
    }
}