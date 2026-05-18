<?php

namespace App\Services;

class CheckoutService
{
    public function calculateTax(int $subtotal, float $taxRate = 0.11): int
    {
        return (int) ($subtotal * $taxRate); // Pajak 11% (PPN)
    }

    public function calculateGrandTotal(int $subtotal, int $tax): int
    {
        return $subtotal + $tax;
    }
}