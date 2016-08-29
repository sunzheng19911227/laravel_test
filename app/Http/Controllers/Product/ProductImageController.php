<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\ProductImage;
use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use App\Services\UploadsManager;

class ProductImageController extends AdminBaseController
{
    private $data;

	public function __construct(Request $request)
	{
		//  获取左侧菜单
		$this->data['menus'] = $this->getMeunList();
		$this->data['breadcrumbs'] = $this->breadcrumbs($request);
		// 获取当前路由
		$this->data['route_path'] = $request->path();
	}

	public function show($id) {
		// 获取
		$this->data['product_id'] = $id;
		$image_list = ProductImage::where('product_id', $id)->paginate(10);
		$this->data['images'] = $image_list;
		return view('product.product_image.list', $this->data);
	}

	public function uploads(Request $request) {
		$data = array();
		if( $request->hasFile('file') ) {
			$file = $request->file('file');
			$data['original'] = $file->getClientOriginalName();
			$data['type'] = substr($data['original'], strrpos($data['original'], '.'));
			$data['size'] = $request->input('size');
			$uploads = new UploadsManager();
			$filename = $uploads->upload_file($file);
			$data['title'] = $filename;
			$data['url'] = $filename;
		}

		$image = new ProductImage();
		$image->product_id = $request->input('product_id');
		$image->image_url = $filename;
		$result = $image->save();
		if($result) {
			$data['state'] = 'SUCCESS';
		} else {
			$data['state'] = 'FAIL';
		}
		echo json_encode($data);
	}

	public function destroy($id) {
		$result = ProductImage::destroy($id);
		echo $result;
	}
}
