<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Permission;
use Gate;
use DB;

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

	// 分成面包屑
	public function breadcrumbs($request) {
		// 分解路由地址
		$routes = explode('/', $request->path());
		$sql = DB::table('permissions');
		foreach($routes as $route) {
			if(is_numeric($route)) {  // 遇到id跳过
				continue;
			}
			$sql->where('route','like','%'.$route.'%');
		}
		$menu = $sql->first();
		if($menu->pid != 0) {
			$m = $this->getSuperiorMenu($menu->pid);
			array_unshift($m, $menu);
		}
		return $m;
	}

	// 获得上级菜单
	protected function getSuperiorMenu($pid, $array = array()) {
		$m = DB::table('permissions')->where('id',$pid)->first();
		array_push($array, $m);
		if($m->pid != 0) {
			return $this->getSuperiorMenu($m->pid, $array);
		} else {
			return $array;
		}
	}
}
