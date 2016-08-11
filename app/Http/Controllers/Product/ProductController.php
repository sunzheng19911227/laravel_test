<?php
// 商品管理
namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\Supplier;
use App\Brand;
use App\Category;
use App\AttrGroup;
use App\Attr;
use App\AttrValue;
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
        //var_dump($request->except('_token'));
        //exit;
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

        // 筛选出属性字段,并处理成json串
        $json = array();
        foreach($request->except('_token') as $field=>$value){
            if( substr($field, 0, 5) == 'attr_' ){
                $field = substr($field, 5);
                $attr_type = Attr::where('input_name','=',$field)->get()->toArray();
                $attr_type = call_user_func_array('array_merge',$attr_type);   // 二维转一维
                if($attr_type['input_box_type'] != 1){
                    // 获取属性值的名称
                    $array = array();
                    if(is_array($value)) {
                        foreach($value as $v) {
                            $attr_value = AttrValue::findOrFail($v)->toArray();
                            $array[$v] = $attr_value['name'];
                        }
                    }else{
                        $attr_value = AttrValue::findOrFail($value)->toArray();
                        $array[$value] = $attr_value['name'];
                    }
                    $json[$field] = $array;
                } else {
                    $json[$field] = $value;  
                }
            }
        }

        $product->public_attr = json_encode($json);
    	$result = $product->save();

    	if($result) {
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

    public function update(Request $request, $id) {

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

        // 筛选出属性字段,并处理成json串
        $json = array();
        foreach($request->except('_token') as $field=>$value){
            if( substr($field, 0, 5) == 'attr_' ){
                $field = substr($field, 5);
                $attr_type = Attr::where('input_name','=',$field)->get()->toArray();
                $attr_type = call_user_func_array('array_merge',$attr_type);   // 二维转一维
                if($attr_type['input_box_type'] != 1){
                    // 获取属性值的名称
                    $array = array();
                    if(is_array($value)) {
                        foreach($value as $v) {
                            $attr_value = AttrValue::findOrFail($v)->toArray();
                            $array[$v] = $attr_value['name'];
                        }
                    }else{
                        $attr_value = AttrValue::findOrFail($value)->toArray();
                        $array[$value] = $attr_value['name'];
                    }
                    $json[$field] = $array;
                } else {
                    $json[$field] = $value;  
                }
            }
        }
        $product->public_attr = json_encode($json);
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

    // 自动生成表单
    public function ajax_create_form(Request $request) {
        $form_data = array();
        $default_value_data = array();
        // 获取商品属性信息
        if($request->input('product_id') !== null){
            $product = Product::findOrFail($request->input('product_id'))->toArray();
            $public_attr = json_decode($product['public_attr'],true);
            foreach($public_attr as $key=>$attr) {
                if(is_array($attr)){
                    foreach($attr as $k=>$value) {
                        $default_value_data[$key][] = $k;
                    }
                } else {
                    $default_value_data[$key] = $attr;
                }
            }
            var_dump($default_value_data);
        }

        // 根据category_id获取属性和属性值
        $category = Category::findOrFail($request->input('category_id'));
        $attr_groups = $category->attr_group->toArray();
        foreach($attr_groups as $group) {
            $attr_group = AttrGroup::findOrFail($group['id']);
            $attrs = $attr_group->attr->toArray();
            foreach($attrs as $attr) {
                $array = array();
                $attr_value = Attr::findOrFail($attr['id'])->AttrValue->toArray();
                foreach($attr_value as $a) {
                    $array['item'][$a['id']] = $a['name'];
                }
                $array['label_name'] = $attr['name'];
                $array['input_name'] = 'attr_'.$attr['input_name'];
                $array['input_box_type'] = $attr['input_box_type'];
                $array['input_value_type'] = $attr['input_value_type'];
                $form_data[] = $array;
            }
        }

        $html = '';
        if(!empty($form_data)) {
            $form = new FormController;
            $input_box = array( '1'=>'create_text',       // 输入框
                                '2'=>'create_checkbox',   // 复选框
                                '3'=>'create_radio',      // 单选框
                                '4'=>'create_select',     // 下拉框
                                );
            foreach($form_data as $data) {
                $default_value = '';
                foreach ($default_value_data as $key => $value) {
                    if($key == substr($data['input_name'], 5) ){
                         $default_value = $value;
                    }
                }
                var_dump($default_value);
                if($data['input_box_type'] == '1') {
                    $html .= $form->$input_box[$data['input_box_type']]($data['label_name'], $data['input_name'], $default_value);
                } else {
                    $html .= $form->$input_box[$data['input_box_type']]($data['label_name'], $data['input_name'], $data['item'], $default_value);
                }
            }
        }
        echo $html;
    }
}
