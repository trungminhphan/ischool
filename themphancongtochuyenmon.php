<?php
require_once('header.php');
check_permis(!$users->is_admin());
$to = new To();$giaovien = new GiaoVien();$tochuyenmon = new ToChuyenMon();
$namhoc_list = $namhoc->get_all_list();
$to_list = $to->get_all_list();
$giaovien_list = $giaovien->get_all_list();
$id_namhoc = ''; $id_to='';//$arr_giaivien = array();
if(isset($_POST['submit'])){
	$id_namhoc = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';
	$id_to = isset($_POST['id_to']) ? $_POST['id_to'] : '';
	$id_giaovien = isset($_POST['id_giaovien']) ? $_POST['id_giaovien'] : '';
	if($id_namhoc && $id_to && $id_giaovien){
		$tochuyenmon->id_namhoc = $id_namhoc;
		$tochuyenmon->id_to = $id_to;

		foreach ($id_giaovien as $key => $value) {
			$tochuyenmon->id_giaovien = $value;
			if(!$tochuyenmon->check_exists_insert()){
				$tochuyenmon->insert();
			}
			//array_push($arr_giaivien, new MongoId($value));
			transfers_to('phancongtochuyenmon.php?id_namhoc='. $id_namhoc . '&id_to=' . $id_to .'&submit=OK');
		}
		
	} else {
		$msg = 'Vui lòng chọn năm học, tổ, giáo viên';
	}
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
<h1><a href="index.php" class="nav-button transform"><span></span></a>&nbsp;Phân công Giáo viên - Tổ chuyên môn</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="formphancongtochuyenmon">
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
		<div class="cell colspan10 input-control select">
			<select name="id_giaovien[]" class="select2" multiple>
				<option value="">Chọn Giáo viên</option>
				<?php
				if($giaovien_list){
					foreach ($giaovien_list as $gv) {
						echo '<option value="'.$gv['_id'].'"'.(in_array($gv['_id'], $arr_giaivien) ? ' selected' :'').'>'.$gv['hoten'].'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
		</div>
	</div>
</div>

</form>