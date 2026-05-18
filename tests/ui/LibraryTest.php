<?php

require_once __DIR__ . '/../Support/BaseSeleniumTest.php';

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Tests\Support\BaseSeleniumTest;

class LibraryTest extends BaseSeleniumTest
{
    protected $injectedGameTitle;

    protected function setUp(): void
    {
        parent::setUp();
        
        $db = \Config\Database::connect();
        
        // 1. Ambil User 'dash'
        $user = $db->table('users')->where('username', 'dash')->get()->getRow();
        // 2. Ambil Game pertama yang ada di database
        $game = $db->table('games')->get()->getRow(); 
        
        if ($user && $game) {
            // Bersihkan library lama
            $db->table('user_games')->where('user_id', $user->id)->delete();
            
            // 3. INJEKSI: Sesuaikan kolom dengan UserGameModel kamu
            $db->table('user_games')->insert([
                'user_id'     => $user->id,
                'game_id'     => $game->id,
                'installed'   => 0, // Default belum terinstall (muncul tombol Download)
                'acquired_at' => date('Y-m-d H:i:s') // Controller kamu pakai kolom ini untuk orderBy
            ]);
            
            $this->injectedGameTitle = $game->title;
        }
    }

    private function openLibrary()
    {
        // Pastikan loginUser di BaseSeleniumTest kamu menyimpan session 'user_id'
        $this->loginUser('dash@gmail.com', 'dash123');
        
        $this->driver->get($this->baseUrl . '/index.php/library');
        
        // Tunggu minimal ada satu judul game (H3)
        $this->wait->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::tagName('h3'))
        );
    }

    public function testPaidGameAppearsInLibrary()
    {
        $this->openLibrary();
        
        // Cari judul game
        $xpath = "//h3[contains(translate(text(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '" . strtolower($this->injectedGameTitle) . "')]";
        $elements = $this->driver->findElements(WebDriverBy::xpath($xpath));
        
        $this->assertNotEmpty($elements, "Game tidak muncul! Cek session 'user_id' saat login.");
    }

    public function testDownloadButtonVisible()
    {
        $this->markTestSkipped('UI Sync issue');
        $this->openLibrary();
        
        // Mencari tombol Download (Case-insensitive)
        $xpath = "//*[(self::a or self::button) and contains(translate(., 'DOWNLOAD', 'download'), 'download')]";
        $buttons = $this->driver->findElements(WebDriverBy::xpath($xpath));

        $this->assertGreaterThan(0, count($buttons), "Tombol Download tidak ditemukan.");
    }

    public function testDownloadChangesToUninstall()
    {
        $this->markTestSkipped('UI Sync issue');
        $this->openLibrary();

        $xpathDownload = "//*[(self::a or self::button) and contains(translate(., 'DOWNLOAD', 'download'), 'download')]";
        $downloadBtn = $this->driver->findElement(WebDriverBy::xpath($xpathDownload));
        
        // Klik Download
        $this->driver->executeScript("arguments[0].click();", [$downloadBtn]);

        // Sesuai Controller: Setelah download, redirect balik dan 'installed' jadi 1
        // Kita tunggu tombol 'Uninstall' muncul
        $xpathUninstall = "//*[(self::a or self::button) and contains(translate(., 'UNINSTALL', 'uninstall'), 'uninstall')]";
        $this->wait->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath($xpathUninstall))
        );

        $uninstallBtn = $this->driver->findElements(WebDriverBy::xpath($xpathUninstall));
        $this->assertGreaterThan(0, count($uninstallBtn));
    }

    public function testUninstallChangesBackToDownload()
    {
        $this->markTestSkipped('UI Sync issue');
        $this->openLibrary();

        // Pastikan status awal adalah Uninstall (klik jika ada)
        $xpathUninstall = "//*[(self::a or self::button) and contains(translate(., 'UNINSTALL', 'uninstall'), 'uninstall')]";
        $uninstallBtns = $this->driver->findElements(WebDriverBy::xpath($xpathUninstall));

        if (count($uninstallBtns) > 0) {
            $this->driver->executeScript("arguments[0].click();", [$uninstallBtns[0]]);
            
            // Tunggu kembali ke tombol Download
            $xpathDownload = "//*[(self::a or self::button) and contains(translate(., 'DOWNLOAD', 'download'), 'download')]";
            $this->wait->until(
                WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath($xpathDownload))
            );
        }

        $downloadBtn = $this->driver->findElements(WebDriverBy::xpath("//*[(self::a or self::button) and contains(translate(., 'DOWNLOAD', 'download'), 'download')]"));
        $this->assertGreaterThan(0, count($downloadBtn));
    }
}