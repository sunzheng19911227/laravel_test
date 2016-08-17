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

    public function __construct(Request $request)
    {
        //  获取左侧菜单
        $this->data['menus'] = $this->getMeunList();
        // 获取当前路由
        $this->data['route_path'] = $request->path();  
    }

    public function index(){
    	$this->data['lists'] = Attr::all()->toArray();
    	return view('product.attr.list',$this->data);
    }

    public function create(){
    	return view('product.attr.add', $this->data);
    }

    public function store(Requests\AttrRequest $request){
    	$attr = new Attr();
    	$attr->name = $request->input('name');
        $attr->input_name = $request->input('input_name');
    	$attr->input_box_type = $request->input('input_box_type');
    	$attr->input_value_type = $request->input('input_value_type');
    	$attr->status = $request->input('status');
    	$attr->sort_order = $request->input('sort_order');
    	$result = $attr->save();

    	if($result){
    		return redirect('/product/property')->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/property')->withWarning('添加失败!');
    	}
    }

    public function edit($id){
    	$this->data['data'] = Attr::findOrFail($id)->toArray();
    	return view('product.attr.edit', $this->data);
    }

    public function update(Requests\AttrRequest $request, $id){
    	$attr = Attr::findOrFail($id);
    	$attr->name = $request->input('name');
        $attr->input_name = $request->input('input_name');
    	$attr->input_box_type = $request->input('input_box_type');
    	$attr->input_value_type = $request->input('input_value_type');
    	$attr->status = $request->input('status');
    	$attr->sort_order = $request->input('sort_order');
    	$result = $attr->save();

    	if($result){
    		return redirect('/product/property')->withSuccess('编辑成功!');
    	} else {
    		return redirect('/product/property')->withWarning('编辑失败!');
    	}
    }

    // 删除
    public function destroy($id){
    	$attr = Attr::findOrFail($id);
        
        $attr->delete();

    	if($attr->trashed()){
    		return redirect('/product/property')->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/property')->withWarning('删除失败!');
    	}
    }
}
