<?php

namespace App\Adapters;

interface StockAdapter
{
    public function getStock($code);
}
