<?php
require_once('header.php');
check_permis(!$users->is_admin());
$giangday = new GiangDay();$giaovien = new GiaoVien();$hocsinh = new HocSinh();
$lophoc = new LopHoc();$namhoc = new NamHoc();$monhoc = new MonHoc();$danhsachlop = new DanhSachLop();
$giaovien_list = $giaovien->get_all_list();
$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_list_limit(3);
$monhoc_list = $monhoc->get_all_list();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
if(isset($_POST['submit'])){
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$id_giaovien = isset($_POST['id_giaovien']) ? $_POST['id_giaovien'] : '';
	$id_lophoc	= isset($_POST['id_lophoc']) ? $_POST['id_lophoc'] : '';
	$id_namhoc = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';
	$id_monhoc = isset($_POST['id_monhoc']) ? $_POST['id_monhoc'] : '';

	$giangday->id = $id;
	$giangday->id_giaovien = $id_giaovien;
	$giangday->id_lophoc = $id_lophoc;
	$giangday->id_namhoc = $id_namhoc;
	$giangday->id_monhoc = $id_monhoc;

	if($id){
		if($giangday->check_giaovien_giangday()){
			$msg = 'Đã phân công giáo viên cho lớp này rồi...';
		} else {
			if($giangday->edit()){
				transfers_to('phanconggiangday.php?id_namhoc=' . $id_namhoc . '&submit=OK&update=edit_ok');
			} else {
				$msg = 'Không thể chỉnh sửa...';
			}
		}
	} else {
		$msg = 'Không thể chỉnh sửa';
	}	
	
}

if($id){
	$giangday->id = $id;
	$edit_gvcn = $giangday->get_one();
	$id_giaovien = $edit_gvcn['id_giaovien'];
	$id_lophoc = $edit_gvcn['id_lophoc'];
	$id_namhoc = $edit_gvcn['id_namhoc'];
	$id_monhoc = $edit_gvcn['id_monhoc'];
}
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
<h1><a href="phanconggiangday.php" class="nav-button transform"><span></span></a>&nbsp;Sửa thông tin phân công giáo viên giảng dạy</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="formphanconggiangday">
<input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id: ''; ?>" />
<div class="grid example" style="margin-top:30px;">
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Năm học:</div>
		<div class="cell colspan4 input-control select">
			<select name="id_namhoc" id="id_namhoc" class="select2">
				<?php
				if($namhoc_list->count() > 0){
					foreach ($namhoc_list as $nh) {
						echo '<option value="'.$nh['_id'].'"'.($nh['_id']==$id_namhoc ? ' selected' : '').'>'.$nh['tennamhoc'].'</option>';
					}
				}
				?>
			</select>
		</div>
		<div class="cell colspan2 align-right padding-top-10">Lớp:</div>
		<div class="cell colspan4 input-control select">
			<select name="id_lophoc" id="id_lophoc" class="select2">
				<?php
				if($lophoc_list->count() > 0){
					foreach ($lophoc_list as $lh) {
						echo '<option value="'.$lh['_id'].'" '.($lh['_id']==$id_lophoc? ' selected' : '').'>'.$lh['tenlophoc'].'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Giáo viên:</div>
		<div class="cell colspan4 input-control select">
			<select name="id_giaovien" id="id_giaovien" class="select2">
				<?php
				if($giaovien_list->count() > 0){
					foreach ($giaovien_list as $gv) {
						echo '<option value="'.$gv['_id'].'" '.($gv['_id'] == $id_giaovien ? ' selected': '').' >'.$gv['masogiaovien'] . ' - ' . $gv['hoten'].'</option>';
					}
				}
				?>
			</select>
		</div>
		<div class="cell colspan2 align-right padding-top-10">Môn học:</div>
		<div class="cell colspan4 input-control select">
			<select name="id_monhoc" id="id_monhoc" class="select2">
				<?php
				if($monhoc_list->count() > 0){
					foreach ($monhoc_list as $mh) {
						echo '<option value="'.$mh['_id'].'"'.($mh['_id']==$id_monhoc ? ' selected' : '').'>'.$mh['tenmonhoc'].'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
			<a href="phanconggiangday.php" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
		</div>
	</div>
</div>
</form>
<?php require_once('footer.php'); ?>
