<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exchange extends Model
{
    use SoftDeletes;

    protected $table = 'exchanges';

    protected $fillable = [
        'rate',
        'date',
        'status',
        'from_currency_id',
        'to_currency_id',
    ];

    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency_id', 'id');
    }

    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency_id', 'id');
    }
}
