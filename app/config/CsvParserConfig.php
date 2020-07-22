<?php

namespace App\config;

class CsvParserConfig implements ConfigManager
{
    public function get(string $name)
    {
        $config = [
            'demo.input1' => "./inputFiles/persons1.csv",
            'demo.input2' => "./inputFiles/persons2.csv",
            'demo.input3' => "./inputFiles/persons3.csv",
            'output.path' => "./output.csv",
        ];

        return $config[$name] ?? null;
    }
}