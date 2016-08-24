<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;
	
	protected $table = 'category';
	
	protected $dates = ['delete_at'];
	
	// 属性组关联 -- 多对多
	public function attr_group() {
		return $this->belongsToMany(AttrGroup::class, 'category_attr_group');
	}

	// 选项组关联 -- 多对多
	public function option_group() {
		return $this->belongsToMany(OptionGroup::class, 'category_option_group');
	}

	#########################   业务逻辑 #########################
	// 根据id获取类别
	public static function getCategoryById($category_id, $field = array()){
		$category = Category::findOrFail($category_id);
		return $category->toArray();
	}
}
