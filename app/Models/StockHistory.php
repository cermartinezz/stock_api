<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon $date
 * @property $name
 * @property $symbol
 * @property $open
 * @property $high
 * @property $low
 * @property $close
 * @property $stockExist
 * @property Carbon $created_at
 */
class StockHistory extends Model
{
    protected $table = 'stock_histories';
    protected $fillable = ['date','name','symbol','open','high','low','close'];
    protected $dates = ['date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toArray()
    {
        return [
            'date' => $this->date->toString(),
            'name' => $this->name,
            'symbol' => $this->symbol,
            'open' => $this->open,
            'high' => $this->high,
            'low' => $this->low,
            'close' => $this->close,
            'requested_at' => $this->created_at->toString()
        ];
    }


}
