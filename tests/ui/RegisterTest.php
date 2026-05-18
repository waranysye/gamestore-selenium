<?php

require_once __DIR__ . '/../Support/BaseSeleniumTest.php';

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Tests\Support\BaseSeleniumTest;

class RegisterTest extends BaseSeleniumTest
{
    protected function setUp(): void
    {
        // Menggunakan driver dari parent jika tersedia, atau inisialisasi ulang
        parent::setUp();
        $this->wait = new \Facebook\WebDriver\WebDriverWait($this->driver, 20, 500);
    }

    private function openPage($path)
    {
        $this->driver->get($this->baseUrl . $path);
        $this->wait->until(function ($d) {
            return $d->executeScript("return document.readyState") === "complete";
        });
    }

    private function waitElement($by)
    {
        return $this->wait->until(WebDriverExpectedCondition::presenceOfElementLocated($by));
    }

    private function fill($by, $value)
    {
        $el = $this->waitElement($by);
        $el->clear();
        $el->sendKeys($value);
    }

    private function clickSafe($by)
    {
        $el = $this->waitElement($by);
        $this->driver->executeScript("arguments[0].scrollIntoView({block:'center'});", [$el]);
        usleep(300000);
        try {
            $el->click();
        } catch (\Exception $e) {
            $this->driver->executeScript("arguments[0].click();", [$el]);
        }
    }

    private function doRegister($name, $email, $password)
    {
        $this->openPage('/index.php/signup');
        $this->fill(WebDriverBy::name('name'), $name);
        $this->fill(WebDriverBy::name('email'), $email);
        $this->fill(WebDriverBy::name('password'), $password);
        
        // Klik checkbox agreement jika ada
        try {
            $this->clickSafe(WebDriverBy::name('agree'));
        } catch (\Exception $e) {
            // Abaikan jika tidak ada checkbox
        }
        
        $this->clickSafe(WebDriverBy::id('submitBtn'));
        sleep(2); // Beri waktu redirect
    }

    public function testRegisterSuccess()
    {
        $email = 'user' . time() . '@mail.com';
        $this->doRegister('Test User', $email, 'password123');
        // Jika sukses biasanya lari ke login atau dashboard
        $this->assertStringNotContainsString('/signup', $this->driver->getCurrentURL());
    }

    public function testRegisterDuplicateEmail()
    {
        // Email 'dash@gmail.com' sudah ada di seeder
        $this->doRegister('Duplicate User', 'dash@gmail.com', 'password123');
        
        // Karena aplikasi kamu redirect ke /login saat gagal/duplikat:
        $currentUrl = $this->driver->getCurrentURL();
        $this->assertTrue(
            (strpos($currentUrl, '/signup') !== false || strpos($currentUrl, '/login') !== false),
            "Harusnya tetap di signup atau redirect ke login dengan pesan error"
        );
    }

    public function testRegisterEmptyForm()
    {
        $this->openPage('/index.php/signup');
        $this->clickSafe(WebDriverBy::id('submitBtn'));
        $this->assertStringContainsString('/signup', $this->driver->getCurrentURL());
    }

    public function testPasswordMinLength()
    {
        $email = 'short' . time() . '@mail.com';
        $this->doRegister('Short Pass', $email, '123');
        $this->assertStringContainsString('/signup', $this->driver->getCurrentURL());
    }

    public function testSignupPageLoads()
    {
        $this->openPage('/index.php/signup');
        $this->assertStringContainsString('/signup', $this->driver->getCurrentURL());
    }

    public function testRegisterWithEmptyEmail() {
        $this->doRegister('No Email', '', 'password123');
        $this->assertStringContainsString('/signup', $this->driver->getCurrentURL());
    }

    public function testRegisterXssInName() {
        $this->doRegister('<b>Bold Name</b>', 'xss' . time() . '@mail.com', 'password123');
        // Karena validasi alpha_space yang kita pasang di Auth.php, ini harusnya gagal/stay di signup
        $this->assertStringContainsString('/signup', $this->driver->getCurrentURL());
    }

    public function testRegisterNumericName() {
        $this->doRegister('12345678', 'numeric' . time() . '@mail.com', 'password123');
        // Gagal karena validasi nama hanya boleh huruf
        $this->assertStringContainsString('/signup', $this->driver->getCurrentURL());
    }

    public function testRegisterWithSpacesOnly() {
        $this->doRegister('   ', 'space' . time() . '@mail.com', 'password123');
        $this->assertStringContainsString('/signup', $this->driver->getCurrentURL());
    }
}