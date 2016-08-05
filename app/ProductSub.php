<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSub extends Model
{
    protected $table = 'product_sub';

    public function Product() {
    	return $this->belongsTo(Product::class);
    }
}
