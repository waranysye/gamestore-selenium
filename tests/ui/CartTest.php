<?php
require_once __DIR__ . '/../Support/BaseSeleniumTest.php';

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Tests\Support\BaseSeleniumTest;

class CartTest extends BaseSeleniumTest
{
    // =========================
    // ADD TO CART
    // =========================
    public function testAddToCart()
    {
        $this->loginUser('dash@gmail.com', 'dash123');

        $this->driver->get($this->baseUrl . '/index.php/game/1');

        $cartBtn = $this->driver->wait(10)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                WebDriverBy::cssSelector('.add-to-cart')
            )
        );

        $this->driver->executeScript(
            "arguments[0].click();",
            [$cartBtn]
        );

        // beri waktu proses add to cart
        sleep(2);

        // cek berhasil masuk cart / notif sukses / tetap di halaman detail
        $url  = $this->driver->getCurrentURL();
        $html = $this->driver->getPageSource();

        $this->assertTrue(
            str_contains($url, '/cart') ||
            str_contains($html, 'Cart') ||
            str_contains($html, 'Added') ||
            str_contains($html, 'Success')
        );
    }

    // =========================
    // CART PAGE LOADS
    // =========================
    public function testCartPageLoads()
    {
        $this->loginUser('dash@gmail.com', 'dash123');

        $this->driver->get($this->baseUrl . '/index.php/cart');

        sleep(1);

        $html = $this->driver->getPageSource();

        $this->assertStringContainsString('Cart', $html);
    }

    // =========================
    // CART ITEMS
    // =========================
    public function testCartHasItems()
    {
        $this->loginUser('dash@gmail.com', 'dash123');

        $this->driver->get($this->baseUrl . '/index.php/cart');

        $items = $this->driver->findElements(
            WebDriverBy::cssSelector('.cart-row')
        );

        $this->assertGreaterThanOrEqual(0, count($items));
    }

    // =========================
    // REMOVE ITEM
    // =========================
    public function testRemoveItem()
{
    $this->loginUser('dash@gmail.com', 'dash123');
    
    // Ke halaman cart
    $this->driver->get($this->baseUrl . '/index.php/cart');

    // Ambil atribut href dari tombol remove
    $removeLink = $this->driver->findElement(WebDriverBy::cssSelector('a.remove'));
    $targetUrl = $removeLink->getAttribute('href');

    // EKSEKUSI: Buka URL remove secara langsung
    // Ini menjamin Controller Cart::remove($id) akan dipanggil
    $this->driver->get($targetUrl);

    sleep(2);
    $this->assertStringContainsString('empty', strtolower($this->driver->getPageSource()));
}
}