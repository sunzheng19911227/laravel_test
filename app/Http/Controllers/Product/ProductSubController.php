<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\ProductSub;
use App\Category;
use App\OptionGroup;
use App\Attr;
use App\AttrValue;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\FormController;
use App\Services\UploadsManager;
use Illuminate\Routing\Router;

class ProductSubController extends AdminBaseController
{
	private $data;

	public function __construct(Request $request)
	{
		//  获取左侧菜单
        $this->data['menus'] = $this->getMeunList();
        // 获取当前路由
        $this->data['route_path'] = $request->path();
	}

	//  查看子商品列表
	public function show(Request $request, $id){
		// 主商品信息
		$product = Product::findOrFail($id);
		$this->data['product'] = $product->toArray();
		// 子商品信息
		$pro = $product->ProductSub;
		$this->data['product_sub'] = $pro;
		return view('product.product.show', $this->data);
	}

	public function create($id) {
		$this->data['product_id'] = $id;
		return view('product.product.add_product_sub', $this->data);
	}

	//  选项值组合
	public function option_assemble($arr){
		if(count($arr) >= 2) {
			$tmparr = array();
			$keys = array_keys($arr);
			$key1 = '';
			$key2 = '';
			if($keys[0] != '0'){
				$key1 = $keys[0];
			}
			if($keys[1] != '0'){
				$key2 = $keys[1];
			}
			$arr1 = array_shift($arr);
			$arr2 = array_shift($arr);
			foreach($arr1 as $k1 => $v1){
				foreach($arr2 as $k2 => $v2){
					if(is_array($v1)){
						$attr_value = AttrValue::findOrFail($v2);
						$array = array_merge($v1, array($key2 => array($v2 => $attr_value->name)));
					} else {
						// 查询属性信息
						$attr_value1 = AttrValue::findOrFail($v1);
						$attr_value2 = AttrValue::findOrFail($v2);
						$array = array( $key1 => array($v1 => $attr_value1->name), 
							$key2 => array($v2 => $attr_value2->name)
							);    
					}
					
					$tmparr[] = $array;
				}
			}
			array_unshift($arr, $tmparr);
			$arr = $this->option_assemble($arr);
		} else {
			return $arr;
		}
		return $arr;
	}

	public function store(Request $request) {

		// 筛选出选项字段
		$options = array();
		foreach($request->except('_token') as $field=>$value){
			if( substr($field, 0, 7) == 'option_' ){
				$options[substr($field, 7)] = $value;
			}
		}
		//  上传文件
		$filename = '';
		if( $request->hasFile('file') ) {       
			$file = $request->file('file');
			$uploads = new UploadsManager();
			$filename = $uploads->upload_file($file);
		}

		// 获取主商品实例
		$product = Product::findOrFail($request->input('product_id'));
		$private_attr = '';
		if(count($options) > 0) {   // 设置了选项值,批量添加
			// 计算选项值排列组合结果集
			$options = $this->option_assemble($options);
			$options = call_user_func_array('array_merge',$options);  // 二维转一维

			foreach($options as $option) {
				$private_attr = json_encode($option);
				// 验证选项值是否冲突  todu
				$product_sub[] = new ProductSub(['productNo'=>$request->input('productNo'),
					'price'=>$request->input('price'),
					'sale_price' => $request->input('sale_price'),
					'review' => $request->input('review'),
					'is_show' => $request->input('is_show'),
					'sort_order' => $request->input('sort_order'),
					'image' => $filename,
					'private_attr' => $private_attr,
					]);
			}
			$result = $product->ProductSub()->saveMany($product_sub);   // 批量添加
		} else {   // 单个子商品
			$product_sub = new ProductSub();
			$product_sub->productNo = $request->input('productNo');
			$product_sub->price = $request->input('price');
			$product_sub->sale_price = $request->input('sale_price');
			$product_sub->review = $request->input('review');
			$product_sub->is_show = $request->input('is_show');
			$product_sub->sort_order = $request->input('sort_order');
			$product_sub->image = $filename;
			$product_sub->private_attr = $private_attr;
			$result = $product->ProductSub()->save($product_sub);
		}

		if($result){
			return redirect('/product/product_sub/'.$request->input('product_id'))->withSuccess('添加成功!');
		} else {
			return redirect('/product/product_sub/'.$request->input('product_id'))->withWarning('添加失败!');
		}
	}

