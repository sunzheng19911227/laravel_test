<?php
// 商品管理
namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\ProductSub;
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
    private $data;

    public function __construct(Request $request)
    {
        //  获取左侧菜单
        $this->data['menus'] = $this->getMeunList();
        $this->data['breadcrumbs'] = $this->breadcrumbs($request);
        // 获取当前路由
        $this->data['route_path'] = $request->path();  
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
            // 删除子商品
            $product->ProductSub()->delete();
         });
    }

    public function index(Request $request) {
        $this->data['name'] = $request->has('name')?$request->input('name'):'';
        $lists = Product::where('name','like','%'.$this->data['name'].'%')->paginate(4);
        foreach($lists as $key=>$list){
            // 验证子商品下架状态
            $product = product::findOrFail($list->id);
            // 获得子商品上架的总数
            $show_counts = $product->ProductSub()->where('review','1')->where('is_show','1')->count();
            // 获得子商品下架的总数
            $hide_counts = $product->ProductSub()->where('review','1')->where('is_show','0')->count();
            /*  
                主商品列表显示状态：
                status = 1 全部上架   
                status = 0 全部下架
                status = -1 部分下架
                status = -2 无子商品
            */
            if($show_counts > 0 && $hide_counts == 0) {
                $status = '全部上架';
            } else if($show_counts == 0 && $hide_counts > 0) {
                $status = '全部下架';
            } else if($show_counts > 0 && $hide_counts > 0) {
                $status = '部分下架';
            } else if($show_counts == 0 && $hide_counts == 0) {
                $status = '无子商品';
            }
            $lists[$key]['status'] = $status;
        }
        $this->data['lists'] = $lists;
    	return view('product.product.list', $this->data);
    }

    public function show($id){
        $pro = array();

        $product = Product::findOrFail($id);
        $pro['product'] = $product->toArray();
        // 获取类别信息
        $category = Category::getCategoryById($product->category_id);
        $pro['product']['category'] = $category['name'];
        // 获取品牌信息
        $brand = Brand::getBrandById($product->brand_id);
        $pro['product']['brand'] = $brand['name'];
        //  获取供应商信息
        $supplier = Supplier::getSupplierById($product->supplier_id);
        $pro['product']['supplier'] = $supplier['name'];

        //$product_sub = $product->ProductSub()->first();
        $pro['product_sub_id'] = '';
        // 获取主商品的属性
        $public_attrs = json_decode($product->public_attr, true);
        $attrs = array();
        foreach($public_attrs as $key=>$public_attr) {
            $attr = Attr::where('input_name', $key)->first();
            if($attr->input_box_type == 1) {
                $attrs[$attr->input_name] = array('name'=>$attr->name, 'value'=>$public_attr);
            } else {
                $value = array_values($public_attr);
                $attrs[$attr->input_name] = array('name'=>$attr->name,'value'=>$value[0]);
            }
        }
        $pro['attrs'] = $attrs;

        $this->data['data'] = $pro;

        return view('product.product.product_show', $this->data);
    }

    // 获得已经选中的选项和选项值
    public function ajax_option_checked(Request $request){
        $product_id = $request->input('product_id');

        //生成表单
        $private_attrs = ProductSub::where('product_id', $product_id)->pluck('private_attr');
        $form_data = array();
        foreach($private_attrs as $private_attr) {
            $attr = json_decode($private_attr, true);
            $form_data = array_merge_recursive($attr, $form_data);   
        }

        // 获取选中值
        $default_value_data = array();
        if($request->has('product_sub_id')) {
            $product_sub_id = $request->input('product_sub_id');
            $private_attr = ProductSub::where('id', $product_sub_id)->pluck('private_attr')->first();
            $attrs = json_decode($private_attr, true);
            foreach ($attrs as $key => $attr) {
                foreach($attr as $k=>$value) {
                    $default_value_data[$key] = array($k);
                }
            }
        }

        $form = new FormController;
        $html = '';
        $default_value = '';
        foreach($form_data as $key=>$data) {
            foreach($default_value_data as $k=>$value){
               $default_value = $value;
            }
            // 获取属性的名称
            $attr_name = Attr::where('input_name',$key)->pluck('name')->first();
            $html .= $form->create_checkbox($attr_name, $key, $data, $default_value, true);
        }
        echo $html;
    }

    public function create() {
    	return view('product.product.add', $this->data);
    }

    public function store(Requests\ProductRequest $request) {
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
    	   return redirect('/product/product_sub/create/'.$product->id);
    	} else {
    		return redirect('/product/products')->withWarning('添加失败!');
    	}
    }

    public function edit($id){
    	$product = Product::findOrFail($id);
    	$this->data['data'] = $product->toArray();
    	return view('product.product.edit', $this->data);
    }

    public function update(Requests\ProductRequest $request, $id) {

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
    	$product = Product::findOrFail($id);
        $product->delete();

    	if($product->trashed()){
    		return redirect('/product/products')->withSuccess('删除成功!');
    	} else {
    		return redirect('/product/products')->withWarning('删除失败!');
    	}
    }

    // 自动生成表单
    public function ajax_create_form(Request $request) {
        $form_data = array();
        $default_value_data = array();
        // 获取表单的类型
        $form_type = $request->input('form_type');
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
        }

        // 根据category_id获取属性和属性值
        $disable = array();
        $category = Category::findOrFail($request->input('category_id'));
        $attr_groups = $category->attr_group->toArray();
        foreach($attr_groups as $group) {
            
            if($form_type == 'create') {  // 添加时,忽略status为停用状态的属性组
                if($group['status'] == 0){
                    continue;
                }
            } elseif( $form_type == 'update') {  // 修改时,标记status为0的属性
                if($group['status'] == 0){
                    $attr_group = AttrGroup::findOrFail($group['id']);
                    $attrs = $attr_group->attr->toArray();
                    foreach($attrs as $attr) {
                        $disable[] = $attr['input_name'];
                    }
                }
            }
            
            $attr_group = AttrGroup::findOrFail($group['id']);
            $attrs = $attr_group->attr->toArray();
            foreach($attrs as $attr) {
                if($form_type == 'create') {  // 添加时,忽略status为停用状态的属性组
                    if($attr['status'] == 0){
                        continue;
                    }
                } elseif( $form_type == 'update') {  // 修改时,标记status为0的属性
                    if($attr['status'] == 0){
                        $disable[] = $attr['input_name'];
                    }
                }
                
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
                $disable_value = false;
                if(in_array( (substr($data['input_name'], 5)), $disable)) {
                    $disable_value = true;
                }
                if($data['input_box_type'] == '1') {
                    $html .= $form->$input_box[$data['input_box_type']]($data['label_name'], $data['input_name'], $default_value, false, $disable_value);
                } else {
                    $html .= $form->$input_box[$data['input_box_type']]($data['label_name'], $data['input_name'], $data['item'], $default_value);
                }
            }
        }
        echo $html;
    }

    // 批量处理
    public function batch(Request $request) {
        $ids = explode(',', $request->input('ids'));
        if($request->input('type') == 'delete'){  // 批量删除
            Product::destroy($ids);
        } else if($request->input('type') == 'show') {  // 批量上架
            foreach($ids as $id){
                ProductSub::where('product_id',$id)->update(['is_show'=>'1']);
            }
        } else if($request->input('type') == 'hide') {  // 批量下架
            foreach($ids as $id){
                 ProductSub::where('product_id',$id)->update(['is_show'=>'0']);
            }
        }
    }
}
