<?php

define('APPPATH', realpath(__DIR__ . '/../app') . DIRECTORY_SEPARATOR);
define('SYSTEMPATH', realpath(__DIR__ . '/../system') . DIRECTORY_SEPARATOR);
define('WRITEPATH', realpath(__DIR__ . '/../writable') . DIRECTORY_SEPARATOR);

require APPPATH . 'Config/Paths.php';
$paths = new Config\Paths();

require SYSTEMPATH . 'Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));