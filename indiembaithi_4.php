<?php
require_once('header_none.php');
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();
$hocsinh = new HocSinh();$lophoc = new LopHoc();$monhoc = new MonHoc();
$to = new To();$tochuyenmon=new ToChuyenMon();
$namhoc_list = $namhoc->get_list_limit(3);
$to_list = $to->get_all_list();
$id_namhoc = ''; $hocky='';$id_to='';
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	$id_to = isset($_GET['id_to']) ? $_GET['id_to'] : ''; //58293cab32341c1409001469 TD-NHAC-MT
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
<?php if($id_namhoc && $hocky && $id_to):
$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$to->id = $id_to; $tc = $to->get_one();
$tochuyenmon->id_namhoc = $id_namhoc; $tochuyenmon->id_to = $id_to;
$giaovien_list = $tochuyenmon->get_distict_giaovien();
$giangday->id_namhoc = $id_namhoc;
$danhsachlop->id_namhoc = $id_namhoc;
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
			Học kỳ: <b><?php echo $hocky=='hocky1' ? 'Học kỳ I' : 'Học kỳ II'; ?></b>&nbsp;&nbsp;&nbsp;
			Tổ: <b><?php echo $tc['tento']; ?></b>
			</p>
		</h4>
		</div>
	</div>
</div>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="150">Họ tên Giáo viên</th>
			<th rowspan="2" width="50">Môn dạy</th>
			<th rowspan="2" width="120">Lớp dạy</th>
			<th rowspan="2" width="55" class="border_right">Số lượng</th>
			<?php if($id_to == '58293cab32341c1409001469'): ?>
				<th colspan="2" class="border_right bg-lighterBlue">Dưới TB (CĐ)</th>
				<th colspan="2" class="border_right bg-yellow">Trên TB (Đ)</th>
				<th colspan="2" class="border_right">Miễn (M)</th>
			<?php else: ?>
			<th colspan="2" class="border_right">KÉM</th>
			<th colspan="2" class="border_right">YẾU</th>
			<th colspan="2" class="border_right bg-lighterBlue">TỔNG</th>
			<th colspan="2" class="border_right">TRUNG BÌNH</th>
			<th colspan="2" class="border_right">KHÁ</th>
			<th colspan="2" class="border_right">GIỎI</th>
			<th colspan="2" class="border_right bg-yellow">TỔNG</th>
			<?php endif;?>
		</tr><tr>
			<?php if($id_to == '58293cab32341c1409001469'): ?>
				<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
				<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
				<th>SL</th><th class="border_right">TL</th>
			<?php else: ?>
				<th>SL</th><th class="border_right">TL</th>
				<th>SL</th><th class="border_right">TL</th>
				<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
				<th>SL</th><th class="border_right">TL</th>
				<th>SL</th><th class="border_right">TL</th>
				<th>SL</th><th class="border_right">TL</th>
				<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<?php endif; ?>
		</tr>
	</thead>
	<tbody>
	<?php
	$stt=1;
	if($giaovien_list){
		$i=1;
		$sum_kem = 0; $sum_yeu=0; $sum_tb=0;$sum_kha=0;$sum_gioi=0;
		$sum_trentb=0; $sum_duoitb = 0;$sum_mientb = 0;$sum_soluong=0;
		foreach ($giaovien_list as $key => $value) {
			$giaovien->id = $value; $gvi=$giaovien->get_one();
			$giangday->id_giaovien = $value;
			$monhoc_list = $giangday->get_distinct_monhoc_1();
			foreach ($monhoc_list as $mk => $mv) {
				$monhoc->id = $mv;$mh = $monhoc->get_one();
				$giangday->id_monhoc = $mv;
				$lophoc_list = $giangday->get_lopgiangday();
				$lopday = array(); $arr_id_lop = array();
				if($lophoc_list){
					foreach($lophoc_list as $lop){
						$lophoc->id = $lop['id_lophoc']; $l = $lophoc->get_one();
						array_push($lopday, $l['tenlophoc']);
						array_push($arr_id_lop, new MongoId($lop['id_lophoc']));
					}
				}
				$danhsachlop->arr_lophoc = $arr_id_lop;
				$danhsachlop_list = $danhsachlop->get_danh_sach_lop_theo_giaovien_tk($hocky);
				$count_kem = 0; $count_yeu=0; $count_tb=0;$count_kha=0;$count_gioi=0;
				$count_trentb=0; $count_duoitb = 0;$count_mientb = 0;
				$soluong = 0; $soluong += $danhsachlop_list->count();
				if($danhsachlop_list){
					foreach ($danhsachlop_list as $ds) {
						if(isset($ds[$hocky]) && $ds[$hocky]){
							foreach($ds[$hocky] as $hk){
								if($hk['id_monhoc'] == $mv){
									$diemthi = isset($hk['diemthi'][0]) ? $hk['diemthi'][0] : '';
									if($id_to == '58293cab32341c1409001469'){
										if($diemthi == 'Đ') $count_trentb ++;
										else if($diemthi=='CĐ') $count_duoitb++;
										else if($diemthi == 'M') $count_mientb++;
									} else {
										$diemthi = doubleval($diemthi);
										if(is_numeric($diemthi)){
											if($diemthi >=0 && $diemthi < 3.5) $count_kem++;
											if($diemthi >=3.5 && $diemthi < 5) $count_yeu++;
											if($diemthi >=5 && $diemthi < 6.5) $count_tb++;
											if($diemthi >=6.5 && $diemthi < 8) $count_kha++;
											if($diemthi >=8 && $diemthi <= 10) $count_gioi++;											
										}
									}
									//$soluong++;
								}
							}
						}
					}
				}
				if($i%2 ==0) $class='eve'; else $class='odd';
				echo '<tr class="'.$class.'">';
				echo '<td class="marks">'.$i.'</td>';
				echo '<td class="marks" style="text-align:left;">'.$gvi['hoten'].'</td>';
				echo '<td class="marks" style="text-align:center;">'.$mh['tenmonhoc'].'</td>';
				echo '<td class="marks" style="text-align:center;">'.implode(", ", $lopday).'</td>';
				echo '<td class="marks border_right">'.format_number($soluong).'</td>';
				$sum_soluong += $soluong;
				if($id_to == '58293cab32341c1409001469'){
					$sum_trungbinh = $count_trentb + $count_duoitb + $count_mientb;
					echo '<td class="marks bg-lighterBlue">'.format_number($count_duoitb).'</td>';
					echo '<td class="marks border_right bg-lighterBlue">'.($sum_trungbinh ? format_decimal(($count_duoitb/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks bg-yellow">'.format_number($count_trentb).'</td>';
					echo '<td class="marks border_right bg-yellow">'.($sum_trungbinh ? format_decimal(($count_trentb/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_mientb).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_mientb/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					$sum_trentb += $count_trentb; $sum_duoitb += $count_duoitb; $sum_mientb += $count_mientb;
				} else {
					$sum_trungbinh = $count_kem + $count_yeu + $count_tb + $count_kha + $count_gioi;
					echo '<td class="marks">'.format_number($count_kem).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_kem/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_yeu).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_yeu/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks bg-lighterBlue">'.format_number($count_kem + $count_yeu).'</td>';
					echo '<td class="marks border_right bg-lighterBlue">'.($sum_trungbinh ? format_decimal((($count_kem+$count_yeu)/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_tb).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_tb/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_kha).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_kha/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_gioi).'</td>';
					echo '<td class="marks border_right">'.($sum_trungbinh ? format_decimal(($count_gioi/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks bg-yellow">'.format_number($count_tb + $count_kha + $count_gioi).'</td>';
					echo '<td class="marks border_right bg-yellow">'.($sum_trungbinh ? format_decimal((($count_tb+$count_kha+$count_gioi)/$sum_trungbinh)*100, 1) . '%' : '').'</td>';
					$sum_kem += $count_kem; $sum_yeu += $count_yeu;
					$sum_tb += $count_tb; $sum_kha += $count_kha; $sum_gioi += $count_gioi;
				}
				echo '</tr>';$i++;
			}
		}
	}
	?>
	<tfoot style="font-weight:bold;">
		<tr>
			<td colspan="4" class="marks" style="text-align:center;">TỔNG CỘNG</td>
			<td class="marks border_right"><?php echo format_number($sum_soluong); ?></td>
		<?php if($id_to == '58293cab32341c1409001469'): ?>
			<?php
			$total_tb = $sum_trentb + $sum_duoitb + $sum_mientb;
			?>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_duoitb); ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo ($total_tb ? format_decimal(($sum_duoitb/$total_tb)*100, 1) . '%' : ''); ?></td>
			<td class="marks bg-yellow"><?php echo format_number($sum_trentb); ?></td>
			<td class="marks border_right bg-yellow"><?php echo ($total_tb ? format_decimal(($sum_trentb/$total_tb)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_mientb); ?></td>
			<td class="marks border_right"><?php echo ($total_tb ? format_decimal(($sum_mientb/$total_tb)*100, 1) . '%' : ''); ?></td>
		<?php else: ?>
			<?php
			$sum_1 = $sum_yeu + $sum_kem;
			$sum_2 = $sum_tb + $sum_kha + $sum_gioi;
			$total = $sum_1 + $sum_2;
			?>
			<td class="marks"><?php echo format_number($sum_kem); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_kem/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_yeu); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_yeu/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_1); ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo ($total ? format_decimal(($sum_1/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_tb); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_tb/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_kha); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_kha/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks"><?php echo format_number($sum_gioi); ?></td>
			<td class="marks border_right"><?php echo ($total ? format_decimal(($sum_gioi/$total)*100, 1) . '%' : ''); ?></td>
			<td class="marks bg-yellow"><?php echo format_number($sum_2); ?></td>
			<td class="marks border_right bg-yellow"><?php echo ($total ? format_decimal(($sum_2/$total)*100, 1) . '%' : ''); ?></td>
		<?php endif;?>
		</tr>
	</tfoot>
	</tbody>
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
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ và Tổ</h3>
<?php endif; ?>
</body>
</html>