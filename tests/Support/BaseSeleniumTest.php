<?php


namespace Tests\Support; // Sesuaikan dengan nama folder 'Support' (S besar)
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;

abstract class BaseSeleniumTest extends TestCase
{
    protected $driver;
    protected $wait;
    protected $baseUrl = 'http://localhost:8082';

    // SLOW MODE: Biar kelihatan prosesnya saat demo/presentasi
    protected $slowMode = true;
    protected $slowDelay = 1200; 

    protected function setUp(): void
{
    parent::setUp();

    // Inisialisasi Database dan Migration
    $this->db = \Config\Database::connect('tests');
    $this->migrations = \Config\Services::migrations();
    $this->seeder = \Config\Database::seeder();

    // PERBAIKAN DI SINI: Jangan pakai refresh()
    // Kita kosongkan (regress) lalu jalankan lagi (latest)
    $this->migrations->setGroup('tests')->regress(0, 'tests');
    $this->migrations->setGroup('tests')->latest('tests');

    // Panggil Seeder dengan urutan yang benar
    $this->seeder->call('UserSeeder');
    $this->seeder->call('CategorySeeder');
    $this->seeder->call('GamesSeeder');
    $this->seeder->call('AdminSeeder');

    // Inisialisasi Selenium
    $this->driver = RemoteWebDriver::create(
        'http://localhost:9515',
        DesiredCapabilities::chrome()
    );

    $this->driver->manage()->window()->maximize();
    $this->wait = new WebDriverWait($this->driver, 10);
}

    protected function tearDown(): void
{
    if ($this->driver) {
        try {
            // Ambil screenshot jika gagal (seperti kode kamu sebelumnya)
            // Tapi bungkus dalam try-catch agar jika screenshot gagal, 
            // browser TETAP ditutup.
            if ($this->status()->isFailure() || $this->status()->isError()) {
                $this->takeScreenshotFailure();
            }
        } catch (\Exception $e) {
            // Abaikan error screenshot
        } finally {
            // INI KUNCINYA: Pastikan quit() dipanggil apapun yang terjadi
            $this->driver->quit();
        }
    }
}

    // =====================================
    // CORE ACTIONS
    // =====================================

    protected function open($path)
    {
        $this->driver->get($this->baseUrl . $path);
        $this->wait->until(function ($d) {
            return $d->executeScript("return document.readyState") === "complete";
        });
        $this->pause();
    }

    protected function click($by)
    {
        $this->wait->until(WebDriverExpectedCondition::presenceOfElementLocated($by));
        $el = $this->driver->findElement($by);
        
        $this->driver->executeScript("arguments[0].scrollIntoView({block:'center'});", [$el]);
        usleep(500000); // Tunggu scroll selesai

        try {
            $el->click();
        } catch (\Exception $e) {
            $this->driver->executeScript("arguments[0].click();", [$el]);
        }
        $this->pause();
    }

    protected function type($by, $text)
    {
        $el = $this->driver->findElement($by);
        $el->clear();
        $el->sendKeys($text);
        $this->pause(500); 
    }

    // =====================================
    // AUTH HELPERS
    // =====================================

    protected function loginUser($email, $password)
    {
        $this->driver->get($this->baseUrl . '/index.php/login');
        
        $emailField = $this->driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::name('email'))
        );
        $emailField->sendKeys($email);
        $this->driver->findElement(WebDriverBy::name('password'))->sendKeys($password);
        
        $submit = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
        $this->driver->executeScript("arguments[0].click();", [$submit]);

        // Tunggu sampai benar-benar masuk dashboard
        $this->driver->wait(15)->until(
            WebDriverExpectedCondition::not(WebDriverExpectedCondition::urlContains('/login'))
        );
    }

    protected function loginAdmin()
    {
        // Langsung panggil loginUser dengan kredensial admin
        $this->loginUser('admin@gamestore.com', 'admin123');
    }
    

    // =====================================
    // UTILS
    // =====================================

    protected function waitForUrlToChange($oldUrlPart)
    {
        $this->waitFor(function ($d) use ($oldUrlPart) {
            return !str_contains($d->getCurrentURL(), $oldUrlPart);
        });
    }

    protected function waitFor($callback, $timeout = 30)
    {
        $wait = new WebDriverWait($this->driver, $timeout, 500);
        return $wait->until($callback);
    }

    protected function pause($ms = null)
    {
        if (!$this->slowMode) return;
        $base = $ms ?? $this->slowDelay;
        usleep(($base + rand(100, 300)) * 1000);
    }

    protected function takeScreenshotFailure()
    {
        $filename = 'FAILED_' . $this->Name() . '_' . date('Y-m-d_H-i-s') . '.png';
        $path = __DIR__ . "/../report/screenshots/" . $filename;
        
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }
        
        $this->driver->takeScreenshot($path);
        fwrite(STDERR, "\n❌ Test Gagal! Screenshot disimpan di: tests/report/screenshots/$filename\n");
    }

    protected function step($message)
    {
        fwrite(STDERR, "\n👉 STEP: $message\n");
    }
}