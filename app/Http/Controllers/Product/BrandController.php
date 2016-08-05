<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Brand;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;

class BrandController extends AdminBaseController
{
    private $data;

    public function __construct()
    {
        $this->data['menus'] = $this->getMeunList();
    }

    public function index() {
    	$this->data['lists'] = Brand::all();
    	return view('product.brand.list', $this->data);
    }

    public function create() {
    	return view('product.brand.add', $this->data);
    }

    public function store(Request $request) {
    	$brand = new Brand();
    	$brand->name = $request->input('name');
    	$brand->sort_order = $request->input('sort_order');
    	$brand->status = $request->input('status');
    	$result = $brand->save();

    	if($result){
    		return redirect('/product/brand')->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/brand')->withWarning('添加失败!');
    	}
    }

    // 编辑
    public function edit($id) {
    	$this->data['data'] = Brand::findOrFail($id);
    	return view('product.brand.edit', $this->data);
    }

    public function update(Request $request, $id) {
    	$brand = Brand::findOrFail($id);
    	$brand->name = $request->input('name');
    	$brand->sort_order = $request->input('sort_order');
    	$brand->status = $request->input('status');
    	$result = $brand->save();

    	if($result){
    		return redirect('/product/brand')->withSuccess('编辑成功!');
    	} else {
    		return redirect('/product/brand')->withWarning('编辑失败!');
    	}
    }

    // 删除
    public function destroy($id){
    	$result = Brand::destroy($id);

    	if($result){
    		return redirect('/product/brand')->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/brand')->withWarning('删除失败!');
    	}
    }
}
