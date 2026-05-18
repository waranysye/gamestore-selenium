<?php

namespace Tests\Ui;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Tests\Support\BaseSeleniumTest;
use App\Models\UserModel; 

class ProfileTest extends BaseSeleniumTest
{
    // RESET DATABASE SETIAP SELESAI SATU TEST
    protected function tearDown(): void
    {
        $model = new UserModel();
        // Kembalikan email user 'dash' ke default agar tidak bentrok di test berikutnya
        $model->where('username', 'dash')->set(['email' => 'dash@gmail.com'])->update();
        parent::tearDown();
    }

    private function openProfile()
    {
        $this->loginUser('dash@gmail.com', 'dash123');
        $this->driver->get($this->baseUrl . '/index.php/profile');
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::name('email'))
        );
    }

    public function testUpdateEmailSuccess()
    {
        $this->markTestSkipped('Database consistency issue');
        $this->openProfile();
        $newEmail = 'fix' . rand(100, 999) . '@gmail.com'; 
        
        $emailField = $this->driver->findElement(WebDriverBy::name('email'));
        $emailField->clear();
        $emailField->sendKeys($newEmail);

        $saveBtn = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
        $this->driver->executeScript("arguments[0].click();", [$saveBtn]);

        sleep(2);

        // Verifikasi langsung menggunakan Query Builder (lebih akurat di testing)
        $db = \Config\Database::connect();
        $userInDb = $db->table('users')->where('username', 'dash')->get()->getRowArray();

        $this->assertNotNull($userInDb, "User 'dash' benar-benar hilang dari tabel users!");
        $this->assertEquals($newEmail, $userInDb['email']);

        // Kembalikan ke email semula agar loginUser() di test lain tidak pecah
        $db->table('users')->where('username', 'dash')->update(['email' => 'dash@gmail.com']);
    }

    public function testProfilePageLoads()
    {
        $this->openProfile();
        $this->assertStringContainsString('/profile', $this->driver->getCurrentURL());
    }

    public function testUpdatePasswordSuccess()
    {
        $this->openProfile();
        $this->driver->findElement(WebDriverBy::name('password'))->sendKeys('dash123');
        
        $saveBtn = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
        $this->driver->executeScript("arguments[0].click();", [$saveBtn]);
        
        sleep(2);
        // Jika tidak logout, berarti berhasil (tetap di profile atau dashboard)
        $this->assertStringNotContainsString('/login', $this->driver->getCurrentURL());
    }

    public function testLogoutFromProfile()
    {
        $this->openProfile();
        $logoutBtn = $this->driver->findElement(WebDriverBy::cssSelector('a[href*="logout"]'));
        $this->driver->executeScript("arguments[0].click();", [$logoutBtn]);
        
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::not(WebDriverExpectedCondition::urlContains('/profile'))
        );
        $this->assertStringContainsString('/login', $this->driver->getCurrentURL());
    }
}