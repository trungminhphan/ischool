<?php 
require_once('header.php');
check_permis(!$users->is_teacher());
require_once('cls/PHPExcel/IOFactory.php');
$monhoc = new MonHoc();$lophoc=new LopHoc();$hocsinh = new HocSinh();
$giaovien = new GiaoVien(); $danhsachlop = new DanhSachLop();$khoanhapdiem=new KhoaNhapDiem();
$id_giaovien = $users->get_id_giaovien();
if(isset($_POST['submit'])){
	$allowedExts = array("xls","xlsx");
	$temp = explode(".", $_FILES['danhsachlop']['name']);
	$extension = end($temp);
	if(in_array($extension, $allowedExts)){
		$filename =  'danhsachlop' . '_' . date("YmdHsi") . '.' . $extension;
		if(move_uploaded_file($_FILES["danhsachlop"]["tmp_name"], 'uploads/' . $filename)){
			$objPHPExcel = PHPExcel_IOFactory::load('uploads/' . $filename);
			$sheetData_import = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$id_lophoc = $objPHPExcel->getActiveSheet()->getCell('B58')->getValue();
			$id_monhoc = $objPHPExcel->getActiveSheet()->getCell('B59')->getValue();
			$id_namhoc = $objPHPExcel->getActiveSheet()->getCell('C58')->getValue();
			$hocky 	   = $objPHPExcel->getActiveSheet()->getCell('C59')->getValue();
			$giangday->id_giaovien = $id_giaovien; $giangday->id_lophoc = $id_lophoc; $giangday->id_namhoc = $id_namhoc;
			$giangday->id_monhoc = $id_monhoc;
			$khoanhapdiem->id_namhoc = $id_namhoc; $khoanhapdiem->id_lophoc = $id_lophoc;
			$khoanhapdiem->id_monhoc = $id_monhoc; $khoanhapdiem->hocky = $hocky;
			if($khoanhapdiem->check_isLock()){
				transfers_to('import_danhsachdiem.html?isLock=ok');
			} else {
				if($giangday->check_giaovien_giangday()){
					if($sheetData_import){
						foreach ($sheetData_import as $key => $value) {
							if($key >= 7 && $value['A'] && $value['B'] && $value['C'] && $value['D']) {
								$masohocsinh = $value['B']; $hocsinh->masohocsinh = $masohocsinh;
								$id_hocsinh = $hocsinh->get_id_hoccinh();
								$arr_cotdiem = array('E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q','R','S');
								$danhsachlop->id_lophoc = $id_lophoc; $danhsachlop->id_namhoc = $id_namhoc;
								$danhsachlop->id_monhoc = $id_monhoc; $danhsachlop->id_hocsinh = $id_hocsinh;
								if($danhsachlop->check_exist_monhoc($hocky)){
									//xoa diem de co....
									$query_delete = array('$unset' => array($hocky . '.$.diemmieng'  => true,  $hocky . '.$.diem15phut'  => true, $hocky . '.$.diem1tiet'  => true, $hocky . '.$.diemthi'  => true));
									$condition = array('id_hocsinh'=>new MongoId($id_hocsinh),'id_lophoc'=> new MongoId($id_lophoc),'id_namhoc'=>new MongoId($id_namhoc), $hocky.'.id_monhoc'=> new MongoId($id_monhoc));
									$danhsachlop->delete_diem($condition, $query_delete);
								} 
								foreach($arr_cotdiem as $k => $v){
									if($value[$v]){
										if($v=='E' || $v=='F' || $v=='G') $cotdiem = 'diemmieng';
										if($v=='H' || $v=='I' || $v=='J'  || $v=='K' || $v=='L') $cotdiem = 'diem15phut';
										if($v=='M' || $v=='N' || $v=='O'  || $v=='P' || $v=='Q' || $v=='R') $cotdiem = 'diem1tiet';
										if($v=='S') $cotdiem = 'diemthi';
										if(trim($value[$v]) == 'M' || trim($value[$v]) == 'Đ' || trim($value[$v]) == 'CĐ'){
											$diem = $value[$v];
										} else {
											$diem = doubleval($value[$v]);
										}
										if($danhsachlop->check_exist_monhoc($hocky)){
											$update_arr = array('$push'=> array($hocky. '.$.'. $cotdiem => $diem));
											$condition = array('id_hocsinh'=>new MongoId($id_hocsinh),'id_lophoc'=> new MongoId($id_lophoc),'id_namhoc'=>new MongoId($id_namhoc), $hocky.'.id_monhoc'=> new MongoId($id_monhoc));
										} else {
											$update_arr = array('$push'=>array($hocky=>array('id_monhoc'=> new MongoId($id_monhoc), $cotdiem=>array($diem))));	
											$condition = array('id_hocsinh'=>new MongoId($id_hocsinh),'id_lophoc'=> new MongoId($id_lophoc),'id_namhoc'=>new MongoId($id_namhoc));
										}
										$danhsachlop->cap_nhat_diem($condition, $update_arr);
									}
								}
							}
						}
					}
					transfers_to('import_danhsachdiem.html?file='.$filename);
				} else {
					$msg = 'Bảng điểm này không phải lớp được phân công giảng dạy [KHÔNG IMPORT ĐIỂM ĐƯỢC].';
				}
			}
		}
	} else {
		$msg =  'Tập tin không đúng [xls, xlsx]';
	}
}

