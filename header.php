<?php
function __autoload($class_name) {
    require_once('cls/class.' . strtolower($class_name) . '.php');
}
$session = new SessionManager();
$users = new Users();
require_once('inc/functions.inc.php');
require_once('inc/config.inc.php');
if(!$users->isLoggedIn()){ transfers_to('./login.html?url=' . $_SERVER['REQUEST_URI']); }
$namhoc = new NamHoc();$giangday = new GiangDay();$giaovienchunhiem = new GiaoVienChuNhiem();
$namhoc_macdinh = $namhoc->get_macdinh();
$id_giaovien = $users->get_id_giaovien();
$giaovienchunhiem->id_namhoc = $namhoc_macdinh['_id'];
$giaovienchunhiem->id_giaovien = $id_giaovien;
$giangday->id_namhoc = $namhoc_macdinh['_id'];
$giangday->id_giaovien = $id_giaovien;
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Phần mềm quản Sổ liên lạc điện tử , Trường PT Thực hành Sư Phạm.">
    <meta name="keywords" content="Phần mềm quản Sổ liên lạc điện tử , Trường PT Thực hành Sư phạm.">
    <meta name="author" content="Trung tâm Tin học Trường Đai học An Giang, 18 Ung Văn Khiêm, Tp Long Xuyên, An Giang">
    <link rel='shortcut icon' type='image/x-icon' href="images/favicon.ico" />
    <title>Phần mềm quản Sổ liên lạc điện tử, Trường PT Thực hành Sư phạm.</title>
    <link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">
    <link href="css/metro-schemes.css" rel="stylesheet">
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/metro.js"></script>
</head>
<body>
<div class="app-bar" data-role="appbar">
    <a href="index.html" class="app-bar-element branding"><span class="mif-home mif-2x"></span></a>
    <ul class="app-bar-menu small-dropdown">
        <?php if($users->is_admin()) : ?>
        <li><a href="#" class="dropdown-toggle"><span class="mif-apps mif-2x"></span>&nbsp;&nbsp;Danh mục</a>
            <ul class="d-menu" data-role="dropdown">
                <li><a href="danhmucnamhoc.html"><span class="mif-calendar"></span>&nbsp;&nbsp;Năm học</a></li>
                <li class="divider"></li>
                <li><a href="danhmuclophoc.html"><span class="mif-library"></span>&nbsp;&nbsp;Lớp học</a></li>
                <li class="divider"></li>
                <li><a href="danhmucmonhoc.html"><span class="mif-folder-open"></span>&nbsp;&nbsp;Môn học</a></li>
                <li class="divider"></li>
                <li><a href="danhmucto.html"><span class="mif-tree"></span>&nbsp;&nbsp;Tổ chuyên môn</a></li>
                <li class="divider"></li>
                <li><a href="danhmuchocsinh.html"><span class="mif-users"></span>&nbsp;&nbsp;Học sinh</a></li>
                <li class="divider"></li>
                <li><a href="danhmucgiaovien.html"><span class="mif-user-md"></span>&nbsp;&nbsp;Giáo viên</a></li>
                <li class="divider"></li>
            </ul>
        </li>
        <?php endif; ?>
        <?php if($users->is_admin() || $users->is_teacher()) : ?>
        <li><a href="#" class="dropdown-toggle"><span class="mif-insert-template mif-2x"></span>&nbsp;&nbsp;Chức năng</a>
            <ul class="d-menu" data-role="dropdown">
            <?php if($users->is_admin()) :?>
                <li><a href="taodanhsachlop.html"><span class="mif-list-numbered"></span>&nbsp;&nbsp;Tạo danh sách lớp</a></li>
                <li class="divider"></li>
                <li><a href="import_danhmuchocsinh.html"><span class="mif-folder-upload"></span>&nbsp;&nbsp;Import danh sách Học sinh</a></li>
                <li class="divider"></li>
                <li><a href="ketchuyenlenlop.html"><span class="mif-upload2"></span>&nbsp;&nbsp;Kết chuyển lên lớp</a></li>
                <li class="divider"></li>
                <li><a href="phanconggvcn.html"><span class="mif-equalizer-v"></span>&nbsp;&nbsp;Phân công GVCN</a></li>
                <li class="divider"></li>
                <li><a href="phanconggiangday.html"><span class="mif-equalizer"></span>&nbsp;&nbsp;Phân công Giảng dạy</a></li>
                <li class="divider"></li>
                <li><a href="phancongtochuyenmon.html"><span class="mif-tree"></span>&nbsp;&nbsp;Phân công Tổ chuyên môn</a></li>
                <li class="divider"></li>
                <li><a href="khoanhapdiem.html"><span class="mif-lock"></span>&nbsp;&nbsp;Khoá nhập điểm</a></li>
                <li class="divider"></li>
            <?php endif; ?>
            <?php if($users->is_admin() || $giangday->check_giaovien_giangday_menu()): ?>
                <li><a href="nhapdiem.html"><span class="mif-star-full"></span>&nbsp;&nbsp;Nhập điểm</a></li>
                <li class="divider"></li>
                <li><a href="import_danhsachdiem.html"><span class="mif-star-empty"></span>&nbsp;&nbsp;Import Danh sách điểm</a></li>
                <li class="divider"></li>
            <?php endif; ?>
            <?php if($users->is_admin() || $giaovienchunhiem->check_is_gvcn_menu()) : ?>
                <li><a href="diemdanh.html"><span class="mif-checkmark"></span>&nbsp;&nbsp;Điểm danh</a></li>
                <li class="divider"></li>
                <li><a href="danhgiahocsinh.html"><span class="mif-medal"></span>&nbsp;&nbsp;Đánh giá Học sinh</a></li>
                <li class="divider"></li>
                <li><a href="import_danhgiahocsinh.html"><span class="mif-paper-plane"></span>&nbsp;&nbsp;Import Đánh giá Học sinh</a></li>
                <li class="divider"></li>
            <?php endif; ?>
            </ul>
        </li>
        <li><a href="#" class="dropdown-toggle"><span class="mif-chart-line mif-2x"></span>&nbsp;&nbsp;Thống kê</a>
            <ul class="d-menu" data-role="dropdown">
                <li><a href="xemdanhsachlop.html"><span class="mif-list"></span>&nbsp;&nbsp;Danh sách lớp theo STT</a></li>
                <li class="divider"></li>
                <li><a href="danhsachloptheohang.html"><span class="mif-list-numbered"></span>&nbsp;&nbsp;Danh sách lớp theo hạng</a></li>
                <li class="divider"></li>
                <li><a href="danhsachloptheodanhhieu.html"><span class="mif-list2"></span>&nbsp;&nbsp;Danh sách lớp theo danh hiệu</a></li>
                <li class="divider"></li>
                <li><a href="xemdiemtheomonhoc.html"><span class="mif-spell-check"></span>&nbsp;&nbsp;Điểm theo môn học</a></li>
                <li class="divider"></li>
                 <li><a href="phieulienlacgiuaky.html"><span class="mif-file-binary"></span>&nbsp;&nbsp;Phiếu liên lạc giữa kỳ</a></li>
                <li class="divider"></li>
                <li><a href="phieulienlac.html"><span class="mif-paragraph-justify"></span>&nbsp;&nbsp;Phiếu liên lạc học kỳ</a></li>
                <li class="divider"></li>
                <li><a href="bangdiemtonghop.html"><span class="mif-widgets"></span>&nbsp;&nbsp;Bảng điểm tổng hợp</a></li>
                <li class="divider"></li>
                <li><a href="hocluchanhkiem.html"><span class="mif-heart"></span>&nbsp;&nbsp;Học lực - Hạnh kiểm</a></li>
                <li class="divider"></li>
                <li><a href="hocluchanhkiemdantoc.html"><span class="mif-brightness"></span>&nbsp;&nbsp;Học lực - Hạnh kiểm (Dân tộc)</a></li>
                <li class="divider"></li>
                <li><a href="xeploaimonhoctheolop.html"><span class="mif-bookmarks"></span>&nbsp;&nbsp;Xếp loại môn học theo lớp</a></li>
                <li class="divider"></li>
            </ul>
        </li>
        <li><a href="#" class="dropdown-toggle"><span class="mif-school mif-2x"></span>&nbsp;&nbsp;Điểm bài thi</a>
            <ul class="d-menu" data-role="dropdown">
                <li><a href="diembaithi.html"><span class="mif-chart-bars"></span>&nbsp;&nbsp;Điểm thi theo bảng điểm Cá nhân</a></li>
                <li class="divider"></li>
                <li><a href="diembaithi_1.html"><span class="mif-chart-bars2"></span>&nbsp;&nbsp;Điểm thi theo Môn học</a></li>
                <li class="divider"></li>
                <li><a href="diembaithi_2.html"><span class="mif-chart-pie"></span>&nbsp;&nbsp;Điểm thi theo Khối</a></li>
                <li class="divider"></li>
                <li><a href="diembaithi_3.html"><span class="mif-user-md"></span>&nbsp;&nbsp;Điểm thi theo Giáo viên</a></li>
                <li class="divider"></li>
                <li><a href="diembaithi_4.html"><span class="mif-windows"></span>&nbsp;&nbsp;Điểm thi theo Tổ chuyên môn</a></li>
                <li class="divider"></li>
            </ul>
        </li>
        <li><a href="#" class="dropdown-toggle"><span class="mif-organization mif-2x"></span>&nbsp;&nbsp;Kết quả giảng dạy</a>
            <ul class="d-menu" data-role="dropdown">
                <li><a href="ketquagiangday.html"><span class="mif-chart-bars"></span>&nbsp;&nbsp;Theo bảng điểm Cá nhân</a></li>
                <li class="divider"></li>
                <li><a href="ketquagiangday_1.html"><span class="mif-chart-bars2"></span>&nbsp;&nbsp;Theo Môn học</a></li>
                <li class="divider"></li>
                <li><a href="ketquagiangday_2.html"><span class="mif-chart-pie"></span>&nbsp;&nbsp;Theo Khối</a></li>
                <li class="divider"></li>
                <li><a href="ketquagiangday_3.html"><span class="mif-user-md"></span>&nbsp;&nbsp;Theo Giáo viên</a></li>
                <li class="divider"></li>
                <li><a href="ketquagiangday_4.html"><span class="mif-windows"></span>&nbsp;&nbsp;Theo Tổ chuyên môn</a></li>
                <li class="divider"></li>
            </ul>
        </li>
        <?php endif; ?>
        <?php if($users->is_student()):?>
            <li><a href="phieulienlacdientu.html"><span class="mif-insert-template mif-2x"></span> Phiếu liên lạc</a></li>
        <?php endif; ?>
        <li><a href="#" class="dropdown-toggle"><span class="mif-users mif-2x"></span>&nbsp;&nbsp;Tài khoản</a>
            <ul class="d-menu" data-role="dropdown">
                <?php if($users->is_admin()): ?>
                    <li><a href="users.html"><span class="mif-user"></span>&nbsp;&nbsp;Quản lý tài khoản</a></li>
                    <li class="divider"></li>
                <?php endif; ?>
                <li><a href="profiles.html"><span class="mif-user-check"></span>&nbsp;&nbsp;Thông tin cá nhân</a></li>
                <li class="divider"></li>
                <li><a href="change_password.html"><span class="mif-key"></span>&nbsp;&nbsp;Thay đổi mật khẩu</a></li>
                <li class="divider"></li>
                <?php if($users->is_student()): ?>
                    <li><a href="change_maxacnhan.html"><span class="mif-openid"></span>&nbsp;&nbsp;Thay đổi mã xác nhận</a></li>
                    <li class="divider"></li>
                <?php endif; ?>
                <li><a href="logout.html"><span class="mif-exit"></span>&nbsp;&nbsp;Đăng xuất</a></li>
                <li class="divider"></li>
            </ul>
        </li>
    </ul>
</div>
<div class="container page-content">
