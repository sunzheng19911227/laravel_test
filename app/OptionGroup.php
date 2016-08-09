<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model
{
	//
    protected $table = 'option_group';

    // 属性关联 -- 多对多
    public function attr() {
    	return $this->belongsToMany(Attr::class, 'option_group_attr');
    }

    // 类型关联 -- 多对多
    public function category() {
    	return $this->belongsToMany(Category::class, 'category_option_group');
    }
}
