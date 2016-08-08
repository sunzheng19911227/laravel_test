<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\ProductSub;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    	return view('product.product.show', $this->data);
    }

    public function create($id) {
    	$this->data['product_id'] = $id;
    	return view('product.product.add_product_sub', $this->data);
    }

    public function store(Request $request) {
    	if(!$request->hasFile('file')){
    		exit('上传文件为空！');
    	}



    	$product = Product::findOrFail($request->input('product_id'));

    	$product_sub = new ProductSub();
    	$product_sub->productNo = $request->input('productNo');
    	$product_sub->price = $request->input('price');
    	$product_sub->sale_price = $request->input('sale_price');
    	$product_sub->review = $request->input('review');
    	$product_sub->is_show = $request->input('is_show');
    	$product_sub->sort_order = $request->input('sort_order');
    	//  上传文件
    	if( $request->hasFile('file') ) {
	    	$file = $request->file('file');
	    	if(!$file->isValid()){
	    		echo '文件上传出错!';
	    		exit;
	    	}
	    	$destPath = public_path('images');
	    	if(!file_exists($destPath)) {
		       mkdir($destPath,0755,true);
	    	}
		    $filename = $file->getClientOriginalName();    //  获取图片名称   现为原名称
		    if($file->move($destPath, $filename) !== false){
		    	$product_sub->image = $filename;	
		    }
    	}
    	$result = $product->ProductSub()->save($product_sub);

    	if($result){
    		return redirect('/product/product_sub/'.$request->input('product_id'))->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/product_sub/'.$request->input('product_id'))->withWarning('添加失败!');
    	}
    }

    public function edit($id) {
    	$product_sub = ProductSub::findOrFail($id);
    	$this->data['data'] = $product_sub->toArray();
    	return view('product.product.edit_product_sub', $this->data);
    }

    public function update(Request $request, $id) {
    	$product_sub = ProductSub::findOrFail($id);

		$product_sub->price = $request->input('price');
    	$product_sub->sale_price = $request->input('sale_price');
    	$product_sub->review = $request->input('review');
    	$product_sub->is_show = $request->input('is_show');
    	$product_sub->sort_order = $request->input('sort_order');
		$result = $product_sub->save();

    	if($result){
    		return redirect('/product/product_sub/'.$product_sub->product_id)->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/product_sub/'.$product_sub->product_id)->withWarning('添加失败!');
    	}
    }

    public function destroy($id) {
    	$product_sub = ProductSub::findOrFail($id);

    	$result = ProductSub::destroy($id);

    	if($result){
    		return redirect('/product/product_sub/'.$product_sub->product_id)->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/product_sub/'.$product_sub->product_id)->withWarning('删除失败!');
    	}
    }
}
