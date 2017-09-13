<?php
require_once('header.php');
check_permis(!$users->is_admin());
$namhoc_list = $namhoc->get_all_list();
$lophoc = new LopHoc(); $lophoc_list = $lophoc->get_all_list();
$id_namhoc = ''; $id_lophoc='';
?>
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		<?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
	});
</script>
<h1><a href="index.php" class="nav-button transform"><span></span></a>&nbsp;Import danh sách học sinh từ file Excel</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="importhocsinh" enctype="multipart/form-data">
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Chọn tập tin</div>
		<div class="cell colspan2 input-control file" data-role="input">
			<input type="file" name="danhsachhocsinh" id="danhsachhocsinh" />
			<button class="button"><span class="mif-folder"></span></button>
			<span class="tag alert">Tập tin theo mẫu Download.</span>
		</div>
		<div class="cell colspan2 align-right padding-top-10">Chọn lớp</div>
		<div class="cell colspan2 input-control select">
			<select name="id_lophoc" id="id_lophoc" class="select2">
			<?php

				if($lophoc_list){
					foreach($lophoc_list as $lh){
						echo '<option value="'.$lh['_id'].'">'.$lh['tenlophoc'].'</option>';
					}
				}
			?>
			</select>
		</div>
		<div class="cell colspan2 align-right padding-top-10">Chọn năm học</div>
		<div class="cell colspan2 input-control select">
			<select name="id_namhoc" id="id_namhoc" class="select2">
			<?php
			if($namhoc_list){
				foreach($namhoc_list as $nh){
					echo '<option value="'.$nh['_id'].'">'.$nh['tennamhoc'].'</option>';
				}
			}
			?>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Import danh sách</button>
			<a href="downloads/mau_danh_muc_hoc_sinh.xlsx" class="button success"><span class="mif-file-download"></span> Download tập tin mẫu</a>
		</div>
	</div>
