<?php

namespace App\Handlers;

interface StockParser
{
    public function transform($response);
}
