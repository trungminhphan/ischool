<?php
require_once('header.php');
check_permis(!$users->is_admin() && !$users->is_teacher());
$update = isset($_GET['update']) ? $_GET['update'] : '';
if($update == 'del_ok') { $msg = 'Xoá thành công'; }
if($update == 'del_no') { $msg = 'Không thể xoá'; }
$danhsachlop = new DanhSachLop(); $lophoc = new LopHoc();$hocsinh = new HocSinh();
$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
//$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_list_limit(3);

if(isset($_GET['submit']) && $id_namhoc && $id_lophoc){
	$danhsachlop->id_lophoc = $id_lophoc;
	$danhsachlop->id_namhoc = $id_namhoc;
	$danhsachlop_list = $danhsachlop->get_id_hocsinh();
	$lophoc->id = $id_lophoc; $l = $lophoc->get_one();
	$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
	$lophoc_list = $danhsachlop->get_list_lophoctheonam();
}
?>
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		$("#id_namhoc").change(function(){
			$.get('load_danhsachlophoctheonam.html?id_namhoc=' + $(this).val(), function(data){
				$("#id_lophoc").html(data);
			});
		});
		<?php if(isset($msg) && $msg) : ?>
        	$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
    	<?php endif; ?>
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Xem danh sách lớp.</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" id="formloaddanhsach">
	Năm học
	<div class="input-control select">
		<select name="id_namhoc" id="id_namhoc" class="select2">
			<option value="">Chọn năm học</option>
			<?php
			foreach($namhoc_list as $nh){
				echo '<option value="'.$nh['_id'].'" '.($nh['_id']==$id_namhoc ? ' selected' : '').'>'. $nh['tennamhoc'].'</option>';
			}
			?>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Lớp
	<div class="input-control select">
		<select name="id_lophoc" id="id_lophoc" class="select2">
			<option value="">Chọn lớp học</option>
			<?php
			if(isset($lophoc_list) && $lophoc_list){
				foreach($lophoc_list as $key=>$value){
					$lophoc->id = $value; $lh = $lophoc->get_one();
					echo '<option value="'.$lh['_id'].'" '.($lh['_id']==$id_lophoc ? ' selected' : '').'>'. $lh['tenlophoc'].'</option>';
				}
			}
			?>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem danh sách</button>
</form>
<hr />
<?php if(isset($danhsachlop_list) && $danhsachlop_list->count() > 0): ?>
	<h2 class="align-center">Danh sách học sinh <?php echo $l['tenlophoc']; ?></h2>
	<h3 class="align-center"><?php echo $n['tennamhoc']; ?></h3>
<table class="table border bordered striped hovered">
<thead>
	<tr>
		<th>STT</th>
		<th>Mã số học sinh</th>
		<!--<th>CMND</th>-->
		<th>Họ tên</th>
		<th>Ngày sinh</th>
		<th>Nơi  sinh</th>
		<th>Giới tính</th>
		<th>Dân tộc</th>
		<th>Xem chi tiết</th>
		<?php if($users->is_admin()): ?>
			<th><span class="mif-user-minus"></span></th>
		<?php endif; ?>
	</tr>
</thead>
<tbody>
<?php
	$i = 1;
	$arr_hocsinh = array();
	foreach($danhsachlop_list as $k => $l){
		$hocsinh->id = $l['id_hocsinh'];
		$hs = $hocsinh->get_one();
		$arr_hocsinh[] = $hs['ten'] . '---'. strval($l['_id']) . '---'.strval($l['id_hocsinh']);
		//$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
		//$arr_hocsinh[$k]['ten'] = $hs['ten'];
	}
	$arr_hocsinh = sort_danhsach($arr_hocsinh);

	foreach($arr_hocsinh as $ds){
		//$ds['id_hocsinh'];
		$a = explode('---', $ds); $id_hocsinh = end($a);
		$hocsinh->id = $id_hocsinh; $hs = $hocsinh->get_one();
		echo '<tr>';
		echo '<td align="center">'.$i.'</td>';
		echo '<td align="center"><a href="chitiethocsinh.html?id='.$id_hocsinh.'&id_lophoc='.$id_lophoc.'&id_namhoc='.$id_namhoc.'">'.$hs['masohocsinh'].'</a></td>';
		//echo '<td align="center">'.$hs['cmnd'].'</td>';
		echo '<td>'.$hs['hoten'].'</td>';
		echo '<td align="center">'.$hs['ngaysinh'].'</td>';
		echo '<td align="center">'.$hs['noisinh'].'</td>';
		echo '<td align="center">'.$hs['gioitinh'].'</td>';
		echo '<td align="center">'.$hs['dantoc'].'</td>';
		echo '<td align="center"><a href="chitiethocsinh.html?id='.$id_hocsinh.'&id_lophoc='.$id_lophoc.'&id_namhoc='.$id_namhoc.'" target="_blank"><span class="mif-profile"></span></a></td>';
		if($users->is_admin()){
			echo '<td align="center"><a href="xoadanhsachlop.html?id_danhsachlop='.$a[1].'&id_namhoc='.$id_namhoc.'&id_lophoc='.$id_lophoc.'" Onclick="return confirm(\'Chắc chắn xoá?\')"><span class="mif-bin"></span></a></td>';
		}
		echo '</tr>';
		$i++;
	}
?>
</tbody>
</table>
<?php else: ?>
	<h2> <span class="mif-search"></span> Chưa có danh sách lớp.</h2>
<?php endif; ?>
<?php require_once('footer.php'); ?>
