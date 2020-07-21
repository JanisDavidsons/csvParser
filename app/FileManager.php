<?php

declare(strict_types=1);

namespace App;

define("OUTPUT", "./app/outputFile/output.csv");

class FileManager
{
    public function generateCsvFile(string ...$csvFilesPath): array
    {
        $csvData = [];
        $headers = [];
        $csvOutputHeader = null;

        foreach ($csvFilesPath as $path) {
            $rawData = array_map('str_getcsv', file($path));
            $csvData[] = $this->mapKeyValuePairs($rawData[0], $rawData);
        }

        foreach ($csvData as $data) {
            $headers[] = array_shift($data);
        }

        $csvOutputHeader = $this->combineHeaders(...$headers);
        $csvOutputData = $this->buildOutputFile($csvOutputHeader, ...$csvData);

        $this->saveOutput($csvOutputHeader, $csvOutputData);

        return $csvOutputData;
    }

    private function combineHeaders(array ...$headers): array
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

    private function mapKeyValuePairs(array $header, array $csvData): array
    {
        $result = [];

        foreach ($csvData as $data) {
            $result[] = array_combine($header, $data);
        }

        return $result;
    }

    private function buildOutputFile(array $header, array ...$csvFileData): array
    {
        $result = [];

        foreach ($csvFileData as $csvData) {
            $data = $csvData;
            array_shift($data);

            foreach ($data as $record) {
                $output = [];
                foreach ($record as $key => $value) {
                    $output[$key] = $value;
                }
                $result[] = array_merge($header, $output);
            }
        }

        return $result;
    }

    private function saveOutput(array $header, array $data)
    {
        $file = fopen(OUTPUT, 'w');
        fputcsv($file, array_keys($header));
        foreach ($data as $value) {
            fputcsv($file, $value);
        }
        fclose($file);
    }
}