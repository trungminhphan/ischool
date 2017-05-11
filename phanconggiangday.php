<?php 
require_once('header.php');
check_permis(!$users->is_admin());
$giaovien = new GiaoVien();$hocsinh = new HocSinh();
$lophoc = new LopHoc();$monhoc = new MonHoc();$danhsachlop = new DanhSachLop();
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update == 'insert_ok') $msg = 'Thêm thành công';
if($update == 'edit_ok') $msg = 'Chỉnh sửa thành công';
if($update == 'delete_ok') $msg = 'Xoá thành công';
$giaovien_list = $giaovien->get_all_list();
$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_list_limit(3);
$monhoc_list = $monhoc->get_all_list();

$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_giaovien = isset($_GET['id_giaovien']) ? $_GET['id_giaovien'] : '';
$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
if(isset($_GET['submit']) && ($id_namhoc || $id_lophoc || $id_giaovien || $id_monhoc)){
	$query = array();
	if($id_giaovien){
		array_push($query, array('id_giaovien' => new MongoId($id_giaovien)));
	}
	if($id_lophoc){
		$arr = array();
		if($id_lophoc){
			foreach ($id_lophoc as $key => $value) {
				array_push($arr, new MongoId($value));
			}
		}
		//array_push($query, array('id_lophoc' => new MongoId($id_lophoc)));
		array_push($query, array('id_lophoc' => array('$in'=> $arr)));
	}
	if($id_namhoc){
		array_push($query, array('id_namhoc' => new MongoId($id_namhoc)));
	}
	if($id_monhoc){
		array_push($query, array('id_monhoc' => new MongoId($id_monhoc)));
	}
	$query = array('$and' => $query);
	$giangday_list = $giangday->get_list_condition($query);
} else {
	$giangday_list = $giangday->get_all_list_limit(50);
}
?>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2({
			placeholder: "Chọn điều kiện tìm kiếm",
			allowClear: true
		});
		$("#table_list").dataTable();
		<?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Danh sách phân công Giáo viên giảng dạy</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" id="formphanconggiangday">
<div class="grid example">
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Năm học:</div>
		<div class="cell colspan4 input-control select">
			<select name="id_namhoc" id="id_namhoc" class="select2">
				<option value=""></option>
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
			<select name="id_lophoc[]" id="id_lophoc" class="select2" multiple>
				<option value=""></option>
				<?php
				if($lophoc_list->count() > 0){
					foreach ($lophoc_list as $lh) {
						echo '<option value="'.$lh['_id'].'" '.(in_array($lh['_id'],$id_lophoc)? ' selected' : '').'>'.$lh['tenlophoc'].'</option>';
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
				<option value=""></option>
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
				<option value=""></option>
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
			<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Tìm kiếm</button>
			<a href="themphanconggiangday.html" class="button success"><span class="mif-plus"></span> Thêm phân công Giảng dạy</a>
		</div>
	</div>
</div>
</form>
<?php
if(isset($giangday_list) && $giangday_list->count() > 0) : ?>
<table class="table border bordered striped hovered" id="table_list"> 
<thead>
	<tr>
		<th>STT</th>
		<th>Mã số</th>
		<th>Họ tên</th>
		<!--<th>Chứng minh nhân dân</th>-->
		<th>Môn học</th>
		<th>Lớp</th>
		<th>Năm học</th>
		<!--<th><img src="images/edit.png" /></th>-->
		<th><span class="mif-bin"></span></th>
		<th><span class="mif-pencil"></span></th>
	</tr>
</thead>
<tbody>
	<?php 
	$i = 1;
	foreach ($giangday_list as $pcgd) {
		$giaovien->id = $pcgd['id_giaovien'];
		$lophoc->id = $pcgd['id_lophoc'];
		$namhoc->id = $pcgd['id_namhoc'];
		$monhoc->id = $pcgd['id_monhoc'];
		$gv = $giaovien->get_one();
		$lop = $lophoc->get_one();
		$nam = $namhoc->get_one();
		$mon = $monhoc->get_one();
		if($i%2==0) $class = 'eve';
		else $class = 'odd';
		echo '<tr class="'.$class.'">';
		echo '<td align="center">'.$i.'</td>';
		echo '<td align="center">'.$gv['masogiaovien'].'</td>';
		echo '<td>'.$gv['hoten'].'</td>';
		//echo '<td align="center">'.$gv['cmnd'].'</td>';
		echo '<td align="center">'.$mon['mamonhoc'] .' - '. $mon['tenmonhoc'].'</td>';
		echo '<td align="center">'.$lop['tenlophoc'].'</td>';
		echo '<td align="center">'.$nam['tennamhoc'].'</td>';
		//echo '<td align="center"><a href="phanconggiangday.html?id='.$pcgd['_id'].'"><img src="images/edit.png" /></a></td>';
		echo '<td align="center"><a href="themphanconggiangday.html?id='.$pcgd['_id'].'&id_namhoc='.$pcgd['id_namhoc'].'&act=del" Onclick="return confirm(\'Có chắc chắn xoá?\');"><span class="mif-bin"></span></a></td>';
		echo '<td align="center"><a href="suaphanconggiangday.html?id='.$pcgd['_id'].'" ><span class="mif-pencil"></span></a></td>';
		echo '</tr>';
		$i++;
	}
	?>
</tbody>
</table>
<?php else: ?>
	<h4> <span class="mif-search"></span> Không tìm thấy</h4>
<?php endif; ?>
<?php require_once('footer.php'); ?>
