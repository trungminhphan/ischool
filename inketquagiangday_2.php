<?php
require_once('header_none.php');
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();
$hocsinh = new HocSinh();$lophoc = new LopHoc();$monhoc = new MonHoc();
$namhoc_list = $namhoc->get_list_limit(3);
$id_namhoc = ''; $hocky='';$id_monhoc='';
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	$khoi = isset($_GET['khoi']) ? $_GET['khoi'] : '';
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="description" content="Phần mềm quản Sổ liên lạc điện tử , Trường PT Thực hành Sư phạm.">
<meta name="keywords" content="Phần mềm quản Sổ liên lạc điện tử , Trường PT Thực hành Sư phạm.">
<meta name="author" content="Trung tâm Tin học Trường Đai học An Giang, 18 Ung Văn Khiêm, Tp Long Xuyên, An Giang">
<link rel='shortcut icon' type='image/x-icon' href="images/favicon.ico" />
<title>Phần mềm quản Sổ liên lạc điện tử, Trường PT Thực hành Sư phạm.</title>
<link href="css/metro.css" rel="stylesheet">
<link href="css/metro-icons.css" rel="stylesheet">
<link href="css/metro-responsive.css" rel="stylesheet">
<link href="css/metro-schemes.css" rel="stylesheet">
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/metro.js"></script>
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript"> $(document).ready(function(){ window.print(); }); </script>
</head>
<body>
<?php if($id_namhoc && $hocky && $khoi):
$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$monhoc_list = $monhoc->get_all_list();
$arr_lophoc = array();
if($khoi=='THCS'){
	foreach ($arr_thcs as $kh) {
		$list_khoi = $lophoc->get_list_to_khoi($kh);
		foreach ($list_khoi as $key => $value) {
			array_push($arr_lophoc, new MongoId($value['_id']));
		}
	}
	
} else {
	$list_khoi = $lophoc->get_list_to_khoi($khoi);
	foreach ($list_khoi as $key => $value) {
		array_push($arr_lophoc, new MongoId($value['_id']));
	}
}

$danhsachlop->id_namhoc = $id_namhoc;
$danhsachlop->arr_lophoc = $arr_lophoc;
$danhsachlop_list = $danhsachlop->get_danh_sach_lop_theo_khoi_tk($hocky);
?>
<table width="100%" align="center" border="0" style="font-size:14px;" cellpadding="10">
	<tr>
		<td align="center" valign="top" style="width:50%;">
			TRƯỜNG ĐẠI HỌC AN GIANG <br /><br />
			<b>TRƯỜNG PT THỰC HÀNH SƯ PHẠM</b>
		</td>
		<td align="center" style="width:50%;">
			<b>CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM<br /><br />Độc lập - Tự do - Hạnh phúc</b><br />
			________________________________<br /><br />
			<i>An Giang, ngày <?php echo date("d"); ?> tháng <?php echo date("m"); ?> năm <?php echo date("Y"); ?></i>
		</td>
	</tr>
</table>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ KẾT QUẢ GIẢNG DẠY</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			<?php if($khoi == 'THCS') : ?>
				Toàn cấp: <b><?php echo $khoi; ?></b>&nbsp;&nbsp;&nbsp;
			<?php else: ?>
				Khối: <b><?php echo $khoi; ?></b>&nbsp;&nbsp;&nbsp;
			<?php endif; ?>
			Học kỳ: <b><?php echo $hocky=='hocky1' ? 'Học kỳ I' : 'Học kỳ II'; ?></b></p>
		</h4>
		</div>
	</div>
