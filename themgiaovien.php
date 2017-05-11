<?php
require_once('header.php');
check_permis(!$users->is_admin());
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$act = isset($_GET['act']) ? $_GET['act'] : '';
$gridfs = new GridFS();$giaovien = new GiaoVien();
$csrf = new CSRF_Protect(); $tochuyenmon = new ToChuyenMon();
if($id && $act=='del'){
    if($tochuyenmon->check_dm_giaogien($id) || $giangday->check_dm_giaovien($id) || $giaovienchunhiem->check_dm_giaovien($id)){
        $msg = 'Không thể xoá [Giảng dạy], [GVCN], [Tổ chuyên môn].';
    } else {
        $giaovien->id = $id;
        $ha = $giaovien->get_one();
    	if($giaovien->delete()) {
            if($ha['hinhanh']){
                $gridfs->id = $ha['hinhanh'];
                $gridfs->delete();
            }
            transfers_to('danhmucgiaovien.html?act=del_ok');
    	}
    }
}
$gioitinh = '';
if(isset($_POST['submit'])){
    $csrf->verifyRequest();
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    if($_FILES["hinhanh"]["name"]){
        $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "GIF", "PNG");
        $temp = explode(".", $_FILES["hinhanh"]["name"]);
        $extension = end($temp);
        if ((($_FILES["hinhanh"]["type"] == "image/gif")
        || ($_FILES["hinhanh"]["type"] == "image/jpeg")
        || ($_FILES["hinhanh"]["type"] == "image/jpg")
        || ($_FILES["hinhanh"]["type"] == "image/pjpeg")
        || ($_FILES["hinhanh"]["type"] == "image/x-png")
        || ($_FILES["hinhanh"]["type"] == "image/png"))
        && ($_FILES["hinhanh"]["size"] < 2000000) && in_array($extension, $allowedExts)){
            $gridfs->filename = $_FILES['hinhanh']['name'];
            $gridfs->filetype = $_FILES['hinhanh']['type'];
            $gridfs->tmpfilepath = $_FILES['hinhanh']['tmp_name'];
            $gridfs->caption = isset($_POST['hoten']) ? $_POST['hoten'] : '';
            $hinhanh = $gridfs->insert_files();
            $old_hinhanh = isset($_POST['old_hinhanh']) ? $_POST['old_hinhanh'] : '';
            if($old_hinhanh){
                $gridfs->id = $old_hinhanh;
                $gridfs->delete();
            }
            //$type = pathinfo($_FILES["hinhanh"]["tmp_name"], PATHINFO_EXTENSION);
            //$data = file_get_contents($_FILES["hinhanh"]["tmp_name"]);
            //$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            //$hinhanh = $base64;    
        } else {
            $hinhanh = '';
        }
    } else {
        $hinhanh = isset($_POST['old_hinhanh']) ? $_POST['old_hinhanh'] : '';
    }

    $giaovien->id = $id;
    $giaovien->hinhanh = $hinhanh;
    $giaovien->masogiaovien = isset($_POST['masogiaovien']) ? $_POST['masogiaovien'] : '';
	$giaovien->hoten = isset($_POST['hoten']) ? $_POST['hoten'] : '';
	$giaovien->ngaysinh = isset($_POST['ngaysinh']) ? $_POST['ngaysinh'] : '';
	$giaovien->noisinh = isset($_POST['noisinh']) ? $_POST['noisinh'] : '';
	$giaovien->gioitinh = isset($_POST['gioitinh']) ? $_POST['gioitinh'] : '';
    $giaovien->sohieucongchuc = isset($_POST['sohieucongchuc']) ? $_POST['sohieucongchuc'] : '';
    $giaovien->cmnd = isset($_POST['cmnd']) ? $_POST['cmnd'] : '';
    $giaovien->noicap = isset($_POST['noicap']) ? $_POST['noicap'] : '';
    $giaovien->ngaycap = isset($_POST['ngaycap']) ? $_POST['ngaycap'] : '';
    $giaovien->dantoc = isset($_POST['dantoc']) ? $_POST['dantoc'] : '';
    $giaovien->tongiao = isset($_POST['tongiao']) ? $_POST['tongiao'] : '';
    $giaovien->quoctich = isset($_POST['quoctich']) ? $_POST['quoctich'] : '';
    $giaovien->quequan = isset($_POST['quequan']) ? $_POST['quequan'] : '';
    $giaovien->diachithuongtru = isset($_POST['diachithuongtru']) ? $_POST['diachithuongtru'] : '';
    $giaovien->noiohiennay = isset($_POST['noiohiennay']) ? $_POST['noiohiennay'] : '';
    $giaovien->dienthoai = isset($_POST['dienthoai']) ? $_POST['dienthoai'] : '';
    $giaovien->email = isset($_POST['email']) ? $_POST['email'] : '';
    $giaovien->tinhtranghonnhan = isset($_POST['tinhtranghonnhan']) ? $_POST['tinhtranghonnhan'] : '';
    $giaovien->ngaybatdaulamviec = isset($_POST['ngaybatdaulamviec']) ? $_POST['ngaybatdaulamviec'] : '';
    $giaovien->congviecduocgiao = isset($_POST['congviecduocgiao']) ? $_POST['congviecduocgiao'] : '';
    $giaovien->ngayvaodoan = isset($_POST['ngayvaodoan']) ? $_POST['ngayvaodoan'] : '';
    $giaovien->chucvudoan = isset($_POST['chucvudoan']) ? $_POST['chucvudoan'] : '';
    $giaovien->ngayvaodang = isset($_POST['ngayvaodang']) ? $_POST['ngayvaodang'] : '';
    $giaovien->chucvudang = isset($_POST['chucvudang']) ? $_POST['chucvudang'] : '';
    $giaovien->trinhdo = 	isset($_POST['trinhdo']) ? $_POST['trinhdo'] : '';
    $giaovien->chuyennganh = isset($_POST['chuyennganh']) ? $_POST['chuyennganh'] : '';
    //$giaovien->monday = isset($_POST['monday']) ? $_POST['monday'] : '';
    //$giaovien->lopday = isset($_POST['lopday']) ? $_POST['lopday'] : '';
    //$giaovien->tochuyenmon = isset($_POST['tochuyenmon']) ? $_POST['tochuyenmon'] : '';
    $giaovien->mangach = isset($_POST['mangach']) ? $_POST['mangach'] : '';
    $giaovien->tenngach = isset($_POST['tenngach']) ? $_POST['tenngach'] : '';
    $giaovien->bacluong = isset($_POST['bacluong']) ? $_POST['bacluong'] : '';
    $giaovien->hesoluong = isset($_POST['hesoluong']) ? $_POST['hesoluong'] : '';
    $giaovien->khenthuong = isset($_POST['khenthuong']) ? $_POST['khenthuong'] : '';
    $giaovien->kyluat = isset($_POST['kyluat']) ? $_POST['kyluat'] : '';
	$giaovien->ghichu = isset($_POST['ghichu']) ? $_POST['ghichu'] : '';

	if($id) {
		//edit
		if($giaovien->edit()){
			transfers_to('danhmucgiaovien.html');
		} else {
			$msg ='Không thể chỉnh sửa.';
		}
	} else {
		//insert
		if($giaovien->check_exists()){
			$msg = 'Mã số Giáo viên bị trùng, Vui lòng chọn mã số khác...';
		} else {
			if($giaovien->insert()){
				transfers_to('danhmucgiaovien.html');
			} else {
				$msg= 'Không thể thêm học sinh mới.';
			}
		}
	}
}

