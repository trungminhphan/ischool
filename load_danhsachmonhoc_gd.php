<?php
require_once('header_none.php');
$id_giaovien = $users->get_id_giaovien();

$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';

$lophoc = new LopHoc(); $giangday = new GiangDay();$monhoc = new MonHoc();
if($users->is_admin()){
	$list_monhoc = $monhoc->get_all_list();
	if($list_monhoc){
		foreach ($list_monhoc as $mh) {
			echo '<option value="'.$mh['_id'].'"'.($mh['_id']==$id_monhoc ? ' selected' : '').'>'.$mh['tenmonhoc'].'</option>';
		}
	} else {
		echo '<option value="">Không có môn giảng dạy</option>';
	}
} else {
	if($users->is_teacher()){
		$giangday->id_giaovien = $id_giaovien;
		$giangday->id_namhoc = $id_namhoc;
		$giangday->id_lophoc = $id_lophoc;
		$monhoc_list = $giangday->get_distinct_monhoc();

		if($monhoc_list){
			echo '<option value="">Chọn môn học</option>';
			foreach ($monhoc_list as $key => $value) {
				$monhoc->id = $value; $mh = $monhoc->get_one();
				echo '<option value="'.$value.'"'.($value==$id_monhoc ? ' selected' : '').'>'.$mh['tenmonhoc'].'</option>';
			}
		} else {
			echo '<option value="">Không có môn giảng dạy</option>';
		}
	}
}
?>