</div>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="140">Môn</th>
			<th rowspan="2" class="border_right">Số lượng</th>
			<th colspan="2">Giỏi</th>
			<th colspan="2">Khá</th>
			<th colspan="2">Trung bình</th>
			<th colspan="2">Yếu</th>
			<th colspan="2" class="border_right">Kém</th>
			<th colspan="2" class="bg-lighterBlue">Đạt</th>
			<th colspan="2" class="bg-lighterBlue">Chưa đạt</th>
			<th colspan="2" class="bg-lighterBlue">Miễn</th>

		</tr><tr>
			<th>SL</th><th>Tỉ lệ</th>
			<th>SL</th><th>Tỉ lệ</th>
			<th>SL</th><th>Tỉ lệ</th>
			<th>SL</th><th>Tỉ lệ</th>
			<th>SL</th><th class="border_right">Tỉ lệ</th>
			<th class="bg-lighterBlue">SL</th><th class="bg-lighterBlue">Tỉ lệ</th>
			<th class="bg-lighterBlue">SL</th><th class="bg-lighterBlue">Tỉ lệ</th>
			<th class="bg-lighterBlue">SL</th><th class="bg-lighterBlue">Tỉ lệ</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$stt=1;
	$sum_kem = 0; $sum_yeu=0; $sum_tb=0;$sum_kha=0;$sum_gioi=0;
	$sum_duoitb=0; $sum_trentb=0; $sum_tbmien = 0;$sum_soluong = 0;
	foreach($monhoc_list as $mh){
		if($stt%2 ==0) $class='eve'; else $class='odd';
		//$count_0_05 = 0;$count_05_1 = 0;$count_1_15 = 0;$count_15_2 = 0;
		//$count_2_25 = 0;$count_25_3 = 0;$count_3_35 = 0;$count_35_4 = 0;
		//$count_4_45 = 0;$count_45_5 = 0;$count_5_55 = 0;$count_55_6 = 0;
		//$count_6_65 = 0;$count_65_7 = 0;$count_7_75 = 0;$count_75_8 = 0;
		//$count_8_85 = 0;$count_85_9 = 0;$count_9_95 = 0;$count_95_10 = 0;
		$count_kem = 0; $count_yeu=0; $count_tb=0;$count_kha=0;$count_gioi=0;
		$count_duoitb=0; $count_trentb=0; $count_tbmien = 0;
		$soluong= $danhsachlop_list->count();
		if($danhsachlop_list){
			foreach ($danhsachlop_list as $ds) {
				if(isset($ds[$hocky]) && $ds[$hocky]){
					$count_mien = 0; $count_d = 0; $count_cd=0;$trungbinh='';
					$count_cotmieng = 0; $sum_cotmieng = 0;$count_cot15phut = 0; $sum_cot15phut = 0;
					$count_cot1tiet = 0; $sum_cot1tiet = 0;$diemthi = '';
					foreach($ds[$hocky] as $hk){
						if($hk['id_monhoc'] == $mh['_id']){
							$mamonhoc = $mh['mamonhoc'];
							$count_cotmieng = 0; $sum_cotmieng = 0;
							//cot mieng hoc ky I
							if(isset($hk['diemmieng']) && $hk['diemmieng']){
								foreach($hk['diemmieng'] as $key => $value){
									if($value == 'M') $count_mien++;
									else if($value == 'Đ') $count_d++;
									else if($value == 'CĐ') $count_cd++;
									$count_cotmieng++;
									$sum_cotmieng += doubleval($value);
								}
							}
							//Cot 15 hoc ky I
							$count_cot15phut = 0; $sum_cot15phut = 0;
							if(isset($hk['diem15phut']) && $hk['diem15phut']){
								foreach($hk['diem15phut'] as $key => $value){
									if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
										if($value == 'M') $count_mien++;
										else if($value == 'Đ') $count_d++;
										else if($value == 'CĐ') $count_cd++;
									}
									$count_cot15phut++;
									$sum_cot15phut += doubleval($value);
								}
							}
							//cot 1 tiet hoc ky 1
							//Toi da 6 cot
							$count_cot1tiet = 0; $sum_cot1tiet = 0;
							if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
								foreach($hk['diem1tiet'] as $key => $value){
									if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
										if($value == 'M') $count_mien++;
										else if($value == 'Đ') $count_d++;
										else if($value == 'CĐ') $count_cd++;

									}
									$count_cot1tiet ++;
									$sum_cot1tiet += doubleval($value);	
								}
								
							}
							//diem thi hoc ky 1
							$diemthi = '';
							if(isset($hk['diemthi']) && $hk['diemthi']){
								foreach($hk['diemthi'] as $key => $value){
									if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
										if($value == 'M') $count_mien++;
										else if($value == 'Đ') $count_d++;
										else if($value == 'CĐ') $count_cd++;
									}
									$diemthi = $value;
								}
							}

							if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
								$sum_d_cd = $count_d + $count_cd;
								if($sum_d_cd && $sum_d_cd/$sum_d_cd >= 0.65){
									$trungbinh = 'Đ';
								} else if($count_mien > 0  && $count_d==0 && $count_cd==0){
									$trungbinh = 'M';
								} else if($count_cd > 0) {
									$trungbinh = 'CĐ';
								} else {
									$trungbinh = '';
								}
								if($trungbinh == 'Đ') $count_trentb++;
								else if($trungbinh == 'CĐ') $count_duoitb++;
								else if($trungbinh == 'M') $count_tbmien++;
							} else {
								$trungbinh = round(($sum_cotmieng + $sum_cot15phut + 2*$sum_cot1tiet + (3* doubleval($diemthi)))/($count_cotmieng + $count_cot15phut + 2*$count_cot1tiet + 3),1);
								if($trungbinh >=0 && $trungbinh < 3.5) $count_kem++;
								if($trungbinh >=3.5 && $trungbinh < 5) $count_yeu++;
								if($trungbinh >=5 && $trungbinh < 6.5) $count_tb++;
								if($trungbinh >=6.5 && $trungbinh < 8) $count_kha++;
								if($trungbinh >=8 && $trungbinh <= 10) $count_gioi++;
							}
							//$soluong++;
						}
					}
				}
			}
		}
		if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
			$sum_trungbinh = $count_trentb + $count_duoitb + $count_tbmien;
			echo '<tr class="'.$class.'">';
			echo '<td class="marks">'.$stt.'</td>';
			echo '<td class="marks" style="text-align:left;">'.$mh['tenmonhoc'].'</td>';
			echo '<td class="marks border_right">'.$soluong.'</td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks"></td>';
			echo '<td class="marks border_right"></td>';
			echo '<td class="marks bg-lighterBlue">'. format_number($count_trentb).'</td>';
			echo '<td class="marks bg-lighterBlue">'.($sum_trungbinh ? format_decimal($count_trentb/$sum_trungbinh*100,1) : '').'%</td>';
			echo '<td class="marks bg-lighterBlue">'. format_number($count_duoitb).'</td>';
			echo '<td class="marks bg-lighterBlue">'.($sum_trungbinh ? format_decimal($count_duoitb/$sum_trungbinh*100,1) : '').'%</td>';
			echo '<td class="marks bg-lighterBlue">'. format_number($count_tbmien).'</td>';
			echo '<td class="marks bg-lighterBlue">'.($sum_trungbinh ? format_decimal($count_tbmien/$sum_trungbinh*100,1) : '').'%</td>';
			echo '</tr>';
			$sum_trentb += $count_trentb; $sum_duoitb += $count_duoitb; $sum_tbmien += $count_tbmien;
		} else {
			$sum_trungbinh = $count_gioi + $count_kha + $count_tb + $count_yeu + $count_kem;
			echo '<tr class="'.$class.'">';
			echo '<td class="marks">'.$stt.'</td>';
			echo '<td class="marks" style="text-align:left;">'.$mh['tenmonhoc'].'</td>';
			echo '<td class="marks border_right">'.$soluong.'</td>';
			echo '<td class="marks">'.format_number($count_gioi).'</td>';
			echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_gioi/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks">'.format_number($count_kha).'</td>';
			echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_kha/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks">'.format_number($count_tb).'</td>';
			echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_tb/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks">'.format_number($count_yeu).'</td>';
			echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_yeu/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks">'.format_number($count_kem).'</td>';
			echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal($count_kem/$sum_trungbinh*100, 1) : '').'%</td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '</tr>';
			$sum_gioi += $count_gioi; $sum_kha += $count_kha; $sum_tb += $count_tb;
			$sum_yeu += $count_yeu; $sum_kem += $count_kem;
		}
		$sum_soluong += $soluong;
		$stt++;
	}
	?>
	</tbody>
	<tfoot style="font-weight:bold;">
		<?php
		$total_hl = $sum_gioi + $sum_kha + $sum_tb + $sum_yeu + $sum_kem;
		$total_tb = $sum_trentb + $sum_duoitb + $sum_tbmien;
		?>
		<tr>
			<td colspan="2" class="marks" style="text-align:center;"><b>TỔNG CỘNG</b></td>
			<td class="marks border_right"><?php echo format_number($sum_soluong); ?></td>
			<td class="marks"><?php echo format_number($sum_gioi); ?></td>
			<td class="marks"><?php echo $total_hl ? format_decimal($sum_gioi/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks"><?php echo format_number($sum_kha); ?></td>
			<td class="marks"><?php echo $total_hl ? format_decimal($sum_kha/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks"><?php echo format_number($sum_tb); ?></td>
			<td class="marks"><?php echo $total_hl ? format_decimal($sum_tb/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks"><?php echo format_number($sum_yeu); ?></td>
			<td class="marks"><?php echo $total_hl ? format_decimal($sum_yeu/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks"><?php echo format_number($sum_kem); ?></td>
			<td class="marks border_right"><?php echo $total_hl ? format_decimal($sum_kem/$total_hl*100,1) : '0' ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_trentb); ?></td>
			<td class="marks bg-lighterBlue"><?php echo $total_tb ? format_decimal($sum_trentb/$total_tb*100,1) : '0'; ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_duoitb); ?></td>
			<td class="marks bg-lighterBlue"><?php echo $total_tb ? format_decimal($sum_duoitb/$total_tb*100,1) : '0'; ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_tbmien); ?></td>
			<td class="marks bg-lighterBlue"><?php echo $total_tb ? format_decimal($sum_tbmien/$total_tb*100,1) : '0'; ?>%</td>
		</tr>
	</tfoot>
</table>
<table width="100%" align="center" border="0" style="font-size:14px;" cellpadding="10">
	<tr>
		<td align="center" valign="top" style="width:50%;">
			<b>NGƯỜI LẬP BẢNG</b>
		</td>
		<td align="center" style="width:50%;">
			<b>HIỆU TRƯỞNG</b>
		</td>
	</tr>
</table>
<?php else : ?>
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ và Khối</h3>
<?php endif; ?>
</body>
</html>
