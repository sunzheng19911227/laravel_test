<?php

namespace App\Http\Controllers\Channel;

use Illuminate\Http\Request;
use App\Channel;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;

class ChannelController extends AdminBaseController
{
	private $data;

	public function __construct(Request $request)
	{
		//  获取左侧菜单
		$this->data['menus'] = $this->getMeunList();
		// 获取当前路由
		$this->data['route_path'] = $request->path();
	}

	public function index() {
		$this->data['lists'] = Channel::all();
		return view('channel.channel.list', $this->data);
	}

	public function create() {
		return view('channel.channel.add', $this->data);
	}

	public function store(Requests\ChannelsRequest $request){
		$channel = new Channel;
		$channel->name = $request->input('name');
		$channel->is_sync = $request->input('is_sync');
		$result = $channel->save();

		if($result) {
    	   	return redirect('/channel/channels')->withSuccess('添加成功!');
    	} else {
    		return redirect('/channel/channels')->withWarning('添加失败!');
    	}
	}

	public function edit($id){
		$channel = Channel::findOrFail($id);
    	$this->data['data'] = $channel->toArray();
    	return view('channel.channel.edit', $this->data); 
	}

	public function update(Requests\ChannelsRequest $request, $id) {
		$channel = Channel::findOrFail($id);
		$channel->name = $request->input('name');
		$channel->is_sync = $request->input('is_sync');
		$result = $channel->save();

		if($result) {
    	   	return redirect('/channel/channels')->withSuccess('编辑成功!');
    	} else {
    		return redirect('/channel/channels')->withWarning('编辑失败!');
    	}
	}


    	} else {
    	}
    }
}
