<?php

namespace Tests\Unit;

use Tests\Support\DatabaseTestCase;
use App\Services\CheckoutService;

class CheckoutServiceTest extends DatabaseTestCase
{
    /**
     * @dataProvider taxProvider
     */
    public function testTaxCalculation($subtotal, $expectedTax)
    {
        $service = new CheckoutService();
        $this->assertEquals($expectedTax, $service->calculateTax($subtotal));
    }

    public function taxProvider()
    {
        return [
            'Nominal 100rb'   => [100000, 11000],
            'Nominal 50rb'    => [50000, 5500],
            'Nominal 1jt'     => [1000000, 110000],
            'Nominal 1.5jt'   => [1500000, 165000],
            'Game Murah 10rb' => [10000, 1100],
            'Gratis'          => [0, 0],
        ];
    }

    /**
     * @dataProvider grandTotalProvider
     */
    public function testGrandTotal($subtotal, $tax, $expectedGrandTotal)
    {
        $service = new CheckoutService();
        $total = $service->calculateGrandTotal($subtotal, $tax);
        $this->assertEquals($expectedGrandTotal, $total);
    }

    public function grandTotalProvider()
    {
        return [
            'Normal Checkout'  => [100000, 11000, 111000],
            'Small Checkout'   => [10000, 1100, 11100],
            'Large Checkout'   => [2000000, 220000, 2220000],
            'Zero Tax Scenario'=> [50000, 0, 50000],
            'Free Game'        => [0, 0, 0],
        ];
    }
}