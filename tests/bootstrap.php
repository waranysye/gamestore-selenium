<?php

declare(strict_types=1);

define('ROOTPATH', realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR);
defined('ENVIRONMENT') || define('ENVIRONMENT', 'testing');
define('FCPATH', ROOTPATH . 'public' . DIRECTORY_SEPARATOR);

require_once ROOTPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();

define('APPPATH', realpath($paths->appDirectory) . DIRECTORY_SEPARATOR);
define('SYSTEMPATH', realpath($paths->systemDirectory) . DIRECTORY_SEPARATOR);
define('WRITEPATH', realpath($paths->writableDirectory) . DIRECTORY_SEPARATOR);
define('TESTPATH', realpath($paths->testsDirectory) . DIRECTORY_SEPARATOR);

// DEFINTSIKAN INI UNTUK MENGHILANGKAN ERROR SUPPORTPATH
define('SUPPORTPATH', TESTPATH . '_support' . DIRECTORY_SEPARATOR);

require_once ROOTPATH . 'vendor/autoload.php';

if (file_exists(SYSTEMPATH . 'Common.php')) {
    require_once SYSTEMPATH . 'Common.php';
}

require_once SYSTEMPATH . 'Boot.php';
CodeIgniter\Boot::bootTest($paths);