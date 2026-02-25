<?php
// โหลด autoloader
require __DIR__ . '/../vendor/autoload.php';

// โหลด environment
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// โหลด config
$config = require __DIR__ . '/../app/Config/App.php';

// เริ่มต้นระบบด้วยศีล 5
$precepts = new Silpa5PHP\Core\FivePrecepts\PreceptEngine($config);
$precepts->validate();

// เริ่มต้นระบบด้วยวัตรบท 7
$vatthabot = new Silpa5PHP\Core\Vatthabot7\VatthabotEngine($config);
$vatthabot->initialize();
