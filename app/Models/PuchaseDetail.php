<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PuchaseDetail extends Model
{
    use SoftDeletes;
    protected $table = 'puchase_details';
    protected $fillable = ['cost','qty','discound','productID','puchaseID'];

    public function puchase(){
        return $this->belongsTo(Purchase::class, 'puchaseID');

    }

    public function product(){
        return $this->belongsTo(Product::class, 'productID');

    }
}
