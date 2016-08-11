<?php
//  生成表单类
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FormController extends Controller
{
    // 生成文本框
	public function create_text($label_name, $input_name, $default_value = '', $disabled = false) {
		$str = <<<EOT
			<div class="form-group">
					<label class="col-lg-2 control-label">{$label_name}</label>
					<div class="col-lg-10">
						<input type="text" placeholder="" id="{$input_name}" name="{$input_name}" class="form-control" 
							value="{$default_value}">
					</div>
				</div>
EOT;
		return $str;
	}

	// 生成下拉框
	public function create_select($label_name, $select_name, $select_item, $selected_id = array()) {
		$select_str = '<option>请选择</option>';
		foreach($select_item as $key=>$item) {
			$selected = '';
	    	if(!empty($selected_id) && array_search($key, $selected_id) !== false){
	    		$selected = 'selected = \"selected\" ';
	    	}
			$select_str .= '<option value="'.$key.'">'.$item.'</option>';
		}

		$str = '<div class="form-group">
	                <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">'.$label_name.'</label>
	                <div class="col-lg-10">
	                    <select class="form-control m-bot15" name="'.$select_name.'">'.$select_str.'</select>
	                </div>
	            </div>';
	    return $str;
	}

	// 生成单选框
	public function create_radio($label_name, $radio_name, $radio_item, $checked_id = array()){
		$str = '<div class="form-group">
	                <label class="col-lg-2 control-label">'.$label_name.'</label>
	                <div class="col-md-7">';
	    foreach($radio_item as $key=>$item) {
	    	$checked = '';
	    	if(!empty($checked_id) && array_search($key, $checked_id) !== false){
	    		$checked = 'checked = \"checked\" ';
	    	}
	    	$str .= '<label class="radio-inline">
                        <input type="radio" name="'.$radio_name.'" value="'.$key.'" ' . $checked . '>'.$item.'
                    </label>';
	    }
	    $str.= '    </div>
	            </div>';
	    return $str;
	}

	// 生成复选框
	public function create_checkbox($label_name, $checkbox_name, $checkbox_item, $checked_id = array(), $is_disabled = false) {
		$checkbox = '';
		foreach($checkbox_item as $key=>$item){
			$checked = '';
			$disabled = '';
	    	if(!empty($checked_id) && array_search($key, $checked_id) !== false){
	    		$checked = 'checked = \"checked\" ';
	    	}
	    	if($is_disabled === true){
				$disabled = 'disabled = \"disabled\"';
	    	}
			$checkbox .= '<input type="checkbox" name="'.$checkbox_name.'[]" '.$checked.' value="'.$key.'" '.$disabled.'/>'.$item;
		}
		$str = '<div>
	                <label>'.$label_name.'</label>
	                '.$checkbox.'
	            </div>';
	    return $str;
	}
}
