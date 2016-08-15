<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attr extends Model
{
    
    use SoftDeletes;

    protected $table = 'attr';

    protected $dates = ['delete_at'];

    public function AttrValue(){
    	return $this->belongsToMany(AttrValue::class);
    }

    // 属性关联 -- 多对多
    public function AttrGroup() {
        return $this->belongsToMany(AttrGroup::class, 'attr_group_attr');
    }

    public function giveAttrValue($AttrValue){
    	return $this->AttrValue()->save($AttrValue);
    }
    
}
