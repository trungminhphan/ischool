<?php
require_once('header_none.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
$cotdiem = isset($_GET['cotdiem']) ? $_GET['cotdiem'] : '';
$key = isset($_GET['key']) ? $_GET['key'] : '';
$diemso = isset($_GET['diemso']) ? $_GET['diemso'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';
$k = isset($_GET['k']) ? $_GET['k'] : '';

$danhsachlop = new DanhSachLop();
/*$array = array('_id' => new MongoId($id), 
				'id_monhoc' => new MongoId($id_monhoc),
				'hocky' => $hocky,
				'cotdiem' => $cotdiem,
				'key' => $key);*/
if($act=='del'){
	//$query = array('$pull' => array($hocky . '.' .$k. '.' . $cotdiem . '.' . $key => $diemso));
	$condition = array('_id' => new MongoId($id), $hocky . '.' . 'id_monhoc' => new MongoId($id_monhoc));
	$query = array('$unset' => array($hocky . '.$.' . $cotdiem .'.'. $key => true));
	//$query = array('$pull' => array($hocky => array($cotdiem => array("key" => $key))));
	//$query = array('$pull' => array($hocky . '.$.' . $cotdiem => array("key" => $key)));
	//$query = array(array($hocky => array($cotdiem)));
	//$danhsachlop->delete_diem($query);
	$danhsachlop->delete_diem($condition, $query);
	$query_delete = array('$pull' => array($hocky . '.$.' . $cotdiem  => NULL ));
	$danhsachlop->delete_diem($condition, $query_delete);
	
	//$danhsachlop->update_diem($condition, $query);
} else {
	$condition = array('_id' => new MongoId($id), $hocky . '.' . 'id_monhoc' => new MongoId($id_monhoc));
	$query = array('$set' => array($hocky . '.$.' . $cotdiem . '.' . $key => $diemso));
	$danhsachlop->update_diem($condition, $query);
}
?> 

