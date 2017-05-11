<?php
require_once('header_none.php');
check_permis(!$users->is_admin());

$id = isset($_GET['id']) ? $_GET['id'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$giangday = new GiangDay();
$giangday->id = $id; $gd = $giangday->get_one();
if($gd['islock'] == 1){
	if($giangday->mokhoanhapdiem()){
		transfers_to('khoanhapdiem.php?id_namhoc='.$id_namhoc.'&id_lophoc='.$id_lophoc.'&load_danhsach=OK');
	} else {
		echo '<h2><span class="mif-lock"></span> Không thể mở khoá</h2>';
	}
} else {
	if($giangday->khoanhapdiem()){
		transfers_to('khoanhapdiem.php?id_namhoc='.$id_namhoc.'&id_lophoc='.$id_lophoc.'&load_danhsach=OK');
	} else {
		echo '<h2><span class="mif-lock"></span> Không thể khoá</h2>';
	}
}
?>

