<?php

namespace App\Handlers;

class CsvParser implements StockParser
{
    public function transform($response): object
    {
        $data = parse_csv($response);
        $stockData = $this->parseData($data);
        return (object) $stockData;
    }

    private function parseData(array $data)
    {
        $keys = array_map('strtolower', $data[0]);
        $value = $data[1];

        return array_combine($keys, $value);
    }
}
