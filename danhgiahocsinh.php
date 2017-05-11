<?php
require_once('header.php');
check_permis(!$users->is_teacher());
$lophoc = new LopHoc(); $giaovien = new GiaoVien();
$hocsinh = new HocSinh(); $danhsachlop = new DanhSachLop; $monhoc = new MonHoc(); 

$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_list_limit(3);
$tenlophoc = '';$tennamhoc='';
if(isset($_GET['submit'])){
	if($id_namhoc && $id_lophoc && $hocky){
		$giaovienchunhiem->id_lophoc = $id_lophoc;
		$giaovienchunhiem->id_namhoc = $id_namhoc;
		$giaovienchunhiem->id_giaovien = $users->get_id_giaovien();
		if($giaovienchunhiem->check_is_gvcn() || $users->is_admin()){
			$danhsachlop->id_lophoc = $id_lophoc;
			$danhsachlop->id_namhoc = $id_namhoc;	
			$danhsachlop_list = $danhsachlop->get_danh_sach_lop();
			$giaovien->id = $users->get_id_giaovien(); $gv = $giaovien->get_one();
		} else {
			$danhsachlop_list = '';
			$msg = 'Bạn không phải là Giáo viên chủ nhiệm lớp này';
		}
	} else {
		$danhsachlop_list = '';
	}
}

?>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		<?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>

		$.get("load_danhsachlophoc.html?id_namhoc=" + $("#id_namhoc").val() + "&id_lophoc=<?php echo $id_lophoc; ?>", function(data){
			$("#id_lophoc").html(data);$("#id_lophoc").select2();
		});
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Đánh giá học sinh</h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" id="formloaddanhsach">
<input type="hidden" name="id_namhoc" id="id_namhoc" value="<?php echo $namhoc_macdinh['_id']; ?>">
<input type="hidden" name="hocky" id="hocky" value="<?php echo $namhoc_macdinh['macdinh']; ?>">
<h4 class="align-center">Năm học: <?php echo $namhoc_macdinh['tennamhoc'] .'&nbsp;&nbsp;&nbsp;&nbsp;'; echo $namhoc_macdinh['macdinh']=='hocky1' ? 'Học kỳ I' : 'Học kỳ 2'; ?></h4>
Lớp: <div class="cell colspan2 input-control select">
		<select name="id_lophoc" id="id_lophoc" class="select2">
			<?php
			foreach($lophoc_list as $lh){
				echo '<option value="'.$lh['_id'].'" '.($lh['_id']==$id_lophoc ? ' selected' : '').'>'.$lh['malophoc'] .'-'. $lh['tenlophoc'].'</option>';
				if($lh['_id']==$id_lophoc) $tenlophoc = $lh['tenlophoc'];
			}
			?>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Tìm kiếm</button>
		<?php if(isset($_GET['submit']) && $id_namhoc && $id_lophoc && count($danhsachlop_list) > 0): ?>
			<a href="export_danhgiahocsinh.html?id_namhoc=<?php echo $id_namhoc; ?>&id_lophoc=<?php echo $id_lophoc;?>&hocky=<?php echo $hocky; ?>" class="button success"><span class="mif-file-excel"></span> Xuất File Excel</a>
		<?php endif; ?>

<hr />
<?php if(isset($danhsachlop_list) && $danhsachlop_list): ?>
<h4 class="align-center">Danh sách học sinh <?php echo $tenlophoc; ?></h4>
<h5 class="align-center">Giáo viên chủ nhiệm: <?php echo isset($gv['hoten']) ? $gv['hoten'] : ''; ?></h5>
<table class="table border bordered striped hovered">
	<tr>
		<th>STT</th>
		<th>Mã số học sinh</th>
		<th>Họ tên</th>
		<th>Ngày sinh</th>
		<th>Giới tính</th>
		<th>Hạnh kiểm</th>
	</tr>
	<?php
	$i = 1 ;
	$arr_hocsinh = iterator_to_array($danhsachlop_list);
	foreach($danhsachlop_list as $k => $l){
		$hocsinh->id = $l['id_hocsinh'];
		$hs = $hocsinh->get_one();
		$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
	}
	$arr_hocsinh = sort_array_and_key($arr_hocsinh, 'masohocsinh', SORT_ASC);
	foreach($arr_hocsinh as $dsl){
		$hocsinh->id = $dsl['id_hocsinh'];
		$hs = $hocsinh->get_one();
		if($i%5==0) $line='sp'; else $line='';
		$hanhkiem = isset($dsl['danhgia_' . $hocky]['hanhkiem']) ? $dsl['danhgia_' . $hocky]['hanhkiem'] : '';
		echo '<tr class="'.$line.'">';
		echo '<td align="center">'.$i.'</td>';
		echo '<td align="center">'.$hs['masohocsinh'].'</td>';
		echo '<td><b>'.$hs['hoten'].'</b></td>';
		echo '<td align="center">'.$hs['ngaysinh'].'</td>';
		echo '<td align="center">'.$hs['gioitinh'].'</td>';
		echo '<td class="align-center">'.$hanhkiem.'</td>';
		echo '</tr>';
		$i++;
	}
	?>
</table>
<?php elseif(isset($danhsachlop_list) && !$danhsachlop_list): ?>
	<h2><span class="mif-search"></span> Bạn không phải là GVCN.</h2>
<?php else: ?>
	<h2><span class="mif-search"></span> Vui lòng chọn lớp, năm học và học kỳ.</h2>
<?php endif; ?>
<?php require_once('footer.php'); ?>