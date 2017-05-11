<?php 
require_once('header_none.php');
$hocsinh = new HocSinh();
$q = isset($_GET['q']) ? $_GET['q'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 0;

$condition = array('$or' => array(array('masohocsinh' => new MongoRegex('/' . $q . '/i')), array('hoten' => new MongoRegex('/' . $q . '/i'))));

$total_count = $hocsinh->get_all_condition($condition)->count();
$hocsinh_list = $hocsinh->get_list_to_position_condition($condition, $page, 30);

$arr = array();
if($hocsinh_list){
	foreach ($hocsinh_list as $hs) {
		array_push($arr, array('id' => $hs['_id']->{'$id'}, 'maso' => $hs['masohocsinh'], 'hoten' => $hs['hoten'], 'text' =>$hs['masohocsinh'] . ' - '. $hs['hoten']));
	}
}

echo json_encode(array(
	"total_count" => $total_count,
  	"incomplete_results" => false,
	"items" => $arr));
?>