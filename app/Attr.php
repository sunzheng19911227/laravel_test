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

    public function giveAttrValue($AttrValue){
    	return $this->AttrValue()->save($AttrValue);
    }

    //   添加软删除
    
}
