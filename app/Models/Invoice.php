<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class Invoice extends Model
// {
//     use SoftDeletes;

//     protected $fillable = [
//         'invoiceDate', 'discound', 'total', 'status',
//         'CustomerID', 'UserID', 'ExchangeID',
//     ];

//     public function customer()
//     {
//         return $this->belongsTo(Customer::class, 'CustomerID');
//     }

//     public function user()
//     {
//         return $this->belongsTo(User::class, 'UserID');
//     }

//     public function exchange()
//     {
//         return $this->belongsTo(Exchange::class, 'ExchangeID');
//     }
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoiceDate',
        'discount', // Fixed potential typo from 'discound'
        'total',
        'status',
        'CustomerID',
        'UserID',
        'ExchangeID',
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'invoiceDate' => 'datetime',
        'discount'    => 'float',
        'total'       => 'float',
    ];

    // --- Relationships ---

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function exchange()
    {
        return $this->belongsTo(Exchange::class, 'ExchangeID');
    }

    /*
    // Example: If an invoice has line items
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'InvoiceID');
    }
    */
}
