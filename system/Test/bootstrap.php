<?php

use CodeIgniter\Boot;
use Config\Paths;

// Pastikan FCPATH didefinisikan (biasanya ke arah folder public)
define('FCPATH', __DIR__ . '/../public/');

// 1. Load file konfigurasi Paths
require __DIR__ . '/../app/Config/Paths.php';
$paths = new Paths();

// 2. Load sistem booting CodeIgniter
require __DIR__ . '/../system/Boot.php';

// 3. Jalankan boot khusus untuk testing
Boot::bootTest($paths);