<?php

namespace App\config;

interface ConfigManager
{
    public function get(string $name);
}