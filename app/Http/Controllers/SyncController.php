<?php

namespace App\Http\Controllers;

use App\Attr;
use App\ProductSub;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Exception;
use Log;

class SyncController extends Controller
{
	// 异常
	protected $exceptions = ['101'=>'商品添加失败',
						 	 '102'=>'商品详情添加失败',
						 	 '103'=>'商品属性添加失败',
						 	 '104'=>'商品选项添加失败',
						 	 '105'=>'商品选项值添加失败',
						 	 '201'=>'品牌添加失败',
							];

	//   todu 同步分销 和  商城
	// 
	public function sync_mall($id = '6') {
		try{
			// 查找子商品信息
			$ProductSub = ProductSub::findOrFail($id);
			//var_dump($ProductSub->toArray());
			// 查找主商品信息
			$product = $ProductSub->product;
			//var_dump($product->toArray());
			DB::connection('mall')->beginTransaction();
			//  查找供应商, 品牌相关信息
			$manufacturer = $this->get_brand($product->brand);
			//var_Dump($manufacturer);
			$merchant = $this->get_supplier($product->supplier);
			//var_dump($merchant);
			// 添加数据
			$mall_product = array();
			$mall_product['model'] = '';
			$mall_product['card_model'] = '0';
			$mall_product['quantity'] = '0';
			$mall_product['stock_status_id'] = '0';
			$mall_product['image'] = '';     // 获取转移后图片地址
			$mall_product['manufacturer_id'] = $manufacturer->manufacturer_id;   //  获取新的品牌id
			$mall_product['shipping'] = 0;
			$mall_product['price'] = $ProductSub->price;         //  价格
			$mall_product['points'] = 0;					  //  积分
			$mall_product['tax_class_id'] = 0;				  //  商品税类
			$mall_product['date_available'] = '0000-00-00';   //  供货日期
			$mall_product['weight'] = '0.0000';               //  重量
			$mall_product['weight_class_id'] = '0';           //  重量单位
			$mall_product['length'] = '0';
			$mall_product['width'] = '0';
			$mall_product['height'] = '0';
			$mall_product['length_class_id'] = '0';           //  尺寸单位
			$mall_product['subtract'] = '1';                  //  扣除库存
			$mall_product['minimum'] = '1';                   //  最小起订数量
			$mall_product['sort_order'] = '0';                //  排序
			$mall_product['is_show'] = '0';                   //  是否前台显示
			$mall_product['is_check'] = '0';                  //  是否审核
			$mall_product['status'] = '2';                    //  商品状态(0:失效,1:正常,2:下架)
			$mall_product['date_added'] = date('Y-m-s H:i:s');
			$mall_product['date_modified'] = date('Y-m-s H:i:s');
			$mall_product['viewed'] = 0;
			$mall_product['purchase_price'] = $ProductSub->price;//  采购价格
			$mall_product['merchant_id'] = $merchant->merchant_id;  //
			$mall_product['merchant'] = $merchant->name;
			$product_id = DB::connection('mall')->table('product')->insertGetId($mall_product,'product_id');
			if($product_id) {
				$this->throw_exception(101);
			}

			//  添加商品详情
			$mall_product_description = array();
			$mall_product_description['product_id'] = $product_id;
			$mall_product_description['language_id'] = '1';
			$mall_product_description['name'] = $product->name;
			$mall_product_description['description'] = $product->details;
			$mall_product_description['detail'] = $product->description;
			$mall_product_description['meta_description'] = $product->seo_description;
			$mall_product_description['meta_keyword'] = $product->seo_keywords;
			$mall_product_description['tag'] = $product->label;
			$mall_product_description['subtitle'] = '';
			//var_dump($mall_product_description);
			//exit;
			$result = DB::connection('mall')->table('product_description')->insert($mall_product_description);
			if(!$result) {
				$this->throw_exception(102);	
			}
			if($ProductSub->private_attr){
				$private_attr = json_decode($ProductSub->private_attr,true);
				$options = $this->get_option($private_attr);
				//var_Dump($options);
			}
			if($product->public_attr){
				$public_attr = json_decode($product->public_attr,true);
				$attributes = $this->get_attribute($public_attr);
				//var_dump($attributes);
			}
			//exit;
			$mall_product_attributes = array();
			foreach($attributes as $attribute) {
				//  添加商品属性表
				$mall_product_attribute = array();
				$mall_product_attribute['product_id'] = $product_id;
				$mall_product_attribute['attribute_id'] = $attribute->attribute_id;
				$mall_product_attribute['language_id'] = '1';
				$mall_product_attribute['text'] = $attribute->text;
				$mall_product_attributes[] = $mall_product_attribute;
			}
			$result = DB::connection('mall')->table('product_attribute')->insert($mall_product_attributes);
			if(!$result) {
				$this->throw_exception(103);	
			}

			foreach($options as $option_id=>$option_value_id) {
				//  添加商品选项表
				$mall_product_option = array();
				$mall_product_option['product_id'] = $product_id;
				$mall_product_option['option_id'] = $option_id;
				$mall_product_option['option_value'] = '';
				$mall_product_option['required'] = '1';
				$product_option_id = DB::connection('mall')->table('product_option')->insertGetId($mall_product_option, 'product_option_id');
				if(!$product_option_id) {
					$this->throw_exception(104);
				}
				//  添加商品选项值表
				$mall_product_option_value = array();
				$mall_product_option_value['product_option_id'] = $product_option_id;
				$mall_product_option_value['product_id'] = $product_id;
				$mall_product_option_value['option_id'] = $option_id;
				$mall_product_option_value['option_value_id'] = $option_value_id;
				$mall_product_option_value['quantity'] = '0';
				$mall_product_option_value['subtract'] = 1;
				$mall_product_option_value['price'] = '0.0000';
				$mall_product_option_value['price_prefix'] = '+';
				$mall_product_option_value['points'] = '0';
				$mall_product_option_value['weight'] = '0';
				$mall_product_option_value['weight_prefix'] = '+';
				$mall_product_option_value['other_option_code'] = '';
				$mall_product_option_value['other_option_codeTow'] = '';
				$result = DB::connection('mall')->table('product_option_value')->insert($mall_product_option_value);
				if(!$result) {
					$this->throw_exception(105);
				}
			}
			DB::connection('mall')->commit();
		} catch(Exception $e) {
			DB::connection('mall')->rollback();
			$data = array('code'=>$e->getCode(), 'message'=>$e->getMessage());
			echo json_encode($data);
			// 获取当前登录用户 $request->user()
			Log::error(json_encode($data));
		}
	}

