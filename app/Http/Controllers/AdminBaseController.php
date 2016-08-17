<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Permission;
use Gate;

class AdminBaseController extends Controller
{

	public function __construct() {
		$this->middleware('auth');
	}

	// 获取菜单列表
	public function getMeunList() {
		$menulist = Permission::where('is_display','=','1')->orderBy('id')->orderBy('sort_order')->get()->toArray();
		$menus = array();
		foreach($menulist as $key=>$m){
			if(Gate::allows($m['label']) === false){
				continue;
			}
			if($m['pid'] == 0) {
				$menus[$m['id']] = $m;
			}else{
				if(isset($menus[$m['pid']])){
					$menus[$m['pid']]['menus'][] = $m;
				}
			}
		}
		return $menus;
	}
}
