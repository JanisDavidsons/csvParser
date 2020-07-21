<?php

use App\FileManager;
use PHPUnit\Framework\TestCase;

class fileManagerTest extends TestCase
{
    private ?FileManager $fileManager;

    public function setUp(): void
    {
        $this->fileManager = new FileManager();
    }

    public function tearDown(): void
    {
        $this->fileManager = null;
    }

    public function testFileManagerReturnsArray(): void
    {
        $resultArray = $this->fileManager->generateCsvFile("./app/inputFiles/persons1.csv");
        self::assertIsArray($resultArray);
    }
}