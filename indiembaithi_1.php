<?php
require_once('header_none.php');
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();
$hocsinh = new HocSinh();$lophoc = new LopHoc();$monhoc = new MonHoc();
$namhoc_list = $namhoc->get_list_limit(3);
$monhoc_list = $monhoc->get_all_list();
$id_namhoc = ''; $hocky='';$id_monhoc='';
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
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
<?php if($id_namhoc && $hocky && $id_monhoc):
$danhsachlop->id_namhoc = $id_namhoc;
$giangday->id_monhoc = $id_monhoc;
$giangday->id_namhoc = $id_namhoc; 

$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$monhoc->id = $id_monhoc; $m = $monhoc->get_one();
$mamonhoc = $m['mamonhoc'];
//$khoi_6_list = $lophoc->get_list_to_khoi(6);
//$khoi_7_list = $lophoc->get_list_to_khoi(7);
//$khoi_8_list = $lophoc->get_list_to_khoi(8);
//$khoi_9_list = $lophoc->get_list_to_khoi(9);

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
		<h3>THỐNG KÊ ĐIỂM THI</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Môn học: <b><?php echo $m['tenmonhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Học kỳ: <b><?php echo $hocky=='hocky1' ? 'Học kỳ I' : 'Học kỳ II'; ?></b></p>
		</h4>
		</div>
	</div>
</div>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<?php if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'): ?>
			<tr>
				<th rowspan="2">STT</th>
				<th rowspan="2" width="140">GIÁO VIÊN</th>
				<th rowspan="2" width="50">LỚP</th>
				<th rowspan="2" class="border_right">SỈ SỐ</th>
				<th colspan="2">ĐẠT</th>
				<th colspan="2">CHƯA ĐẠT</th>
				<th colspan="2">MIỄN ĐẠT</th>
			</tr>
			<tr>
				<th>SL</th><th>TL</th>
				<th>SL</th><th>TL</th>
				<th>SL</th><th>TL</th>
			</tr>
		<?php else: ?>
			<tr>
				<th rowspan="2">STT</th>
				<th rowspan="2" width="140">GIÁO VIÊN</th>
				<th rowspan="2" width="50">LỚP</th>
				<th rowspan="2" class="border_right">SỈ SỐ</th>
			<?php
			for($i=0; $i<10.5; $i=$i+0.5){
				$j = $i + 0.5;
				if($i==4.5){
					echo '<th rowspan="2" class="border_right">'.$i.'<br /><' .$j .'</th>';
				} else if($i == 10){
					echo '<th rowspan="2" class="border_right">'.$i.'</th>';
				} else {
					echo '<th rowspan="2">'.$i.'<br /><' .$j .'</th>';
				}
			}
			?>
			<th colspan="2" class="border_right bg-yellow">DƯỚI TB</th>
			<th colspan="2" class="border_right bg-lighterBlue">TRÊN TB</th>
			</tr>
			<tr>
				<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
				<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			</tr>
		<?php endif ;?>		
	</thead>
	<tbody>
	<?php
	$stt=1;
	$count_0_05_thcs = 0;$count_05_1_thcs = 0;$count_1_15_thcs = 0;$count_15_2_thcs = 0;
	$count_2_25_thcs = 0;$count_25_3_thcs = 0;$count_3_35_thcs = 0;$count_35_4_thcs = 0;
	$count_4_45_thcs = 0;$count_45_5_thcs = 0;$count_5_55_thcs = 0;$count_55_6_thcs = 0;
	$count_6_65_thcs = 0;$count_65_7_thcs = 0;$count_7_75_thcs = 0;$count_75_8_thcs = 0;
	$count_8_85_thcs = 0;$count_85_9_thcs = 0;$count_9_95_thcs = 0;$count_95_10_thcs = 0;$count_10_thcs=0;
	$count_duoitb_thcs=0; $count_trentb_thcs=0;$count_mientb_thcs=0;$total_siso_thcs = 0;
	foreach($arr_thcs as $khoi){
		$list_khoi = $lophoc->get_list_to_khoi($khoi);
		if($list_khoi){
			$count_0_05_khoi = 0;$count_05_1_khoi = 0;$count_1_15_khoi = 0;$count_15_2_khoi = 0;
			$count_2_25_khoi = 0;$count_25_3_khoi = 0;$count_3_35_khoi = 0;$count_35_4_khoi = 0;
			$count_4_45_khoi = 0;$count_45_5_khoi = 0;$count_5_55_khoi = 0;$count_55_6_khoi = 0;
			$count_6_65_khoi = 0;$count_65_7_khoi = 0;$count_7_75_khoi = 0;$count_75_8_khoi = 0;
			$count_8_85_khoi = 0;$count_85_9_khoi = 0;$count_9_95_khoi = 0;$count_95_10_khoi = 0;$count_10_khoi=0;
			$count_duoitb_khoi=0; $count_trentb_khoi=0;$count_mientb_khoi=0;$total_siso = 0;
			foreach($list_khoi as $ko){
				$count_0_05 = 0;$count_05_1 = 0;$count_1_15 = 0;$count_15_2 = 0;
				$count_2_25 = 0;$count_25_3 = 0;$count_3_35 = 0;$count_35_4 = 0;
				$count_4_45 = 0;$count_45_5 = 0;$count_5_55 = 0;$count_55_6 = 0;
				$count_6_65 = 0;$count_65_7 = 0;$count_7_75 = 0;$count_75_8 = 0;
				$count_8_85 = 0;$count_85_9 = 0;$count_9_95 = 0;$count_95_10 = 0;$count_10 = 0;
				$count_duoitb=0; $count_trentb=0;$count_mientb=0;$siso=0;
				$danhsachlop->id_lophoc = $ko['_id'];
				$danhsachlop_list = $danhsachlop->get_danh_sach_lop_tk($hocky);
				$giangday->id_namhoc = $id_namhoc; 
				$giangday->id_lophoc = $ko['_id']; 
				$id_giaovien = $giangday->get_id_giaovien();
				$giaovien->id = $id_giaovien; $gv = $giaovien->get_one();
				$siso = $danhsachlop_list->count(); $total_siso += $siso;
				foreach ($danhsachlop_list as $ds) {
					//foreach($arr_hocky as $key => $value){
					if(isset($ds[$hocky]) && $ds[$hocky]){
						foreach($ds[$hocky] as $hk){
							if($hk['id_monhoc'] == $id_monhoc){
								$diemthi = isset($hk['diemthi'][0]) ? $hk['diemthi'][0] : '';
								if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'){
									if($diemthi == 'Đ') $count_trentb++;
									else if($diemthi == 'CĐ') $count_duoitb++;
									else if($diemthi == 'M') $count_mientb++;
								} else {
									$diemthi = doubleval($diemthi);
									if(is_numeric($diemthi)){
										if($diemthi >= 0 && $diemthi < 0.5)   $count_0_05++;
										if($diemthi >= 0.5 && $diemthi < 1) 	$count_05_1++;
										if($diemthi >= 1 && $diemthi < 1.5) 	$count_1_15++;
										if($diemthi >= 1.5 && $diemthi < 2) 	$count_15_2++;
										if($diemthi >= 2    && $diemthi < 2.5) 	$count_2_25++;
										if($diemthi >= 2.5  && $diemthi < 3) 	$count_25_3++;
										if($diemthi >= 3    && $diemthi < 3.5) 	$count_3_35++;
										if($diemthi >= 3.5  && $diemthi < 4) 	$count_35_4++;
										if($diemthi >= 4    && $diemthi < 4.5) 	$count_4_45++;
										if($diemthi >= 4.5  && $diemthi < 5) 	$count_45_5++;
										if($diemthi >= 5    && $diemthi < 5.5) 	$count_5_55++;
										if($diemthi >= 5.5  && $diemthi < 6) 	$count_55_6++;
										if($diemthi >= 6    && $diemthi < 6.5) 	$count_6_65++;
										if($diemthi >= 6.5  && $diemthi < 7) 	$count_65_7++;
										if($diemthi >= 7    && $diemthi < 7.5) 	$count_7_75++;
										if($diemthi >= 7.5  && $diemthi < 8) 	$count_75_8++;
										if($diemthi >= 8    && $diemthi < 8.5) 	$count_8_85++;
										if($diemthi >= 8.5  && $diemthi < 9) 	$count_85_9++;
										if($diemthi >= 9    && $diemthi < 9.5) 	$count_9_95++;
										if($diemthi >= 9.5  && $diemthi < 10) 	$count_95_10++;
										if($diemthi == 10) $count_10++;
										if($diemthi < 5) $count_duoitb++;
										if($diemthi >=5) $count_trentb++;
									}
								}
							}
						}
					}
					//}
				}
				if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'){
					$sum_tb = $count_trentb + $count_duoitb + $count_mientb;
					echo '<tr>';
					echo '<td class="marks">'.$stt.'</td>';
					echo '<td class="marks" style="text-align:left;">'.$gv['hoten'].'</td>';
					echo '<td class="marks">'.$ko['tenlophoc'].'</td>';
					echo '<td class="marks border_right">'.$siso.'</td>';
					echo '<td class="marks">'.format_number($count_trentb).'</td>';
					echo '<td class="marks">'.($sum_tb ? format_decimal($count_trentb/$sum_tb*100,1) : '0').'%</td>';
					echo '<td class="marks">'.format_number($count_duoitb).'</td>';
					echo '<td class="marks">'.($sum_tb ? format_decimal($count_duoitb/$sum_tb*100,1) : '0').'%</td>';
					echo '<td class="marks">'.format_number($count_mientb).'</td>';
					echo '<td class="marks">'.($sum_tb ? format_decimal($count_mientb/$sum_tb*100,1) : '0').'%</td>';
					echo '</tr>';$stt++;
					$count_duoitb_khoi+=$count_duoitb; $count_trentb_khoi+=$count_trentb;$count_mientb_khoi += $count_mientb;
				} else {
					echo '<tr>';
					echo '<td class="marks">'.$stt.'</td>';
					echo '<td class="marks" style="text-align:left;">'.$gv['hoten'].'</td>';
					echo '<td class="marks">'.$ko['tenlophoc'].'</td>';
					echo '<td class="marks border_right">'.$siso.'</td>';
					echo '<td class="marks">'.$count_0_05.'</td>';
					echo '<td class="marks">'.$count_05_1.'</td>';
					echo '<td class="marks">'.$count_1_15.'</td>';
					echo '<td class="marks">'.$count_15_2.'</td>';
					echo '<td class="marks">'.$count_2_25.'</td>';
					echo '<td class="marks">'.$count_25_3.'</td>';
					echo '<td class="marks">'.$count_3_35.'</td>';
					echo '<td class="marks">'.$count_35_4.'</td>';
					echo '<td class="marks">'.$count_4_45.'</td>';
					echo '<td class="marks border_right">'.$count_45_5.'</td>';
					echo '<td class="marks">'.$count_5_55.'</td>';
					echo '<td class="marks">'.$count_55_6.'</td>';
					echo '<td class="marks">'.$count_6_65.'</td>';
					echo '<td class="marks">'.$count_65_7.'</td>';
					echo '<td class="marks">'.$count_7_75.'</td>';
					echo '<td class="marks">'.$count_75_8.'</td>';
					echo '<td class="marks">'.$count_8_85.'</td>';
					echo '<td class="marks">'.$count_85_9.'</td>';
					echo '<td class="marks">'.$count_9_95.'</td>';
					echo '<td class="marks">'.$count_95_10.'</td>';
					echo '<td class="marks border_right">'.$count_10.'</td>';
					echo '<td class="marks bg-yellow">'.$count_duoitb.'</td>';
					echo '<td class="marks border_right bg-yellow">'.($count_duoitb ? format_decimal(($count_duoitb/($count_duoitb+$count_trentb))*100,1) .'%' : '').'</td>';
					echo '<td class="marks bg-lighterBlue">'.$count_trentb.'</td>';
					echo '<td class="marks border_right bg-lighterBlue">'.($count_trentb ? format_decimal(($count_trentb/($count_duoitb+$count_trentb))*100,1) .'%' : '').'</td>';
					echo '</tr>';
					$count_0_05_khoi += $count_0_05;$count_05_1_khoi += $count_05_1;
					$count_1_15_khoi += $count_1_15;$count_15_2_khoi += $count_15_2;
					$count_2_25_khoi += $count_2_25;$count_25_3_khoi += $count_25_3;
					$count_3_35_khoi += $count_3_35;$count_35_4_khoi += $count_35_4;
					$count_4_45_khoi += $count_4_45;$count_45_5_khoi += $count_45_5;
					$count_5_55_khoi += $count_5_55;$count_55_6_khoi += $count_55_6;
					$count_6_65_khoi += $count_6_65;$count_65_7_khoi += $count_65_7;
					$count_7_75_khoi += $count_7_75;$count_75_8_khoi += $count_75_8;
					$count_8_85_khoi += $count_8_85;$count_85_9_khoi += $count_85_9;
					$count_9_95_khoi += $count_9_95;$count_95_10_khoi += $count_95_10; $count_10_khoi += $count_10;
					$count_duoitb_khoi+=$count_duoitb; $count_trentb_khoi+=$count_trentb;
					$stt++;
				}
			}
		}

		if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'){
			$sum_tb_khoi = $count_trentb_khoi + $count_duoitb_khoi + $count_mientb_khoi;
			echo '<tr style="font-weight:bold;">';
			echo '<td colspan="3">Tổng kết khối '.$khoi.'</td>';
			echo '<td class="marks border_right">'.$total_siso.'</td>';
			echo '<td class="marks">'.format_number($count_trentb_khoi).'</td>';
			echo '<td class="marks">'.($sum_tb_khoi ? format_decimal($count_trentb_khoi/$sum_tb_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.format_number($count_duoitb_khoi).'</td>';
			echo '<td class="marks">'.($sum_tb_khoi ? format_decimal($count_duoitb_khoi/$sum_tb_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.format_number($count_mientb_khoi).'</td>';
			echo '<td class="marks">'.($sum_tb_khoi ? format_decimal($count_mientb_khoi/$sum_tb_khoi*100,1) : '0').'%</td>';
			echo '</tr>';$stt++;
			$total_siso_thcs += $total_siso;
			$count_duoitb_thcs+=$count_duoitb_khoi; $count_trentb_thcs+=$count_trentb_khoi;
			$count_mientb_thcs+=$count_mientb_khoi;
		} else {
			echo '<tr style="font-weight:bold;">';
			echo '<td colspan="3">Tổng kết khối '.$khoi.'</td>';
			echo '<td class="marks border_right">'.$total_siso.'</td>';
			echo '<td class="marks">'.$count_0_05_khoi.'</td>';
			echo '<td class="marks">'.$count_05_1_khoi.'</td>';
			echo '<td class="marks">'.$count_1_15_khoi.'</td>';
			echo '<td class="marks">'.$count_15_2_khoi.'</td>';
			echo '<td class="marks">'.$count_2_25_khoi.'</td>';
			echo '<td class="marks">'.$count_25_3_khoi.'</td>';
			echo '<td class="marks">'.$count_3_35_khoi.'</td>';
			echo '<td class="marks">'.$count_35_4_khoi.'</td>';
			echo '<td class="marks">'.$count_4_45_khoi.'</td>';
			echo '<td class="marks border_right">'.$count_45_5_khoi.'</td>';
			echo '<td class="marks">'.$count_5_55_khoi.'</td>';
			echo '<td class="marks">'.$count_55_6_khoi.'</td>';
			echo '<td class="marks">'.$count_6_65_khoi.'</td>';
			echo '<td class="marks">'.$count_65_7_khoi.'</td>';
			echo '<td class="marks">'.$count_7_75_khoi.'</td>';
			echo '<td class="marks">'.$count_75_8_khoi.'</td>';
			echo '<td class="marks">'.$count_8_85_khoi.'</td>';
			echo '<td class="marks">'.$count_85_9_khoi.'</td>';
			echo '<td class="marks">'.$count_9_95_khoi.'</td>';
			echo '<td class="marks">'.$count_95_10_khoi.'</td>';
			echo '<td class="marks border_right">'.$count_10_khoi.'</td>';
			echo '<td class="marks">'.$count_duoitb_khoi.'</td>';
			echo '<td class="marks border_right">'.($count_duoitb_khoi ? format_decimal(($count_duoitb_khoi/($count_duoitb_khoi + $count_trentb_khoi))*100,1) .'%' : '').'</td>';
			echo '<td class="marks">'.$count_trentb_khoi.'</td>';
			echo '<td class="marks border_right">'.($count_trentb_khoi ? format_decimal(($count_trentb_khoi/($count_duoitb_khoi + $count_trentb_khoi))*100,1) .'%' : '').'</td>';
			echo '</tr>';
			$count_0_05_thcs += $count_0_05_khoi;
			$count_05_1_thcs += $count_05_1_khoi;
			$count_1_15_thcs += $count_1_15_khoi;
			$count_15_2_thcs += $count_15_2_khoi;
			$count_2_25_thcs += $count_2_25_khoi;
			$count_25_3_thcs += $count_25_3_khoi;
			$count_3_35_thcs += $count_3_35_khoi;
			$count_35_4_thcs += $count_35_4_khoi;
			$count_4_45_thcs += $count_4_45_khoi;
			$count_45_5_thcs += $count_45_5_khoi;
			$count_5_55_thcs += $count_5_55_khoi;
			$count_55_6_thcs += $count_55_6_khoi;
			$count_6_65_thcs += $count_6_65_khoi;
			$count_65_7_thcs += $count_65_7_khoi;
			$count_7_75_thcs += $count_7_75_khoi;
			$count_75_8_thcs += $count_75_8_khoi;
			$count_8_85_thcs += $count_8_85_khoi;
			$count_85_9_thcs += $count_85_9_khoi;
			$count_9_95_thcs += $count_9_95_khoi; $count_10_thcs += $count_10_khoi;
			$count_95_10_thcs += $count_95_10_khoi;$total_siso_thcs += $total_siso;
			$count_duoitb_thcs+=$count_duoitb_khoi; $count_trentb_thcs+=$count_trentb_khoi;
		}
	}
	?>
	<?php if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'): ?>
	<?php
		$sum_tb_thcs = $count_trentb_thcs + $count_duoitb_thcs + $count_mientb_thcs;
	?>
	<tr style="font-weight:bold;">
		<td colspan="3">Tổng kết THCS</td>
		<td class="marks border_right"><?php echo $total_siso_thcs; ?></td>
		<td class="marks"><?php echo format_number($count_trentb_thcs); ?></td>
		<td class="marks"><?php echo ($sum_tb_thcs ? format_decimal($count_trentb_thcs/$sum_tb_thcs*100,1) : '0'); ?>%</td>
		<td class="marks"><?php echo format_number($count_duoitb_thcs); ?></td>
		<td class="marks"><?php echo ($sum_tb_thcs ? format_decimal($count_duoitb_thcs/$sum_tb_thcs*100,1) : '0'); ?>%</td>
		<td class="marks"><?php echo format_number($count_mientb_thcs); ?></td>
		<td class="marks"><?php echo ($sum_tb_thcs ? format_decimal($count_mientb_thcs/$sum_tb_thcs*100,1) : '0'); ?>%</td>
	</tr>
	<?php else: ?>
	<tr style="font-weight:bold;">
		<td colspan="3">Tổng kết THCS</td>
		<td class="marks border_right"><?php echo $total_siso_thcs; ?></td>
		<td class="marks"><?php echo $count_0_05_thcs; ?></td>
		<td class="marks"><?php echo $count_05_1_thcs; ?></td>
		<td class="marks"><?php echo $count_1_15_thcs; ?></td>
		<td class="marks"><?php echo $count_15_2_thcs; ?></td>
		<td class="marks"><?php echo $count_2_25_thcs; ?></td>
		<td class="marks"><?php echo $count_25_3_thcs; ?></td>
		<td class="marks"><?php echo $count_3_35_thcs; ?></td>
		<td class="marks"><?php echo $count_35_4_thcs; ?></td>
		<td class="marks"><?php echo $count_4_45_thcs; ?></td>
		<td class="marks"><?php echo $count_45_5_thcs; ?></td>
		<td class="marks"><?php echo $count_5_55_thcs; ?></td>
		<td class="marks"><?php echo $count_55_6_thcs; ?></td>
		<td class="marks"><?php echo $count_6_65_thcs; ?></td>
		<td class="marks"><?php echo $count_65_7_thcs; ?></td>
		<td class="marks"><?php echo $count_7_75_thcs; ?></td>
		<td class="marks"><?php echo $count_75_8_thcs; ?></td>
		<td class="marks"><?php echo $count_8_85_thcs; ?></td>
		<td class="marks"><?php echo $count_85_9_thcs; ?></td>
		<td class="marks"><?php echo $count_9_95_thcs; ?></td>
		<td class="marks"><?php echo $count_95_10_thcs; ?></td>
		<td class="marks border_right"><?php echo $count_10_thcs; ?></td>
		<td class="marks"><?php echo $count_duoitb_thcs; ?></td>
		<td class="marks border_right"><?php echo $count_duoitb_thcs ? format_decimal(($count_duoitb_thcs/($count_duoitb_thcs+$count_trentb_thcs))*100,1) .'%' : ''; ?></td>
		<td class="marks"><?php echo $count_trentb_thcs; ?></td>
		<td class="marks border_right"><?php echo $count_trentb_thcs ? format_decimal(($count_trentb_thcs/($count_duoitb_thcs+$count_trentb_thcs))*100,1) .'%' : ''; ?></td>
	</tr>
	<?php endif; ?>
	</tbody>
</table>
<?php else : ?>
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ và Môn học</h3>
<?php endif; ?>
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
</body>
</html>