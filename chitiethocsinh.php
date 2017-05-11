<?php
require_once('header.php');
check_permis(!$users->is_admin() && !$users->is_teacher());
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$hocsinh = new HocSinh();
$giaovienchunhiem->id_namhoc = $id_namhoc;
$giaovienchunhiem->id_lophoc = $id_lophoc;

if($id){
    $hocsinh->id = $id;
    $edit_hocsinh = $hocsinh->get_one();
    $id = $edit_hocsinh['_id'];
    $hinhanh = $edit_hocsinh['hinhanh'];
    $masohocsinh = $edit_hocsinh['masohocsinh'];
    $cmnd = $edit_hocsinh['cmnd'];
    $hoten = $edit_hocsinh['hoten'];
    $ngaysinh = $edit_hocsinh['ngaysinh'];
    $gioitinh = $edit_hocsinh['gioitinh'];
    $noisinh = $edit_hocsinh['noisinh'];
    $quoctich = $edit_hocsinh['quoctich'];
    $dantoc = $edit_hocsinh['dantoc'];
    $tongiao = $edit_hocsinh['tongiao'];
    $quequan = $edit_hocsinh['quequan'];
    $hokhauthuongtru = $edit_hocsinh['hokhauthuongtru'];
    $noiohiennay = $edit_hocsinh['noiohiennay'];
    $ngayvaodoan = $edit_hocsinh['ngayvaodoan'];
    $ngayvaodang = $edit_hocsinh['ngayvaodang'];
    $dienthoai = $edit_hocsinh['dienthoai'];
    $email = $edit_hocsinh['email'];
    $hotencha = $edit_hocsinh['hotencha'];
    $namsinhcha = $edit_hocsinh['namsinhcha'];
    $nghenghiepcha = $edit_hocsinh['nghenghiepcha'];
    $donvicongtaccha = $edit_hocsinh['donvicongtaccha'];
    $hotenme = $edit_hocsinh['hotenme'];
    $namsinhme = $edit_hocsinh['namsinhme'];
    $nghenghiepme = $edit_hocsinh['nghenghiepme'];
    $donvicongtacme = $edit_hocsinh['donvicongtacme'];
    $khenthuong = $edit_hocsinh['khenthuong'];
    $maxacnhanphuhuynh = $edit_hocsinh['maxacnhanphuhuynh'];
    $kyluat = $edit_hocsinh['kyluat'];
    $ghichu = $edit_hocsinh['ghichu'];

    if($edit_hocsinh['totnghiep'] == 0){
        $totnghiep = 'Chưa tốt nghiệp';
    } else { $totnghiep = 'Đã tốt nghiệp'; }
}
?>
<h1><a href="danhmuchocsinh.html" class="nav-button transform"><span></span></a>&nbsp;Thông tin chi tiết Học sinh.</h1>
<div class="align-center">
<?php
    if($hinhanh && file_exists('uploads/students/' . $hinhanh)){
            echo '<img src="uploads/students/'.$hinhanh.'" width="40" height="50" />';    
    } else if($hinhanh && !file_exists('uploads/students/' . $hinhanh)){
        echo '<img src="image.html?id='.$hinhanh.'" width="100" height="150" />';    
    } else {
        echo '<img src="images/user.png" width="100" height="150" />';  
    }
