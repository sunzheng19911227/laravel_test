<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttrValue extends Model
{
    use SoftDeletes;
    
    protected $table = 'attr_value';
    
    protected $dates = ['delete_at'];

    public function Attr(){
    	return $this->belongsToMany(Attr::class);
    }
}
