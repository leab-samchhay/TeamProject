<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = ['ProName', 'ProNameKh', 'Barcode', 'Qty_Onhand',
        'Qty_Alert', 'Remark','ReleaseDate','ExpiredDate', 'Photo','Status','price', 'CategoryID', 'SupplierID','UnitypeID'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'SupplierID', 'id');
    }

    public function unitype()
    {
        return $this->belongsTo(Unitype::class, 'UnitypeID', 'id');
    }
}
