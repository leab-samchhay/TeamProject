<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class InvoiceDetail extends Model
// {
//     use SoftDeletes;
//     protected $table = 'invoice_details';
//     protected $fillable = [
//         'InvoiceID', 'ProductID', 'qty', 'price',
//         'cost', 'totalPay', 'discound',
//     ];

//     public function invoice()
//     {
//         return $this->belongsTo(Invoice::class, 'InvoiceID');
//     }

//     public function product()
//     {
//         return $this->belongsTo(Product::class, 'ProductID');
//     }
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model
{
    use SoftDeletes;

    protected $table = 'invoice_details';

    protected $fillable = [
        'InvoiceID',
        'ProductID',
        'qty',
        'price',
        'cost',
        'totalPay',
        'discount',
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'qty'      => 'integer',
        'price'    => 'float',
        'cost'     => 'float',
        'totalPay' => 'float',
        'discount' => 'float',
    ];

    // --- Relationships ---

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'InvoiceID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductID');
    }
}
