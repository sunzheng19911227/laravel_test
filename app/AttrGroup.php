<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttrGroup extends Model
{
    //
    protected $table = 'attr_group';

    // 属性关联 -- 多对多
    public function attr() {
    	return $this->belongsToMany(Attr::class, 'attr_group_attr');
    }

    // 类型关联 -- 多对多
    public function category() {
    	return $this->belongsToMany(Category::class, 'category_attr_group');
    }
}
