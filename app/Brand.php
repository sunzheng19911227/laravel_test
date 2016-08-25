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

	#########################   业务逻辑 #########################
	// 根据id获取品牌
	public static function getBrandById($brand_id, $field = array()){
		$brand = Brand::findOrFail($brand_id);
		return $brand->toArray();
	}
}
