<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Database\Seeds\ExampleSeeder;
use Tests\Support\Models\ExampleModel;

final class ExampleDatabaseTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    // 1. Tambahkan ini agar tabel otomatis dibuat sebelum seeder berjalan
    protected $migrate     = true;
    protected $refresh     = true; // Memastikan database bersih setiap kali test
    protected $namespace   = 'App'; // Sesuaikan dengan namespace migration kamu

    protected $seed = ExampleSeeder::class;

    public function testModelFindAll(): void
    {
        $model = new ExampleModel();
        $objects = $model->findAll();

        $this->assertCount(3, $objects);
    }

    // tests/database/ExampleDatabaseTest.php

public function testDeleteActuallyRemovesRow(): void
{
    $model = new ExampleModel();
    
    $object = $model->first();
    $model->delete($object->id);

    // Pastikan data sudah tidak bisa ditemukan oleh model
    $this->assertNull($model->find($object->id));

    // Pastikan data benar-benar hilang dari database (size 0)
    $result = $model->builder()->where('id', $object->id)->get()->getResult();
    $this->assertCount(0, $result); // 👈 Ubah jadi 0 karena datanya memang hilang permanen
}
}