<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sync extends Model
{
    protected $table = 'sync';



    #########################   业务逻辑 #########################
    // 同步  渠道 商品 关联数据
    public static function sync_data($product_id, $channel_product_id, $type = 'mall') {
    	$sync = Sync::where('product_id',$product_id)->first();
    	if(empty($sync)) {  // 没有数据,创建同步数据
    		$sync = new sync;
    		$sync->product_id = $product_id;
    		$sync->save();
    	}
    	// 更新同步数据
    	if($type == 'mall'){
	    	$sync->mall_product_id = $channel_product_id;
	    } elseif($type == 'fenxiao'){
	    	$sync->fenxiao_product_id = $channel_product_id;
	    }
    	return $sync->save();
    }
}
