<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    protected $dates = ['delete_at'];

    public function ProductSub() {
    	return $this->hasMany(ProductSub::class);
    }
}
