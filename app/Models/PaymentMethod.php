<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;

    protected $table = 'payment_methods';

    protected $fillable = [
        'MethodName',
        'Status',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'MethodID');
    }

    public function purchasePayments()
    {
        return $this->hasMany(PurchasePayment::class, 'MethodID');
    }
}
