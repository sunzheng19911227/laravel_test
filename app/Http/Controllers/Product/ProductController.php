<?php
// 商品管理
namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\Supplier;
use App\Brand;
use App\Category;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;

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
}
