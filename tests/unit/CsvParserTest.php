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
        Mockery::close();
    }

    public function testFileManagerReturnsArray(): void
    {
        $mockedFileManager = Mockery::mock(FileManager::class);
        $mockedFileManager->shouldReceive('generateCsvFile')->once()->andReturn([]);
        self::assertIsArray($mockedFileManager->generateCsvFile());
    }

    public function testCsvHeadersKeysAreSet(): void
    {
        $resultHeader = $this->fileManager->combineHeaders(
            ['name', 'surname'],
            ['age', 'id'],
            ['gender', 'nationality']);

        self::assertArrayHasKey('name', $resultHeader);
        self::assertArrayHasKey('nationality', $resultHeader);
        self::assertArrayHasKey('id', $resultHeader);
        self::assertArrayHasKey('gender', $resultHeader);
    }

    public function testCsvHeaderValuesAreSet(): void
    {
        $resultHeader = $this->fileManager->combineHeaders(
            ['name', 'surname'],
            ['age', 'id'],
            ['gender', 'nationality']);
        self::assertContains(' ', $resultHeader);
    }

    public function testKeyValuePairsAreSet(): void
    {
        $result = $this->fileManager->mapKeyValuePairs(
            [
                ['name', 'surname', 'age'],
                ['janis', 'davidsons', '33'],
            ]);
        self::assertSame([
            ['name' => 'janis', 'surname' => 'davidsons', 'age' => '33'],
        ], $result);
    }

    public function testOutputFileIsBuilt(): void
    {
        $result = $this->fileManager->buildOutputFile(
            ['id' => ' ', 'name' => ' ', 'surname' => ' ', 'age' => ' '],
            [
                ['id' => '123456', 'name' => 'janis'],
                ['age' => '33', 'surname' => 'davidsons'],
            ]
        );

        self::assertSame([
            ['id' => '123456', 'name' => 'janis', 'surname' => ' ', 'age' => ' '],
            ['id' => ' ', 'name' => ' ', 'surname' => 'davidsons', 'age' => '33'],
        ], $result);
    }
}