<?php

use App\FileManager;

require_once __DIR__.'/vendor/autoload.php';

define("PERSONS1", __DIR__."/app/inputFiles/persons1.csv");
define("PERSONS2",  __DIR__."/app/inputFiles/persons2.csv");
define("PERSONS3",  __DIR__."/app/inputFiles/persons3.csv");

$fileManager = new FileManager();
$fileManager->generateCsvFile(PERSONS1, PERSONS2, PERSONS3);