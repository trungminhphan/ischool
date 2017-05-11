<?php 
require_once('header.php');
check_permis(!$users->is_admin());
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update && $update == 'ok'){
	echo '<div class="messages">Cập nhật thành công.!</div>';
}
$danhsachlop = new DanhSachLop();$hocsinh = new HocSinh();$lophoc = new LopHoc();
if(isset($_GET['search_hocsinh']) ){
	$keysearch_hocsinh = isset($_GET['keysearch_hocsinh']) ? $_GET['keysearch_hocsinh'] :'';
	if($keysearch_hocsinh){
		$hocsinh_list = $hocsinh->get_all_condition(array('$or'=>array(array('masohocsinh'=> new MongoRegex('/'.$keysearch_hocsinh.'/')), array('hoten' => new MongoRegex('/'.$keysearch_hocsinh.'/')), array('cmnd' => new MongoRegex('/'.$keysearch_hocsinh.'/')))));
	} else {
		$hocsinh_list='';
	}
}

if(isset($_POST['submit'])){
	$id_hocsinh = isset($_POST['id_hocsinh']) ? $_POST['id_hocsinh'] : '';
	$id_lophoc = isset($_POST['id_lophoc']) ? $_POST['id_lophoc'] : '';
	$id_namhoc = isset($_POST['id_namhoc']) ? $_POST['id_namhoc'] : '';

	$danhsachlop->id_lophoc = $id_lophoc;
	$danhsachlop->id_namhoc = $id_namhoc;
	//var_dump($id_hocsinh);
	if($id_hocsinh){
		foreach ($id_hocsinh as $key => $value) {
			$danhsachlop->id_hocsinh = $value;
			if($danhsachlop->check_exists()){
				//Khong insert vi da co
				$msg =  'Học sinh có mã ['.$value.'] đã tồn tại.';
			} else {
				//insert vao vi chu co
				if($danhsachlop->insert_list()){
					//transfers_to('taodanhsachlop.php?update=ok');
					$msg = 'Thêm thành công.';
				}
			}
		}
	}
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
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Tạo danh sách lớp</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="searchhocsinh" data-role="validator" data-show-required-state="false">
<a href="themhocsinh.html" class="button"><span class="mif-plus"></span> Thêm học sinh mới</a>
	Họ tên/CMND/Mã số học sinh
	<div class="input-control text">
		<input type="text" name="keysearch_hocsinh" id="keysearch_hocsinh" value="<?php echo isset($keysearch_hocsinh) ? $keysearch_hocsinh: ''; ?>" data-validate-func="required"/>
		<span class="input-state-error mif-warning"></span><span class="input-state-success mif-checkmark"></span>
	</div>
	<button name="search_hocsinh" id="search_hocsinh" value="OK" class="button primary"><span class="mif-search"></span> Tìm kiếm</button>
</form> 
<hr />
<?php
if(isset($_GET['search_hocsinh'])): 
if(isset($hocsinh_list) && $hocsinh_list && $hocsinh_list->count() > 0): 
	$lophoc_list = $lophoc->get_all_list();
	$namhoc_list = $namhoc->get_list_limit(3);
?>
<script type="text/javascript">
	function toggle(source) {
  		checkboxes = document.getElementsByName('id_hocsinh[]');
  		for(var i=0, n=checkboxes.length;i<n;i++) {
    		checkboxes[i].checked = source.checked;
  		}
	}
</script>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="formtaodanhsach">
<table class="table border bordered striped hovered">
	<tr>
		<th>
			<label class="input-control checkbox small-check">
			<input type="checkbox" name="checkall" id="checkall" onClick="toggle(this)">
			<span class="check"></span>
		</th>
		<th>STT</th>
		<th>Mã số học sinh</th>
		<th>Họ tên</th>
		<th>CMND</th>
		<th>Ngày sinh</th>
	</tr>
<?php
	$i = 1;
	foreach($hocsinh_list as $hs){
		if($i % 2 == 0) $class = 'eve';
		else $class = 'odd';
		echo '<tr class="'.$class.'">';
		echo '<td align="center" style="padding:0px;"><label class="input-control checkbox small-check" style="margin:0px !important;"><input type="checkbox" name="id_hocsinh[]" value="'.$hs['_id'].'"><span class="check"></span></td>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$hs['masohocsinh'].'</td>';
		echo '<td>'.$hs['hoten'].'</td>';
		echo '<td align="center">'.$hs['cmnd'].'</td>';
		echo '<td align="center">'.$hs['ngaysinh'].'</td>';
		echo '</tr>';
		$i++;
	}
?>
<tr>
	<td colspan="6" align="left">
		<b>CHỌN LỚP VÀ NĂM HỌC CẦN CHUYỂN LÊN:</b>
		<select name="id_lophoc" id="id_lophoc" class="select2">
		<?php
			if(isset($lophoc_list)){
				foreach ($lophoc_list as $lh) {
					# code...
					echo '<option value="'.$lh['_id'].'">'.$lh['tenlophoc'].'</option>';
				}
			}
		?>
		</select>
		<select name="id_namhoc" id="id_namhoc" class="select2">
		<?php
			if(isset($namhoc_list)){
				foreach ($namhoc_list as $nh) {
					# code...
					echo '<option value="'.$nh['_id'].'">'.$nh['tennamhoc'].'</option>';
				}
			}
		?>
		</select>
		<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> OK</button>
	</td>
</tr>
</table>
</form>
<?php else: ?>
<div class="messages error">Không tìm thấy học sinh nào!</div>
<?php endif; endif;?>

<?php require_once('footer.php'); ?>