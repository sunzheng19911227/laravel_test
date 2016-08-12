<?php
// 文件上传
namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;   // 文件管理

class UploadsManager
{
	protected $storage;
	protected $dir_name;   //文件目录

	public function __construct(){
		$this->storage = Storage::disk('uploads');
		// 按月份生成
		// $this->dir_name = date('Ymd');
		// if(!$Storage->exists($this->dir_name)) {
		// 	$Storage->makeDirectory($this->dir_name, 0755, true);
		// }
	}

	// 上传文件
	public function upload_file($file) {
		$filename = $file->getClientOriginalName();  // 图片名称   现为原图片名称
			// 上传文件
		if($this->storage->put($filename, file_get_contents($file->getRealPath()))){
			return $filename;
		}
		return false;
	}

	// 删除文件
	public function delete_file($filename) {
		return $this->storage->delete($filename);
	}

	// 移动文件
	public function move_file(){

	}

	// 复制文件
	public function copy_file(){

	}
}
