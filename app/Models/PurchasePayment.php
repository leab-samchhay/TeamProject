<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasePayment extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_payments';

    protected $fillable = [
        'MethodID',
        'PurchaseID',
        'TotalPayment',
        'PurchaseDate',
    ];

    protected $casts = [
        'PurchaseDate' => 'date',
        'TotalPayment' => 'float',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'MethodID');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'PurchaseID');
    }
}
