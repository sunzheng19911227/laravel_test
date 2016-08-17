<?php
/**
 *  菜单管理
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Permission;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\TreeController;

class MenuController extends AdminBaseController
{
    private $data;

    public function __construct(Request $request)
    {
    	//  获取左侧菜单
        $this->data['menus'] = $this->getMeunList();
        // 获取当前路由
        $this->data['route_path'] = $request->path();
        //  获取二级数据
        //$this->data['lists'] = Permission::with('chindren')->where('pid', '=', '0')->get()->toArray();
        $permissions = Permission::all()->toArray();
        $tree = new TreeController();
        $tree->tree($permissions);
        $this->data['lists'] = $tree->getArray();
    }

    // 显示页面
    public function index(){
    	return view('admin.menus.list', $this->data);
    }

    //  显示单页
    public function show(){
    	return view('admin.menus.list', $this->data);
    }

    // 添加页面
    public function create(){
    	return view('admin.menus.add', $this->data);
    }

    // 添加处理
    public function store(Requests\PermissionRequest $request) {
    	//  验证表单数据
    	$validator = $this->validator( $request->all() );
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        //  添加数据
        $permission = new Permission();
        $permission->pid = $request->input('pid');
        $permission->name = $request->input('name');
        $permission->label = $request->input('label');
        $permission->route = $request->input('route');
        $permission->description = $request->input('description');
        $permission->is_display = $request->input('is_display');
        $permission->sort_order = $request->input('sort_order');
        $result = $permission->save();

    	if($result){
    		return redirect('/admin/menus')->withSuccess('添加成功!');
    	} else {
    		return redirect('/admin/menus')->withWarning('添加失败!');
    	}
    }

    // 修改页面
    public function edit($id) {
    	$this->data['data'] = Permission::find($id)->toArray();
    	return view('admin.menus.edit', $this->data);
    }

    // 修改处理
    public function update(Requests\PermissionRequest $request) {
    	//  验证表单数据
    	$validator = $this->validator( $request->all(), 'update');
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        //  添加数据
        $permission = Permission::find($request->input('id'));
        $permission->pid = $request->input('pid');
        $permission->label = $request->input('label');
        $permission->route = $request->input('route');
        $permission->description = $request->input('description');
        $permission->is_display = $request->input('is_display');
        $permission->sort_order = $request->input('sort_order');
        $result = $permission->save();

    	if($result){
    		return redirect('/admin/menus')->withSuccess('更新成功!');
    	} else {
    		return redirect('/admin/menus')->withWarning('更新失败!');
    	}
    }

    // 删除处理
    public function destroy($id){
    	// 判断是否有下级菜单
    	$data = Permission::find($id)->toArray();
    	if($data['pid'] == '0'){
			$result = Permission::destroy($id);
			$result = Permission::where('pid', '=', $id)->delete();
    	} else {
    		$result = Permission::destroy($id);
    	}

    	if($result){
    		return redirect('/admin/menus')->withSuccess('删除成功!');
    	} else {
    		return redirect('/admin/menus')->withWarning('删除失败!');
    	}
    }

    //  表单认证
    protected function validator(array $data, $type = 'store')
    {
        $Verification = array();
        if($type == 'update'){
        	//$Verification['name'] = 'required|max:255';
        } else {
        	$Verification['name'] = 'required|max:255|unique:permissions';
        }
        $Verification['label'] = 'required|max:255';
        $Verification['route'] = 'required|max:255';
        return Validator::make($data, $Verification);
    }
}
