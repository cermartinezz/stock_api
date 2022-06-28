<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property $date
 * @property $name
 * @property $symbol
 * @property $open
 * @property $high
 * @property $low
 * @property $close
 * @property $stockExist
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
}
