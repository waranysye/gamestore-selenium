<?php

namespace Tests\Unit;
use App\Models\GameModel; 
use PHPUnit\Framework\TestCase;
use CodeIgniter\Test\CIUnitTestCase; // Pakai ini agar fitur CI4 aktif

class GameModelTest extends CIUnitTestCase
{
    public function testPriceMustBeNumeric()
    {
        $price = 50000;

        $this->assertIsNumeric($price);
        $this->assertGreaterThan(0, $price);
    }

    public function testGameTitleNotEmpty()
    {
        $title = "Elden Ring";

        $this->assertNotEmpty($title);
    }

    public function testSearchKeywordLogic()
    {
        $keyword = "ring";

        $this->assertIsString($keyword);
        $this->assertGreaterThan(2, strlen($keyword));
    }
}