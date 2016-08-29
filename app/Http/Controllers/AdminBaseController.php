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
		$numeric = array();
		foreach($routes as $route) {
			if(is_numeric($route)) {  // 遇到id跳过
				$numeric[] = $route;
				continue;
			}
			$sql->where('route','like','%'.$route.'%');
		}
		$menu = $sql->first();
		$m = array();
		if(!empty($menu) && $menu->pid != 0) {
			$m = $this->getSuperiorMenu($menu->pid);
			array_unshift($m, $menu);
		}
		// 替换参数值
		if( !empty($numeric) ) {
			$m = $this->replaceRouteParam($m, $numeric);
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

	// 替换路由中的参数
	protected function replaceRouteParam($routes, $numeric) {
		foreach($routes as $key=>$value) {
			//var_dump($value->route);
			// 查找替换参数
			$start = strpos($value->route, '{');
			$end = strpos($value->route, '}');
			if($start == false || $end == false) {
				continue;
			}
			// 替换
			$param = substr($value->route, $start, $end);
			$replace = array_shift($numeric);
			$route = str_replace($param, $replace, $value->route);
			$routes[$key]->route = $route; 
		}
		// 验证是否还存在需要替换的参数
		$is_replace = false;
		foreach($routes as $key=>$value) {
			// 查找替换参数
			$start = strpos($value->route, '{');
			$end = strpos($value->route, '}');
			if($start == false || $end == false) {
				continue;
			}
			$is_replace = true;
		}
		if( $is_replace ) {
			if( !empty($numeric) ) {
				$this->replaceRouteParam($routes, $numeric);
			}
		} else {
			return $routes;
		}
	}
}
