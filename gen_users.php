<?php
require_once('header_none.php');
check_permis(!$users->is_admin());

//gen users for Giao vien
/*$giaovien = new GiaoVien();
$giaovien_list = $giaovien->get_all_list();
if($giaovien_list){
	foreach ($giaovien_list as $gv) {
		echo $gv['_id'] . '---' . $gv['masogiaovien'] .' <br />';
		$query = array(
				'username' => $gv['masogiaovien'],
				'password' => md5($gv['masogiaovien']),
				'id_giaovien' => new MongoId($gv['_id']),
				'roles' => TEACHER
			);
		$users->insert($query);
	}
}

$hocsinh = new HocSinh();
$hocsinh_list = $hocsinh->get_all_list();
$hocsinh->maxacnhanphuhuynh = 'PPS';
if($hocsinh_list){
	foreach ($hocsinh_list as $hs) {
		$hocsinh->id = $hs['_id'];
		$hocsinh->set_maxacnhanphuhuynh();
	}
}
*/
?>

