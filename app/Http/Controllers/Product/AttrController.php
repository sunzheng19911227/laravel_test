<?php
// 属性管理
namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Attr;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;

class AttrController extends AdminBaseController
{
    private $data;

    public function __construct()
    {
        $this->data['menus'] = $this->getMeunList();
    }

    public function index(){
    	$this->data['lists'] = Attr::all()->toArray();
    	return view('product.attr.list',$this->data);
    }

    public function create(){
    	return view('product.attr.add', $this->data);
    }

    public function store(Request $request){
    	$attr = new Attr();
    	$attr->name = $request->input('name');
    	$attr->input_box_type = $request->input('input_box_type');
    	$attr->input_value_type = $request->input('input_value_type');
    	$attr->status = $request->input('status');
    	$attr->sort_order = $request->input('sort_order');
    	$result = $attr->save();

    	if($result){
    		return redirect('/product/attr')->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/attr')->withWarning('添加失败!');
    	}
    }

    public function edit($id){
    	$this->data['data'] = Attr::findOrFail($id)->toArray();
    	return view('product.attr.edit', $this->data);
    }

    public function update(Request $request, $id){
    	$attr = Attr::findOrFail($id);
    	$attr->name = $request->input('name');
    	$attr->input_box_type = $request->input('input_box_type');
    	$attr->input_value_type = $request->input('input_value_type');
    	$attr->status = $request->input('status');
    	$attr->sort_order = $request->input('sort_order');
    	$result = $attr->save();

    	if($result){
    		return redirect('/product/attr')->withSuccess('编辑成功!');
    	} else {
    		return redirect('/product/attr')->withWarning('编辑失败!');
    	}
    }

    // 删除
    public function destroy($id){
    	$result = Attr::destroy($id);

    	if($result){
    		return redirect('/product/attr')->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/attr')->withWarning('删除失败!');
    	}
    }
}
