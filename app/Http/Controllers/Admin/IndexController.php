<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use Auth;

class IndexController extends AdminBaseController
{
	private $data;

    public function __construct()
    {
        $this->data['menus'] = $this->getMeunList();
    }

    public function index()
    {
        return view('admin.index',$this->data);
    }

}