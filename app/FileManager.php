<?php

declare(strict_types=1);

namespace App;

use App\interfaces\FileManagerInterface;

class FileManager implements FileManagerInterface
{
    public function generateCsvFile(string ...$csvFilesPath): array
    {
        $csvData = [];
        $headers = [];
        $csvOutputHeader = null;

        foreach ($csvFilesPath as $path) {
            $rawData = array_map('str_getcsv', file($path));
            var_dump($csvFilesPath);

            $csvData[] = $this->mapKeyValuePairs($rawData);
        }

        foreach ($csvData as $data) {
            foreach ($data as $value) {
                $headers[] = array_keys($value);
            }
        }
        $csvOutputHeader = $this->combineHeaders(...$headers);
        $csvOutputData = $this->buildOutputFile($csvOutputHeader, ...$csvData);
        $this->saveOutput($csvOutputHeader, $csvOutputData);

        return $csvOutputData;
    }

    public function combineHeaders(array ...$headers): array
    {
        $resultHeader = [];
        foreach ($headers as $header) {
            foreach ($header as $value) {
                if (!in_array($value, $resultHeader)) {
                    $resultHeader[$value] = " ";
                }
            }
        }

        return $resultHeader;
    }

    public function mapKeyValuePairs(array $csvData): array
    {
        $rawData = $csvData;
        $keys = $rawData[0];
        array_shift($rawData);
        $result = [];

        foreach ($rawData as $data) {
            $keyValuePairs = array_combine($keys, $data);
            $result[] = $keyValuePairs;
        }

        return $result;
    }

    public function buildOutputFile(array $header, array ...$csvFileData): array
    {
        $result = [];
        foreach ($csvFileData as $csvData) {
            foreach ($csvData as $record) {
                $output = [];
                foreach ($record as $key => $value) {
                    $output[$key] = $value;
                }
                $result[] = array_merge($header, $output);
            }
        }

        return $result;
    }

    private function saveOutput(array $header, array $data): void
    {
        $file = fopen(config()->get('output.path'), 'w');
        fputcsv($file, array_keys($header));
        foreach ($data as $value) {
            fputcsv($file, $value);
        }
        fclose($file);
    }
}