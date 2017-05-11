<?php
require_once('header.php');
if(!$users->is_admin()){
    echo '<h2>Bạn không có quyền...</h2>';
    exit();
}
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$act = isset($_GET['act']) ? $_GET['act'] : '';
$giaovien = new GiaoVien();$lophoc=new LopHoc();$monhoc=new MonHoc();$to=new To();$tochuyenmon=new ToChuyenMon();
$giaovien->id = $id;
if($id){
	$edit_giaovien = $giaovien->get_one();
	$id = $edit_giaovien['_id'];
    $hinhanh = $edit_giaovien['hinhanh'];
    $masogiaovien = $edit_giaovien['masogiaovien'];
    $hoten = $edit_giaovien['hoten'];
    $ngaysinh = $edit_giaovien['ngaysinh'];
    $noisinh = $edit_giaovien['noisinh'];
    $gioitinh = $edit_giaovien['gioitinh'];
    $sohieucongchuc = $edit_giaovien['sohieucongchuc'];
    $cmnd = $edit_giaovien['cmnd'];
    $noicap = $edit_giaovien['noicap'];
    $ngaycap = $edit_giaovien['ngaycap'];
    $dantoc = $edit_giaovien['dantoc'];
    $tongiao = $edit_giaovien['tongiao'];
    $quoctich = $edit_giaovien['quoctich'];
    $quequan = $edit_giaovien['quequan'];
    $diachithuongtru = $edit_giaovien['diachithuongtru'];
    $noiohiennay = $edit_giaovien['noiohiennay'];
    $dienthoai = $edit_giaovien['dienthoai'];
    $email = $edit_giaovien['email'];
    $tinhtranghonnhan = $edit_giaovien['tinhtranghonnhan'];
    $ngaybatdaulamviec = $edit_giaovien['ngaybatdaulamviec'];
    $congviecduocgiao = $edit_giaovien['congviecduocgiao'];
    $ngayvaodoan = $edit_giaovien['ngayvaodoan'];
    $chucvudoan = $edit_giaovien['chucvudoan'];
    $ngaytruongthanhdoan = $edit_giaovien['ngaytruongthanhdoan'];
    $ngayvaodang = $edit_giaovien['ngayvaodang'];
    $chucvudang = $edit_giaovien['chucvudang'];
    $trinhdo =  $edit_giaovien['trinhdo'];
    $chuyennganh = $edit_giaovien['chuyennganh'];
    //$monday = $edit_giaovien['monday'];
    //$lopday = $edit_giaovien['lopday'];
    //$tochuyenmon = $edit_giaovien['tochuyenmon'];
    $mangach = $edit_giaovien['mangach'];
    $tenngach = $edit_giaovien['tenngach'];
    $bacluong = $edit_giaovien['bacluong'];
    $hesoluong = $edit_giaovien['hesoluong'];
    $khenthuong = $edit_giaovien['khenthuong'];
    $kyluat = $edit_giaovien['kyluat'];
    $ghichu = $edit_giaovien['ghichu'];
}

?>
<h1><a href="danhmucgiaovien.php" class="nav-button transform"><span></span></a>&nbsp;Thông tin chi tiết Giáo viên.</h1>
<div class="align-center">
<?php
    if($hinhanh && file_exists('uploads/teachers/' . $hinhanh)){
            echo '<img src="uploads/teachers/'.$gv['hinhanh'].'" width="40" height="50" />';    
    } else if($hinhanh && !file_exists('uploads/teachers/' . $hinhanh)){
        echo '<img src="image.php?id='.$hinhanh.'" width="100" height="150" />';    
    } else {
        echo '<img src="images/user.png" width="100" height="150" />';  
    }
