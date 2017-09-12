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

function sort_danhsach($arr){
	/*$sortArray = array();
	foreach($arr as $k => $a){
	    foreach($a as $key=>$value){
	        if(!isset($sortArray[$key])){
	            $sortArray[$key] = array();
	        }
	        $sortArray[$key][] = $value;
	    }
	}*/
	//var_dump($sortArray[$orderby]);
	$arr = sortFullName($arr);
	return $arr;
}

// SORT
function c_convert_vi($str) {
		/*Bước 1*/
		$map = array('1'=>array('à','ằ','ầ','è','ề','ì','ù','ừ','ò','ờ','ồ','ỳ'),
					'2'=>array('á','ắ','ấ','é','ế','í','ú','ứ','ó','ớ','ố','ý'),
					'3'=>array('ả','ẳ','ẩ','ẻ','ể','ỉ','ủ','ử','ỏ','ở','ổ','ỷ'),
					'4'=>array('ã','ẵ','ẫ','ẽ','ễ','ĩ','ũ','ữ','õ','ỡ','ỗ','ỹ'),
					'5'=>array('ạ','ặ','ậ','ẹ','ệ','ị','ụ','ự','ọ','ợ','ộ','ỵ')
					);
		$arrStr = explode(" ", $str);//Tach xau ngan cach nhau boi dau cach (" ")
		$tmpStr = "";
		for($i=0; $i<count($arrStr); $i++) {
			$subStr = $arrStr[$i];
			$tmpStr .= $subStr;
			$exist = false;
			foreach($map as $key => $subMap) {
				foreach ($subMap as $val) {
					if(strpos($subStr, $val) !== false) {//ton tai
						//Them key vao cuoi xau con
						$tmpStr .= $key;
						$exist = true;
						break;
					}
				}
				if($exist) {
					$exist = false;
					break;
				}
			}
			$tmpStr .= ' ';
		}
		$str = $tmpStr;
		/*Bước 2*/
		$map2 = array('à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a',	'ạ' => 'a',
					'ằ' => 'ă',	'ắ' => 'ă',	'ẳ' => 'ă',	'ẵ' => 'ă',	'ặ' => 'ă',
					'ầ' => 'â',	'ấ' => 'â',	'ẩ' => 'â',	'ẫ' => 'â',	'ậ' => 'â',
					'è' => 'e',	'é' => 'e',	'ẻ' => 'e',	'ẽ' => 'e',	'ẹ' => 'e',
					'ề' => 'ê',	'ế' => 'ê',	'ể' => 'ê',	'ễ' => 'ê',	'ệ' => 'ê',
					'ì' => 'i',	'í' => 'i',	'ỉ' => 'i',	'ĩ' => 'i',	'ị' => 'i',
					'ò' => 'o',	'ó' => 'o',	'ỏ' => 'o',	'õ' => 'o',	'ọ' => 'o',
					'ồ' => 'ô',	'ố' => 'ô',	'ổ' => 'ô',	'ỗ' => 'ô',	'ộ' => 'ô',
					'ờ' => 'ơ',	'ớ' => 'ơ',	'ở' => 'ơ',	'ỡ' => 'ơ',	'ợ' => 'ơ',
					'ù' => 'u',	'ú' => 'u',	'ủ' => 'u',	'ũ' => 'u',	'ụ' => 'u',
					'ừ' => 'ư', 'ứ' => 'ư',	'ử' => 'ư',	'ữ' => 'ư',	'ự' => 'ư',
					'ỳ' => 'y',	'ý' => 'y',	'ỷ' => 'y',	'ỹ' => 'y',	'ỵ' => 'y',
					'À' => 'A', 'Á' => 'A', 'Ả' => 'A', 'Ã' => 'A',	'Ạ' => 'A',
					'Ằ' => 'Ă',	'Ắ' => 'Ă',	'Ẳ' => 'Ă',	'Ẵ' => 'Ă',	'Ặ' => 'Ă',
					'Ầ' => 'Â',	'Ấ' => 'Â',	'Ẩ' => 'Â',	'Ẫ' => 'Â',	'Ậ' => 'Â',
					'È' => 'E',	'É' => 'E',	'Ẻ' => 'E',	'Ẽ' => 'E',	'Ẹ' => 'E',
					'Ề' => 'Ê',	'Ế' => 'Ê',	'Ể' => 'Ê',	'Ễ' => 'Ê',	'Ệ' => 'Ê',
					'Ì' => 'I',	'Í' => 'I',	'Ỉ' => 'I',	'Ĩ' => 'I',	'Ị' => 'I',
					'Ò' => 'O',	'Ó' => 'O',	'Ỏ' => 'O',	'Õ' => 'O',	'Ọ' => 'O',
					'Ồ' => 'Ô',	'Ố' => 'Ô',	'Ổ' => 'Ô',	'Ỗ' => 'Ô',	'Ộ' => 'Ô',
					'Ờ' => 'Ơ',	'Ớ' => 'Ơ',	'Ở' => 'Ơ',	'Ỡ' => 'Ơ',	'Ợ' => 'Ơ',
					'Ù' => 'U',	'Ú' => 'U',	'Ủ' => 'U',	'Ũ' => 'U',	'Ụ' => 'U',
					'Ừ' => 'Ư', 'Ứ' => 'Ư',	'Ử' => 'Ư',	'Ữ' => 'Ư',	'Ự' => 'Ư',
					'Ỳ' => 'Y',	'Ý' => 'Y',	'Ỷ' => 'Y',	'Ỹ' => 'Y',	'Ỵ' => 'Y',
		);
		$keys2 = array_keys($map2);
		$vals2 = array_values($map2);
		$str = str_replace($keys2, $vals2, $str);
		/*Bước 3*/
		$map3 = array('a' => 'a0', 'ă' => 'a1',	'â' => 'a2',
					'e' => 'e0', 'ê' => 'e1',
					'o' => 'o0', 'ô' => 'o1', 'ơ' => 'o2',
					'u' => 'u0', 'ư' => 'u1',
					'đ' => 'dx',
					'A' => 'A0', 'Ă' => 'A1', 'Â' => 'A2',
					'E' => 'E0', 'Ê' => 'E1',
					'O' => 'O0', 'Ô' => 'O1', 'Ơ' => 'O2',
					'U' => 'U0', 'Ư' => 'U1',
					'Đ' => 'Dx',
		);
		$key3s = array_keys($map3);
		$val3s = array_values($map3);
		$str = str_replace($key3s, $val3s, $str);
		return $str;
	}
	//Hàm sắp xếp theo tên và Họ đệm
	function sortArr($data) {
		//echo "vaoday";
		$firstName = array();
		$lastName = array();
	  	foreach ($data as $key => $row) {
			  $firstName[$key]  = $row['firstname'];//Họ đệm
			  $lastName[$key]  = $row['lastname'];//Tên
	  	}
	  if(!empty($firstName) && !empty($lastName)) {
		//echo "vaotiep";
		  array_multisort($lastName, SORT_ASC, $firstName, SORT_ASC, $data);
		}
	  return $data;
	}

	//Hàm loại bỏ một phần tử trong mảng theo key
	function traverseArray(&$array, $keys) {
    foreach($array as $key=>&$value){
      if(is_array($value)){
          traverseArray($value, $keys);
      } else {
          if(in_array($key, $keys)){
              unset($array[$key]);
          }
      }
    }
	}
	//Hàm sắp xếp một mảng chứa họ tên đầy đủ
	function sortFullName($listFullName=array()) {
		if(empty($listFullName)) return $listFullName;//Neu mảng trống thì trả về ngay và luôn
		$tmpListFullName = array();
		foreach ($listFullName as $fullName) {
			$tmpFullName = explode(" ", $fullName);//Tách họ tên đầy đủ thành các từ ngăn cách nhau bởi dấu cách, trả về một mảng
			$tmpLastName = $tmpFullName[count($tmpFullName)-1];//Tên
			$tmpFirstName = mb_substr($fullName, 0, mb_strlen($fullName) - mb_strlen($tmpLastName)-mb_strlen(" "));//Họ đệm
			$tmpLastName = c_convert_vi($tmpLastName);//Chuyển Tên sang mã mới
			$tmpFirstName = c_convert_vi($tmpFirstName);//Chuyển Họ đêm sang mã mới
			$tmpListFullName[] = array("fullname"=>$fullName, "firstname"=>$tmpFirstName, "lastname"=>$tmpLastName) ;
		}
		$listFullName = sortArr($tmpListFullName);//Sắp xếp theo Tên, Họ đệm
		traverseArray($listFullName, array('firstname', 'lastname'));//Xóa phần từ firstname và lastname trong mảng listFullName
		$tmp = array();
		foreach($listFullName as $fullName) {
			$tmp[] = $fullName['fullname'];
		}
		return $tmp;
	}
?>
