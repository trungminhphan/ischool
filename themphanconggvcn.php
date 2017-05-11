<?php
require_once('header.php');
check_permis(!$users->is_admin());
$giaovienchunhiem = new GiaoVienChuNhiem();
$giaovien = new GiaoVien();$hocsinh = new HocSinh();$lophoc = new LopHoc();$namhoc = new NamHoc();
$giaovien_list = $giaovien->get_all_list(); $lophoc_list = $lophoc->get_all_list();$namhoc_list = $namhoc->get_all_list();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
if($id && $act=='del'){
	$giaovienchunhiem->id = $id;
	if($giaovienchunhiem->delete()){
		transfers_to('phanconggvcn.html?id_namhoc='.$id_namhoc.'&submit=OK&update=delete_ok');
	}
}
if(isset($_POST['submit'])){
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$id_giaovien = isset($_POST['id_giaovien']) ? $_POST['id_giaovien'] : '';
	$id_lophoc	= isset($_POST['id_lophoc']) ? $_POST['id_lophoc'] : '';
	$id_namhoc = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';
	$giaovienchunhiem->id = $id;
	$giaovienchunhiem->id_giaovien = $id_giaovien;
	$giaovienchunhiem->id_lophoc = $id_lophoc;
	$giaovienchunhiem->id_namhoc = $id_namhoc;

	if($id){
		if($giaovienchunhiem->check_giaovien_exists_namhoc()){
			$msg = 'Đã phân công giáo viên cho lớp này rồi...';
		} else {
			if($giaovienchunhiem->edit()){
				transfers_to('phanconggvcn.html?id_namhoc='.$id_namhoc.'&submit=OK&update=edit_ok');	
			}
		}
	} else {
		//insert
		if($giaovienchunhiem->check_exists()){
			$msg = 'Đã phân công GVCN cho lớp này và năm học này rồi...';
		} else {
			if($giaovienchunhiem->insert()){
				transfers_to('phanconggvcn.html?id_namhoc='.$id_namhoc.'&submit=OK&update=insert_ok');
			}
		}
	}
}
if($id){
	$giaovienchunhiem->id = $id;
	$edit_gvcn = $giaovienchunhiem->get_one();
	$id_giaovien = $edit_gvcn['id_giaovien'];
	$id_lophoc = $edit_gvcn['id_lophoc'];
	$id_namhoc = $edit_gvcn['id_namhoc'];
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
<h1><a href="phanconggvcn.html" class="nav-button transform"><span></span></a>&nbsp;Thông tin phân công giáo viên chủ nhiệm</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="formphanconggvcn">
<input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id: ''; ?>" />
<div class="grid example" style="margin-top:30px;">
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Giáo viên:</div>
		<div class="cell colspan2 input-control select">
			<select name="id_giaovien" id="id_giaovien" class="select2">
				<?php
					if($giaovien_list->count() > 0){
						foreach ($giaovien_list as $gv) {
							echo '<option value="'.$gv['_id'].'" '.($gv['_id'] == $id_giaovien ? ' selected': '').' >'.$gv['masogiaovien'] .' - '. $gv['hoten'].'</option>';
						}
					}
				?>
			</select>
		</div>
		<div class="cell colspan2 align-right padding-top-10">Lớp:</div>
		<div class="cell colspan2 input-control select">
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
		<div class="cell colspan2 align-right padding-top-10">Năm học:</div>
		<div class="cell colspan2 input-control select">
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
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
			<a href="phanconggvcn.html" class="button"><span class="mif-keyboard-return"></span> Trở về</a>
		</div>
	</div>
</div>
</form>
<?php require_once('footer.php'); ?>