	//  抛出异常
	protected function throw_exception($code) {
		throw new Exception($this->exceptions[$code], $code);
	}
	

	// 验证选项是否存在
	protected function get_option($private_attr){
		$options = array();
		foreach($private_attr as $key=>$value) {
			// 查找属性信息
			$attr = Attr::where('input_name', $key)->first();
			// 查找选项是否存在
			$option = $this->check_option($attr);
			$option_id = $option?$option->option_id:$option_id;
			foreach($value as $k=>$v){
				// 验证选项值存在
				$option_value = $this->check_option_value($option_id, $v);
				$options[$option_id] = $option_value->option_value_id;
			}
		}
		return $options;
	}

	//  验证选项的存在
	protected function check_option($attr){
		$option = DB::connection('mall')->table('option_description')->where('name',$attr->name)->first();
		if(!$option) {
			// 添加选项
			$option_id = DB::connection('mall')->table('option')->insertGetId(['type'=>'radio','sort_order'=>'1']);
			$result = DB::connection('mall')->table('option_description')->insert(['option_id'=>$option_id,'language_id'=>1,'name'=>$attr->name]);
			if($result){
				$this->check_option($attr);
			}
		}
		return $option;
	}

	// 验证选项值存在
	protected function check_option_value($option_id, $value) {
		$option_value = DB::connection('mall')->table('option_value_description')->where('option_id', $option_id)->where('name', $value)->first();
		if(!$option_value) {
			// 添加选项值 
			$option_value_id = DB::connection('mall')->table('option_value')->insertGetId(['option_id'=>$option_id,'image'=>'no_image.jpg','sort_order'=>1]);
			$result = DB::connection('mall')->table('option_value_description')->insert(['option_value_id'=>$option_value_id,'language_id'=>1,'option_id'=>$option_id,'name'=>$value]);
			if($result){
				$this->check_option_value($option_id, $value);
			}
		}
		return $option_value;
	}

