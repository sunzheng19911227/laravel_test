<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\ProductSub;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;

class ProductSubController extends AdminBaseController
{
	private $data;

    public function __construct()
    {
        $this->data['menus'] = $this->getMeunList();
    }

    //  查看子商品列表
    public function show($id){
    	// 主商品信息


    	
    	$product = Product::findOrFail($id);
    	$this->data['product'] = $product->toArray();
    	// 子商品信息
    	$pro = $product->ProductSub;
    	$this->data['product_sub'] = $pro;
    	return view('product.product.show',$this->data);
    }

    public function create() {
    	return view('product.product.add_product_sub', $this->data);
    }
}
