<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_Variants extends Model
{
    use SoftDeletes;

    protected $table = 'product__variants';

    protected $fillable = [
        'product_id',
        'sku',
        'barcode',
        'qr_code',
        'attributes',
        'cost',
        'selling_price',
        'wholesale_price',
        'minimum_stock',
        'current_stock',
        'weight',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'attributes' => 'array',
        'cost' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
