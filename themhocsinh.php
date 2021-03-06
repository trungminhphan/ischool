<?php
require_once('header.php');
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$giaovienchunhiem->id_namhoc = $id_namhoc;
$giaovienchunhiem->id_lophoc = $id_lophoc;

check_permis(!$users->is_admin() && !$giaovienchunhiem->check_is_gvcn());
$act = isset($_GET['act']) ? $_GET['act'] : '';
$hocsinh = new HocSinh();$gridfs = new GridFS();
$csrf = new CSRF_Protect();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';
if($id && $act=='del'){
	$hocsinh->id = $id;
	$hs = $hocsinh->get_one();
	$gridfs->id = $hs['hinhanh'];
	if($hocsinh->delete()){
		$gridfs->delete();
		transfers_to('danhmuchocsinh.html');
	} else {
		$msg = 'Không thể xoá...';
	}
}
$gioitinh ='';
$totnghiep = 0;
if(isset($_POST['submit'])){
	$csrf->verifyRequest();
	$id = isset($_POST['id']) ? $_POST['id'] : 0;
	if($_FILES["hinhanh"]["name"]){
        $allowedExts = array("gif", "jpeg", "jpg", "png");
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
        } else {
            $hinhanh = '';
        }
    } else {
        $hinhanh = isset($_POST['old_hinhanh']) ? $_POST['old_hinhanh'] : '';
    }
    $id_namhoc = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';
    $id_lophoc = isset($_POST['id_lophoc']) ? $_POST['id_lophoc'] : '';
	$masohocsinh = isset($_POST['masohocsinh']) ? $_POST['masohocsinh'] : '';
	$cmnd = isset($_POST['cmnd']) ? $_POST['cmnd'] : '';
	$hoten = isset($_POST['hoten']) ? $_POST['hoten'] : '';
	$ngaysinh = isset($_POST['ngaysinh']) ? $_POST['ngaysinh'] : '';
	$gioitinh = isset($_POST['gioitinh']) ? $_POST['gioitinh'] : '';
	$noisinh = isset($_POST['noisinh']) ? $_POST['noisinh'] : '';
	$quoctich = isset($_POST['quoctich']) ? $_POST['quoctich'] : '';
	$dantoc = isset($_POST['dantoc']) ? $_POST['dantoc'] : '';
	$tongiao = isset($_POST['tongiao']) ? $_POST['tongiao'] : '';
	$quequan = isset($_POST['quequan']) ? $_POST['quequan'] : '';
	$hokhauthuongtru = isset($_POST['hokhauthuongtru']) ? $_POST['hokhauthuongtru'] : '';
	$noiohiennay = isset($_POST['noiohiennay']) ? $_POST['noiohiennay'] : '';
	$ngayvaodoan = isset($_POST['ngayvaodoan']) ? $_POST['ngayvaodoan'] : '';
	$ngayvaodang = isset($_POST['ngayvaodang']) ? $_POST['ngayvaodang'] : '';
	$dienthoai = isset($_POST['dienthoai']) ? $_POST['dienthoai'] : '';
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$hotencha = isset($_POST['hotencha']) ? $_POST['hotencha'] : '';
	$namsinhcha = isset($_POST['namsinhcha']) ? $_POST['namsinhcha'] : '';
	$nghenghiepcha = isset($_POST['nghenghiepcha']) ? $_POST['nghenghiepcha'] : '';
	$donvicongtaccha = isset($_POST['donvicongtaccha']) ? $_POST['donvicongtaccha'] : '';
	$hotenme = isset($_POST['hotenme']) ? $_POST['hotenme'] : '';
	$namsinhme = isset($_POST['namsinhme']) ? $_POST['namsinhme'] : '';
	$nghenghiepme = isset($_POST['nghenghiepme']) ? $_POST['nghenghiepme'] : '';
	$donvicongtacme = isset($_POST['donvicongtacme']) ? $_POST['donvicongtacme'] : '';
	$khenthuong = isset($_POST['khenthuong']) ? $_POST['khenthuong'] : '';
	$maxacnhanphuhuynh = isset($_POST['maxacnhanphuhuynh']) ? $_POST['maxacnhanphuhuynh'] : '';
	$kyluat = isset($_POST['kyluat']) ? $_POST['kyluat'] : '';
	$ghichu = isset($_POST['ghichu']) ? $_POST['ghichu'] : '';
	$totnghiep = isset($_POST['totnghiep']) ? $_POST['totnghiep'] : '';;
  $a = explode(" ", trim($hoten)); $ten = end($a);
	$hocsinh->id = $id;
	$hocsinh->hinhanh = $hinhanh;
	$hocsinh->masohocsinh = $masohocsinh;
	$hocsinh->cmnd = $cmnd;
	$hocsinh->hoten = $hoten;
  $hocsinh->ten = $ten;
	$hocsinh->ngaysinh = $ngaysinh;
	$hocsinh->gioitinh = $gioitinh;
	$hocsinh->noisinh = $noisinh;
	$hocsinh->quoctich = $quoctich;
	$hocsinh->dantoc = $dantoc;
	$hocsinh->tongiao = $tongiao;
	$hocsinh->quequan = $quequan;
	$hocsinh->hokhauthuongtru = $hokhauthuongtru;
	$hocsinh->noiohiennay = $noiohiennay;
	$hocsinh->ngayvaodoan = $ngayvaodoan;
	$hocsinh->ngayvaodang = $ngayvaodang;
	$hocsinh->dienthoai = $dienthoai;
	$hocsinh->email = $email;
	$hocsinh->hotencha = $hotencha;
	$hocsinh->namsinhcha = $namsinhcha;
	$hocsinh->nghenghiepcha = $nghenghiepcha;
	$hocsinh->donvicongtaccha = $donvicongtaccha;
	$hocsinh->hotenme = $hotenme;
	$hocsinh->namsinhme = $namsinhme;
	$hocsinh->nghenghiepme = $nghenghiepme;
	$hocsinh->donvicongtacme = $donvicongtacme;
	$hocsinh->khenthuong = $khenthuong;
	$hocsinh->maxacnhanphuhuynh = $maxacnhanphuhuynh;
	$hocsinh->kyluat = $kyluat;
	$hocsinh->ghichu = $ghichu;
	$hocsinh->totnghiep = $totnghiep;

	if($id) {
		//edit
		if($hocsinh->edit()){
			if($users->is_admin()){
				transfers_to('danhmuchocsinh.html');
			} else {
				transfers_to('xemdanhsachlop.html?id_namhoc='.$id_namhoc.'&id_lophoc='.$id_lophoc.'&submit=OK');
			}
		} else {
			$msg = 'Không thể chỉnh sửa.';
		}
	} else {
		//insert
		if($hocsinh->check_exists()){
			$msg = 'Mã số học sinh bị trùng, Vui lòng chọn tên khác...</b>';
		} else {
      $id_hocsinh = new MongoId(); $hocsinh->id = $id_hocsinh;
			if($hocsinh->insert_id()){
        $query_user = array('username' => $masohocsinh, 'password' => md5($masohocsinh), 'id_hocsinh' => new MongoId($id_hocsinh), 'roles' => (int) STUDENT);
        $users->insert($query_user);
				transfers_to('danhmuchocsinh.html');
			} else {
				$msg = 'Không thể thêm học sinh mới.';
			}
		}
	}
}

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
	$totnghiep = $edit_hocsinh['totnghiep'];
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
<h1><a href="danhmuchocsinh.html" class="nav-button transform"><span></span></a>&nbsp;Thông tin Học sinh</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="themhocsinhform" data-role="validator" data-show-required-state="false" enctype="multipart/form-data">
<?php $csrf->echoInputField(); ?>
<input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : ''; ?>" />
<input type="hidden" name="id_namhoc" value="<?php echo isset($id_namhoc) ? $id_namhoc: ''; ?>">
<input type="hidden" name="id_lophoc" value="<?php echo isset($id_lophoc) ? $id_lophoc: ''; ?>">
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Mã số học sinh</div>
		<div class="cell colspan2 input-control text">
			<input type="text" name="masohocsinh" id="masohocsinh" value="<?php echo isset($masohocsinh) ? $masohocsinh : ''; ?>" maxlength="20" data-validate-func="required" placeholder="Mã số học sinh" <?php echo $users->is_admin() ? '' : 'class="bg-grayLight" readonly'; ?> />
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
		<div class="cell colspan2 align-right padding-top-10">Họ tên</div>
		<div class="cell colspan2 input-control text">
			<input type="text" name="hoten" id="hoten" value="<?php echo isset($hoten) ? $hoten : ''; ?>" maxlength="150" placeholder="Họ tên" data-validate-func="required"/>
			<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
		</div>
		<div class="cell colspan2 align-right padding-top-10">Ngày sinh</div>
		<div class="cell colspan2 input-control text" data-role="datepicker" data-format="dd/mm/yyyy">
			<input type="text" name="ngaysinh" id="ngaysinh" value="<?php echo isset($ngaysinh) ? $ngaysinh : ''; ?>" placeholder="Ngày sinh" data-inputmask="'alias': 'date'" class="ngaythangnam"/>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">CMND</div>
		<div class="cell colspan2 input-control text">
			<input type="text" name="cmnd" id="cmnd" value="<?php echo isset($cmnd) ? $cmnd : ''; ?>" placeholder="CMND" />
		</div>
		<div class="cell colspan2 align-right padding-top-10">Giới tính</div>
        <div class="cell colspan2 input-control select">
            <select name="gioitinh" id="gioitinh">
                <option value="Nam" <?php echo $gioitinh == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo $gioitinh == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
            </select>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Nơi sinh</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="noisinh" id="noisinh" value="<?php echo isset($noisinh) ? $noisinh : ''; ?>"  placeholder="Nơi sinh"/>
        </div>
	</div>
	<div class="row cells12">
        <div class="cell colspan2 align-right padding-top-10">Quê quán</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="quequan" id="quequan" value="<?php echo isset($quequan) ? $quequan : ''; ?>" placeholder="Quê quán"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Hộ khẩu thường trú</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="hokhauthuongtru" id="hokhauthuongtru" value="<?php echo isset($hokhauthuongtru) ? $hokhauthuongtru : ''; ?>" placeholder="Hộ khẩu thường trú"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Nơi ở hiện nay</div>
        <div class="cell colspan2 input-control text">
            <input type="text" name="noiohiennay" id="noiohiennay" value="<?php echo isset($noiohiennay) ? $noiohiennay : ''; ?>" placeholder="Nơi ở hiện nay"/>
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
        <div class="cell colspan2 align-right padding-top-10">Ngày vào Đoàn</div>
        <div class="cell colspan2 input-control text" data-role="datepicker" data-format="dd/mm/yyyy">
            <input type="text" name="ngayvaodoan" id="ngayvaodoan" value="<?php echo isset($ngayvaodoan) ? $ngayvaodoan : ''; ?>" placeholder="Ngày vào Đoàn" data-inputmask="'alias': 'date'" class="ngaythangnam"/>
        </div>
        <div class="cell colspan2 align-right padding-top-10">Ngày vào Đảng</div>
        <div class="cell colspan2 input-control text" data-role="datepicker" data-format="dd/mm/yyyy">
            <input type="text" name="ngayvaodang" id="ngayvaodang" value="<?php echo isset($ngayvaodang) ? $ngayvaodang : ''; ?>" placeholder="Ngày vào Đảng" data-inputmask="'alias': 'date'" class="ngaythangnam"/>
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
        <div class="cell colspan2 align-right padding-top-10">Mã xác nhận phụ huynh</div>
        <div class="cell colspan2 input-control text">
            <input type="password" name="maxacnhanphuhuynh" id="maxacnhanphuhuynh" value="<?php echo isset($maxacnhanphuhuynh) ? $maxacnhanphuhuynh : ''; ?>" placeholder="Mã xác nhận" <?php echo $users->is_admin() ? '' : ' class="bg-grayLight" readonly'; ?> />
        </div>
    </div>
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Họ tên Cha</div>
		<div class="cell colspan2 input-control text">
            <input type="text" name="hotencha" id="hotencha" value="<?php echo isset($hotencha) ? $hotencha : ''; ?>" placeholder="Họ tên Cha"/>
        </div>
		<div class="cell colspan2 align-right padding-top-10">Năm sinh</div>
		<div class="cell colspan2 input-control text">
            <input type="text" name="namsinhcha" id="namsinhcha" value="<?php echo isset($namsinhcha) ? $namsinhcha : ''; ?>" placeholder="Năm sinh"/>
        </div>
		<div class="cell colspan2 align-right padding-top-10">Đơn vị công tác</div>
		<div class="cell colspan2 input-control text">
            <input type="text" name="donvicongtaccha" id="donvicongtaccha" value="<?php echo isset($donvicongtaccha) ? $donvicongtaccha : ''; ?>" placeholder="Đơn vị công tác"/>
        </div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Họ tên Mẹ</div>
		<div class="cell colspan2 input-control text">
            <input type="text" name="hotenme" id="hotenme" value="<?php echo isset($hotenme) ? $hotenme : ''; ?>" placeholder="Họ tên Mẹ"/>
        </div>
		<div class="cell colspan2 align-right padding-top-10">Năm sinh</div>
		<div class="cell colspan2 input-control text">
            <input type="text" name="namsinhme" id="namsinhme" value="<?php echo isset($namsinhme) ? $namsinhme : ''; ?>" placeholder="Năm sinh"/>
        </div>
		<div class="cell colspan2 align-right padding-top-10">Đơn vị công tác</div>
		<div class="cell colspan2 input-control text">
            <input type="text" name="donvicongtacme" id="donvicongtacme" value="<?php echo isset($donvicongtacme) ? $donvicongtacme : ''; ?>" placeholder="Đơn vị công tác"/>
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
		<div class="cell colspan8 input-control textarea">
			<textarea name="ghichu" id="ghichu"><?php echo isset($ghichu) ? $ghichu: ''; ?></textarea>
		</div>
		<div class="cell colspan2">
			<label class="input-control checkbox">
			    <input type="checkbox" value="0" name="totnghiep" id="totnghiep" <?php echo $totnghiep ? ' checked' : ''; ?>/>
			    <span class="check"></span>
			    <span class="caption">Tốt nghiệp</span>
			</label>
		</div>
	</div>
	<div class="row cells12">
        <div class="cell colspan10 align-center">
            <button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
            <?php if($users->is_admin()) : ?>
            	<a href="danhmuchocsinh.html" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
            <?php else: ?>
            	<a href="chitiethocsinh.html?id=<?php echo $id; ?>&id_lophoc=<?php echo $id_lophoc; ?>&id_namhoc=<?php echo $id_namhoc; ?>" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
            <?php endif; ?>
        </div>
    </div>
</div>
</form>
<?php require_once('footer.php'); ?>
