<?php
require_once('header_none.php');
$start = isset($_GET['start']) ? $_GET['start'] : 0;  
$length = isset($_GET['length']) ? $_GET['length'] : 0; 
$draw = isset($_GET['draw']) ? $_GET['draw'] : 1; 
$keysearch = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
$condition = array('$or' => array(array('masogiaovien' => new MongoRegex('/' . $keysearch . '/i')), array('hoten' => new MongoRegex('/' .$keysearch. '/i'))));

$giaovien = new GiaoVien();
$giaovien_list = $giaovien->get_list_to_position_condition($condition, $start, $length);
$recordsTotal = $giaovien->count_all();
$recordsFiltered = $giaovien->get_totalFilter($condition);
$arr_giaovien = array();
if(isset($giaovien_list) && $giaovien_list){
	$i= $start+1;
	foreach ($giaovien_list as $gv) {
		array_push($arr_giaovien, array(
				$i,'<a href="chitietgiaovien.html?id='.$gv['_id'].'">'.$gv['masogiaovien'] .'</a>', $gv['hoten'], $gv['ngaysinh'], $gv['gioitinh'], $gv['noisinh'],
				'<a href="themgiaovien.html?id='.$gv['_id'].'"><span class="mif-pencil"></span></a>',
				'<a href="themgiaovien.html?id='.$gv['_id'].'&act=del" onclick="return confirm(\'Chắc chắn xóa?\')"><span class="mif-bin"></span></a>'));
		$i++;
	}
}
echo json_encode(
  array('draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $arr_giaovien
    ));
?>