	// 验证属性组是否存在
	protected function check_attribute_group($attr_group){
		// 验证属性组存在
		$attribute_group = DB::connection('mall')->table('attribute_group_description')->where('name',$attr_group->name)->first();
		if(!$attribute_group) {
			// 添加属性组
			$attribute_group_id = DB::connection('mall')->table('attribute_group')->insertGetId(['sort_order'=>'0'], 'attribute_group_id');
			$result = DB::connection('mall')->table('attribute_group_description')->insert(['attribute_group_id'=>$attribute_group_id,'language_id'=>'1','name'=>$attr_group->name]);
			if($result) {
				$this->check_attribute_group($attr_group);
			}
		}
		return $attribute_group;
	}

	// 验证属性是否存在
	protected function get_attribute($public_attr) {
		// var_dump($public_attr);
		// 验证属性组是否存在
		$attributes = array();
		foreach($public_attr as $key=>$value) {
			// 查找属性信息
			$attr = Attr::where('input_name', $key)->first();
			// 查找属性是否存在
			$attribute = DB::connection('mall')->table('attribute_description')->where('name', $attr->name)->first();
			if(!$attribute) {
				// 没有属性先查找属性组,再添加属性
				$attr_group = $attr->AttrGroup->first();
				// 验证属性组存在
				$attribute_group = $this->check_attribute_group($attr_group);
				$attribute_group_id = $attribute_group?$attribute_group->attribute_group_id:$attribute_group_id;
				// 添加属性
				$attribute_id = DB::connection('mall')->table('attribute')->insertGetId(['attribute_group_id'=>$attribute_group_id, 'sort_order'=>'0']);
				$result = DB::connection('mall')->table('attribute_description')->insert(['attribute_id'=>$attribute_id, 'language_id'=>'1', 'name'=>$attr->name]);
			} else {
				if(is_array($value)){
					foreach($value as $v){
						$attribute->text = $v;
					}
				} else {
					$attribute->text = $value;	
				}
				$attributes[] = $attribute;		
			}
		}

		if(!$attributes){
			$this->check_attribute($public_attr);
		} else {
			return $attributes;
		}
	}

	//  获取品牌
	protected function get_brand($brand){
		//  验证是否已存在品牌
		$manufacturer = DB::connection('mall')->table('manufacturer')->where('name',$brand->name)->first();

		if(!$manufacturer) {
			// 没有查找到品牌,新增
			$manufacturer_id = DB::connection('mall')
			->table('manufacturer')
			->insertGetId(
				['name' => $brand->name,
				'image' => '',
				'sort_order' => '0'], 
				'manufacturer_id');
			if($manufacturer_id){
				$this->get_brand($brand);
			} else {
				$this->throw_exception(201);
			}
		} else {
			return $manufacturer;
		}
	}

	// 获取供应商
	protected function get_supplier($supplier){
		// 验证是否已存在供应商
		$merchant = DB::connection('mall')->table('merchant')->where('name', $supplier->name)->first();
		if(!$merchant) {
			// 没有查找到供应商,新增
			$merchant_id = DB::connection('mall')->table('merchant')->insertGetId(['name' => $supplier->name,
				'interface_type' => '',
				'description' => '',
				'image' => '',
				'sort_order' => '0',
				'status' => '1',
				'date_added' => date('Y-m-s H:i:s'),
				'date_modified' => date('Y-m-s H:i:s'),
				'is_shipping' => '0',
				'shipping_status' => '0',
				'invoice_type' => '0'], 'merchant_id');
			if($merchant_id){
				$this->get_supplier($supplier);
			}
		} else {
			return $merchant;
		}
	}
}
