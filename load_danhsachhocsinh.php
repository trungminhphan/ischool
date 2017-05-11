<?php
function __autoload($class_name) {
    require_once('cls/class.' . strtolower($class_name) . '.php');
}
$session = new SessionManager();
$users = new Users();
require_once('inc/functions.inc.php');
require_once('inc/config.inc.php');
if(!$users->isLoggedIn()){
    transfers_to('./login.php');   
}

//$id_giaovien = $users->get_id_giaovien();
$danhsachlop = new DanhSachLop(); $hocsinh = new HocSinh();
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_hocsinh = isset($_GET['id_hocsinh']) ? $_GET['id_hocsinh'] : '';
$danhsachlop->id_namhoc = $id_namhoc; $danhsachlop->id_lophoc = $id_lophoc;

$hocsinh_list = $danhsachlop->get_distinct_hocsinh();

if($hocsinh_list){
	foreach ($hocsinh_list as $key => $value) {
		$hocsinh->id = $value; $hs = $hocsinh->get_one();
		echo '<option value="'.$value.'"'.($value==$id_hocsinh ? ' selected' : '').'>'.$hs['hoten'].'</option>';
	}
} else {
	echo '<option value=""></option>';
}
?>