$filename = isset($_GET['file']) ? $_GET['file'] : '';
$isLock = isset($_GET['isLock']) ? $_GET['isLock'] : '';
if($isLock=='ok') $msg = 'Phần mềm đang nâng cấp, hoặc khoá nhập điểm. Vui lòng liên hệ với quản trị.';

if($filename){
	$objPHPExcel = PHPExcel_IOFactory::load('uploads/' . $filename);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	$id_lophoc = $objPHPExcel->getActiveSheet()->getCell('B58')->getValue();
	$id_monhoc = $objPHPExcel->getActiveSheet()->getCell('B59')->getValue();
	$id_namhoc = $objPHPExcel->getActiveSheet()->getCell('C58')->getValue();
	$hocky 	   = $objPHPExcel->getActiveSheet()->getCell('C59')->getValue();
	$siso = $objPHPExcel->getActiveSheet()->getCell('B4')->getValue();
	$hotengiaovien = $objPHPExcel->getActiveSheet()->getCell('D3')->getValue();
	$tenhocky = $objPHPExcel->getActiveSheet()->getCell('D4')->getValue();
	
	$khoanhapdiem->id_namhoc = $id_namhoc; $khoanhapdiem->id_lophoc = $id_lophoc;
	$khoanhapdiem->id_monhoc = $id_monhoc; $khoanhapdiem->hocky = $hocky;

}
?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(isset($msg) && $msg) : ?>
            $.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
        <?php endif; ?>
	});
</script>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Import điểm từ Excel.</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="import_danhsachdiem" enctype="multipart/form-data">
	<img src="images/icon_excel.png" />
		<b>CHỌN DANH SÁCH ĐIỂM [EXCEL]:</b> 
		<div class="input-control file" data-role="input">
			<input type="file" name="danhsachlop" id="danhsachlop" placeholder="Chọn tập tin" />
			<button class="button fg-green"><span class="mif-file-excel"></span></button>
		</div>
		<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-checkmark"></span> Import</button>
		<span class="tag alert padding10">* Lưu ý: Nhập bảng điểm môn học theo học kỳ</span>
