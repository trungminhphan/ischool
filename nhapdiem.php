<?php
require_once('header.php');
check_permis(!$users->is_teacher());
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();$hocsinh = new HocSinh();
$lophoc = new LopHoc();$monhoc = new MonHoc();$khoanhapdiem = new KhoaNhapDiem();

if(isset($_GET['loaddanhsachnhapdiem']) && $_GET['loaddanhsachnhapdiem']=='OK'){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
	$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	$khoanhapdiem->id_namhoc=$id_namhoc;$khoanhapdiem->id_lophoc = $id_lophoc;
	$khoanhapdiem->id_monhoc = $id_monhoc; $khoanhapdiem->hocky = $hocky;
	$update = isset($_GET['update']) ? $_GET['update'] : '';
	$giangday->id_giaovien = $users->get_id_giaovien();
	$giangday->id_lophoc = $id_lophoc; $giangday->id_namhoc = $id_namhoc; $giangday->id_monhoc = $id_monhoc;
	if($update == 'insert_ok') $msg = 'CẬP NHẬT THÀNH CÔNG';
	if(!$id_lophoc || !$id_namhoc || !$id_monhoc){
		$msg = 'Chưa phân công giảng dạy...';
	} else if($khoanhapdiem->check_isLock()){
		$msg = 'Phần mềm đang nâng cấp, hoặc khoá nhập điểm. Vui lòng liên hệ với quản trị.';
	} else {
		//Kiem tra xem co phai Giao vien giang day hay khong?
		if($giangday->check_giang_day()){
			$danhsachlop->id_lophoc = $id_lophoc; $danhsachlop->id_namhoc = $id_namhoc; $danhsachlop->id_monhoc = $id_monhoc;
			//load danh sach lop...
			$danhsachlop_list = $danhsachlop->get_danh_sach_lop();
			//echo '<div class="messages">OK</div>';
		} else {
			$msg = 'Bạn không phải là giáo viên của môn, lớp, năm,....Vui lòng chọn lớp, môn học khác.';
		}
	}
}
$monhoc_list = $monhoc->get_all_list();
$lophoc_list = $lophoc->get_all_list();
$namhoc_list = $namhoc->get_list_limit(3);
$giangday->id_giaovien = $users->get_id_giaovien();
$giangday->id_namhoc = $namhoc_macdinh['_id'];
$phanconggiangday = $giangday->get_giangday_theonam();
$list_monday = $giangday->get_monday_theonam();
?>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript" src="js/nhapdiem.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		<?php if(isset($msg) && $msg): ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
        submit_nhapdiem();marks_keyup();marks_keydown();fixed_header();marks_focus();
 	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Nhập điểm cho môn học </h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" name="formloadnhapdiem">
<input type="hidden" name="id_namhoc" id="id_namhoc" value="<?php echo $namhoc_macdinh['_id']; ?>">
<input type="hidden" name="hocky" id="hocky" value="<?php echo $namhoc_macdinh['macdinh']; ?>">
<div class="grid example">
	<div class="row">
		<div class="cell colspan12 align-center"><h4>Năm học: <?php echo $namhoc_macdinh['tennamhoc'] .'&nbsp;&nbsp;&nbsp;&nbsp;'; echo $namhoc_macdinh['macdinh']=='hocky1' ? 'Học kỳ I' : 'Học kỳ 2'; ?></h4></div>
	</div>
	<div class="row cells12">
		<div class="cell colspan2 align-right padding-top-10">Lớp học:</div>
		<div class="cell colspan4 input-control select">
			<select name="id_lophoc" id="id_lophoc" class="select2">
			<?php
				if($phanconggiangday->count() > 0){
					foreach ($phanconggiangday as $pcgd) {
						$lophoc->id = $pcgd['id_lophoc'];
						$lh = $lophoc->get_one();
						echo '<option value="'.$lh['_id'].'"'.($lh['_id']==$id_lophoc ? ' selected': '').'>'.$lh['tenlophoc'].'</option>';
					}
				}
			?>
			</select>
		</div>
		<div class="cell colspan2 align-right padding-top-10">Môn học:</div>
		<div class="cell colspan4 input-control select">
			<select name="id_monhoc" id="id_monhoc" class="select2">
			<?php
				if($list_monday){
					foreach ($list_monday as $key => $value) {
						$monhoc->id = $value;
						$mh = $monhoc->get_one();
						echo '<option value="'.$mh['_id'].'"'.($mh['_id']==$id_monhoc ? ' selected': '').'>'. $mh['tenmonhoc'].'</option>';
					}
				}
			?>
			</select>
		</div>
	</div>
	<div class="row cells12">
		<div class="cell colspan12 align-center">
			<button name="loaddanhsachnhapdiem" id="loaddanhsachnhapdiem" value="OK" class="button primary"><span class="mif-checkmark"></span> Tìm danh sách lớp</button>
			<?php if(isset($_GET['loaddanhsachnhapdiem']) && $id_namhoc && $id_lophoc && $id_monhoc && $hocky){
				echo '<a href="export_bangdiem.html?id_lophoc='.$id_lophoc.'&id_namhoc='.$id_namhoc.'&id_monhoc='.$id_monhoc.'&hocky='.$hocky.'" class="button success" ><span class="mif-file-excel"></span> Xuất file Excel</a>';
			}
			?>

		</div>
	</div>
