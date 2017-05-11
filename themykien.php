<?php
require_once('header_none.php');
$danhsachlop = new DanhSachLop();
$hocsinh = new HocSinh();
$csrf = new CSRF_Protect();
$id_danhsachlop = isset($_POST['id_danhsachlop']) ? $_POST['id_danhsachlop'] : '';
$ykien = isset($_POST['ykien']) ? $_POST['ykien'] : '';
$noidung = isset($_POST['noidung']) ? $_POST['noidung'] : '';
$ngaycapnhat = new MongoDate();
$id = new MongoId();

$csrf->verifyRequest();
if($users->is_student()){
	$maxacnhan = isset($_POST['maxacnhanphuhuynh']) ? $_POST['maxacnhanphuhuynh'] : '';
	$id_hocsinh = $users->get_id_student(); $hocsinh->id = $id_hocsinh;
	$maxacnhanphuhuynh = $hocsinh->get_maxacnhanphuhuynh();
	if($maxacnhan === $maxacnhanphuhuynh){
		$query = array('$push' => array($ykien => array('_id'=> $id,'noidung' => $noidung, 'ngaycapnhat' => $ngaycapnhat)));
		$danhsachlop->id = $id_danhsachlop;
		$danhsachlop->push_ykien($query);
		echo '<li>'.$noidung.'<span class="tag">'.date("d/m/Y h:i",$ngaycapnhat->sec).'&nbsp;<a href="xoaykien.php?id_danhsachlop='.$id_danhsachlop.'&ykien='.$ykien.'&id='.$id.'&_token='.$csrf->getToken().'" class="xoaykien" onclick="return false;"><span class="mif-bin"></span></a></span></li>';		
	} else {
		echo 'Failed';	
	}
}
if($users->is_teacher()){
	$query = array('$push' => array($ykien => array('_id'=> $id,'noidung' => $noidung, 'ngaycapnhat' => $ngaycapnhat)));
	$danhsachlop->id = $id_danhsachlop;
	$danhsachlop->push_ykien($query);
	echo '<li>'.$noidung.'<span class="tag">'.date("d/m/Y h:i",$ngaycapnhat->sec).'&nbsp;<a href="xoaykien.php?id_danhsachlop='.$id_danhsachlop.'&ykien='.$ykien.'&id='.$id.'&_token='.$csrf->getToken().'" class="xoaykien" onclick="return false;"><span class="mif-bin"></span></a></span></li>';		
}

?>