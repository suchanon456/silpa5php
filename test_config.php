<?php
require 'vendor/autoload.php';
$config = require 'app/Config/App.php';
echo "App.php loaded successfully!\n";
echo "Base URL: " . $config->baseURL . "\n";
?>