</div>
</form>

<?php if(isset($_GET['loaddanhsachnhapdiem']) && !empty($danhsachlop_list)) :
$monhoc->id = $id_monhoc; $lophoc->id=$id_lophoc; $namhoc->id = $id_namhoc;
$mh_title = $monhoc->get_one();$lop_title = $lophoc->get_one();$nh_title = $namhoc->get_one();
$mamonhoc = $mh_title['mamonhoc'];
$giangday->id_lophoc = $id_lophoc; $giangday->id_namhoc = $id_namhoc; $giangday->id_monhoc = $id_monhoc;
$id_gvbm = $giangday->get_id_giaovien();
$giaovien->id = $id_gvbm; $gvbm = $giaovien->get_one();
?>
<h3 class="align-center fg-red">NHẬP BẢNG ĐIỂM TRỰC TUYẾN</h3>
<div class="grid" style="max-width:960px;margin:auto;">
	<div class="row cells12">
		<div class="cell colspan4 align-center fg-blue"><b>Tên lớp: <?php echo $lop_title['tenlophoc']; ?></b></div>
		<div class="cell colspan4 align-center fg-blue"><b>Giáo viên: <?php echo $gvbm['hoten']; ?></b></div>
		<div class="cell colspan4 align-center fg-blue"><b>Môn học: <?php echo $mh_title['tenmonhoc']; ?></b></div>
	</div>
	<div class="row cells12">
		<div class="cell colspan4 align-center fg-blue"><b><b>Sỉ số: <?php echo $danhsachlop_list->count();?> </b></div>
		<div class="cell colspan4 align-center fg-blue"><?php echo $hocky=='hocky1'?'Học kỳ I':'Học kỳ II'; ?></b></div>
		<div class="cell colspan4 align-center fg-blue"><b>Năm học: <?php echo $namhoc_macdinh['tennamhoc'];?></b></div>
	</div>
</div>
<form action="nhapdiem_submit.html" method="POST" id="nhapdiemform" data-role="validator" data-show-required-state="false" data-hint-mode="line" data-hint-background="bg-red" data-hint-color="fg-white" data-hide-error="5000">
<input type="hidden" name="mamonhoc" id="mamonhoc" value="<?php echo $mamonhoc; ?>">
<input type="hidden" name="id_monhoc" id="id_monhoc" value="<?php echo $id_monhoc; ?>">
<input type="hidden" name="id_lophoc" id="id_lophoc" value="<?php echo $id_lophoc; ?>">
<input type="hidden" name="id_namhoc" id="id_namhoc" value="<?php echo $id_namhoc; ?>">
<input type="hidden" name="hocky" id="hocky" value="<?php echo $hocky; ?>">
<input type="hidden" name="tenlophoc" id="tenlophoc" value="<?php echo $lop_title['tenlophoc']; ?>">
<input type="hidden" name="giaovienbomon" id="giaovienbomon" value="<?php echo $gvbm['hoten']; ?>">
<input type="hidden" name="tenmonhoc" id="tenmonhoc" value="<?php echo $mh_title['tenmonhoc']; ?>">
<input type="hidden" name="siso" id="siso" value="<?php echo $danhsachlop_list->count(); ?>">
<input type="hidden" name="tennmahoc" id="tennmahoc" value="<?php echo $namhoc_macdinh['tennamhoc']; ?>">

<table border="1" id="nhapdiem" cellpadding="0" align="center">
<thead>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
	<tr>
		<th width="40">STT</th>
		<th width="119">MSHS</th>
		<th width="255">Họ tên</th>
		<th colspan="8" width="234" class="border-right">Kiểm tra thường xuyên</th>
		<th colspan="6" width="175" width="145" class="border-right">Kiểm tra định kỳ</th>
		<th width="46" class="border-right">Thi</th>
	</tr>
	<?php else: ?>
	<tr>
		<th width="40">STT</th>
		<th width="119">MSHS</th>
		<th width="255">Họ tên</th>
		<th colspan="3" width="88" class="border-right">Miệng</th>
		<th colspan="5" width="145" class="border-right">15 Phút</th>
		<th colspan="6" width="174" class="border-right">1 Tiết</th>
		<th width="47" class="border-right">Thi</th>
	</tr>
	<?php endif; ?>
