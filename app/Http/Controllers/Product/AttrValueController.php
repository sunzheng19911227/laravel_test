<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Attr;
use App\AttrValue;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\TreeController;

class AttrValueController extends AdminBaseController
{
    
    private $data;

    public function __construct(Request $request)
    {
        //  获取左侧菜单
        $this->data['menus'] = $this->getMeunList();
        // 获取当前路由
        $this->data['route_path'] = $request->path();

        //  获取属性组信息
        $attr = Attr::all();
        $this->data['lists'] = $attr;
    }

    public function show($id){
    	// show atrribute_value list
    	$attr = Attr::find($id);
        $this->data['attr'] = $attr;
    	$this->data['datas'] = $attr->AttrValue->toArray();
    	return view('product.attr_value.list', $this->data);
    }

    public function create(){
        //$attr = Attr::find($id)->toArray();
        //$this->data['attr'] = $attr;
        return view('product.attr_value.add', $this->data);
    }

    public function create_value($id){
        $attr = Attr::find($id)->toArray();
        $this->data['attr'] = $attr;
    	return view('product.attr_value.add', $this->data);
    }

    public function store(Request $request){
    	$attr_value = new AttrValue();
    	$attr_value->name = $request->input('name');
    	$attr_value->status = $request->input('status');
    	$attr_value->sort_order = $request->input('sort_order');
    	$result = $attr_value->save();
        $attr = Attr::findOrFail($request->input('attribute_id'));
        $result = $attr->giveAttrValue($attr_value);

    	if($result){
    		return redirect('/product/attr')->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/attr')->withWarning('添加失败!');
    	}
    }

    public function edit($id) {
        $attr_value = AttrValue::findOrFail($id);
        $this->data['data'] = $attr_value;
        return view('product.attr_value.edit', $this->data);
    }

    public function update(Request $request, $id){
        $attr_value = AttrValue::findOrFail($id);
        $attr_value->name = $request->input('name');
        $attr_value->status = $request->input('status');
        $attr_value->sort_order = $request->input('sort_order');
        $result = $attr_value->save();

        if($result){
            return redirect('/product/attr')->withSuccess('编辑成功!');
        } else {
            return redirect('/product/attr')->withWarning('编辑失败!');
        }
    }

    // 删除
    public function destroy($id){
        $result = AttrValue::destroy($id);

        if($result){
            return redirect('/product/attr')->withSuccess('删除成功!');
        } else {
            return redirect('/product/attr')->withWarning('删除失败!');
        }
    }
}
