<?php
// 商品管理
namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\Supplier;
use App\Brand;
use App\Category;
use App\AttrGroup;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\FormController;

class ProductController extends AdminBaseController
{
    //
    private $data;

    public function __construct()
    {
        $this->data['menus'] = $this->getMeunList();
        // 供应商列表
        $supplier_lists = Supplier::all()->toArray();
        $this->data['supplier_lists'] = $supplier_lists;
        // 品牌列表
        $brand_lists = Brand::all()->toArray();
        $this->data['brand_lists'] = $brand_lists;
        // 类型列表
        $category_lists = Category::all()->toArray();
        $this->data['category_lists'] = $category_lists;

        // 注册删除事件--删除主商品时删除全部子商品
        Product::deleting(function($product){
        	$result = $product->ProductSub()->delete();
        	if($result === false){
        		return false;
        	}
        });
    }

    public function index() {
    	$this->data['lists'] = Product::all();
    	return view('product.product.list', $this->data);
    }

    public function create() {
    	return view('product.product.add', $this->data);
    }

    public function store(Request $request) {
    	$product = new Product;
    	$product->supplier_id = $request->input('supplier_id');
    	$product->brand_id = $request->input('brand_id');
    	$product->category_id = $request->input('category_id');
    	$product->name = $request->input('name');
    	$product->details = $request->input('details');
    	$product->description = $request->input('description');
    	$product->seo_keywords = $request->input('seo_keywords');
    	$product->seo_description = $request->input('seo_description');
    	$product->label = $request->input('label');
    	$result = $product->save();

    	if($result){
    		return redirect('/product/products')->withSuccess('添加成功!');
    	} else {
    		return redirect('/product/products')->withWarning('添加失败!');
    	}
    }

    public function edit($id){
    	$product = Product::findOrFail($id);
    	$this->data['data'] = $product->toArray();
    	return view('product.product.edit', $this->data);
    }

    public function update(Request $request, $id){
    	$product = Product::findOrFail($id);
    	$product->supplier_id = $request->input('supplier_id');
    	$product->brand_id = $request->input('brand_id');
    	$product->category_id = $request->input('category_id');
    	$product->name = $request->input('name');
    	$product->details = $request->input('details');
    	$product->description = $request->input('description');
    	$product->seo_keywords = $request->input('seo_keywords');
    	$product->seo_description = $request->input('seo_description');
    	$product->label = $request->input('label');
    	$result = $product->save();

    	if($result){
    		return redirect('/product/products')->withSuccess('编辑成功!');
    	} else {
    		return redirect('/product/products')->withWarning('编辑失败!');
    	}
    }

    public function destroy($id){
    	$result = Product::destroy($id);

    	if($result){
    		return redirect('/product/products')->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/products')->withWarning('删除失败!');
    	}
    }

    public function ajax_create_form(Request $request) {
        $form = array();

        // 根据category_id获取属性和属性值
        $category = Category::findOrFail($request->input('category_id'));
        $attr_group = $category->attr_group->toArray();
        //$attr = $attr_group->attr;
        //var_dump($attr_group);
        foreach($attr_group as $group){
            $attr_group = AttrGroup::findOrFail($group['id']);
            //var_dump($attr_group->attr->toArray());
            $attr = $attr_group->attr->toArray();
        }
        exit;
        $form = new FormController;
        $select = array('1'=>'下拉框1','2'=>'下拉框2');
        echo $form->create_checkbox('下拉框','test',$select);
    }
}