</thead>
<tbody>
	<?php
	$arr_hocsinh = array();
	foreach($danhsachlop_list as $k => $l){
		$hocsinh->id = $l['id_hocsinh'];
		$hs = $hocsinh->get_one();
		$arr_hocsinh[] = $hs['ten'] . '---'. strval($l['_id']) . '---'.strval($l['id_hocsinh']);
		//$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
		//$arr_hocsinh[$k]['ten'] = $hs['ten'];
	}
	$arr_hocsinh = sort_danhsach($arr_hocsinh);
	$r = 1; $tabindex=0;
	foreach($arr_hocsinh as $dsl){
		$a = explode('---', $dsl); $id_hocsinh = end($a);
		$hocsinh->id = $id_hocsinh; $hs = $hocsinh->get_one();
		$hs = $hocsinh->get_one();
		if($r%2==0) $class='eve'; else $class = 'odd';
		if($r%5==0) $line='sp'; else $line='';
		echo '<input type="hidden" name="id_hocsinh[]" value="'.$id_hocsinh.'">';
		echo '<tr class="'.$class. ' '.$line.'">';
		echo '<td align="center">'.$r.'</td>';
		echo '<td align="center">'.$hs['masohocsinh'].'</td>';
		echo '<td><b>&nbsp;'.$hs['hoten'].'</b></td>';
		if(isset($dsl[$hocky]) && $dsl[$hocky]){
			$cols=0;
			foreach($dsl[$hocky] as $hk){
				if($hk['id_monhoc'] == $id_monhoc){
					//diem mieng (3 cot)
					for($i=0; $i<3; $i++){
						if($i==2 && !in_array($mamonhoc, $arr_monhocdanhgia)) $class='border-right'; else $class='';
						$diemmieng = isset($hk['diemmieng'][$i]) ? $hk['diemmieng'][$i] : '';
						echo '<td class="marks '.$class.'"><input type="text" name="'.$dsl['id_hocsinh'].'_diem[]" class="marks" value="'.$diemmieng.'" tabindex='.$tabindex.'></td>';$tabindex++;
					}
					//diem15phut (5 cot)
					for($i=0; $i<5; $i++){
						if($i==4) $class='border-right'; else $class='';
						$diem15phut = isset($hk['diem15phut'][$i]) ? $hk['diem15phut'][$i] : '';
						echo '<td class="marks '.$class.'"><input type="text" name="'.$dsl['id_hocsinh'].'_diem[]" class="marks" value="'.$diem15phut.'" tabindex='.$tabindex.'></td>';$tabindex++;
					}
					//diem1tiet (6 cot)
					for($i=0; $i<6; $i++){
						if($i==5) $class='border-right'; else $class='';
						$diem1tiet = isset($hk['diem1tiet'][$i]) ? $hk['diem1tiet'][$i] : '';
						echo '<td class="marks '.$class.'"><input type="text" name="'.$dsl['id_hocsinh'].'_diem[]" class="marks" value="'.$diem1tiet.'" tabindex='.$tabindex.'></td>';$tabindex++;
					}
					//diemthi (1 cot)
					$diemthi = isset($hk['diemthi']) ? $hk['diemthi'][0] : '';
					echo '<td class="marks border-right"><input type="text" name="'.$dsl['id_hocsinh'].'_diem[]" class="marks" value="'.$diemthi.'" tabindex='.$tabindex.'></td>';$tabindex++;
					$cols++;
				}
			}
			if($cols == 0){
				for($cell=0; $cell<15; $cell++){
					if(($cell==2 && !in_array($mamonhoc, $arr_monhocdanhgia)) || $cell==7 || $cell == 13 || $cell == 14) $class= 'border-right';
					else $class='';
					echo '<td class="marks '.$class.'"><input type="text" name="'.$dsl['id_hocsinh'].'_diem[]" class="marks" value="" tabindex='.$tabindex.'></td>'; $tabindex++;
				}
			}
		} else {
			for($cell=0; $cell<15; $cell++){
				if($cell==2 || $cell==7 || $cell == 13 || $cell == 14) $class= 'border-right';
				else $class='';
				echo '<td class="marks '.$class.'"><input type="text" name="'.$id_hocsinh.'_diem[]" class="marks" value="" tabindex='.$tabindex.'></td>'; $tabindex++;
			}
		}
		echo '</tr>';
		$r++;
	}
	?>
</tbody>
<tfoot>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
	<tr>
		<th width="40">STT</th>
		<th width="126">MSHS</th>
		<th width="270">Họ tên</th>
		<th colspan="8" width="263" class="border-right">Kiểm tra thường xuyên</th>
		<th colspan="6" width="200" class="border-right">Kiểm tra định kỳ</th>
		<th width="50" class="border-right">Thi</th>
	</tr>
	<?php else: ?>
	<tr>
		<th width="40">STT</th>
		<th width="126">MSHS</th>
		<th width="269">Họ tên</th>
		<th colspan="3" width="97" class="border-right">Miệng</th>
		<th colspan="5" width="166" class="border-right">15 Phút</th>
		<th colspan="6" width="200" class="border-right">1 Tiết</th>
		<th width="51" class="border-right">Thi</th>
	</tr>
	<?php endif; ?>
</tfoot>
</table>
<div class="align-center padding20">
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Cập nhật danh sách điểm</button>
</div>
</form>
<?php endif; ?>
<?php require_once('footer.php'); ?>
