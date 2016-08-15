<?php

namespace App\Http\Controllers;

use App\Attr;
use App\ProductSub;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class SyncController extends Controller
{
	//
	public function sync_mall() {
		$product_id = '6';
		// 查找子商品信息
		$ProductSub = ProductSub::findOrFail($product_id);
		// 查找主商品信息
		$product = $ProductSub->product;
		var_dump($product->public_attr);
		//  查找供应商,品牌相关信息
		$brand = $product->brand;
		$supplier = $product->supplier;

		$public_attr = json_decode($product->public_attr);
		var_dump($public_attr);
		// 验证属性组是否存在
		foreach($public_attr as $key=>$value){
			if(is_array($value)) {

			} else {
				// 查找属性信息
				$attr = Attr::where('input_name', $key)->first();
				var_dump($attr->toArray());
				var_Dump($attr->name);
				// 查找属性是否存在
				$attribute = DB::connection('mall')->table('attribute_description')->where('name', $attr->name)->get();
				if(!$attribute) {
					// 没有属性先查找属性组,再添加属性
					$attr_group = $attr->AttrGroup->first();
					var_dump($attr_group->name);
					// 验证属性组存在
					DB::connection('mall')->table('attribute_group')->select();
					// 添加属性
					$attribute_group_id = DB::connection('mall')->table('attribute_group')
					->insertGetId(['sort_order'=>'0'], 'attribute_group_id');
					$result = DB::connection('mall')->table('attribute_group_description')
					->insert(['attribute_group_id'=>$attribute_group_id,
						'language_id'=>'1',
						'name'=>$attr_group->name]);
					var_Dump($result);
					exit;
				}
				var_dump($attribute);
			}
		}
	}

	//  获取品牌
	public function get_brand(){
		//  验证是否已存在品牌
		$manufacturer = DB::connection('mall')->table('manufacturer')->where('name',$brand->name)->get();
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
				$manufacturer = DB::connection('mall')->table('manufacturer')->where('name',$brand->name)->get();
			}
		}
	}

	// 获取供应商
	public function get_supplier(){
		// 验证是否已存在供应商
		$merchant = DB::connection('mall')->table('merchant')->where('name',$supplier->name)->get();
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
				$merchant = DB::connection('mall')->table('merchant')->where('name',$supplier->name)->get();
			}
		}
	}
}