</div>
</form>
<hr />
<?php
if(isset($_POST['submit'])){
	$danhsachlop = new DanhSachLop();$hocsinh = new HocSinh();
	$id_namhoc = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';
	$id_lophoc = isset($_POST['id_lophoc']) ? $_POST['id_lophoc'] : '';
	$danhsachlop->id_namhoc = $id_namhoc; $danhsachlop->id_lophoc = $id_lophoc;
	if($danhsachlop->check_exists_import()){
		$msg = 'Dữ liệu của lớp này đã tồn tại, vui lòng kiểm tra lại...';
	} else {
		$allowedExts = array("xls","xlsx");
		$temp = explode(".", $_FILES["danhsachhocsinh"]["name"]);
		$extension = end($temp);
		if(in_array($extension, $allowedExts)){
			$filename =  $_FILES["danhsachhocsinh"]["name"] . '_' . date("YmdHsi") . '.' . $extension;
			if(move_uploaded_file($_FILES["danhsachhocsinh"]["tmp_name"], 'uploads/' . $filename)){
				require_once('cls/PHPExcel/IOFactory.php');
				$objPHPExcel = PHPExcel_IOFactory::load('uploads/' . $filename);
				$sheetData_import = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$j =1;
				echo '<table class="table border bordered striped hovered">
						<tr>
							<th>STT</th>
							<th>Hình ảnh</th>
							<th>Mã số học sinh</th>
							<th>Chứng minh nhân dân</th>
							<th>Họ tên</th>
							<th>Ngày sinh</th>
							<th>Giới tính</th>
							<th>Nơi sinh</th>
							<th>Quốc tịch</th>
							<th>Dân tộc</th>
							<th>Tôn giáo</th>
							<th>Quê quán</th>
							<th>Hộ khẩu thường trú</th>
							<th>Nơi ở hiện nay</th>
							<th>Ngày vào Đoàn</th>
							<th>Ngày vào Đảng</th>
							<th>Điện thoại</th>
							<th>Email</th>
							<th>Họ tên Cha</th>
							<th>Năm sinh cha</th>
							<th>Nghề nghiệp Cha</th>
							<th>Đơn vị công tác cha</th>
							<th>Họ tên mẹ</th>
							<th>Năm sinh mẹ</th>
							<th>Nghề nghiệp mẹ</th>
							<th>Đơn vị công tác mẹ</th>
							<th>Khen thưởng</th>
							<th>Kỷ luật</th>
							<th>Ghi chú</th>
							<th>Tốt Nghiệp</th>
						</tr>';
				if($sheetData_import) {
					foreach ($sheetData_import as $key => $value) {
						if($key >= 2 && $value['B'] && $value['D']) {
							$hinhanh = $value['A'];	$masohocsinh = $value['B'];
							$cmnd = $value['C']; $hoten = $value['D'];
							$ngaysinh = $value['E'];$gioitinh = $value['G'];
							$noisinh = $value['F']; $quoctich = $value['J'];
							$dantoc = $value['H']; $tongiao = $value['K'];
							$quequan = $value['L']; $hokhauthuongtru = $value['M'];
							$noiohiennay = $value['N']; $ngayvaodoan = $value['O'];
							$ngayvaodang = $value['P']; $dienthoai = $value['Q'];
							$email = $value['R']; $hotencha = $value['S'];
							$namsinhcha = $value['T']; $nghenghiepcha = $value['U'];
							$donvicongtaccha = $value['V']; $hotenme = $value['W'];
							$namsinhme = $value['X']; $nghenghiepme = $value['Y'];
							$donvicongtacme = $value['Z']; $khenthuong = $value['AA'];
							$kyluat = $value['AB']; $ghichu = $value['I'];	$totnghiep = $value['AC'];
							$a = explode(" ", trim($hoten));$ten = end($a);
							$id_hocsinh = new MongoId();
							$hocsinh->id = $id_hocsinh;
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
							$hocsinh->kyluat = $kyluat;
							$hocsinh->ghichu = $ghichu;
							$hocsinh->totnghiep = $totnghiep ? $totnghiep : 0;
							$danhsachlop->id_hocsinh = $id_hocsinh;
							if($hoten){
								if($hocsinh->insert_id()){
									$danhsachlop->insert_list();
									$query_user = array('username' => $masohocsinh, 'password' => md5($masohocsinh), 'id_hocsinh' => new MongoId($id_hocsinh), 'roles' => (int) STUDENT);
									$users->insert($query_user);
									echo '<tr>';
									echo '<td>'.$j.'</td>';
									echo '<td>'.$hinhanh.'</td>';
									echo '<td>'.$masohocsinh.'</td>';
									echo '<td>'.$cmnd.'</td>';
									echo '<td>'.$hoten.'</td>';
									echo '<td>'.$ngaysinh.'</td>';
									echo '<td>'.$gioitinh.'</td>';
									echo '<td>'.$noisinh.'</td>';
									echo '<td>'.$quoctich.'</td>';
									echo '<td>'.$dantoc.'</td>';
									echo '<td>'.$tongiao.'</td>';
									echo '<td>'.$quequan.'</td>';
									echo '<td>'.$hokhauthuongtru.'</td>';
									echo '<td>'.$noiohiennay.'</td>';
									echo '<td>'.$ngayvaodoan.'</td>';
									echo '<td>'.$ngayvaodang.'</td>';
									echo '<td>'.$dienthoai.'</td>';
									echo '<td>'.$email.'</td>';
									echo '<td>'.$hotencha.'</td>';
									echo '<td>'.$namsinhcha.'</td>';
									echo '<td>'.$nghenghiepcha.'</td>';
									echo '<td>'.$donvicongtaccha.'</td>';
									echo '<td>'.$hotenme.'</td>';
									echo '<td>'.$namsinhme.'</td>';
									echo '<td>'.$nghenghiepme.'</td>';
									echo '<td>'.$donvicongtacme.'</td>';
									echo '<td>'.$khenthuong.'</td>';
									echo '<td>'.$kyluat.'</td>';
									echo '<td>'.$ghichu.'</td>';
									echo '<td>'.$totnghiep.'</td>';
									echo '</tr>';
									$j++;
								}
							}
						}
					}
				}
				echo '</table>';
				$msg = 'Import thành công...';
			}
		} else {
			$msg = 'Tập tin không hợp lệ...';
		}
	}
}
?>

<?php require_once('footer.php'); ?>
