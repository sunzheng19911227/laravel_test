<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttrValue extends Model
{
    protected $table = 'attr_value';

    public function Attr(){
    	return $this->belongsToMany(Attr::class);
    }
}
