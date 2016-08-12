<?php
//  权限组管理
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Role;
use App\Permission;
use App\PermissionRole;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\TreeController;

class RoleController extends AdminBaseController
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
    public function index() {
    	$this->data['lists'] = Role::all()->toArray();
    	return view('admin.roles.list', $this->data);
    }

    //  显示单页
    public function show(){
    	return view('admin.roles.list', $this->data);
    }

    // 添加页面
    public function create(){
    	return view('admin.roles.add', $this->data);
    }

    // 添加处理
    public function store(Request $request) {
    	//  验证表单数据
    	$validator = $this->validator( $request->all() );
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //  添加数据
        $role = new Role();
        $role->name = $request->input('name');
        $role->label = $request->input('label');
        $role->description = $request->input('description');
        $result = $role->save();

    	if($result){
    		return redirect('/admin/roles')->withSuccess('添加成功!');
    	} else {
    		return redirect('/admin/roles')->withWarning('添加失败!');
    	}
    }

    // 修改页面
    public function edit($id) {
    	$this->data['data'] = Role::find($id)->toArray();
    	return view('admin.roles.edit', $this->data);
    }

    // 修改处理
    public function update(Request $request) {
    	//  验证表单数据
    	$validator = $this->validator( $request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        //  添加数据
        $role = Role::find($request->input('id'));
        $role->name = $request->input('name');
        $role->label = $request->input('label');
        $role->description = $request->input('description');
        $result = $role->save();

    	if($result){
    		return redirect('/admin/roles')->withSuccess('更新成功!');
    	} else {
    		return redirect('/admin/roles')->withWarning('更新失败!');
    	}
    }

    // 删除处理
    public function destroy($id){
    	$result = Role::destroy($id);

    	if($result){
    		return redirect('/admin/roles')->withSuccess('删除成功!');
    	} else {
    		return redirect('/admin/roles')->withWarning('删除失败!');
    	}
    }

    // 分配权限
    public function assign($id) {
    	// 获取用户组信息
    	$this->data['data'] = Role::find($id)->toArray();
    	// 获取权限信息
    	$menus = Permission::all()->toArray();
    	$tree = new TreeController();
    	$tree->tree($menus);
    	$this->data['lists'] = $tree->getArray();
    	// 获取用户组和权限关联信息
    	$permissions = PermissionRole::where('role_id','=',$id)->get()->toArray();
    	$this->data['permission_role'] = $permissions;
    	return view('admin.roles.assign',$this->data);
    }

    // 分配权限
    public function assign_update(Request $request){
    	// 清除原有权限
    	$permission_role = PermissionRole::where('role_id','=',$request->input('id'))->get();
    	if(count($permission_role->all()) > 0){
    		$result = PermissionRole::where('role_id','=',$request->input('id'))->delete();
    	}
    	// 添加新权限
    	$data = array();
    	$role = new Role(); 
    	$role = $role->find($request->input('id'));
    	foreach($request->input('pid') as $pid){
    		$permissions = Permission::find($pid);
    		$result = $role->givePermissionTo($permissions);
    	}
    	return redirect('/admin/roles')->withSuccess('编辑成功!');
    }

    //  表单认证
    protected function validator(array $data, $type = 'store')
    {
        $Verification = array();
        $Verification['name'] = 'required|max:255';
        $Verification['label'] = 'max:255';
        $Verification['description'] = 'max:255';
        return Validator::make($data, $Verification);
    }
}
