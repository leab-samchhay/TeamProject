<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    protected $fillable = [
        'name',
        'display_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function values()
    {
        return $this->hasMany(AttributesModel::class, 'attribute_id')->orderBy('display_order')->orderBy('value');
    }
}
