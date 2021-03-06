<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\ProductSub;
use App\Brand;
use App\Supplier;
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
		$this->data['breadcrumbs'] = $this->breadcrumbs($request);
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
		$this->data['product_sub'] = $pro->toArray();
		return view('product.product.show', $this->data);
	}

	//  查看子商品详情
	public function show_details($id) {
        $pro = array();
        // 获取子商品信息
        $product_sub = ProductSub::findOrFail($id);
		$pro['product_sub_id'] = $id;

        $product = $product_sub->Product;
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

	// ajax 获取子商品信息
	public function ajax_pro_sub(Request $request) {
		$pro_sub = ProductSub::findOrFail($request->input('product_sub_id'));
		echo $pro_sub->toJson();
	}

	public function create($id) {
		$this->data['product_id'] = $id;
		return view('product.product.add_product_sub', $this->data);
	}

	// 生成商品编号   子商品编号规则：品类id3位（不足3位补0）+6位数字随机组合；保证唯一性。
	public function buildProductNo($category_id) {
		// 生成产品编号
		$productNo = str_pad($category_id, 3, '0', STR_PAD_LEFT).rand(100000, 999999);
		// 验证唯一性
		$has = ProductSub::where('productNo', $productNo)->count();
		if($has != 0) {
			return $this->buildProductNo($category_id);
		}
		return $productNo;
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

	public function store(Requests\ProductSubRequest $request) {
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
		// 查询子商品选项
		$private_attr = $product->ProductSub()->pluck('private_attr')->first();
		if(!empty($private_attr)) { // 当子商品存在
			$private_attr_length = count(json_decode($private_attr, true));
			if( $private_attr_length != count($options) ) { // 选项结构跟换时..停用现有全部子商品
				$product->ProductSub()->update(['is_show'=>'0']);
			}
		}

		$private_attr = '';
		if(count($options) > 0) {   // 设置了选项值,批量添加
			// 计算选项值排列组合结果集
			if(count($options) > 1 ) {  
				$options = $this->option_assemble($options);
				$options = call_user_func_array('array_merge',$options);  // 二维转一维
			} else {   // 选项值只有一个的情况
				$array = array();
				foreach($options as $key=>$option) {
					foreach($option as $o) {
						$attr_value = AttrValue::findOrFail($o);
						$array[] = array($key=>array($attr_value->id=>$attr_value->name));
					}
				}
				$options = $array;
			}

			// 验证子商品是否需要下架
			$private_attr = $product->ProductSub->pluck('private_attr','id')->toArray();
			foreach ($private_attr as $key => $value) {
				//var_dump($value);
				foreach($options as $option) {
					$json = json_encode($option);
					if($value == $json) {
						continue;
					}
					// 停用子商品
					ProductSub::find($key)->update(['is_show'=>'0']);
				}
			}
			$product_sub = array();
			foreach($options as $option) {
				$private_attr = json_encode($option);
				// 验证选项值是否冲突
				$check = ProductSub::where('private_attr', $private_attr)->count();
				if( $check > 0 )
					continue;

				$product_sub[] = new ProductSub(['productNo'=>$this->buildProductNo($product->category_id),
						'price'=>$request->input('price'),
						'sale_price' => $request->input('sale_price'),
						'review' => $request->input('review'),
						'is_show' => $request->input('is_show'),
						'sort_order' => $request->input('sort_order'),
						'image' => $filename,
						'private_attr' => $private_attr,
					]);
			}
			if(count($product_sub) > 0 ){
				$result = $product->ProductSub()->saveMany($product_sub);   // 批量添加
			} else {
				return redirect('/product/product_sub/'.$request->input('product_id'))
						->withSuccess('没有修改!');
			}
		} else {   // 单个子商品
			$product_sub = new ProductSub();
			$product_sub->productNo = $this->buildProductNo($product->category_id);
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

	public function update(Requests\ProductSubRequest $request, $id) {

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
		// 获取表单的类型
		$form_type = $request->input('form_type');
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
		} else {  // 获取已经添加的子商品选项信息
			$private_attr = $product->ProductSub()->pluck('private_attr');
			$options = array();
			foreach($private_attr as $attr){
				$option = json_decode($attr, true);
				$options = array_merge_recursive($option,$options);
			}
			foreach($options as $key=>$option){
				$k = array_keys($option);
				$default_value_data[$key] = $k;
			}
		}
		// 根据category_id获取选项和选项属性值
		$disable = array();
		$category = Category::findOrFail($category_id);
		$option_groups = $category->option_group->toArray();
		foreach($option_groups as $group) {
			if($form_type == 'create') {  // 添加时,忽略status为停用状态的属性组
				if($group['status'] == 0){
					continue;
				}
			} elseif( $form_type == 'update') {  // 修改时,标记status为0的属性
				if($group['status'] == 0){
					$option_group = OptionGroup::findOrFail($group['id']);
					$attrs = $option_group->attr->toArray();
					foreach($attrs as $attr) {
						$disable[] = $attr['input_name'];
					}
				}
			}
			$option_group = OptionGroup::findOrFail($group['id']);
			$attrs = $option_group->attr->toArray();
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
				$is_continue = true;  // 第一次新增拉取全部选项值, 第二次新增只拉取选过的选项组和属性值
				foreach ($default_value_data as $key => $value) {
					if($key == substr($data['input_name'], 7) ){
						$default_value = $value;
						if($form_type == 'update')
							$is_disabled = true;
						$is_continue = false;
					} 
				}
				if($is_continue && $default_value_data)
					continue;
				$disable_value = false;
				if(in_array( (substr($data['input_name'], 7)), $disable)) {
					$disable_value = true;
				}
				if($data['input_box_type'] == '1') {
					$html .= $form->$input_box[$data['input_box_type']]($data['label_name'], $data['input_name'], $default_value, false, $disable_value);
				} else {
					$html .= $form->$input_box[$data['input_box_type']]($data['label_name'], $data['input_name'], $data['item'], $default_value, $is_disabled, $disable_value);
				}
			}
		}
		echo $html;
	}
}
