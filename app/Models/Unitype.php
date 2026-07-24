<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unitype extends Model
{
    use SoftDeletes;
    protected $table = 'unitypes';
    protected $fillable = ['name','qty','status'];
}
