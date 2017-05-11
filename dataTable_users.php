<?php
require_once('header_none.php');
$hocsinh = new HocSinh(); $giaovien = new GiaoVien();
$start = isset($_GET['start']) ? $_GET['start'] : 0;  
$length = isset($_GET['length']) ? $_GET['length'] : 0; 
$draw = isset($_GET['draw']) ? $_GET['draw'] : 1; 
$keysearch = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
$condition =  array('username'=> new MongoRegex('/'.$keysearch.'/i'));

$users_list = $users->get_list_to_position_condition($condition, $start, $length);
$recordsTotal = $users->count_all();
$recordsFiltered = $users->get_totalFilter($condition);
$arr_users = array();

if(isset($users_list) && $users_list){
	$i= $start+1;
	foreach ($users_list as $ul) {
		if(isset($ul['id_hocsinh'])){
			$hocsinh->id = $ul['id_hocsinh'];
			$fullname = $hocsinh->get_one();
		} else if(isset($ul['id_giaovien'])) {
			$giaovien->id = $ul['id_giaovien'];
			$fullname = $giaovien->get_one();
		}
		if(($ul['roles'] & ADMIN) == ADMIN) $quyen = 'Quản trị';
		else if(($ul['roles'] & TEACHER) == TEACHER) $quyen = 'Giáo viên';
		else $quyen = 'Học sinh';

		array_push($arr_users, array(
				$i,$ul['username'], $fullname['hoten'], $quyen,
				'<a href="users_add.html?id='.$ul['_id'].'"><span class="mif-pencil"></span></a>',
				'<a href="users_delete.html?id='.$ul['_id'].'" onclick="return confirm(\'Chắc chắn xoá?\');"><span class="mif-bin"></span></a>'));
		$i++;
	}
}
echo json_encode(
	array('draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $arr_users
	)
);


?>