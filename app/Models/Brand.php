<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $primaryKey = 'brand_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['nama_brand'];
}
