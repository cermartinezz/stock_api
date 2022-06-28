<?php

namespace App\Factories;

use App\Handlers\CsvParser;
use App\Handlers\JsonParser;

class StockParserFactory
{
    const VALID_FORMATS = [
        'csv' => CsvParser::class,
        'json' => JsonParser::class
    ];

    public static function make($format)
    {
         $class = self::VALID_FORMATS[$format];

         return new $class();
    }
}
