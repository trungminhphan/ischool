<?php
require_once('header_none.php');
$danhsachlop = new DanhSachLop();$hocsinh = new HocSinh();$csrf = new CSRF_Protect();
$id_danhsachlop = isset($_GET['id_danhsachlop']) ? $_GET['id_danhsachlop'] : '';
$ykien = isset($_GET['ykien']) ? $_GET['ykien'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
if($users->is_student()){
	$maxacnhan  = isset($_GET['maxacnhan']) ? $_GET['maxacnhan'] : '';
	$id_hocsinh = $users->get_id_student(); $hocsinh->id = $id_hocsinh;
	$maxacnhanphuhuynh = $hocsinh->get_maxacnhanphuhuynh();
	if($maxacnhan === $maxacnhanphuhuynh){
		$csrf->verifyGet();
		$danhsachlop->id = $id_danhsachlop;
		$query = array('$pull' => array($ykien => array('_id' => new MongoId($id))));
		$danhsachlop->pull_ykien($query);
	} else {
		echo 'Failed';
	}
}

if($users->is_teacher()){
	$csrf->verifyGet();
	$danhsachlop->id = $id_danhsachlop;
	$query = array('$pull' => array($ykien => array('_id'=> new MongoId($id))));
	$danhsachlop->pull_ykien($query);
}

?>