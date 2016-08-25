<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    
    protected $table = 'supplier';
    
    protected $dates = ['delete_at'];

    // 关联主商品
    public function Product() {
    	return $this->hasMany(Product::class);
    }


	#########################   业务逻辑 #########################
	// 根据id获取供应商
	public static function getSupplierById($supplier_id, $field = array()){
		$supplier = Supplier::findOrFail($supplier_id);
		return $supplier->toArray();
	}
}
