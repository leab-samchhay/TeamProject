<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetail extends Model
{
    use SoftDeletes;
    protected $table = 'purchase_details';
    protected $fillable = ['cost','qty','discount','productID','purchaseID'];

    public function purchase(){
        return $this->belongsTo(Purchase::class, 'purchaseID');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'productID');
    }
}
