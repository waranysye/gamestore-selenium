<?php

namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Database\Seeds\TestUserSeeder;

abstract class DatabaseTestCase extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $DBGroup = 'tests';
    protected $refresh = true;
    protected $namespace = 'App'; // Ensure it looks for App migrations

    // ✅ CI4 will automatically run this Seeder after migrating
    protected $seed = TestUserSeeder::class; 
}