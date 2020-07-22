<?php

namespace App\interfaces;

interface FileManagerInterface
{
    public function generateCsvFile(): array;

    public function combineHeaders(array ...$headers): array;

    public function mapKeyValuePairs(array $csvData): array;

    public function buildOutputFile(array $header, array ...$csvFileData): array;

}