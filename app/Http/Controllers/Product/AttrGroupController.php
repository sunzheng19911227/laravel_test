<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\AttrGroup;
use App\Attr;
use App\category;
use App\Product;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\TreeController;

class AttrGroupController extends AdminBaseController
{
	private $data;

    public function __construct(Request $request)
    {
        //  获取左侧菜单
        $this->data['menus'] = $this->getMeunList();
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
        $attr = Attr::where('input_box_type','<>','2')->get();
        $this->data['attr'] = $attr;
    }

    public function index() {
    	$this->data['lists'] = AttrGroup::all()->toArray();
    	return view('product.attr_group.list',$this->data);
    }

    public function create() {
    	return view('product.attr_group.add', $this->data);
    }

    public function store(Requests\AttrGroupRequest $request) {
    	$attr_group = new AttrGroup;
    	$attr_group->name = $request->input('name');
    	$attr_group->status = $request->input('status');
    	$attr_group->sort_order = $request->input('sort_order');
    	$result = $attr_group->save();
      $attr_group->category()->sync($request->input('category_id'));

    	if($result){
    		return redirect('/product/attr_group/')->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/attr_group/')->withWarning('添加失败!');
    	}
    }

    public function edit($id) {
    	$attr_group = AttrGroup::findOrFail($id);
    	$this->data['data'] = $attr_group->toArray();
    	foreach($attr_group->category as $g){
    		  $this->data['categorys_data'][] = $g->toArray();
    	}
    	return view('product.attr_group.edit', $this->data);
    }

    public function update(Requests\AttrGroupRequest $request, $id){
    	$attr_group = AttrGroup::findOrFail($id);
    	$attr_group->name = $request->input('name');
    	$attr_group->status = $request->input('status');
    	$attr_group->sort_order = $request->input('sort_order');
    	$result = $attr_group->save();
      $attr_group->category()->sync($request->input('category_id'));

    	if($result){
    		return redirect('/product/attr_group/')->withSuccess('编辑成功!');
    	} else {
    		return redirect('/product/attr_group/')->withWarning('编辑失败!');
    	}
    }

   	public function destroy($id){
   		$result = AttrGroup::destroy($id);

   		if($result){
    		return redirect('/product/attr_group/')->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/attr_group/')->withWarning('删除失败!');
    	}
   	}

   	public function show($id) {
   		$AttrGroup = AttrGroup::findOrFail($id);
   		$this->data['attr_group'] = $AttrGroup->toArray(); 
   		$attrs = $AttrGroup->attr;
   		$this->data['lists'] = $attrs->toArray();
   		return view('product.attr_group.show', $this->data);
   	}

   	//  关联
   	public function relevance($id){
   		$AttrGroup = AttrGroup::findOrFail($id);
   		$this->data['attr_group'] = $AttrGroup->toArray();
   		return view('product.attr_group.relevance', $this->data);
   	}

   	public function relevance_handle(Request $request) {
   		$AttrGroup = AttrGroup::findOrFail($request->input('attr_group_id'));
   		// 验证是否已经存在这个属性
   		$result = $AttrGroup->attr->contains('id',$request->input('attr_id'));

   		if($result === false) {
			$AttrGroup->attr()->attach($request->input('attr_id'));
			return redirect('/product/attr_group/'.$request->input('attr_group_id'))->withSuccess('关联成功!');
   		} else {
   			return redirect('/product/attr_group/'.$request->input('attr_group_id'))->withWarning('关联失败,属性已存在!');
   		}
   	}

   	// 解除关联
   	public function detach($id, $attr_group_id){
   		$AttrGroup = AttrGroup::findOrFail($attr_group_id);
   		// 验证是否已经存在这个属性
   		$result = $AttrGroup->attr->contains('id',$id);
   		if($result === true) {
			$AttrGroup->attr()->detach($id);
			return redirect('/product/attr_group/'.$attr_group_id)->withSuccess('解除关联成功!');
   		} else {
   			return redirect('/product/attr_group/'.$attr_group_id)->withWarning('解除关联失败,属性不存在!');
   		}
   	}

    // 验证受影响的商品数量
    public function check_status(Request $request) {
        $count = 0;
        $attr_group = AttrGroup::findOrFail($request->input('id'));
        // 获得关联属性
        $attrs = $attr_group->attr;
        foreach($attrs as $attr) {
            $count += Product::where('public_attr','like','%\"'.$attr->input_name.'\"%')->count();
        }
        echo $count;
    }
}
