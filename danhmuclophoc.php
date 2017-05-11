<?php
require_once('header.php');
check_permis(!$users->is_admin());
$id = isset($_GET['id']) ? $_GET['id'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update == 'del'){ $msg = 'Xoá thành công.' ; }
if($update == 'insert'){ $msg = 'Thêm mới thành công.' ; }
if($update == 'edit'){ $msg = 'Chỉnh sửa thành công.' ; }
$lophoc = new LopHoc(); $danhsachlop = new DanhSachLop(); 
$lophoc_list = $lophoc->get_all_list();
$danhsachlop->id_lophoc = $id;
$giangday->id_lophoc = $id;
$giaovienchunhiem->id_lophoc = $id;
if($id && $act=='del'){
	if($danhsachlop->check_exist_lophoc() || $giangday->check_exist_lophoc() || $giaovienchunhiem->check_exist_lophoc()){
		$msg = 'Không thể xoá vì liên quan: [Danh sách lớp], [Phân công giảng dạy], [Giáo viên chủ nhiệm]';
	} else {
		$lophoc->id = $id;
		if($lophoc->delete()){
			transfers_to('danhmuclophoc.html?update=del');
		} else {
			$msg = 'Không thể xoá...';
		}
	}
}
if(isset($_POST['submit'])){
	$id = isset($_POST['id']) ? $_POST['id'] : null;
	$malophoc = isset($_POST['malophoc']) ? quote_smart($_POST['malophoc']) : '';
	$tenlophoc = isset($_POST['tenlophoc']) ? quote_smart($_POST['tenlophoc']) : '';
	$lophoc->id = $id;
	$lophoc->malophoc = $malophoc;
	$lophoc->tenlophoc = $tenlophoc;
	if($id){
		if($lophoc->check_exists_edit()){
			$msg = 'Không thể cập nhật được';
		} else {
			$lophoc->edit();
			transfers_to('danhmuclophoc.html?update=edit');	
		}
	} else {	
		if($lophoc->check_exists() || $tenlophoc == ''){
			$msg = 'Lớp học bị trùng, Mã lớp học, Tên lớp hoặc chưa nhập, Vui lòng chọn tên khác...';
		} else {
			$lophoc->insert();
			transfers_to('danhmuclophoc.html?update=insert');
		}
	}
}
if(isset($id) && $act=='edit'){
	$lophoc->id = $id;
	$edit_lophoc = $lophoc->get_one();
	$id = $edit_lophoc['_id'];
	$malophoc = $edit_lophoc['malophoc'];
	$tenlophoc = $edit_lophoc['tenlophoc'];
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
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Quản lý Danh mục Lớp học</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="lophocform">
	<a href="danhmucmonhoc.html" class="button"><span class="mif-sync-problem"></span> Tải lại trang</a>
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<div class="input-control text">
		<input type="text" name="malophoc" id="malophoc" value="<?php echo isset($malophoc) ? $malophoc : ''; ?>" required oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" placeholder="Mã lớp học" />
	</div>
	<div class="input-control text">
		<input type="text" name="tenlophoc" id="tenlophoc" value="<?php echo isset($tenlophoc) ? $tenlophoc : ''; ?>" required oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" placeholder="Tên lớp học" />
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
</form>
<?php if(isset($lophoc_list) && $lophoc_list->count() >0) : ?>
<table class="table striped hovered dataTable" data-role="datatable">
	<thead>
		<tr>
			<th>STT</th>
			<th>Mã lớp</th>
			<th>Tên lớp</th>
			<th><span class="mif-bin"></span></th>
			<th><span class="mif-pencil"></span></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=1;
		foreach ($lophoc_list as $lh) {
		echo '<tr>
				<td>'.$i.'</td>
				<td>'.$lh['malophoc'].'</td>
				<td>'.$lh['tenlophoc'].'</td>
				<td><a href="danhmuclophoc.html?id='.$lh['_id'].'&act=edit"><span class="mif-pencil"></span></a></td>
				<td><a href="danhmuclophoc.html?id='.$lh['_id'].'&act=del" onclick="return confirm(\'Chắc chắn muốn xóa?\');"><span class="mif-bin"></span></a></td>
			</tr>';$i++;
		}
		?>
	</tbody>
</table>
<?php endif; ?>

<?php require_once('footer.php'); ?>