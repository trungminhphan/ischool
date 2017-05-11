<?php
require_once('header_none.php');
$id_danhsachlop = isset($_GET['id_danhsachlop']) ? $_GET['id_danhsachlop'] : '';
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$danhsachlop = new DanhSachLop();
$danhsachlop->id = $id_danhsachlop; 
if($users->is_admin()){
	if($danhsachlop->delete()){
		transfers_to('xemdanhsachlop.php?id_lophoc=' . $id_lophoc . '&id_namhoc=' . $id_namhoc . '&submit=OK&update=del_ok');
	} else {
		echo transfers_to('xemdanhsachlop.php?id_lophoc=' . $id_lophoc . '&id_namhoc=' . $id_namhoc . '&submit=OK&update=del_no');
	}
} else {
	echo transfers_to('xemdanhsachlop.php?id_lophoc=' . $id_lophoc . '&id_namhoc=' . $id_namhoc . '&submit=OK&update=del_no');
}
?>