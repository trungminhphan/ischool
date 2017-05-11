<?php
function convert_string_number($string){
	$len_of_string = strlen($string);
	$i = 0;
	$number = '';
	for($i=0; $i<$len_of_string; $i++){
		if($string[$i] != ".") $number .= $string[$i];
	}
	$number = str_replace(",",".",$number);
	doubleval($number);
	return $number;
}

function transfers_to($url){
	header('Location: ' . $url);
}

function format_number($number){
	return number_format($number, 0, ",", ".");
}

function format_decimal($number, $dec){
	if($number > 0 )
		return number_format($number, $dec, ",", ".");
	if($number == 0) return "0,0";
	else return '';
}
function format_date($date){
	return date("d/m/Y", strtotime($date));
}

function show_gioitinh($gioitinh){
	if($gioitinh == 1) return 'Nam';
	else return 'Nữ';
}

function quote_smart($value){
    if(get_magic_quotes_gpc()){
		$value=stripcslashes($value);    
    }
	$value=addslashes($value);
	return $value;    
}

function vn_str_filter ($str){
    $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ','d'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 'i'=>'í|ì|ỉ|ĩ|ị', 'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ','D'=>'Đ', 'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị', 'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ','U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự', 'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        '' => ' ');
      foreach($unicode as $nonUnicode=>$uni){
           $str = preg_replace("/($uni)/i", $nonUnicode, $str);
      }
       return $str;
   }
function ranks($dtb, $range=array()){
	$ranks = array(1);
	for($i = 1; $i < count($range); $i++) {
	   	if ($range[$i] != $range[$i-1]){
			$ranks[$i] = $i + 1;
		} else {
			$ranks[$i] = $ranks[$i-1];
		}
	}
	foreach ($ranks as $key => $value) {
		if(round($dtb,1) == round($range[$key],1)) return $value;
	}
	return '0';
}

function sort_arr_desc($arr = array()){
	$number = count($arr);
	for($i=0; $i<$number-1; $i++){
		for($j=$i+1; $j<$number; $j++){
			if(doubleval($arr[$i]) < doubleval($arr[$j])){
				$tam = $arr[$i];
				$arr[$i] = $arr[$j];
				$arr[$j] = $tam;
			}
		}
	}
	return $arr;
}

function check_permis($permis){
	if($permis){
		echo '<h2><span class="mif-user-minus"></span> Bạn không có quyền. <a href="index.php"><span class="mif-keyboard-return"></span></a></h2>';
	    require_once('footer.php');
	    exit();
	}
}

function convert_date($str_date){
	$a = explode("/", $str_date);
	return $a[2] . '-' . $a[1] . '-' . $a[0];
}
function convert_date_1($str_date){
	$a = explode("-", $str_date);
	return $a[2] . '-' . $a[1] . '-' . $a[0];
}

function sort_array($arrays, $orderby, $sortby){
	foreach ($arrays as $id => $array) {
		$array_sort[$id]   = $array[$orderby];
	}
	// Sort the data with weight descending, specialties ascending
	// Add $data as the last parameter, to sort by the common key
	$keys = array_keys($arrays);
	array_multisort(
		$array_sort, $sortby, SORT_STRING,
		$arrays, $keys
	);
	$arrays = array_combine($keys, $arrays);
	return $arrays;
}
function sort_array_and_key($arr, $orderby, $sortby){
	$sortArray = array();
	foreach($arr as $k => $a){
	    foreach($a as $key=>$value){
	        if(!isset($sortArray[$key])){
	            $sortArray[$key] = array();
	        }
	        $sortArray[$key][] = $value;
	    }
	}
	array_multisort($sortArray[$orderby],$sortby,$arr);
	return $arr;
}
?>
