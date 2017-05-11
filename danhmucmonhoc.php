<?php
require_once('header.php');
if(!$users->is_admin()){
    echo '<div class="messages error">Bạn không có quyền...</div>';
    require_once('footer.php');
    exit();
}
$id = isset($_GET['id']) ? $_GET['id'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update == 'del'){ $msg = 'Xoá thành công.' ; }
if($update == 'insert'){ $msg ='Thêm mới thành công.' ; }
if($update == 'edit'){ $msg = 'Chỉnh sửa thành công.' ; }
$monhoc = new MonHoc(); $danhsachlop = new DanhSachLop();
$monhoc_list = $monhoc->get_all_list();
$danhsachlop->id_monhoc = $id;
$giangday->id_monhoc = $id;
if($id && $act=='del'){
	if($danhsachlop->check_exists_dm_monhoc() || $giangday->check_exist_monhoc()) {
		$msg = 'Không thể xoá: [Danh sách lớp], [Phân công giảng dạy].';
	} else {
		$monhoc->id = $id;
		$monhoc->delete();
		transfers_to('danhmucmonhoc.html?update=del');
	}
}

if(isset($_POST['submit'])){
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$mamonhoc = isset($_POST['mamonhoc']) ? quote_smart($_POST['mamonhoc']) : '';
	$tenmonhoc = isset($_POST['tenmonhoc']) ? quote_smart($_POST['tenmonhoc']) : '';
	$monhoc->id = $id; $monhoc->mamonhoc = $mamonhoc; $monhoc->tenmonhoc = $tenmonhoc;
	if($id){
		if($monhoc->check_exists_edit()){ $msg= 'Không thể cập nhật được';} 
		else {
			$monhoc->edit(); transfers_to('danhmucmonhoc.html?update=edit');	
		}
	} else {	
		if($monhoc->check_exists() || $tenmonhoc == ''){
			$msg = 'Tên lớp học bị trùng, hoặc chưa nhập, Vui lòng chọn tên khác...';
		} else {
			$monhoc->insert();
			transfers_to('danhmucmonhoc.html?update=insert');
		}
	}
}
if(isset($id) && $act=='edit'){
	$monhoc->id = $id; $edit_monhoc = $monhoc->get_one();
	$id = $edit_monhoc['_id'];
	$mamonhoc = $edit_monhoc['mamonhoc'];
	$tenmonhoc = $edit_monhoc['tenmonhoc'];
}
?>
<script type="text/javascript" src="js/html5.messages.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(isset($msg) && $msg): ?>
			$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
		<?php endif; ?>
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Quản lý Danh mục Môn học</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="monhocform">
	<a href="danhmucmonhoc.html" class="button"><span class="mif-sync-problem"></span> Tải lại trang</a>
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<div class="input-control text">
		<input type="text" name="mamonhoc" id="mamonhoc" value="<?php echo isset($mamonhoc) ? $mamonhoc : ''; ?>" required oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" placeholder="Mã môn học" />
	</div>
	<div class="input-control text">
		<input type="text" name="tenmonhoc" id="tenmonhoc" value="<?php echo isset($tenmonhoc) ? $tenmonhoc : ''; ?>" required oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" placeholder="Tên môn học" />
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
</form>

<?php if(isset($monhoc_list) && $monhoc_list->count()): ?>
<table class="table striped hovered dataTable" data-role="datatable">
	<thead>
		<tr>
			<th>STT</th>
			<th>Mã môn học</th>
			<th>Tên môn học</th>
			<th><span class="mif-bin"></span></th>
			<th><span class="mif-pencil"></span></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i= 1;
	foreach ($monhoc_list as $mh) {
		echo '<tr>';
		echo '<td>'.$i.'</td>';
		echo '<td>'.$mh['mamonhoc'].'</td>';
		echo '<td>'.$mh['tenmonhoc'].'</td>';
		echo '<td><a href="danhmucmonhoc.html?id='.$mh['_id'].'&act=edit"><span class="mif-pencil"></span></a></td>';
		echo '<td><a href="danhmucmonhoc.html?id='.$mh['_id'].'&act=del" onclick="return confirm(\'Chắc chắn muốn xóa?\');"><span class="mif-bin"></span></a></td>';
		echo '</tr>';$i++;
	}?>
	</tbody>
</table>
<?php endif; ?>

<?php require_once('footer.php'); ?>