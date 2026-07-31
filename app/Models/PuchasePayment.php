<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PuchasePayment extends Model
{
    use SoftDeletes;

    protected $table = 'puchase_payments';

    protected $fillable = [
        'MethodID',
        'PuchaseID',
        'TotalPayment',
        'PuchaseDate',
    ];

    protected $casts = [
        'PuchaseDate' => 'date',
        'TotalPayment' => 'float',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'MethodID');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'PuchaseID');
    }
}
