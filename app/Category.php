<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';

    // 属性组关联 -- 多对多
    public function attr_group() {
    	return $this->belongsToMany(AttrGroup::class, 'category_attr_group');
    }

    // 选项组关联 -- 多对多
    public function option_group() {
    	return $this->belongsToMany(OptionGroup::class, 'category_option_group');
    }
}
