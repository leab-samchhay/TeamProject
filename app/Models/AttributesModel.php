<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributesModel extends Model

{
    protected $table = 'attribute_values';

    protected $fillable = [
        'attribute_id',
        'value',
        'display_order',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attributes::class);
    }
}
