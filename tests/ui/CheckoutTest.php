<?php

namespace Tests\Ui;

use Tests\Support\BaseSeleniumTest;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class CheckoutTest extends BaseSeleniumTest
{
    public function testCheckoutBuyNowToPendingStatus()
    {
        // 1. Login
        $this->login('dash@gmail.com', 'dash123');

        // 2. Ke halaman detail game (Gunakan ID yang pasti ada dari seeder)
        $this->driver->get($this->baseUrl . '/index.php/game/1');

        // 3. Ambil tombol Buy Now
        $buyNowBtn = $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.buy-now'))
        );

        // GUNAKAN JAVASCRIPT UNTUK KLIK (Lebih stabil untuk elemen yang dinamis)
        $this->driver->executeScript("arguments[0].click();", [$buyNowBtn]);

        // 4. Tunggu transisi ke halaman Checkout
        $this->driver->wait(15)->until(
            WebDriverExpectedCondition::urlContains('/checkout')
        );

        // 5. Klik Confirm Payment menggunakan Selector Form agar presisi
        $confirmBtn = $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('form[action*="confirm"] button, .btn'))
        );
        
        // Klik Konfirmasi
        $this->driver->executeScript("arguments[0].click();", [$confirmBtn]);

        // 6. Verifikasi Halaman Status Pembayaran
        $this->driver->wait(15)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('.payment-title'))
        );

        $statusTitle = $this->driver->findElement(WebDriverBy::cssSelector('.payment-title'))->getText();
        $this->assertMatchesRegularExpression('/(Waiting|Successful|Payment)/i', $statusTitle);
    }

    private function login($email, $password)
    {
        $this->driver->get($this->baseUrl . '/index.php/login');
        
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::name('email'))
        );

        $this->driver->findElement(WebDriverBy::name('email'))->sendKeys($email);
        $this->driver->findElement(WebDriverBy::name('password'))->sendKeys($password);
        
        $loginBtn = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
        $this->driver->executeScript("arguments[0].click();", [$loginBtn]);

        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::not(WebDriverExpectedCondition::urlContains('/login'))
        );
    }
}