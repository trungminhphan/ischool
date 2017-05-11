<?php
require_once('header.php');
$update  = isset($_GET['update']) ? $_GET['update'] : '';
if($update=='ok') { echo '<div class="messages success">Cập nhật thành công...</div>'; }
if($users->is_teacher() || $users->is_admin()):
$giaovien = new GiaoVien();$lophoc=new LopHoc();$monhoc=new MonHoc();$to=new To();$tochuyenmon=new ToChuyenMon();
$giaovien->id = $users->get_id_giaovien();
$gv= $giaovien->get_one();
?>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Thông tin chi tiết Giáo viên.</h1>
<div class="align-right">
    <a href="teacher_edit.html?id=<?php echo $users->get_id_giaovien(); ?>" class="button primary"><span class="mif-pencil"></span> Chỉnh sửa thông tin</a>
</div>
<div class="align-center">
<?php
    if($gv['hinhanh'] && file_exists('uploads/teachers/' . $gv['hinhanh'])){
        echo '<img src="uploads/teachers/'.$gv['hinhanh'].'" width="40" height="50" />';    
    } else if($gv['hinhanh'] && !file_exists('uploads/teachers/' . $gv['hinhanh'])){
        echo '<img src="image.html?id='.$gv['hinhanh'].'" width="100" height="150" />';    
    } else {
        echo '<img src="images/user.png" width="100" height="150" />';  
    }
?>
</div>
<div class="grid example">
    <div class="row cells12">
        <div class="cell colspan2">Mã số Giáo viên</div>
        <div class="cell colspan2"><b><?php echo $gv['masogiaovien']; ?></b></div>
        <div class="cell colspan2">Họ tên</div>
        <div class="cell colspan2"><b><?php echo $gv['hoten']; ?></b></div>
        <div class="cell colspan2">Ngày sinh</div>
        <div class="cell colspan2"><b><?php echo $gv['ngaysinh']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Giới tính</div>
        <div class="cell colspan2"><b><?php echo $gv['gioitinh']; ?></b></div>
        <div class="cell colspan2">Số hiệu công chức</div>
        <div class="cell colspan2"><b><?php echo $gv['sohieucongchuc']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">CMND</div>
        <div class="cell colspan2"><b><?php echo $gv['cmnd']; ?></b></div>
        <div class="cell colspan2">Ngày cấp</div>
        <div class="cell colspan2"><b><?php echo $gv['ngaycap']; ?></b></div>
        <div class="cell colspan2">Nơi cấp</div>
        <div class="cell colspan2"><b><?php echo $gv['noicap']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Dân tộc</div>
        <div class="cell colspan2"><b><?php echo $gv['dantoc']; ?></b></div>
        <div class="cell colspan2">Tôn giáo</div>
        <div class="cell colspan2"><b><?php echo $gv['tongiao']; ?></b></div>
        <div class="cell colspan2">Quốc tịch</div>
        <div class="cell colspan2"><b><?php echo $gv['quoctich']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Quê quán</div>
        <div class="cell colspan2"><b><?php echo $gv['quequan']; ?></b></div>
        <div class="cell colspan2">Địa chỉ thường trú</div>
        <div class="cell colspan2"><b><?php echo $gv['diachithuongtru']; ?></b></div>
        <div class="cell colspan2">Nơi ở hiện nay</div>
        <div class="cell colspan2"><b><?php echo $gv['noiohiennay']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Điện thoại</div>
        <div class="cell colspan2"><b><?php echo $gv['dienthoai']; ?></b></div>
        <div class="cell colspan2">Email</div>
        <div class="cell colspan2"><b><?php echo $gv['email']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày bắt đầu làm việc</div>
        <div class="cell colspan2"><b><?php echo $gv['ngaybatdaulamviec']; ?></b></div>
        <div class="cell colspan2">Công việc được giao</div>
        <div class="cell colspan2"><b><?php echo $gv['congviecduocgiao']; ?></b></div>
        <div class="cell colspan2">Tình trạng hôn nhân</div>
        <div class="cell colspan2"><b><?php echo $gv['tinhtranghonnhan']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày vào đoàn</div>
        <div class="cell colspan2"><b><?php echo $gv['ngayvaodoan']; ?></b></div>
        <div class="cell colspan2">Chức vụ</div>
        <div class="cell colspan2"><b><?php echo $gv['chucvudoan']; ?></b></div>
        <div class="cell colspan2">Ngày trưởng thành Đoàn</div>
        <div class="cell colspan2"><b><?php echo $gv['ngaytruongthanhdoan']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày vào Đảng</div>
        <div class="cell colspan2"><b><?php echo $gv['ngayvaodang']; ?></b></div>
        <div class="cell colspan2">Chức vụ</div>
        <div class="cell colspan2"><b><?php echo $gv['chucvudang']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Trình độ</div>
        <div class="cell colspan2"><b><?php echo $gv['trinhdo']; ?></b></div>
        <div class="cell colspan2">Chuyên ngành</div>
        <div class="cell colspan2"><b><?php echo $gv['chuyennganh']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Mã ngạch</div>
        <div class="cell colspan2"><b><?php echo $gv['mangach']; ?></b></div>
        <div class="cell colspan2">Tên ngạch</div>
        <div class="cell colspan2"><b><?php echo $gv['tenngach']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Bậc lương</div>
        <div class="cell colspan2"><b><?php echo $gv['bacluong']; ?></b></div>
        <div class="cell colspan2">Hệ số lương</div>
        <div class="cell colspan2"><b><?php echo $gv['hesoluong']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Khen thưởng</div>
        <div class="cell colspan2"><b><?php echo $gv['khenthuong']; ?></b></div>
        <div class="cell colspan2">Kỹ luật</div>
        <div class="cell colspan2"><b><?php echo $gv['kyluat']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Chi chú</div>
        <div class="cell colspan10"><b><?php echo $gv['ghichu']; ?></b></div>
    </div>
