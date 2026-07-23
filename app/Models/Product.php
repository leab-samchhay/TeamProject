<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = ['ProName', 'ProNameKh', 'Barcode', 'Qty_Onhand',
        'Qty_Alert', 'Remark', 'Photo', 'StockType','Status', 'CategoryID', 'SupplierID'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID', 'id');
    }
}
