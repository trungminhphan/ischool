<?php
require_once('header.php');
check_permis(!$users->is_admin());
$id = isset($_GET['id']) ? $_GET['id'] : null;
$act = isset($_GET['act']) ? $_GET['act'] : '';
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update == 'del'){ $msg = 'Xoá thành công.' ; }
if($update == 'insert'){ $msg = 'Thêm mới thành công.' ; }
if($update == 'edit'){ $msg= 'Chỉnh sửa thành công.' ; }
$tochuyenmon = new ToChuyenMon();
$danhsachlop = new DanhSachLop();
$danhsachlop->id_namhoc = $id;
$giangday->id_namhoc = $id;
$giaovienchunhiem->id_namhoc = $id;
$namhoc_list = $namhoc->get_all_list();
if($id && $act=='del'){
	if($danhsachlop->check_exist_namhoc() || $giangday->check_exist_namhoc() || $giaovienchunhiem->check_exist_namhoc() || $tochuyenmon->check_dm_namhoc($id)){
		echo '<div class="messages error">Không thể xoá vì liên quan: [Danh sách lớp], [Phân công giảng dạy], [Giáo viên chủ nhiệm]</div>';
	} else {
		$namhoc->id = $id;
		if($namhoc->delete()) transfers_to('danhmucnamhoc.html?update=del');
	}
}

if(isset($_POST['submit'])){
	$id = isset($_POST['id']) ? $_POST['id'] : null;
	$tennamhoc = isset($_POST['tennamhoc']) ? quote_smart($_POST['tennamhoc']) : '';
	$macdinh = isset($_POST['macdinh']) ? $_POST['macdinh'] : '';
	$namhoc->id = $id;	$namhoc->tennamhoc = $tennamhoc;$namhoc->macdinh = $macdinh;
	
	if($id && $macdinh && $namhoc->check_exists()){
		$namhoc->set_all_khongmacdinh();
		$namhoc->set_macdinh();
		transfers_to('danhmucnamhoc.html?update=edit');	
	} else {
		if($id){
			if($namhoc->check_exists()){
				$msg = 'Không thể cập nhật được, do trùng tên hoặc lỗi xảy ra.';
			} else {
				$namhoc->edit();
				transfers_to('danhmucnamhoc.html?update=edit');	
			}
		} else {
			if($namhoc->check_exists() || $tennamhoc == ''){
				$msg = 'Tên năm học bị trùng, hoặc chưa nhập, Vui lòng chọn tên khác...';
			} else {
				if($macdinh){
					$namhoc->set_all_khongmacdinh();
				}
				$namhoc->insert();
				transfers_to('danhmucnamhoc.html?update=insert');
			}
		}
	}
}

if($id && $act=='edit'){
	$namhoc->id = $id; $edit_namhoc = $namhoc->get_one();
	$id = $edit_namhoc['_id'];
	$tennamhoc = $edit_namhoc['tennamhoc'];
	$macdinh = isset($edit_namhoc['macdinh']) ? $edit_namhoc['macdinh'] : '';
} else {
	$macdinh = '';
}
?>
<script type="text/javascript" src="js/html5.messages.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		<?php if(isset($msg) && $msg): ?>
			$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
		<?php endif; ?>
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Quản lý Danh mục Năm học</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="namhocform">
	<a href="danhmucnamhoc.html" class="button"><span class="mif-sync-problem"></span> Tải lại trang</a>
	<input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : '';  ?>" />
	<div class="input-control text">
		<input type="text" name="tennamhoc" id="tennamhoc" value="<?php echo isset($tennamhoc) ? $tennamhoc : ''; ?>" required oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" placeholder="Tên năm học" />
	</div>
	<div class="input-control select">
		<select name="macdinh" id="macdinh" class="select2">
			<option value="">Chọn học kỳ mặc định</option>
			<option value="hocky1" <?php echo $macdinh=='hocky1' ? ' selected' : ''; ?>>Học kỳ 1</option>
			<option value="hocky2" <?php echo $macdinh=='hocky2' ? ' selected' : ''; ?>>Học kỳ 2</option>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
</form>

<?php if(isset($namhoc_list) && $namhoc_list->count() > 0) : ?>
<table class="table striped hovered dataTable" data-role="datatable">
	<thead>
		<tr>
			<th>STT</th>
			<th>Tên năm học</th>
			<th>Học kỳ mặc định</th>
			<th><span class="mif-bin"></span></th>
			<th><span class="mif-pencil"></span></th>
		</tr>
	</thead>
	<tbody>

	<?php 
	$i =1;
	foreach ($namhoc_list as $nh) {
		$macdinh = isset($nh['macdinh']) ? $nh['macdinh'] : '';
		echo '<tr>
			<td>'.$i.'</td>
			<td>'.$nh['tennamhoc'].'</td>
			<td>'.$macdinh.'</td>
			<td><a href="danhmucnamhoc.html?id='.$nh['_id'].'&act=edit"><span class="mif-pencil"></span></a></td>
			<td><a href="danhmucnamhoc.html?id='.$nh['_id'].'&act=del" onclick="return confirm(\'Chắc chắn muốn xóa?\');"><span class="mif-bin"></span></a></td>
		</tr>';$i++;
	}
	?>	
	</tbody>
</table>
<?php endif; ?>
<?php
require_once('footer.php');
?>
