<?php
require_once('header.php');
check_permis(!$users->is_admin());
$to = new To();$giaovien = new GiaoVien();$tochuyemon = new ToChuyenMon();

$namhoc_list = $namhoc->get_all_list();
$to_list = $to->get_all_list();
$giaovien_list = $giaovien->get_all_list();
$id_namhoc='';$id_to='';$id_giaovien='';$arr_query = array();
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] :'';
	$id_to = isset($_GET['id_to']) ? $_GET['id_to'] :'';
	$id_giaovien = isset($_GET['id_giaovien']) ? $_GET['id_giaovien'] :'';

	if($id_giaovien || $id_namhoc || $id_to){
		if($id_namhoc){ array_push($arr_query, array('id_namhoc' => new MongoId($id_namhoc))); }
		if($id_to){ array_push($arr_query, array('id_to' => new MongoId($id_to))); }
		if($id_giaovien){ array_push($arr_query, array('id_giaovien' => new MongoId($id_giaovien)));}

		$query = array('$and' => $arr_query);
		$tochuyenmon_list = $tochuyemon->get_list_condition($query);
	} else {
		$tochuyenmon_list = '';
		$msg = 'Hãy chọn Năm học, tổ hoặc giáo viên';
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
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="formphancongtochuyenmon">
Năm học:
<div class="input-control select">
	<select name="id_namhoc" id="id_namhoc" class="select2">
		<option value="">Chọn năm học</option>
		<?php
		if($namhoc_list){
			foreach ($namhoc_list as $nh) {
				echo '<option value="'.$nh['_id'].'"'.($id_namhoc==$nh['_id']?' selected':'').'>'.$nh['tennamhoc'].'</option>';
			}
		}
		?>
	</select>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tổ: 
<div class="input-control select">
	<select name="id_to" id="id_to" class="select2">
		<option value="">Chọn tổ</option>
		<?php
		if($to_list){
			foreach ($to_list as $t) {
				echo '<option value="'.$t['_id'].'"'.($id_to==$t['_id'] ? ' selected':'').'>'.$t['tento'].'</option>';
			}
		}
		?>
	</select>
</div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Giáo viên: 
<div class="input-control select">
	<select name="id_giaovien" id="id_giaovien" class="select2">
		<option value="">Chọn Giáo viên</option>
		<?php
		if($giaovien_list){
			foreach ($giaovien_list as $gv) {
				echo '<option value="'.$gv['_id'].'"'.($id_giaovien==$gv['_id'] ? ' selected' : '').'>'.$gv['hoten'].'</option>';
			}
		}
		?>
	</select>
</div>
<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Tìm kiếm</button>
<a href="themphancongtochuyenmon.php" class="button success"><span class="mif-plus"></span> Thêm phân công</a>
</form>
<hr />
<?php if(isset($tochuyenmon_list) && $tochuyenmon_list) : ?>
<table class="table border bordered striped hovered"> 
	<thead>
		<tr>
			<th>STT</th>
			<th>Họ tên</th>
			<th>Năm học</th>
			<th>Tổ</th>
			<th><span class="mif-bin"></span></th>
			<th><span class="mif-pencil"></span></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i=1;
	foreach($tochuyenmon_list as $tc){
		$giaovien->id = $tc['id_giaovien']; $gv = $giaovien->get_one();
		$namhoc->id = $tc['id_namhoc']; $nh = $namhoc->get_one();
		$to->id = $tc['id_to']; $t = $to->get_one();
		echo '<tr>
		<td>'.$i.'</td>
		<td>'.$gv['hoten'].'</td>
		<td>'.$nh['tennamhoc'].'</td>
		<td>'.$t['tento'].'</td>
		<td><a href="suaphancongtochuyenmon.php?id='.$tc['_id'].'&id_namhoc='.$tc['id_namhoc'].'&id_to='.$tc['id_to'].'&act=del" onclick="return confirm(\'Bạn chắc chắn muốn xoá?\')"><span class="mif-bin"></span></a></td>
		<td><a href="suaphancongtochuyenmon.php?id='.$tc['_id'].'&id_namhoc='.$tc['id_namhoc'].'&id_to='.$tc['id_to'].'&act=edit"><span class="mif-pencil"></span></a></td>
		</tr>';$i++;
	}
	?>
	</tbody>
</table>
<?php endif; ?>

<?php
require_once('footer.php');
?>