	public function edit($id) {
		$product_sub = ProductSub::findOrFail($id);
		$this->data['data'] = $product_sub->toArray();
		return view('product.product.edit_product_sub', $this->data);
	}

	public function update(Request $request, $id) {

		$product_sub = ProductSub::findOrFail($id);
		$product_sub->price = $request->input('price');
		$product_sub->sale_price = $request->input('sale_price');
		$product_sub->review = $request->input('review');
		$product_sub->is_show = $request->input('is_show');
		$product_sub->sort_order = $request->input('sort_order');
		//  上传文件
		$filename = '';
		if( $request->hasFile('file') ) {       
			$file = $request->file('file');
			$uploads = new UploadsManager();
			$filename = $uploads->upload_file($file);
		}
		$product_sub->image = $filename;
		$result = $product_sub->save();

		if($result){
			return redirect('/product/product_sub/'.$product_sub->product_id)->withSuccess('添加成功!');
		} else {
			return redirect('/product/product_sub/'.$product_sub->product_id)->withWarning('添加失败!');
		}
	}

	public function destroy($id) {
		$product_sub = ProductSub::findOrFail($id);

		$product_sub->delete();

		if($product_sub->trashed()) {
			return redirect('/product/product_sub/'.$product_sub->product_id)->withSuccess('删除成功!');
		} else {
			return redirect('/product/product_sub/'.$product_sub->product_id)->withWarning('删除失败!');
		}
	}

	// 自动生成表单
	public function ajax_create_form(Request $request) {
		$form_data = array();
		$default_value_data = array();
		// 获取商品的category_id
		$product = Product::findOrFail($request->input('product_id'));
		$category_id = $product->category_id;

		// 获取子商品选项信息
		if($request->input('product_sub_id') !== null){
			$product_sub = ProductSub::findOrFail($request->input('product_sub_id'))->toArray();
			$private_attr = json_decode($product_sub['private_attr'],true);
			foreach($private_attr as $key=>$attr) {
				if(is_array($attr)){
					foreach($attr as $k=>$value) {
						$default_value_data[$key][] = $k;
					}
				} else {
					$default_value_data[$key] = $attr;
				}
			}
		}

		// 根据category_id获取选项和选项属性值
		$category = Category::findOrFail($category_id);
		$option_groups = $category->option_group->toArray();
		foreach($option_groups as $group) {
			$option_group = OptionGroup::findOrFail($group['id']);
			$attrs = $option_group->attr->toArray();
			foreach($attrs as $attr) {
				$array = array();
				$attr_value = Attr::findOrFail($attr['id'])->AttrValue->toArray();
				foreach($attr_value as $a) {
					$array['item'][$a['id']] = $a['name'];
				}
				$array['label_name'] = $attr['name'];
				$array['input_name'] = 'option_'.$attr['input_name'];
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
				$is_disabled = false;
				foreach ($default_value_data as $key => $value) {
					if($key == substr($data['input_name'], 7) ){
						$default_value = $value;
						$is_disabled = true;
					}
				}
				if($data['input_box_type'] == '1') {
					$html .= $form->$input_box[$data['input_box_type']]($data['label_name'], $data['input_name'], $default_value);
				} else {
					$html .= $form->$input_box[$data['input_box_type']]($data['label_name'], $data['input_name'], $data['item'], $default_value, $is_disabled);
				}
			}
		}
		echo $html;
	}
}
