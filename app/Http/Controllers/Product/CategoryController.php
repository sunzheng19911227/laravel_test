<?php
//   商品类别
namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\TreeController;

class CategoryController extends AdminBaseController
{
    private $data;

    public function __construct(Request $request)
    {
        //  获取左侧菜单
        $this->data['menus'] = $this->getMeunList();
        // 获取当前路由
        $this->data['route_path'] = $request->path();
    }

    public function index() {
    	//$this->data['lists'] = Category::all();
    	$categorys = Category::all()->toArray();
    	$tree = new TreeController();
    	$tree->tree($categorys);
    	$categorys_data = $tree->getArray();
    	$this->data['lists'] = $categorys_data;

    	return view('product.category.list', $this->data);
    }

    public function create() {
    	// 下拉菜单
    	$categorys = Category::all()->toArray();
    	$tree = new TreeController();
    	$tree->tree($categorys);
    	$categorys_data = $tree->getArray();
    	$this->data['lists'] = $categorys_data;
    	return view('product.category.add', $this->data);
    }

    public function store(Request $request) {
    	$category = new Category();
    	$category->pid = $request->input('pid');
    	$category->name = $request->input('name');
    	$category->status = $request->input('status');
    	$result = $category->save();

    	if($result){
    		return redirect('/product/category')->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/category')->withWarning('添加失败!');
    	}
    }

    // 编辑
    public function edit($id) {
    	$this->data['data'] = Category::findOrFail($id);

    	// 下拉菜单
    	$categorys = Category::all()->toArray();
    	$tree = new TreeController();
    	$tree->tree($categorys);
    	$categorys_data = $tree->getArray();
    	$this->data['lists'] = $categorys_data;

    	return view('product.category.edit', $this->data);
    }

    public function update(Request $request, $id) {
    	$category = Category::findOrFail($id);
    	$category->pid = $request->input('pid');
    	$category->name = $request->input('name');
    	$category->status = $request->input('status');
    	$result = $category->save();

    	if($result){
    		return redirect('/product/category')->withSuccess('编辑成功!');
    	} else {
    		return redirect('/product/category')->withWarning('编辑失败!');
    	}
    }

    // 删除
    public function destroy($id){
    	$result = Category::destroy($id);

    	if($result){
    		return redirect('/product/category')->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/category')->withWarning('删除失败!');
    	}
    }
}
