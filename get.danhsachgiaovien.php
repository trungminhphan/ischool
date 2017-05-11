<?php 
require_once('header_none.php');

$giaovien = new GiaoVien();
$q = isset($_GET['q']) ? $_GET['q'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 0;

$condition = array('$or' => array(array('masogiaovien' => new MongoRegex('/' . $q . '/i')), array('hoten' => new MongoRegex('/' . $q . '/i'))));

$total_count = $giaovien->get_all_condition($condition)->count();
$giaovien_list = $giaovien->get_list_to_position_condition($condition, $page, 30);

$arr = array();
if($giaovien_list){
	foreach ($giaovien_list as $gv) {
		array_push($arr, array('id' => $gv['_id']->{'$id'}, 'maso' => $gv['masogiaovien'], 'hoten' => $gv['hoten'], 'text' =>$gv['masogiaovien'] . ' - '. $gv['hoten']));
	}
}

echo json_encode(array(
	"total_count" => $total_count,
  	"incomplete_results" => false,
	"items" => $arr));
?>