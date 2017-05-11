<?php
	//DEFINE QUYEN CHO TUNG NGUOI
	define("ADMIN", 1);
	define("TEACHER", 2);
	define("STUDENT", 4);

	$arr_monhocdanhgia = array('AMNHAC', 'MYTHUAT', 'THEDUC');
	$arr_hocky = array('hocky1', 'hocky2');
	$arr_khoi = array(6 => 'Khối 6',7 => 'Khối 7',8 => 'Khối 8',9 => 'Khối 9','THCS' => 'THCS');
	$arr_thcs = array(6,7,8,9);
	//define("MANAGER", 8);
	
	//$g_config['db_server'] = 'mysql.agu.edu.vn';
	/*$g_config['db_server'] = 'localhost';
	$g_config['db_username'] = 'root';
	$g_config['db_password'] = 'root';
	$g_config['db_database_name'] = 'ptth';
	$g_config['image_folder'] = 'images/';*/

	//$mongo_server = 'localhost';
	//$mongo_username = 'admin';
	//$mongo_password = 'admin';
	//$mongo_database_name = 'ptth';

	//$g_config['admin_user'] = 'admin';
	//$g_config['admin_password'] = MD5('pmtrung');
	//$g_config['admin_password'] = '6701a36f285636bfbf4afc07bed8fc0c';
	
	//$hash_password["crypt"] = 'MD5';
	//$hash_password["password"] = 'PASSWORD';
	//$hash_password[""] = 'PLAIN_TEXT';
	
	//smtp config for send mail
	$arr_danhhieu = array('Học sinh giỏi' => 'Học sinh giỏi', 'Học sinh tiên tiến' => 'Học sinh tiên tiến', 'All' => 'HSG + HSTT');
?>