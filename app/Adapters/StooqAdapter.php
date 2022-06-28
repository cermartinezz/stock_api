<?php

namespace App\Adapters;

use App\Factories\StockParserFactory;
use App\Models\StockHistory;
use Curl\Curl;
use Illuminate\Support\Str;

class StooqAdapter implements StockAdapter
{

    /**
     * @var mixed
     */
    private $stockData;
    private $validFormats;
    private string|null|false $response;
    private mixed $parser;

    public function __construct()
    {
        $this->url = 'https://stooq.com/q/l/?s=$code$&f=sd2t2ohlcvn&h&e=';
        $this->validFormats = ['json', 'csv'];
    }

    public function getStock($code, $format = 'json')
    {
        return $this->setUrl($code)
            ->setFormat($format)
            ->setHandler($format)
            ->fetchData()
            ->transformData();
    }

    private function setUrl($code): StooqAdapter
    {
        $this->url = Str::replaceFirst('$code$', $code, $this->url);

        return $this;
    }

    private function setHandler(mixed $format): StooqAdapter
    {
        $this->parser = StockParserFactory::make($format);

        return $this;
    }

    private function fetchData(): StooqAdapter
    {
        $request = new Curl();

        $this->response = $request->get($this->url)->response;

        return $this;
    }

    private function transformData(): StockHistory
    {
        $this->stockData = $this->parser->transform($this->response);

        return $this->createStock($this->stockData);

    }

    private function setFormat(mixed $format): StooqAdapter
    {
        $isValid = $this->validateFormat($format);

        throw_when(!$isValid, "Format not valid", \Exception::class);

        $this->url .= $format;

        return $this;
    }

    private function validateFormat(mixed $format): bool
    {
        return in_array($format, $this->validFormats);
    }

    private function createStock(mixed $stockData): StockHistory
    {
        $stock = new StockHistory();

        $stock->symbol = $stockData->symbol;
        if(isset($stockData->date) && $stockData->date != 'N/D'){
            $stock->date = $stockData->date . " " . $stockData->time;
        }
        $stock->name = $stockData->name ?? '';
        $stock->open = $stockData->open ?? '';
        $stock->high = $stockData->high ?? '';
        $stock->low = $stockData->low ?? '';
        $stock->close = $stockData->close ?? '';

        return $stock;
    }


}
