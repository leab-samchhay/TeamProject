<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;
    protected $table = 'purchases';

    protected $fillable = [
        'billno', 'purchaseDate', 'discount', 'totalAmount', 'status',
        'supplierId', 'userId',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplierId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function purchasePayments()
    {
        return $this->hasMany(PurchasePayment::class, 'PurchaseID');
    }
}
