<?php

use App\FileManager;

require_once __DIR__.'/vendor/autoload.php';

$fileManager = new FileManager();
$fileManager->generateCsvFile(
    config()->get('demo.input1'),
    config()->get('demo.input2'),
    config()->get('demo.input2'),
);