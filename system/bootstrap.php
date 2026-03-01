<?php
// Define base constants
if (!defined('BASEPATH')) {
    define('BASEPATH', __DIR__ . DIRECTORY_SEPARATOR);
}

if (!defined('APPPATH')) {
    define('APPPATH', __DIR__ . '/../app' . DIRECTORY_SEPARATOR);
}

if (!defined('WRITEPATH')) {
    define('WRITEPATH', __DIR__ . '/../writable' . DIRECTORY_SEPARATOR);
}

if (!defined('APP_NAMESPACE')) {
    define('APP_NAMESPACE', 'App');
}

if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', $_ENV['CI_ENVIRONMENT'] ?? 'development');
}

// โหลด autoloader
require __DIR__ . '/../vendor/autoload.php';

// โหลด environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// โหลด config
require __DIR__ . '/../app/Config/App.php';
$config = new Config\App();

// เริ่มต้นระบบด้วยศีล 5
$precepts = new Silpa5PHP\Core\FivePrecepts\PreceptEngine($config);
$precepts->validate();

// เริ่มต้นระบบด้วยวัตรบท 7
$vatthabot = new Silpa5PHP\Core\Vatthabot7\VatthabotEngine($config);
$vatthabot->initialize();