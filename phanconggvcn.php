<?php 
require_once('header.php');
check_permis(!$users->is_admin());
$giaovien = new GiaoVien();$hocsinh = new HocSinh();$lophoc = new LopHoc();
$giaovien_list = $giaovien->get_all_list(); $lophoc_list = $lophoc->get_all_list();$namhoc_list = $namhoc->get_all_list();
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update == 'delete_ok') $msg = 'Xoá thành công';
if($update == 'edit_ok') $msg = 'Chỉnh sửa thành công';
if($update == 'insert_ok') $msg = 'Thêm thành công';
$id_giaovien = isset($_GET['id_giaovien']) ? $_GET['id_giaovien'] : '';
$id_lophoc	= isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
if(isset($_GET['submit']) && ($id_namhoc || $id_giaovien || $id_lophoc)){
	$query = array();
	if($id_giaovien){
		array_push($query, array('id_giaovien' => new MongoId($id_giaovien)));
	}
	if($id_lophoc){
		array_push($query, array('id_lophoc' => new MongoId($id_lophoc)));
	}
	if($id_namhoc){
		array_push($query, array('id_namhoc' => new MongoId($id_namhoc)));
	}
	$query = array('$and' => $query);
	$giaovienchunhiem_list = $giaovienchunhiem->get_list_condition($query);
	
} else {
	$giaovienchunhiem_list = $giaovienchunhiem->get_list_50();
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
 <h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Danh sách phân công Giáo viên chủ nhiệm</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" id="formphanconggvcn">
Năm học:
	<select name="id_namhoc" id="id_namhoc" class="select2">
		<option value="">Chọn năm học</option>
		<?php
		if($namhoc_list->count() > 0){
			foreach ($namhoc_list as $nh) {
				echo '<option value="'.$nh['_id'].'"'.($nh['_id']==$id_namhoc ? ' selected' : '').'>'.$nh['tennamhoc'].'</option>';
			}
		}
		?>
	</select>
	&nbsp;&nbsp;&nbsp;Lớp: 
	<select name="id_lophoc" id="id_lophoc" class="select2">
		<option value="">Chọn lớp học</option>
		<?php
		if($lophoc_list->count() > 0){
			foreach ($lophoc_list as $lh) {
				echo '<option value="'.$lh['_id'].'" '.($lh['_id']==$id_lophoc? ' selected' : '').'>'.$lh['tenlophoc'].'</option>';
			}
		}
		?>
	</select>
&nbsp;&nbsp;&nbsp;Giáo viên: 
	<select name="id_giaovien" id="id_giaovien" class="select2">
		<option value="">Chọn giáo viên</option>
		option
		<?php
			if($giaovien_list->count() > 0){
				foreach ($giaovien_list as $gv) {
					echo '<option value="'.$gv['_id'].'" '.($gv['_id'] == $id_giaovien ? ' selected': '').' >'.$gv['masogiaovien'] .' - '. $gv['hoten'].'</option>';
				}
			}
		?>
	</select>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Tìm kiếm</button>
	<a href="themphanconggvcn.html" class="button success"><span class="mif-plus"></span> Thêm phân công</a>
</form>
<hr />
<?php 
if($giaovienchunhiem_list && $giaovienchunhiem_list->count() > 0) : ?>
<table class="table border bordered striped hovered"> 
	<tr>
		<th>STT</th>
		<th>Mã số giáo viên</th>
		<th>Họ tên giao viên</th>
		<!--<th>Chứng minh nhân dân</th>-->
		<th>Lớp</th>
		<th>Năm học</th>
		<th><span class="mif-pencil"></span></th>
		<th><span class="mif-bin"></span></th>
	</tr>
	<?php 
	$i = 1;
	foreach ($giaovienchunhiem_list as $gvcn) {
		if($i%2 == 0) $class= 'eve'; else $class= 'odd';
		$giaovien->id = $gvcn['id_giaovien'];
		$lophoc->id = $gvcn['id_lophoc'];
		$namhoc->id = $gvcn['id_namhoc'];

		$gv = $giaovien->get_one_fields_list();
		$lop = $lophoc->get_one();
		$nh = $namhoc->get_one();
		echo '<tr class="'.$class.'">';
		echo '<td align="center">'.$i.'</td>';
		echo '<td align="center">'.$gv['masogiaovien'].'</td>';
		echo '<td>'.$gv['hoten'].'</td>';
		//echo '<td align="center">'.$gv['cmnd'].'</td>';
		echo '<td align="center">'.$lop['tenlophoc'].'</td>';
		echo '<td align="center">'.$nh['tennamhoc'].'</td>';
		echo '<td align="center"><a href="themphanconggvcn.html?id='.$gvcn['_id'].'"><span class="mif-pencil"></span></a></td>';
		echo '<td align="center"><a href="themphanconggvcn.html?id='.$gvcn['_id'].'&id_namhoc='.$id_namhoc.'&act=del" Onclick="return confirm(\'Có chắc chắn xoá?\');"><span class="mif-bin"></span></a></td>';
		echo '</tr>';
		$i++;
	}
	?>
</table>
<?php else: ?>
	<h4><span class="mif-search"></span> Không tìm thấy</h4>
<?php endif; ?>
<?php require_once('footer.php'); ?>