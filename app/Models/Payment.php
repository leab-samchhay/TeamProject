<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $table = 'payments';

    protected $fillable = [
        'MethodID',
        'InvoiceID',
        'TotalPayment',
        'PaymentDate',
    ];

    protected $casts = [
        'PaymentDate' => 'date',
        'TotalPayment' => 'float',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'MethodID');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'InvoiceID');
    }
}
