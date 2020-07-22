<?php

use App\config\ConfigManager;
use App\config\CsvParserConfig;

function config(): ConfigManager
{
    return new CsvParserConfig();
}