</div>
<h1><span class="mif-users"></span> Thông tin khác</h1>
<div class="grid example">
    <div class="row cells12">
        <div class="cell colspan12">
            <div class="tabcontrol2" data-role="tabcontrol">
                <ul class="tabs">
                    <li><a href="#giangday">Giảng dạy</a></li>
                    <li><a href="#giaovienchunhiem">Giáo viên chủ nhiệm</a></li>
                    <li><a href="#tochuyenmon">Tổ chuyên môn</a></li>
                </ul>
                <div class="frames">
                    <div class="frame" id="giangday">
                    <?php
                    $giangday_list = $giangday->get_list_condition(array('id_giaovien' => new MongoId($id_giaovien)));
                    if($giangday_list){
                        echo '<table class="table border bordered hovered striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>STT</th>';
                        echo '<th>Năm học</th>';
                        echo '<th>Lớp dạy</th>';
                        echo '<th>Môn dạy</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        $i=1;
                        foreach ($giangday_list as $gd) {
                            $namhoc->id = $gd['id_namhoc'];$nh=$namhoc->get_one();
                            $lophoc->id = $gd['id_lophoc']; $lh=$lophoc->get_one();
                            $monhoc->id = $gd['id_monhoc'];$mh = $monhoc->get_one();
                            echo '<tr>';
                            echo '<td>'.$i.'</td>';
                            echo '<td>'.$nh['tennamhoc'].'</td>';
                            echo '<td>'.$lh['tenlophoc'].'</td>';
                            echo '<td>'.$mh['tenmonhoc'].'</td>';
                            echo '</tr>';$i++;
                        }
                        echo '</tbody>';
                        echo '</table>';
                    }
                    ?>
                    </div>
                    <div class="frame" id="giaovienchunhiem">
                    <?php
                    $giaovienchunhiem_list = $giaovienchunhiem->get_list_condition(array('id_giaovien' => new MongoId($id_giaovien)));
                    if($giaovienchunhiem_list){
                        echo '<table class="table border bordered hovered striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>STT</th>';
                        echo '<th>Năm học</th>';
                        echo '<th>Lớp chủ nhiệm</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        $i=1;
                        foreach ($giaovienchunhiem_list as $gvcn) {
                            $namhoc->id = $gvcn['id_namhoc'];$nh=$namhoc->get_one();
                            $lophoc->id = $gvcn['id_lophoc']; $lh=$lophoc->get_one();
                            echo '<tr>';
                            echo '<td>'.$i.'</td>';
                            echo '<td>'.$nh['tennamhoc'].'</td>';
                            echo '<td>'.$lh['tenlophoc'].'</td>';
                            echo '</tr>';$i++;
                        }
                        echo '</tbody>';
                        echo '</table>';
                    }
                    ?>
                    </div>
                    <div class="frame" id="tochuyenmon">
                    <?php
                    $tochuyenmon_list = $tochuyenmon->get_list_condition(array('id_giaovien' => new MongoId($id_giaovien)));
                    if($tochuyenmon_list){
                        echo '<table class="table border bordered hovered striped">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>STT</th>';
                        echo '<th>Năm học</th>';
                        echo '<th>Tổ trực thuộc</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        $i=1;
                        foreach ($tochuyenmon_list as $tc) {
                            $namhoc->id = $tc['id_namhoc'];$nh=$namhoc->get_one();
                            $to->id = $tc['id_to']; $t=$to->get_one();
                            echo '<tr>';
                            echo '<td>'.$i.'</td>';
                            echo '<td>'.$nh['tennamhoc'].'</td>';
                            echo '<td>'.$t['tento'].'</td>';
                            echo '</tr>';$i++;
                        }
                        echo '</tbody>';
                        echo '</table>';
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php 
//Thông tin học sinh
if($users->is_student()): 
$hocsinh = new HocSinh();$lophoc=new LopHoc();
$id_hocsinh = $users->get_id_student();
$hocsinh->id = $id_hocsinh;
$hs = $hocsinh->get_one();
?>
<h1><a href="danhmuchocsinh.html" class="nav-button transform"><span></span></a>&nbsp;Thông tin chi tiết Học sinh.</h1>
<!--<div class="align-right">
    <a href="student_edit.php?id=<?php //echo $users->get_id_student(); ?>" class="button primary"><span class="mif-pencil"></span> Chỉnh sửa thông tin</a>
</div>-->
<div class="align-center">
<?php
    if($hs['hinhanh'] && file_exists('uploads/students/' . $hs['hinhanh'])){
            echo '<img src="uploads/students/'.$hs['hinhanh'].'" width="40" height="50" />';    
    } else if($hs['hinhanh'] && !file_exists('uploads/students/' . $hs['hinhanh'])){
        echo '<img src="image.html?id='.$hs['hinhanh'].'" width="100" height="150" />';    
    } else {
        echo '<img src="images/user.png" width="100" height="150" />';  
    }
?>
</div>
<div class="grid example">
    <div class="row cells12">
        <div class="cell colspan2">Mã số học sinh</div>
        <div class="cell colspan2"><b><?php echo $hs['masohocsinh']; ?></b></div>
        <div class="cell colspan2">CMND</div>
        <div class="cell colspan2"><b><?php echo $hs['cmnd']; ?></b></div>
        <div class="cell colspan2">Họ tên</div>
        <div class="cell colspan2"><b><?php echo $hs['hoten']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày sinh</div>
        <div class="cell colspan2"><b><?php echo $hs['ngaysinh']; ?></b></div>
        <div class="cell colspan2">Giới tính</div>
        <div class="cell colspan2"><b><?php echo $hs['gioitinh']; ?></b></div>
        <div class="cell colspan2">Nơi sinh</div>
        <div class="cell colspan2"><b><?php echo $hs['noisinh']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Quốc tịch</div>
        <div class="cell colspan2"><b><?php echo $hs['quoctich']; ?></b></div>
        <div class="cell colspan2">Dân tộc</div>
        <div class="cell colspan2"><b><?php echo $hs['dantoc']; ?></b></div>
        <div class="cell colspan2">Tôn giáo</div>
        <div class="cell colspan2"><b><?php echo $hs['tongiao']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Quê quán</div>
        <div class="cell colspan2"><b><?php echo $hs['quequan']; ?></b></div>
        <div class="cell colspan2">Hộ khẩu thường trú</div>
        <div class="cell colspan2"><b><?php echo $hs['hokhauthuongtru']; ?></b></div>
        <div class="cell colspan2">Nơi ở hiện nay</div>
        <div class="cell colspan2"><b><?php echo $hs['noiohiennay']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày vào đoàn</div>
        <div class="cell colspan2"><b><?php echo $hs['ngayvaodoan']; ?></b></div>
        <div class="cell colspan2">Ngày vào Đảng</div>
        <div class="cell colspan2"><b><?php echo $hs['ngayvaodang']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Điện thoại</div>
        <div class="cell colspan2"><b><?php echo $hs['dienthoai']; ?></b></div>
        <div class="cell colspan2">Email</div>
        <div class="cell colspan2"><b><?php echo $hs['email']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Họ tên Cha</div>
        <div class="cell colspan2"><b><?php echo $hs['hotencha']; ?></b></div>
        <div class="cell colspan2">Năm sinh</div>
        <div class="cell colspan2"><b><?php echo $hs['namsinhcha']; ?></b></div>
        <div class="cell colspan2">Nghề nghiệp/Đơn vị Công tác</div>
        <div class="cell colspan2"><b><?php echo $hs['nghenghiepcha'] . '/' . $hs['donvicongtaccha']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Họ tên Mẹ</div>
        <div class="cell colspan2"><b><?php echo $hs['hotenme']; ?></b></div>
        <div class="cell colspan2">Năm sinh</div>
        <div class="cell colspan2"><b><?php echo $hs['namsinhme']; ?></b></div>
        <div class="cell colspan2">Nghề nghiệp/Đơn vị Công tác</div>
        <div class="cell colspan2"><b><?php echo $hs['nghenghiepme'] . '/' . $hs['donvicongtacme']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Khen thưởng</div>
        <div class="cell colspan2"><b><?php echo $hs['khenthuong']; ?></b></div>
        <div class="cell colspan2">Kỹ luật</div>
        <div class="cell colspan2"><b><?php echo $hs['kyluat']; ?></b></div>
        <div class="cell colspan2">Tốt nghiệp</div>
        <div class="cell colspan2"><b><?php echo $hs['totnghiep']; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ghi chú</div>
        <div class="cell colspan10"><b><?php echo $hs['ghichu']; ?></b></div>
    </div>
</div>
<h1><span class="mif-school"></span> Các lớp đã học tại PT Thực hành Sư phạm</h1>
<div class="grid example">
    <div class="row cells12">
        <div class="cell colspan12">
            <table class="table border bordered hovered striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Năm học</th>
                        <th>Lớp học</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $danhsachlop = new DanhSachLop();
                $danhsachlop_list = $danhsachlop->get_list(array('id_hocsinh' => new MongoId($id_hocsinh)));
                if($danhsachlop_list){
                    $i=1;
                    foreach ($danhsachlop_list as $ds) {
                        $namhoc->id = $ds['id_namhoc']; $nh=$namhoc->get_one();
                        $lophoc->id = $ds['id_lophoc']; $lh=$lophoc->get_one();
                        echo '<tr>
                            <td>'.$i.'</td>
                            <td>'.$nh['tennamhoc'].'</td>
                            <td>'.$lh['tenlophoc'].'</td>
                        </tr>';$i++;
                    }
                        
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
<?php require_once('footer.php'); ?>