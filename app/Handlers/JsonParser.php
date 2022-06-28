<?php

namespace App\Handlers;


class JsonParser implements StockParser
{
    public function transform($response)
    {
        return json_decode($response)->symbols[0];
    }
}
