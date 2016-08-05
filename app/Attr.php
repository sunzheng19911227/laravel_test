<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attr extends Model
{
    //
    protected $table = 'attr';

    public function AttrValue(){
    	return $this->belongsToMany(AttrValue::class);
    }

    public function giveAttrValue($AttrValue){
    	return $this->AttrValue()->save($AttrValue);
    }
}
