<?php

namespace App\Services;

class CartService
{
    public function calculateTotal(array $cartItems): int
    {
        $total = 0;
        foreach ($cartItems as $item) {
            // Menyesuaikan dengan kolom 'price' dari database
            $price = isset($item['price']) ? (int)$item['price'] : 0;
            $total += $price;
        }
        return $total;
    }

    public function formatRupiah(int $amount): string
    {
        return "Rp " . number_format($amount, 0, ',', '.');
    }
}