?>
</div>
<div class="grid example">
    <div class="row cells12">
        <div class="cell colspan2">Mã số Giáo viên</div>
        <div class="cell colspan2"><b><?php echo $masogiaovien; ?></b></div>
        <div class="cell colspan2">Họ tên</div>
        <div class="cell colspan2"><b><?php echo $hoten; ?></b></div>
        <div class="cell colspan2">Ngày sinh</div>
        <div class="cell colspan2"><b><?php echo $ngaysinh; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Giới tính</div>
        <div class="cell colspan2"><b><?php echo $gioitinh; ?></b></div>
        <div class="cell colspan2">Số hiệu công chức</div>
        <div class="cell colspan2"><b><?php echo $sohieucongchuc; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">CMND</div>
        <div class="cell colspan2"><b><?php echo $cmnd; ?></b></div>
        <div class="cell colspan2">Ngày cấp</div>
        <div class="cell colspan2"><b><?php echo $ngaycap; ?></b></div>
        <div class="cell colspan2">Nơi cấp</div>
        <div class="cell colspan2"><b><?php echo $noicap; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Dân tộc</div>
        <div class="cell colspan2"><b><?php echo $dantoc; ?></b></div>
        <div class="cell colspan2">Tôn giáo</div>
        <div class="cell colspan2"><b><?php echo $tongiao; ?></b></div>
        <div class="cell colspan2">Quốc tịch</div>
        <div class="cell colspan2"><b><?php echo $quoctich; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Quê quán</div>
        <div class="cell colspan2"><b><?php echo $quequan; ?></b></div>
        <div class="cell colspan2">Địa chỉ thường trú</div>
        <div class="cell colspan2"><b><?php echo $diachithuongtru; ?></b></div>
        <div class="cell colspan2">Nơi ở hiện nay</div>
        <div class="cell colspan2"><b><?php echo $noiohiennay; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Điện thoại</div>
        <div class="cell colspan2"><b><?php echo $dienthoai; ?></b></div>
        <div class="cell colspan2">Email</div>
        <div class="cell colspan2"><b><?php echo $email; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày bắt đầu làm việc</div>
        <div class="cell colspan2"><b><?php echo $ngaybatdaulamviec; ?></b></div>
        <div class="cell colspan2">Công việc được giao</div>
        <div class="cell colspan2"><b><?php echo $congviecduocgiao; ?></b></div>
        <div class="cell colspan2">Tình trạng hôn nhân</div>
        <div class="cell colspan2"><b><?php echo $tinhtranghonnhan; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày vào đoàn</div>
        <div class="cell colspan2"><b><?php echo $ngayvaodoan; ?></b></div>
        <div class="cell colspan2">Chức vụ</div>
        <div class="cell colspan2"><b><?php echo $chucvudoan; ?></b></div>
        <div class="cell colspan2">Ngày trưởng thành Đoàn</div>
        <div class="cell colspan2"><b><?php echo $ngaytruongthanhdoan; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Ngày vào Đảng</div>
        <div class="cell colspan2"><b><?php echo $ngayvaodang; ?></b></div>
        <div class="cell colspan2">Chức vụ</div>
        <div class="cell colspan2"><b><?php echo $chucvudang; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Trình độ</div>
        <div class="cell colspan2"><b><?php echo $trinhdo; ?></b></div>
        <div class="cell colspan2">Tổ chuyên môn</div>
        <div class="cell colspan2"><b><?php echo $chuyennganh; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Mã ngạch</div>
        <div class="cell colspan2"><b><?php echo $mangach; ?></b></div>
        <div class="cell colspan2">Tên ngạch</div>
        <div class="cell colspan2"><b><?php echo $tenngach; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Bậc lương</div>
        <div class="cell colspan2"><b><?php echo $bacluong; ?></b></div>
        <div class="cell colspan2">Hệ số lương</div>
        <div class="cell colspan2"><b><?php echo $hesoluong; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Khen thưởng</div>
        <div class="cell colspan2"><b><?php echo $khenthuong; ?></b></div>
        <div class="cell colspan2">Kỹ luật</div>
        <div class="cell colspan2"><b><?php echo $kyluat; ?></b></div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2">Chi chú</div>
        <div class="cell colspan10"><b><?php echo $ghichu; ?></b></div>
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
                    $giangday_list = $giangday->get_list_condition(array('id_giaovien' => new MongoId($id)));
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
                    $giaovienchunhiem_list = $giaovienchunhiem->get_list_condition(array('id_giaovien' => new MongoId($id)));
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
                    $tochuyenmon_list = $tochuyenmon->get_list_condition(array('id_giaovien' => new MongoId($id)));
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
<div class="align-center">
    <a href="themgiaovien.php?id=<?php echo $id; ?>" class="button primary"><span class="mif-pencil"></span> Sửa</a>
    <a href="danhmucgiaovien.php" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
</div>