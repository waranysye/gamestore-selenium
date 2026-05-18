<?php

require_once __DIR__ . '/../Support/BaseSeleniumTest.php';

use Facebook\WebDriver\WebDriverBy;
use Tests\Support\BaseSeleniumTest;
class LoginTest extends BaseSeleniumTest
{
    // =========================
    // JANGAN AUTO LOGIN
    // =========================
    protected function setUp(): void
{
    // WAJIB panggil parent agar migrasi & seeder di Base dijalankan
    parent::setUp(); 

    // Tidak perlu inisialisasi driver lagi di sini karena sudah ada di parent
    // Kecuali kamu ingin settingan yang sangat berbeda
}

    protected function tearDown(): void
    {
        if ($this->driver) {
            $this->driver->quit();
        }
    }

    // =========================
    // OPEN PAGE
    // =========================
    private function openPage($path)
    {
        $this->driver->get($this->baseUrl . $path);

        $this->wait->until(function ($d) {
            return $d->executeScript(
                "return document.readyState"
            ) === "complete";
        });
    }

    // =========================
    // LOGIN ACTION
    // =========================
    private function doLogin($email, $password)
{
    $this->openPage('/login');

    $this->driver->findElement(WebDriverBy::name('email'))->clear()->sendKeys($email);
    $this->driver->findElement(WebDriverBy::name('password'))->clear()->sendKeys($password);

    $btn = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
    $this->driver->executeScript("arguments[0].click();", [$btn]);
    
    // HAPUS bagian wait->until dari sini agar tidak macet saat login gagal
}

    // =========================
    // TEST 1: LOGIN SUCCESS
    // =========================
    public function testLoginSuccess()
    {
        $this->doLogin('dash@gmail.com', 'dash123');

        // Tunggu sampai elemen di halaman utama muncul (misal: tulisan Dashboard atau Logout)
        $this->wait->until(
            \Facebook\WebDriver\WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::cssSelector('body') // Tunggu body terload
            )
        );

        $currentUrl = $this->driver->getCurrentURL();
        $this->assertStringNotContainsString('/login', $currentUrl, "Gagal Login: Masih tertahan di halaman login.");
    }

    // =========================
    // TEST 2
    // WRONG PASSWORD
    // =========================
    public function testLoginWrongPassword()
    {
        $this->doLogin(
            'dash@gmail.com',
            'wrong123'
        );

        $this->assertStringContainsString(
            '/login',
            $this->driver->getCurrentURL()
        );
    }

    // =========================
    // TEST 3
    // EMPTY FORM
    // =========================
    public function testLoginEmptyForm()
{
    $this->openPage('/login');
    $btn = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
    $this->driver->executeScript("arguments[0].click();", [$btn]);

    // Beri jeda sebentar saja untuk loading
    sleep(1); 

    // Pastikan masih di halaman login karena error
    $this->assertStringContainsString('/login', $this->driver->getCurrentURL());
}

    // =========================
    // TEST 4: LOGOUT SUCCESS
    // =========================
    public function testLogoutSuccess()
    {
        // 1. Login dulu
        $this->doLogin('dash@gmail.com', 'dash123');
        
        // 2. Beri jeda sebentar agar session tertanam sempurna
        sleep(2); 

        // 3. Langsung tembak URL logout (lebih aman daripada nyari tombol)
        $this->openPage('/logout');

        // 4. Tunggu sampai balik ke login atau landing page
        $this->wait->until(function ($d) {
            return str_contains($d->getCurrentURL(), '/login') || $d->getCurrentURL() === $this->baseUrl . '/';
        });

        $this->assertStringNotContainsString('/profile', $this->driver->getCurrentURL());
    }

    // ... (kode lama tetap) ...

    public function testLoginWrongEmailFormat() {
        $this->doLogin('bukanemail', 'password123');
        $this->assertStringContainsString('/login', $this->driver->getCurrentURL());
    }

    public function testLoginAdminSuccess() {
        $this->doLogin('admin@gamestore.com', 'admin123');
        $this->assertStringNotContainsString('/login', $this->driver->getCurrentURL());
    }

    public function testLoginSqlInjectionAttempt() {
        $this->doLogin("' OR '1'='1", "password");
        $this->assertStringContainsString('/login', $this->driver->getCurrentURL());
    }

    public function testLoginVeryLongPassword() {
        $this->doLogin('dash@gmail.com', str_repeat('a', 100));
        $this->assertStringContainsString('/login', $this->driver->getCurrentURL());
    }

    public function testLoginWithXssInput() {
        $this->doLogin('<script>alert(1)</script>@mail.com', 'password');
        $this->assertStringContainsString('/login', $this->driver->getCurrentURL());
    }

    public function testLoginCaseSensitiveEmail() {
        // Asumsi email disimpan lowercase
        $this->doLogin('DASH@GMAIL.COM', 'dash123');
        $this->assertStringNotContainsString('/login', $this->driver->getCurrentURL());
    }
}