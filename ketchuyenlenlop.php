<?php
require_once('header.php');
check_permis(!$users->is_admin());
$danhsachlop = new DanhSachLop();$lophoc = new LopHoc();
$hocsinh = new HocSinh();
$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_list_limit(3);
 if(isset($_POST['submit'])){
 	$id_hocsinh = isset($_POST['id_hocsinh']) ? $_POST['id_hocsinh'] : ''; 
	$id_lophoc = isset($_POST['id_lophoc_new']) ? $_POST['id_lophoc_new'] : '';
	$id_namhoc = isset($_POST['id_namhoc_new']) ? $_POST['id_namhoc_new'] : '';
	$danhsachlop->id_lophoc = $id_lophoc;
	$danhsachlop->id_namhoc = $id_namhoc;
	if($id_hocsinh){
		foreach ($id_hocsinh as $key => $value) {
			$danhsachlop->id_hocsinh = $value;
			if($danhsachlop->check_exists()){
				$msg = 'Học sinh có mã ['.$value.'] đã tồn tại.';
			} else {
				//insert vao vi chua co
				if($danhsachlop->insert_list()){
					//transfers_to('ketchuyenlenlop.php?id_lophoc=' . $id_lophoc . '&id_namhoc=' . $id_namhoc);
					$msg = 'Kết chuyển thành công';
				}
			}			
		}
	}
}

if(isset($_GET['search_hocsinh'])){
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$danhsachlop->id_lophoc = $id_lophoc;
	$danhsachlop->id_namhoc = $id_namhoc;
	$danhsachlop_list = $danhsachlop->get_danh_sach_lop();
}

?>
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#id_lophoc").select2();
		$("#id_namhoc").select2();
		$("#id_lophoc_new").select2();
		$("#id_namhoc_new").select2();
		<?php if(isset($msg) && $msg) : ?>
        	$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
    	<?php endif; ?>
	});
</script>
<h1><a href="index.php" class="nav-button transform"><span></span></a>&nbsp;Kết chuyển danh sách lên lớp.</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" id="formloaddanhsach">
<b>CHỌN LỚP KẾT CHUYỂN</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lớp: 
	<select name="id_lophoc" id="id_lophoc" style="width: 130px;">
		<?php
		foreach($lophoc_list as $lophoc){
			echo '<option value="'.$lophoc['_id'].'" '.($lophoc['_id']==$id_lophoc ? ' selected' : '').'>'.$lophoc['malophoc'] .'-'. $lophoc['tenlophoc'].'</option>';
		}
		?>
	</select>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Năm học: 
	<select name="id_namhoc" id="id_namhoc">
		<?php
		foreach($namhoc_list as $namhoc){
			echo '<option value="'.$namhoc['_id'].'" '.($namhoc['_id']==$id_namhoc ? ' selected' : '').'>'. $namhoc['tennamhoc'].'</option>';
		}
		?>
	</select>
	<button name="search_hocsinh" id="search_hocsinh" value="OK" class="button primary"><span class="mif-checkmark"></span> OK</button>
</form>
<hr />
<?php if(isset($danhsachlop_list) && $danhsachlop_list->count() > 0): ?>
<script type="text/javascript">
	function toggle(source) {
  		checkboxes = document.getElementsByName('id_hocsinh[]');
  		for(var i=0, n=checkboxes.length;i<n;i++) {
    		checkboxes[i].checked = source.checked;
  		}
	}
</script>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="ketchuyenform">
<table class="table border bordered striped hovered">
	<tr>
		<th><input type="checkbox" name="checkall" id="checkall" onClick="toggle(this)"></th>
		<th>STT</th>
		<th>Mã số học sinh</th>
		<th>CMND</th>
		<th>Họ tên</th>
		<th>Ngày sinh</th>
		<th>Nơi  sinh</th>
		<th>Giới tính</th>
		<th>Dân tộc</th>
	</tr>
<?php
	$i = 1;
	foreach($danhsachlop_list as $ds){
		$hocsinh->id = $ds['id_hocsinh'];
		$hs = $hocsinh->get_one();
		echo '<tr>';
		echo '<td align="center"><input type="checkbox" name="id_hocsinh[]" value="'.$hs['_id'].'"></td>';
		echo '<td align="center">'.$i.'</td>';
		echo '<td align="center">'.$hs['masohocsinh'].'</td>';
		echo '<td align="center">'.$hs['cmnd'].'</td>';
		echo '<td>'.$hs['hoten'].'</td>';
		echo '<td align="center">'.$hs['ngaysinh'].'</td>';
		echo '<td align="center">'.$hs['noisinh'].'</td>';
		echo '<td align="center">'.$hs['gioitinh'].'</td>';
		echo '<td align="center">'.$hs['dantoc'].'</td>';
		echo '</tr>';
		$i++;
	}
?><tr>
	<td colspan="9" align="left">
		<b>CHỌN LỚP VÀ NĂM HỌC CẦN CHUYỂN LÊN:</b>
		<select name="id_lophoc_new" id="id_lophoc_new" style="width:130px;">
		<?php
			if(isset($lophoc_list)){
				foreach ($lophoc_list as $lh) {
					# code...
					echo '<option value="'.$lh['_id'].'">'.$lh['tenlophoc'].'</option>';
				}
			}
		?>
		</select>
		<select name="id_namhoc_new" id="id_namhoc_new">
		<?php
			if(isset($namhoc_list)){
				foreach ($namhoc_list as $nh) {
					# code...
					echo '<option value="'.$nh['_id'].'">'.$nh['tennamhoc'].'</option>';
				}
			}
		?>
		</select>
		<button name="submit" id="submit" value="Kết chuyển lên lớp" class="button primary"><span class="mif-checkmark"></span> Kết chuyển lên lớp</button>
	</td>
</tr>
</table>
</form>
<?php else: ?>
	<?php if(isset($_GET['search_hocsinh'])): ?>
		<h3><span class="mif-search"></span> Không có học sinh nào trong lớp...!</h3>
	<?php endif; ?>
<?php endif; ?>
<?php require_once('footer.php'); ?>