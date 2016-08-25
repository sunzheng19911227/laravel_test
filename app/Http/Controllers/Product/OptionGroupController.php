<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\OptionGroup;
use App\Attr;
use App\category;
use App\ProductSub;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\TreeController;

class OptionGroupController extends AdminBaseController
{
	private $data;

	public function __construct(Request $request)
	{
		//  获取左侧菜单
		$this->data['menus'] = $this->getMeunList();
		$this->data['breadcrumbs'] = $this->breadcrumbs($request);
		// 获取当前路由
		$this->data['route_path'] = $request->path();
		// 获取类别
		$category = Category::where('status','1')->get();
		// 获取树状数据格式
		$tree = new TreeController();
		$tree->tree($category->toArray());
		$categorys_data = $tree->getArray();
		$this->data['category'] = $categorys_data;
		// 获取属性 
		$attr = Attr::where('input_box_type','=','2')->get();
		$this->data['attr'] = $attr;
	}

	public function index() {
		$this->data['lists'] = OptionGroup::all()->toArray();
		return view('product.option_group.list',$this->data);
	}

	public function create() {
		return view('product.option_group.add', $this->data);
	}

	public function store(Requests\OptionGroupRequest $request) {
		//$category = Category::findOrFail($request->input('category_id'));

		$option_group = new OptionGroup;
		$option_group->name = $request->input('name');
		$option_group->status = $request->input('status');
		$option_group->sort_order = $request->input('sort_order');
		$result = $option_group->save();
		$option_group->category()->sync($request->input('category_id'));

		if($result){
			return redirect('/product/option_group/')->withSuccess('添加成功!');
		} else {
			return redirect('/product/option_group/')->withWarning('添加失败!');
		}
	}

	public function edit($id){
		$option_group = OptionGroup::findOrFail($id);
		$this->data['data'] = $option_group->toArray();
		foreach($option_group->category as $g){
			$this->data['categorys_data'][] = $g->toArray();
		}
		return view('product.option_group.edit', $this->data);
	}

	public function update(Requests\OptionGroupRequest $request, $id){
		$option_group = OptionGroup::findOrFail($id);
		$option_group->name = $request->input('name');
		$option_group->status = $request->input('status');
		$option_group->sort_order = $request->input('sort_order');
		$result = $option_group->save();
		$option_group->category()->sync($request->input('category_id'));

		if($result){
			return redirect('/product/option_group/')->withSuccess('编辑成功!');
		} else {
			return redirect('/product/option_group/')->withWarning('编辑失败!');
		}
	}

	public function destroy($id){
		$result = OptionGroup::destroy($id);

		if($result){
			return redirect('/product/option_group/')->withSuccess('删除成功!');
		} else {
			return redirect('/product/option_group/')->withWarning('删除失败!');
		}
	}

	public function show($id) {
		$OptionGroup = OptionGroup::findOrFail($id);
		$this->data['option_group'] = $OptionGroup->toArray(); 
		$attrs = $OptionGroup->attr;
		$this->data['lists'] = $attrs->toArray();
		return view('product.option_group.show', $this->data);
	}

	//  关联
	public function relevance($id){
		$OptionGroup = OptionGroup::findOrFail($id);
		$this->data['option_group'] = $OptionGroup->toArray();
		return view('product.option_group.relevance', $this->data);
	}

	public function relevance_handle(Request $request) {
		$OptionGroup = OptionGroup::findOrFail($request->input('option_group_id'));
		// 验证是否已经存在这个属性
		$result = $OptionGroup->attr->contains('id',$request->input('attr_id'));

		if($result === false) {
			$OptionGroup->attr()->attach($request->input('attr_id'));
			return redirect('/product/option_group/'.$request->input('option_group_id'))->withSuccess('关联成功!');
		} else {
			return redirect('/product/option_group/'.$request->input('option_group_id'))->withWarning('关联失败,属性已存在!');
		}
	}

	// 解除关联
	public function detach($id, $option_group_id){
		$OptionGroup = OptionGroup::findOrFail($option_group_id);
		// 验证是否已经存在这个属性
		$result = $OptionGroup->attr->contains('id',$id);
		if($result === true) {
			$OptionGroup->attr()->detach($id);
			return redirect('/product/option_group/'.$option_group_id)->withSuccess('解除关联成功!');
		} else {
			return redirect('/product/option_group/'.$option_group_id)->withWarning('解除关联失败,属性不存在!');
		}
	}

	// 验证受影响的商品数量
	public function check_status(Request $request) {
		$count = 0;
		$option_group = OptionGroup::findOrFail($request->input('id'));
		// 获得关联属性
		$attrs = $option_group->attr;
		foreach($attrs as $attr) {
			$count += ProductSub::where('private_attr','like','%\"'.$attr->input_name.'\"%')->count();
		}
		echo $count;
	}
}
