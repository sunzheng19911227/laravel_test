<?php
/**
 *  管理员管理
*/


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\RoleUser;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Auth\AuthController;


class AdminController extends AdminBaseController
{
    private $data;

    public function __construct(Request $request)
    {
        //  获取左侧菜单
        $this->data['menus'] = $this->getMeunList();
        // 获取当前路由
        $this->data['route_path'] = $request->path();
    }

    // 显示页面
    public function index(){
    	$this->data['lists'] = User::all()->toArray();
    	return view('admin.admins.list', $this->data);
    }

    //  显示单页
    public function show(){
    	return view('admin.admins.list', $this->data);
    }

    // 添加页面
    public function create(){
    	return view('admin.admins.add', $this->data);
    }

    // 添加处理
    public function store(Request $request) {
    	// 注册管理员
    	$Auth = new AuthController();
    	$result = $Auth->register($request);

    	if($result){
    		return redirect('/admin/admins')->withSuccess('添加成功!');
    	} else {
    		return redirect('/admin/admins')->withWarning('添加失败!');
    	}
    }

    // 修改页面
    public function edit($id) {
    	$this->data['data'] = User::find($id)->toArray();
    	return view('admin.admins.edit', $this->data);
    }

    // 修改处理
    public function update(Request $request) {
    	$Auth = new AuthController();
    	$result = $Auth->update($request->all());

    	if($result){
    		return redirect('/admin/admins')->withSuccess('更新成功!');
    	} else {
    		return redirect('/admin/admins')->withWarning('更新失败!');
    	}
    }

    // 删除处理
    public function destroy($id){
    	$result = User::destroy($id);

    	if($result){
    		return redirect('/admin/admins')->withSuccess('删除成功!');
    	} else {
    		return redirect('/admin/admins')->withWarning('删除失败!');
    	}
    }

    // 分配权限组
    public function assign($id){
    	// 
    	$this->data['data'] = User::find($id);
    	// 获取用户组
    	$this->data['roles'] = Role::all();
    	// 
    	$this->data['role_user'] = RoleUser::where('user_id','=',$id)->get()->toArray();
    	return view('admin.admins.assign', $this->data);
    }

    //
    public function assign_update(Request $request) {
    	$user = new User();
    	$user = $user->find($request->input('id'));

    	// 清除原有用户组
    	$user->roles()->detach();

    	$role = new Role();
    	foreach($request->input('role_id') as $r){
	    	$role = $role->find($r);
	    	$result = $user->assignRole($role->name);
    	}
    	return redirect('/admin/admins')->withSuccess('成功!');
    }
}
