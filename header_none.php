<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
function __autoload($class_name) {
    require_once('cls/class.' . strtolower($class_name) . '.php');
}
$session = new SessionManager();
$users = new Users();
require_once('inc/functions.inc.php');
require_once('inc/config.inc.php');
if(!$users->isLoggedIn()){ transfers_to('./login.php'); }
$namhoc = new NamHoc();$giangday = new GiangDay();$giaovienchunhiem = new GiaoVienChuNhiem();
$namhoc_macdinh = $namhoc->get_macdinh();
$id_giaovien = $users->get_id_giaovien();
$giaovienchunhiem->id_namhoc = $namhoc_macdinh['_id'];
$giaovienchunhiem->id_giaovien = $id_giaovien;
$giangday->id_namhoc = $namhoc_macdinh['_id'];
$giangday->id_giaovien = $id_giaovien;
?>