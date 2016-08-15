<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    protected $dates = ['delete_at'];

    public function ProductSub() {
    	return $this->hasMany(ProductSub::class);
    }

    // 关联供应商
    public function Supplier() {
    	return $this->belongsTo(Supplier::class);
    }

    // 关联品牌
    public function Brand() {
    	return $this->belongsTo(Brand::class);
    }
}
