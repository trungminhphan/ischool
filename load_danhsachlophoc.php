<?php
require_once('header_none.php');
$id_giaovien = $users->get_id_giaovien();
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$lophoc = new LopHoc(); $giaovienchunhiem = new GiaoVienChuNhiem();

if($users->is_admin()){
	//$lophoc_list = $giaovienchunhiem->get_distinct_lophoc();
	$danhsachlop = new DanhSachLop();
	$danhsachlop->id_namhoc = $id_namhoc;
	$lophoc_list = $danhsachlop->get_list_lophoctheonam();
	if($lophoc_list){
		foreach ($lophoc_list as $key => $value) {
			$lophoc->id = $value; $lh = $lophoc->get_one();
			echo '<option value="'.$value.'"'.($value==$id_lophoc ? ' selected' : '').'>'.$lh['tenlophoc'].'</option>';
		}
	} else {
		echo '<option value="">Không có lớp chủ nhiệm</option>';
	}
}
if($users->is_teacher()){
	$giaovienchunhiem->id_giaovien = $id_giaovien;
	$giaovienchunhiem->id_namhoc = $id_namhoc;
	$lophoc_list = $giaovienchunhiem->get_distinct_lophoc();
	if($lophoc_list){
		foreach ($lophoc_list as $key => $value) {
			$lophoc->id = $value; $lh = $lophoc->get_one();
			echo '<option value="'.$value.'"'.($value==$id_lophoc ? ' selected' : '').'>'.$lh['tenlophoc'].'</option>';
		}
	} else {
		echo '<option value="">Không có lớp chủ nhiệm</option>';
	}
}

?>

