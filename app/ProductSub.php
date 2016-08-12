<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;   // 开启软删除

//  子商品模型
class ProductSub extends Model
{
	use SoftDeletes;

	//  指定数据表
    protected $table = 'product_sub';
    
    // 允许批量导入字段
    //protected $fillable = ['productNo'];

    //  不允许批量导入字段
    protected $guarded = ['id'];

    //  隐藏字段
    protected $hidden = [
        'deleted_at',
    ];

    // 软删除标识字段
    protected $dates = ['delete_at'];

    //  子商品关联主商品 多对一
    public function Product() {
    	return $this->belongsTo(Product::class);
    }
}