if($id){
    $giaovien->id = $id;
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
<script type="text/javascript" src="js/jquery.inputmask.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".ngaythangnam").inputmask();
        <?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
    });
</script>
<h1><a href="danhmucgiaovien.html" class="nav-button transform"><span></span></a>&nbsp;Thông tin Giáo viên</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="themgiaovienfrom" data-role="validator" data-show-required-state="false" enctype="multipart/form-data">
<?php $csrf->echoInputField(); ?>
<input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : ''; ?>" />
<div class="grid">
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Mã số Giáo viên</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="masogiaovien" id="masogiaovien" value="<?php echo isset($masogiaovien) ? $masogiaovien : ''; ?>"  placeholder="Mã số giáo viên" data-validate-func="required"/>
            <span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Họ tên</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="hoten" id="hoten" value="<?php echo isset($hoten) ? $hoten : ''; ?>" placeholder="Họ tên" data-validate-func="required"/>
            <span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Giới tính</div>
        <div class="cell colspan2 input-control select">
            <select name="gioitinh" id="gioitinh">
                <option value="Nam" <?php echo $gioitinh == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo $gioitinh == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
            </select>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Số hiệu công chức</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="sohieucongchuc" id="sohieucongchuc" value="<?php echo isset($sohieucongchuc) ? $sohieucongchuc : ''; ?>" placeholder="Số hiệu công chức"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Ngày sinh</div>
        <div class="cell colspan2 input-control text" data-role="datepicker" data-format="dd/mm/yyyy">
            <input type="text" name="ngaysinh" id="ngaysinh" value="<?php echo isset($ngaysinh) ? $ngaysinh : ''; ?>" placeholder="Ngày sinh" data-inputmask="'alias': 'date'" class="ngaythangnam"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Nơi sinh</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="noisinh" id="noisinh" value="<?php echo isset($noisinh) ? $noisinh : ''; ?>"  placeholder="Nơi sinh"/>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">CMND</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="cmnd" id="cmnd" value="<?php echo isset($cmnd) ? $cmnd : ''; ?>" placeholder="CMND"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Ngày cấp</div>
        <div class="cell colspan2 input-control text" data-role="datepicker" data-format="dd/mm/yyyy">
            <input type="text" name="ngaycap" id="ngaycap" value="<?php echo isset($ngaycap) ? $ngaycap : ''; ?>" placeholder="Ngày cấp" data-inputmask="'alias': 'date'" class="ngaythangnam"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Nơi cấp</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="noicap" id="noicap" value="<?php echo isset($noicap) ? $noicap : ''; ?>"  placeholder="Nơi cấp"/>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Dân tộc</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="dantoc" id="dantoc" value="<?php echo isset($dantoc) ? $dantoc : ''; ?>" placeholder="Dân tộc"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Tôn giáo</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="tongiao" id="tongiao" value="<?php echo isset($tongiao) ? $tongiao : ''; ?>" placeholder="Tôn giáo"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Quốc tịch</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="quoctich" id="quoctich" value="<?php echo isset($quoctich) ? $quoctich : ''; ?>" placeholder="Quốc tịch"/>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Quê quán</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="quequan" id="quequan" value="<?php echo isset($quequan) ? $quequan : ''; ?>" placeholder="Quê quán"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Địa chị thường trú</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="diachithuongtru" id="diachithuongtru" value="<?php echo isset($diachithuongtru) ? $diachithuongtru : ''; ?>" placeholder="Địa chỉ thường trú"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Nơi ở hiện nay</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="noiohiennay" id="noiohiennay" value="<?php echo isset($noiohiennay) ? $noiohiennay : ''; ?>" placeholder="Nơi ở hiện nay"/>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Điện thoại</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="dienthoai" id="dienthoai" value="<?php echo isset($dienthoai) ? $dienthoai : ''; ?>" placeholder="Điện thoại"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Email</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Email"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Tình trạng hôn nhân</div>
        <div class="cell colspan2 input-control select">
            <select name="tinhtranghonnhan" id="tinhtranghonnhan">
                <option value="Độc thân">Độc thân</option>
                <option value="Có gia đình">Có gia đình</option>
            </select>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Ngày vào Đảng</div>
        <div class="cell colspan2 input-control text" data-role="datepicker" data-format="dd/mm/yyyy">
            <input type="text" name="ngayvaodang" id="ngayvaodang" value="<?php echo isset($ngayvaodang) ? $ngayvaodang : ''; ?>" placeholder="Ngày vào Đảng" data-inputmask="'alias': 'date'" class="ngaythangnam"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Chức vụ Đảng</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="chucvudang" id="chucvudang" value="<?php echo isset($chucvudang) ? $chucvudang : ''; ?>" placeholder="Chức vụ Đảng"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Trình độ</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="trinhdo" id="trinhdo" value="<?php echo isset($trinhdo) ? $trinhdo : ''; ?>" placeholder="Trình độ"/>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Chuyên ngành</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="chuyennganh" id="chuyennganh" value="<?php echo isset($chuyennganh) ? $chuyennganh : ''; ?>" placeholder="Chuyên ngành"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Mã ngạch</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="mangach" id="mangach" value="<?php echo isset($mangach) ? $mangach : ''; ?>" placeholder="Mã ngạch"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Tên ngạch</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="tenngach" id="tenngach" value="<?php echo isset($tenngach) ? $tenngach : ''; ?>" placeholder="Tên ngạch"/>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Bậc lương</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="bacluong" id="bacluong" value="<?php echo isset($bacluong) ? $bacluong : ''; ?>" placeholder="Bậc lương"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Hệ số lương</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="hesoluong" id="hesoluong" value="<?php echo isset($hesoluong) ? $hesoluong : ''; ?>" placeholder="Hệ số lương"/>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Khen thưởng</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="khenthuong" id="khenthuong" value="<?php echo isset($khenthuong) ? $khenthuong : ''; ?>" placeholder="Khen thưởng"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Kỹ luật</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="kyluat" id="kyluat" value="<?php echo isset($kyluat) ? $kyluat : ''; ?>" placeholder="Kỹ luật"/>
        </div>
        <div class="cell colspan2 align-right">
            Hình ảnh
            <?php
            if(isset($hinhanh)){
                if($hinhanh && file_exists('uploads/teachers/' . $hinhanh)){
                    echo '<img src="uploads/teachers/'.$gv['hinhanh'].'" width="40" height="50" />';    
                } else if($hinhanh && !file_exists('uploads/teachers/' . $hinhanh)){
                    echo '<img src="image.html?id='.$hinhanh.'" width="40" height="50" />';    
                }
                echo '<input type="hidden" name="old_hinhanh" id="old_hinhanh" value="'.$hinhanh.'"/>';
            }
            ?>
        </div>
        <div class="cell colspan2 input-control file" data-role="input">
            <input type="file" name="hinhanh" id="hinhanh" value="">
            <button class="button"><span class="mif-folder"></span></button>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Ghi chú</div>
        <div class="cell colspan10 input-control textarea">
            <textarea name="ghichu" id="ghichu"><?php echo isset($ghichu) ? $ghichu : ''; ?></textarea>
        </div>
    </div>
    <div class="row cells12">
        <div class="cell colspan12 align-center">
            <button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
            <a href="danhmucgiaovien.html" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
        </div>
    </div>
</div>
</form>
<?php require_once('footer.php'); ?>