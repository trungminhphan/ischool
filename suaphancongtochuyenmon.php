<?php
require_once('header.php');
check_permis(!$users->is_admin());
$to = new To();$giaovien = new GiaoVien();$tochuyenmon = new ToChuyenMon();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id_to = isset($_GET['id_to']) ? $_GET['id_to'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';
if($id && $act=='del'){
	$tochuyenmon->id = $id;
	if($tochuyenmon->delete()){
		transfers_to('phancongtochuyenmon.php?id_namhoc='.$id_namhoc.'&id_to='.$id_to .'&submit=OK');
	} else {
		$msg = 'Không thể xoá.';
	}
}
$namhoc_list = $namhoc->get_all_list();
$to_list = $to->get_all_list();
$giaovien_list = $giaovien->get_all_list();
//$arr_giaivien = array();
if(isset($_POST['submit'])){
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$id_namhoc = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';
	$id_to = isset($_POST['id_to']) ? $_POST['id_to'] : '';
	$id_giaovien = isset($_POST['id_giaovien']) ? $_POST['id_giaovien'] : '';
	if($id_namhoc && $id_to && $id_giaovien){
		$tochuyenmon->id = $id;
		$tochuyenmon->id_namhoc = $id_namhoc;
		$tochuyenmon->id_to = $id_to;
		$tochuyenmon->id_giaovien = $id_giaovien;
		if($tochuyenmon->check_exists()){
			$msg = 'Đã phân công cho giáo viên này rùi';
		} else {
			if($tochuyenmon->edit()){
				transfers_to('phancongtochuyenmon.php?id_namhoc='. $id_namhoc . '&id_to=' . $id_to .'&submit=OK');
			} else {
				$msg = 'Không thể chỉnh sửa';
				//array_push($arr_giaivien, new MongoId($value));
			}
		}
	} else {
		$msg = 'Vui lòng chọn năm học, tổ, giáo viên';
	}
}
if($id && $act=='edit'){
	$tochuyenmon->id = $id;$tc = $tochuyenmon->get_one();
	$id_namhoc = $tc['id_namhoc'];
	$id_to = $tc['id_to'];
	$id_giaovien = $tc['id_giaovien'];
}
?>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		$("#table_list").dataTable();
		<?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
	});
</script>
<h1><a href="index.php" class="nav-button transform"><span></span></a>&nbsp;Sửa phân công Giáo viên - Tổ chuyên môn</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="formphancongtochuyenmon">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<div class="grid example">
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right">Năm học</div>
		<div class="cell colspan4 input-control select">
			<select name="id_namhoc" id="id_namhoc" class="select2">
				<option value="">Chọn năm học</option>
				<?php
				if($namhoc_list){
					foreach ($namhoc_list as $nh) {
						echo '<option value="'.$nh['_id'].'"'.($id_namhoc==$nh['_id'] ? ' selected' : '').'>'.$nh['tennamhoc'].'</option>';
					}
				}
				?>
			</select>
		</div>
		<div class="cell colspan2 padding-top-10 align-right">Tổ</div>
		<div class="cell colspan4 input-control select">
			<select name="id_to" id="id_to" class="select2">
				<option value="">Chọn tổ</option>
				<?php
				if($to_list){
					foreach ($to_list as $t) {
						echo '<option value="'.$t['_id'].'"'.($id_to == $t['_id'] ? ' selected' : '').'>'.$t['tento'].'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 padding-top-10 align-right">Giáo viên</div>
		<div class="cell colspan6 input-control select">
			<select name="id_giaovien" id="id_giaovien" class="select2">
				<option value="">Chọn Giáo viên</option>
				<?php
				if($giaovien_list){
					foreach ($giaovien_list as $gv) {
						echo '<option value="'.$gv['_id'].'"'.($gv['_id']==$id_giaovien ? ' selected' :'').'>'.$gv['hoten'].'</option>';
					}
				}
				?>
			</select>
		</div>
		<div class="cell colspan4 align-left">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
		</div>
	</div>

</div>

</form>