?>
</div>
<div class="grid">
    <div class="row cells12">
        <div class="cell colspan2">Mã số học sinh</div>
        <div class="cell colspan2"><b><?php echo $masohocsinh; ?></b></div>
        <div class="cell colspan2">CMND</div>
        <div class="cell colspan2"><b><?php echo $cmnd; ?></b></div>
        <div class="cell colspan2">Họ tên</div>
        <div class="cell colspan2"><b><?php echo $hoten; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày sinh</div>
        <div class="cell colspan2"><b><?php echo $ngaysinh; ?></b></div>
        <div class="cell colspan2">Giới tính</div>
        <div class="cell colspan2"><b><?php echo $gioitinh; ?></b></div>
        <div class="cell colspan2">Nơi sinh</div>
        <div class="cell colspan2"><b><?php echo $noisinh; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Quốc tịch</div>
        <div class="cell colspan2"><b><?php echo $quoctich; ?></b></div>
        <div class="cell colspan2">Dân tộc</div>
        <div class="cell colspan2"><b><?php echo $dantoc; ?></b></div>
        <div class="cell colspan2">Tôn giáo</div>
        <div class="cell colspan2"><b><?php echo $tongiao; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Quê quán</div>
        <div class="cell colspan2"><b><?php echo $quequan; ?></b></div>
        <div class="cell colspan2">Hộ khẩu thường trú</div>
        <div class="cell colspan2"><b><?php echo $hokhauthuongtru; ?></b></div>
        <div class="cell colspan2">Nơi ở hiện nay</div>
        <div class="cell colspan2"><b><?php echo $noiohiennay; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày vào đoàn</div>
        <div class="cell colspan2"><b><?php echo $ngayvaodoan; ?></b></div>
        <div class="cell colspan2">Ngày vào Đảng</div>
        <div class="cell colspan2"><b><?php echo $ngayvaodang; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Điện thoại</div>
        <div class="cell colspan2"><b><?php echo $dienthoai; ?></b></div>
        <div class="cell colspan2">Email</div>
        <div class="cell colspan2"><b><?php echo $email; ?></b></div>
        <div class="cell colspan2">Mã xác nhận Phụ huynh</div>
        <?php if($users->is_admin()): ?>
            <div class="cell colspan2"><b><?php echo $maxacnhanphuhuynh; ?></b></div>
        <?php else: ?>
            <div class="cell colspan2"><b><?php echo '******'; ?></b></div>
        <?php endif; ?>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Họ tên Cha</div>
        <div class="cell colspan2"><b><?php echo $hotencha; ?></b></div>
        <div class="cell colspan2">Năm sinh</div>
        <div class="cell colspan2"><b><?php echo $namsinhcha; ?></b></div>
        <div class="cell colspan2">Nghề nghiệp/Đơn vị Công tác</div>
        <div class="cell colspan2"><b><?php echo $nghenghiepcha . '/' . $donvicongtaccha; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Họ tên Mẹ</div>
        <div class="cell colspan2"><b><?php echo $hotenme; ?></b></div>
        <div class="cell colspan2">Năm sinh</div>
        <div class="cell colspan2"><b><?php echo $namsinhme; ?></b></div>
        <div class="cell colspan2">Nghề nghiệp/Đơn vị Công tác</div>
        <div class="cell colspan2"><b><?php echo $nghenghiepme . '/' . $donvicongtacme; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Khen thưởng</div>
        <div class="cell colspan2"><b><?php echo $khenthuong; ?></b></div>
        <div class="cell colspan2">Kỹ luật</div>
        <div class="cell colspan2"><b><?php echo $kyluat; ?></b></div>
        <div class="cell colspan2">Tốt nghiệp</div>
        <div class="cell colspan2"><b><?php echo $totnghiep; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ghi chú</div>
        <div class="cell colspan10"><b><?php echo $ghichu; ?></b></div>
    </div>
</div>
<div class="align-center">
    <?php if($users->is_admin() || $giaovienchunhiem->check_is_gvcn()): ?>
        <a href="themhocsinh.html?id=<?php echo $id; ?>&id_namhoc=<?php echo $id_namhoc; ?>&id_lophoc=<?php echo $id_lophoc; ?>" class="button primary"><span class="mif-pencil"></span> Sửa</a>
    <?php endif; ?>

    <?php if($users->is_admin()) : ?>
        <a href="themhocsinh.html" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
    <?php else: ?>
        <a href="xemdanhsachlop.php?id_namhoc=<?php echo $id_namhoc; ?>&id_lophoc=<?php echo $id_lophoc; ?>&submit=OK" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
    <?php endif; ?>
</div>
