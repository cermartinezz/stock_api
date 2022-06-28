<?php

namespace App\Adapters;

use App\Models\StockHistory;
use Curl\Curl;
use Illuminate\Support\Str;

class StooqAdapter implements StockAdapter
{

    /**
     * @var mixed
     */
    private $stockData;

    public function __construct()
    {
        $this->url = 'https://stooq.com/q/l/?s=$code$&f=sd2t2ohlcvn&h&e=json';
    }

    public function getStock($code)
    {
        return $this->setUrl($code)
            ->fetchData()
            ->transformData();
    }

    private function setUrl($code)
    {
        $this->url = Str::replaceFirst('$code$', $code, $this->url);

        return $this;
    }

    private function fetchData(): StooqAdapter
    {
        $request = new Curl();

        $response = $request->get($this->url)->response;

        $market = json_decode($response);

        $this->stockData = $market->symbols[0];

        return $this;
    }

    private function transformData()
    {
        $stock = new StockHistory();

        $stock->symbol = $this->stockData->symbol;
        $stock->date = $this->stockData->date ?? '';
        $stock->name = $this->stockData->name ?? '';
        $stock->open = $this->stockData->open ?? '';
        $stock->high = $this->stockData->high ?? '';
        $stock->low = $this->stockData->low ?? '';
        $stock->close = $this->stockData->close ?? '';

        return $stock;
    }
}
