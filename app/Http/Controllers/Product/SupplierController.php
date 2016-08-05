<?php
// 商品管理
namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Supplier;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;

class SupplierController extends AdminBaseController
{
    //

    private $data;

    public function __construct()
    {
        $this->data['menus'] = $this->getMeunList();
    }

    // 列表显示
    public function index(){
    	$this->data['lists'] = Supplier::all();
    	return view('product.supplier.list', $this->data);
    }

    // 添加
    public function create(){
    	return view('product.supplier.add', $this->data);
    }

    public function store(Request $request) {
    	$supplier = new Supplier();
    	$supplier->name = $request->input('name');
    	$supplier->description = $request->input('description');
    	$supplier->status = $request->input('status');
    	$result = $supplier->save();

    	if($result){
    		return redirect('/product/supplier')->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/supplier')->withWarning('添加失败!');
    	}
    }

    // 编辑
    public function edit($id) {
    	$this->data['data'] = Supplier::findOrFail($id);
    	return view('product.supplier.edit', $this->data);
    }

    public function update(Request $request, $id) {
    	$supplier = Supplier::findOrFail($id);
    	$supplier->name = $request->input('name');
    	$supplier->description = $request->input('description');
    	$supplier->status = $request->input('status');
    	$result = $supplier->save();

    	if($result){
    		return redirect('/product/supplier')->withSuccess('编辑成功!');
    	} else {
    		return redirect('/product/supplier')->withWarning('编辑失败!');
    	}
    }

    // 删除
    public function destroy($id){
    	$result = Supplier::destroy($id);

    	if($result){
    		return redirect('/product/supplier')->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/supplier')->withWarning('删除失败!');
    	}
    }
}
