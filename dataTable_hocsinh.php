<?php
require_once('header_none.php');

$start = isset($_GET['start']) ? $_GET['start'] : 0;  
$length = isset($_GET['length']) ? $_GET['length'] : 0; 
$draw = isset($_GET['draw']) ? $_GET['draw'] : 1; 
$keysearch = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
$condition = array('$or' => array(array('masohocsinh' => new MongoRegex('/' . $keysearch . '/i')), array('hoten' => new MongoRegex('/' .$keysearch. '/i'))));

$hocsinh = new HocSinh();
$hocsinh_list = $hocsinh->get_list_to_position_condition($condition, $start, $length);
$recordsTotal = $hocsinh->count_all();
$recordsFiltered = $hocsinh->get_totalFilter($condition);
$arr_hocsinh = array();
if(isset($hocsinh_list) && $hocsinh_list){
	$i= $start+1;
	foreach ($hocsinh_list as $hs) {
		array_push($arr_hocsinh, array(
				$i,'<a href="chitiethocsinh.html?id='.$hs['_id'].'">'.$hs['masohocsinh'] .'</a>', $hs['hoten'], $hs['ngaysinh'],  $hs['gioitinh'], $hs['noisinh'],
				'<a href="themhocsinh.html?id='.$hs['_id'].'"><span class="mif-pencil"></span></a>',
				'<a href="themhocsinh.html?id='.$hs['_id'].'&act=del" onclick="return confirm(\'Chắc chắn xóa?\')"><span class="mif-bin"></span></a>'));
		$i++;
	}
}
echo json_encode(
  array('draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $arr_hocsinh
    ));
?>