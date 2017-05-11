<?php
require_once('header.php'); 
require_once('cls/PHPExcel/IOFactory.php');
$lophoc=new LopHoc();$hocsinh = new HocSinh();
$giaovien = new GiaoVien(); $giangday = new GiangDay();$danhsachlop = new DanhSachLop();
$id_giaovien = $users->get_id_giaovien(); $tenlophoc =''; $tenhocky='';$tennamhoc='';$siso='';$hotengiaovien='';
if(isset($_POST['submit'])){
	$allowedExts = array("xls","xlsx");
	$temp = explode(".", $_FILES['danhsachdanhgia']['name']);
	$extension = end($temp);
	if(in_array($extension, $allowedExts)){
		$filename =  'danhsachdanhgia' . '_' . date("YmdHsi") . '.' . $extension;
		if(move_uploaded_file($_FILES["danhsachdanhgia"]["tmp_name"], 'uploads/' . $filename)){
			$objPHPExcel = PHPExcel_IOFactory::load('uploads/' . $filename);
			$sheetData_import = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$id_lophoc = $objPHPExcel->getActiveSheet()->getCell('A58')->getValue();
			$id_namhoc = $objPHPExcel->getActiveSheet()->getCell('B58')->getValue();
			$hocky = $objPHPExcel->getActiveSheet()->getCell('C58')->getValue();
			$giaovienchunhiem->id_giaovien = $id_giaovien; $giaovienchunhiem->id_lophoc = $id_lophoc; $giaovienchunhiem->id_namhoc = $id_namhoc;
			if($giaovienchunhiem->check_exists()){
				if($sheetData_import){
					foreach ($sheetData_import as $key => $value) {
						if($key >= 8 && intval($value['A']) > 0 && $value['B'] && $value['C'] && $value['D']) {
							$masohocsinh = $value['B']; $hocsinh->masohocsinh = $masohocsinh;
							$id_hocsinh = $hocsinh->get_id_hoccinh();
							$hanhkiem = $value['E']; $nghicophep = intval($value['F']); $nghikhongphep = intval($value['G']);
							$str_nghiluon = $value['H'];
							if($str_nghiluon == 'x' || $str_nghiluon == 'X'){
								$nghiluon = 1;
							} else $nghiluon = 0;
							$ghichu = isset($value['I']) ? $value['I'] : '';
							$arr_update = array('$set' => array('danhgia_' . $hocky => array('hanhkiem' => $hanhkiem, 'nghicophep' => $nghicophep, 'nghikhongphep' => $nghikhongphep, 'nghiluon' => $nghiluon, 'ghichu' => $ghichu)));
							$condition =  array('id_hocsinh' => new MongoId($id_hocsinh), 'id_lophoc' => new MongoId($id_lophoc), 'id_namhoc' => new MongoId($id_namhoc));
							$danhsachlop->cap_nhat_danh_gia_hocsinh($condition, $arr_update);
						}
					}
				}
				transfers_to('import_danhgiahocsinh.html?file='.$filename);
			} else {
				$msg = 'Danh sách này không phải lớp bạn chủ nhiệm [KHÔNG IMPORT ĐÁNH GIÁ HỌC SINH ĐƯỢC].';
			}
		}
	} else {
		$msg = '<div class="messages error">Tập tin không đúng [xls, xlsx]</div>';
	}
}

$filename = isset($_GET['file']) ? $_GET['file'] : '';
if($filename){
	$objPHPExcel = PHPExcel_IOFactory::load('uploads/' . $filename);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	$id_lophoc = $objPHPExcel->getActiveSheet()->getCell('C64')->getValue();
	$id_namhoc = $objPHPExcel->getActiveSheet()->getCell('C65')->getValue();
	$hocky = $objPHPExcel->getActiveSheet()->getCell('C66')->getValue();
	$tenlophoc = $objPHPExcel->getActiveSheet()->getCell('B3')->getValue();
	$siso = $objPHPExcel->getActiveSheet()->getCell('B4')->getValue();
	$hotengiaovien = $objPHPExcel->getActiveSheet()->getCell('D3')->getValue();
	$tenhocky = $objPHPExcel->getActiveSheet()->getCell('D4')->getValue();
	$tennamhoc = $objPHPExcel->getActiveSheet()->getCell('G4')->getValue();
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Import đánh giá học sinh từ Excel </h1>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST" id="import_danhgiahocsinh" enctype="multipart/form-data">
	<img src="images/icon_excel.png" />
	<b>CHỌN DANH SÁCH ĐÁNH GIÁ [EXCEL]:</b>
	<div class="input-control file" data-role="input">
		<input type="file" name="danhsachdanhgia" id="danhsachdanhgia" placeholder="Chọn tập tin" />
		<button class="button fg-green"><span class="mif-file-excel"></span></button>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Import</button>
	<span class="tag padding10 alert">* Lưu ý: Nhập đánh giá học sinh theo học kỳ.</span>
</form>
<hr />
<?php if($filename): ?>
<h2 style="text-align:center;">Danh sách đánh giá đã được cập nhật vào Cơ sở dữ liệu</h2>
<table width="650" border="0" cellpadding="10" align="center">
	<tr>
		<td>Tên lớp: <b><?php echo $tenlophoc; ?></b></td>
		<td>Giáo viên chủ nhiệm: <b><?php echo $hotengiaovien; ?></b></td>
	</tr>
	<tr>
		<td>Sỉ số: <b><?php echo $siso; ?></b></td>
		<td>Học kỳ: <b><?php echo $tenhocky; ?></b></td>
		<td>Năm học: <b><?php echo $tennamhoc; ?></td>
	</tr>
</table>
<table class="table border bordered striped">
<tr>
	<th rowspan="2">STT</th>
	<th rowspan="2">MSHS</th>
	<th rowspan="2" width="250">Họ tên</th>
	<th rowspan="2">Giới tính</th>
	<th rowspan="2">Hạnh kiểm</th>
	<th colspan="2">Nghỉ (Vắng)</th>
	<th rowspan="2">Nghỉ luôn</th>
	<th rowspan="2">Ghi chú</th>
</tr>
<tr>
	<th>Có phép</th>
	<th>Không phép</th>
</tr>
<?php
if($sheetData){
	$i = 1;
	foreach($sheetData as $key => $value){
		if($key >= 8 && intval($value['A']) > 0 && $value['B'] && $value['C'] && $value['D']){
			if($i%2==0) $class='eve'; else $class='odd';
			echo '<tr class="'.$class.'">';
			echo '<td align="center">'.$value['A'].'</td>';
			echo '<td align="center"><b>'.$value['B'].'</b></td>';
			echo '<td>'.$value['C'].'</td>';
			echo '<td align="center">'.$value['D'].'</td>';
			echo '<td align="center">'.$value['E'].'</td>';
			echo '<td align="center">'.$value['F'].'</td>';
			echo '<td align="center">'.$value['G'].'</td>';
			echo '<td align="center">'.$value['H'].'</td>';
			echo '<td align="center">'.$value['I'].'</td>';
			echo '</tr>';
			$i++;
		}
	}
}
?>
</table>
<?php endif; ?>
<?php require_once('footer.php'); ?>