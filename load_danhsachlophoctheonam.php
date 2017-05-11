<?php
require_once('header_none.php');
$lophoc = new LopHoc(); $danhsachlop = new DanhSachLop();
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$danhsachlop = new DanhSachLop(); $danhsachlop->id_namhoc = $id_namhoc;
$lophoc_list = $danhsachlop->get_list_lophoctheonam();
echo '<option value="">Chọn lớp học</option>';
if($lophoc_list){
	foreach ($lophoc_list as $key=>$value) {
		$lophoc->id = $value; $lh = $lophoc->get_one();
		echo '<option value="'.$value.'">'.$lh['tenlophoc'].'</option>';
	}
} else {
	echo '<option value="">Không có lớp chủ nhiệm</option>';
}

?>