</form>
<hr />
<?php
if($filename){
	$lophoc->id = $id_lophoc; $lh = $lophoc->get_one(); $tenlophoc=$lh['tenlophoc'];
	$monhoc->id = $id_monhoc; $mh = $monhoc->get_one(); $tenmonhoc=$mh['tenmonhoc']; 
	$mamonhoc=$mh['mamonhoc'];
	$namhoc->id = $id_namhoc; $nh = $namhoc->get_one(); $tennamhoc = $nh['tennamhoc'];
?>
<table width="650" border="0" cellpadding="10" align="center">
	<tr>
		<td>Tên lớp: <b><?php echo $tenlophoc; ?></b></td>
		<td>Giáo viên: <b><?php echo $hotengiaovien; ?></b></td>
		<td>Môn: <b><?php echo $tenmonhoc; ?></b></td>
	</tr>
	<tr>
		<td>Sỉ số: <b><?php echo $siso; ?></b></td>
		<td>Học kỳ: <b><?php echo $tenhocky; ?></b></td>
		<td>Năm học: <b><?php echo $tennamhoc; ?></td>
	</tr>
</table>

<table class="table striped hovered border bordered">
<tr>
	<th>STT</th>
	<th>MSHS</th>
	<th>Họ tên</th>
	<th>Giới tính</th>
<?php if($mamonhoc=='AMNHAC' || $mamonhoc=='THEDUC' || $mamonhoc=='MYTHUAT') : ?>
	<th colspan="8">Kiểm tra thường xuyên</th>
	<th colspan="6">Kiểm tra định kỳ</th>

<?php else: ?>
	<th colspan="3">Điểm Miệng</th>
	<th colspan="5">Điểm 15 Phút</th>
	<th colspan="6">Điểm 1 Tiết</th>
<?php endif; ?>
	<th>Điểm Thi</th>
</tr>
<?php
if($sheetData){
	$i = 1;
	foreach($sheetData as $key => $value){
			if($key >= 7 && $value['A'] > 0 && $value['B'] && $value['C'] && $value['D']){
				if($i%2==0) $class='eve'; else $class='odd';
				echo '<tr class="'.$class.'">';
				echo '<td align="center">'.$value['A'].'</td>';
				echo '<td align="center"><b>'.$value['B'].'</b></td>';
				echo '<td>'.$value['C'].'</td>';
				echo '<td align="center">'.$value['D'].'</td>';
				if($mamonhoc=='AMNHAC' || $mamonhoc=='THEDUC' || $mamonhoc=='MYTHUAT'){
					echo '<td align="right" class="marks">'.$value['E'].'</td>';
					echo '<td align="right" class="marks">'.$value['F'].'</td>';
					echo '<td align="right" class="marks">'.$value['G'].'</td>';
					echo '<td align="right" class="marks">'.$value['H'].'</td>';
					echo '<td align="right" class="marks">'.$value['I'].'</td>';
					echo '<td align="right" class="marks">'.$value['J'].'</td>';
					echo '<td align="right" class="marks">'.$value['K'].'</td>';
					echo '<td align="right" class="marks">'.$value['L'].'</td>';
					echo '<td align="right" class="marks">'.$value['M'].'</td>';
					echo '<td align="right" class="marks">'.$value['N'].'</td>';
					echo '<td align="right" class="marks">'.$value['O'].'</td>';
					echo '<td align="right" class="marks">'.$value['P'].'</td>';
					echo '<td align="right" class="marks">'.$value['Q'].'</td>';
					echo '<td align="right" class="marks">'.$value['R'].'</td>';
					echo '<td align="right" class="marks">'.$value['S'].'</td>';
					echo '</tr>';
				} else {
					echo '<td align="right" class="marks">'.($value['E'] ? doubleval($value['E']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['F'] ? doubleval($value['F']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['G'] ? doubleval($value['G']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['H'] ? doubleval($value['H']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['I'] ? doubleval($value['I']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['J'] ? doubleval($value['J']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['K'] ? doubleval($value['K']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['L'] ? doubleval($value['L']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['M'] ? doubleval($value['M']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['N'] ? doubleval($value['N']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['O'] ? doubleval($value['O']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['P'] ? doubleval($value['P']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['Q'] ? doubleval($value['Q']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['R'] ? doubleval($value['R']) : '').'</td>';
					echo '<td align="right" class="marks">'.($value['S'] ? doubleval($value['S']) : '').'</td>';
					echo '</tr>';
				}
				$i++;
			}
	}
}
?>
</table>
<?php } ?>
<?php require_once('footer.php'); ?>