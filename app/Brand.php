<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    
    protected $table = 'brand';
    
    protected $dates = ['delete_at'];

    // 关联主商品
    public function Product() {
    	return $this->hasMany(Product::class);
    }
}
