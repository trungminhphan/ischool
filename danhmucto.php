<?php
require_once('header.php');
check_permis(!$users->is_admin());
$id = isset($_GET['id']) ? $_GET['id'] : null;
$act = isset($_GET['act']) ? $_GET['act'] : '';
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update == 'del'){ $msg = 'Xoá thành công.' ; }
if($update == 'insert'){ $msg = 'Thêm mới thành công.' ; }
if($update == 'edit'){ $msg= 'Chỉnh sửa thành công.' ; }
$to = new To();
$giangday->id_to = $id;
$giaovienchunhiem->id_to = $id;
$to_list = $to->get_all_list();
if($id && $act=='del'){
	if($tochuyenmon->check_dm_to($id)){
		echo '<div class="messages error">Không thể xoá vì liên quan: [Tổ chuyên môn], [Phân công giảng dạy]</div>';
	} else {
		$to->id = $id;
		if($to->delete()) transfers_to('danhmucto.html?update=del');
	}
}

if(isset($_POST['submit'])){
	$id = isset($_POST['id']) ? $_POST['id'] : null;
	$tento = isset($_POST['tento']) ? quote_smart($_POST['tento']) : '';
	$to->id = $id;	$to->tento = $tento;
	if($to->check_exists()){
		$msg = 'Tên Tổ đã có trong CSDL, hoặc chưa nhập, Vui lòng chọn tên khác...';
	} else {
		if($id){
			if($to->edit()){
				transfers_to('danhmucto.html?update=edit');	
			} else {
				$msg = 'Không thể chỉnh sửa';
			}

		} else {
			if($to->insert()){
				transfers_to('danhmucto.html?update=insert');
			} else {
				$msg = 'Không thể thêm mới';
			}
		}
	}
}

if($id && $act=='edit'){
	$to->id = $id; $edit_to = $to->get_one();
	$id = $edit_to['_id'];
	$tento = $edit_to['tento'];
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
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Quản lý Danh mục Tổ chuyên môn</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="toform">
	<a href="danhmucto.html" class="button"><span class="mif-sync-problem"></span> Tải lại trang</a>
	<input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : '';  ?>" />
	<div class="input-control text" style="width: 300px;">
		<input type="text" name="tento" id="tento" value="<?php echo isset($tento) ? $tento : ''; ?>" required oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" placeholder="Tên tổ" />
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật</button>
</form>

<?php if(isset($to_list) && $to_list->count() > 0) : ?>
<table class="table striped hovered dataTable" data-role="datatable">
	<thead>
		<tr>
			<th>STT</th>
			<th>Tên Tổ chuyên môn</th>
			<th><span class="mif-bin"></span></th>
			<th><span class="mif-pencil"></span></th>
		</tr>
	</thead>
	<tbody>

	<?php 
	$i =1;
	foreach ($to_list as $t) {
		echo '<tr>
			<td>'.$i.'</td>
			<td>'.$t['tento'].'</td>
			<td><a href="danhmucto.html?id='.$t['_id'].'&act=edit"><span class="mif-pencil"></span></a></td>
			<td><a href="danhmucto.html?id='.$t['_id'].'&act=del" onclick="return confirm(\'Chắc chắn muốn xóa?\');"><span class="mif-bin"></span></a></td>
		</tr>';$i++;
	}
	?>	
	</tbody>
</table>
<?php endif; ?>
<?php
require_once('footer.php');
?>
