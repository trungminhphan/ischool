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
	$id_to = isset($_GET['id_to']) ? $_GET['id_to'] : '';
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
		<h3>THỐNG KÊ KẾT QUẢ GIẢNG DẠY THEO TỔ</h3>
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
		<?php if($id_to == '58293cab32341c1409001469'): ?>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="150">HỌ TÊN GIÁO VIÊN</th>
			<th rowspan="2" width="50">MÔN DẠY</th>
			<th rowspan="2" width="120">LỚP DẠY</th>
			<th rowspan="2" width="55" class="border_right">SỐ LƯỢNG</th>
			<th colspan="2">ĐẠT</th>
			<th colspan="2">CHƯA ĐẠT</th>
			<th colspan="2">MIỄN</th>
		</tr>
		<tr>
			<th>SL</th><th>TL</th>
			<th>SL</th><th>TL</th>
			<th>SL</th><th>TL</th>
		</tr>
		<?php else: ?>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="150">HỌ TÊN GIÁO VIÊN</th>
			<th rowspan="2" width="50">MÔN DẠY</th>
			<th rowspan="2" width="120">LỚP DẠY</th>
			<th rowspan="2" width="55" class="border_right">SỐ LƯỢNG</th>
			<th colspan="2" class="border_right">KÉM</th>
			<th colspan="2" class="border_right">YẾU</th>
			<th colspan="2" class="border_right bg-lighterBlue">TỔNG</th>
			<th colspan="2" class="border_right">TRUNG BÌNH</th>
			<th colspan="2" class="border_right">KHÁ</th>
			<th colspan="2" class="border_right">GIỎI</th>
			<th colspan="2" class="border_right bg-yellow">TỔNG</th>
		</tr><tr>
			<th>SL</th><th class="border_right">TL</th>
			<th>SL</th><th class="border_right">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th>SL</th><th class="border_right">TL</th>
			<th>SL</th><th class="border_right">TL</th>
			<th>SL</th><th class="border_right">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
		</tr>
		<?php endif; ?>
	</thead>
	<tbody>
	<?php
	$stt=1;
	if($giaovien_list){
		$i=1; $sum_gioi = 0; $sum_kha=0;$sum_tb=0;$sum_yeu=0;$sum_kem=0;
		$sum_trentb = 0; $sum_duoitb=0;$sum_tbmien=0;$sum_soluong=0;
		$sum_1= 0;$sum_2=0;
		foreach ($giaovien_list as $key => $value) {
			$giaovien->id = $value; $gvi=$giaovien->get_one();
			$giangday->id_giaovien = $value;
			$monhoc_list = $giangday->get_distinct_monhoc_1();
			foreach ($monhoc_list as $mk => $mv) {
				$monhoc->id = $mv;$mh = $monhoc->get_one();$mamonhoc = $mh['mamonhoc'];
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
				$soluong = 0;$count_trentb=0;$count_duoitb=0;$count_tbmien=0;
				if($danhsachlop_list){
					foreach ($danhsachlop_list as $ds) {
						if(isset($ds[$hocky]) && $ds[$hocky]){
							$count_mien = 0; $count_d = 0; $count_cd=0;$trungbinh='';
							$count_cotmieng = 0; $sum_cotmieng = 0;$count_cot15phut = 0; $sum_cot15phut = 0;
							$count_cot1tiet = 0; $sum_cot1tiet = 0;$diemthi = '';
							foreach($ds[$hocky] as $hk){
								if($hk['id_monhoc'] == $mv){
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

									//tinh diem trung binh
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
									$soluong++;
								}
							}
							
						}
					}
				}

				if($id_to == '58293cab32341c1409001469'){
					if($i%2 ==0) $class='eve'; else $class='odd';
					$sum_trungbinh = $count_trentb + $count_duoitb + $count_tbmien;
					echo '<tr class="'.$class.'">';
					echo '<td class="marks">'.$i.'</td>';
					echo '<td class="marks" style="text-align:left;">'.$gvi['hoten'].'</td>';
					echo '<td class="marks" style="text-align:center;">'.$mh['tenmonhoc'].'</td>';
					echo '<td class="marks" style="text-align:center;">'.implode(", ", $lopday).'</td>';
					echo '<td class="marks border_right">'.format_number($soluong).'</td>';
					echo '<td class="marks">'.format_number($count_trentb).'</td>';
					echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_trentb/$sum_trungbinh*100,1) : '').'%</td>';
					echo '<td class="marks">'.format_number($count_duoitb).'</td>';
					echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_duoitb/$sum_trungbinh*100,1) : '').'%</td>';
					echo '<td class="marks">'.format_number($count_tbmien).'</td>';
					echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_tbmien/$sum_trungbinh*100,1) : '').'%</td>';
					echo '</tr>';
					$sum_trentb += $count_trentb; $sum_duoitb += $count_duoitb; $sum_tbmien += $count_tbmien;
					$sum_soluong += $soluong;
				} else {
					if($i%2 ==0) $class='eve'; else $class='odd';
					$count_1 = $count_yeu + $count_kem;
					$count_2 = $count_gioi + $count_kha + $count_tb;
					$count_all = $count_1 + $count_2;
					echo '<tr class="'.$class.'">';
					echo '<td class="marks">'.$i.'</td>';
					echo '<td class="marks" style="text-align:left;">'.$gvi['hoten'].'</td>';
					echo '<td class="marks" style="text-align:center;">'.$mh['tenmonhoc'].'</td>';
					echo '<td class="marks" style="text-align:center;">'.implode(", ", $lopday).'</td>';
					echo '<td class="marks border_right">'.format_number($soluong).'</td>';
					echo '<td class="marks">'.format_number($count_kem).'</td>';
					echo '<td class="marks border_right">'.($count_all ? format_decimal(($count_kem/$count_all)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_yeu).'</td>';
					echo '<td class="marks border_right">'.($count_all ? format_decimal(($count_yeu/$count_all)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks bg-lighterBlue">'.format_number($count_1).'</td>';
					echo '<td class="marks border_right bg-lighterBlue">'.($count_all ? format_decimal((($count_1)/$count_all)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_tb).'</td>';
					echo '<td class="marks border_right">'.($count_all ? format_decimal(($count_tb/$count_all)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_kha).'</td>';
					echo '<td class="marks border_right">'.($count_all ? format_decimal(($count_kha/$count_all)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks">'.format_number($count_gioi).'</td>';
					echo '<td class="marks border_right">'.($count_all ? format_decimal(($count_gioi/$count_all)*100, 1) . '%' : '').'</td>';
					echo '<td class="marks bg-yellow">'.format_number($count_2).'</td>';
					echo '<td class="marks border_right bg-yellow">'.($count_all ? format_decimal((($count_2)/$count_all)*100, 1) . '%' : '').'</td>';
					echo '</tr>';
					$sum_gioi += $count_gioi; $sum_kha += $count_kha; $sum_tb += $count_tb;
					$sum_yeu += $count_yeu; $sum_kem += $count_kem;$sum_soluong += $soluong;
				}
				$i++;
			}
		}
	}
	?>
	<tfoot style="font-weight: bold;">
	<?php if($id_to == '58293cab32341c1409001469'): ?>
		<?php
		$sum_hl = $sum_trentb + $sum_duoitb + $sum_tbmien;
		?>
		<tr>
			<td class="marks" colspan="4" style="text-align:center">TỔNG CỘNG</td>
			<td class="marks border_right"><?php echo format_number($sum_soluong); ?></td>
			<td class="marks"><?php echo format_number($sum_trentb); ?></td>
			<td class="marks"><?php echo $sum_hl ? format_decimal($sum_trentb/$sum_hl*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo format_number($sum_duoitb); ?></td>
			<td class="marks"><?php echo $sum_hl ? format_decimal($sum_duoitb/$sum_hl*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo format_number($sum_tbmien); ?></td>
			<td class="marks"><?php echo $sum_hl ? format_decimal($sum_tbmien/$sum_hl*100,1) : '0'; ?>%</td>
		</tr>
	<?php else: ?>
		<?php
		$sum_1 = $sum_yeu + $sum_kem;
		$sum_2 = $sum_gioi + $sum_kha + $sum_tb;
		$sum = $sum_1 + $sum_2;
		?>
		<tr>
			<td class="marks" colspan="4" style="text-align:center">TỔNG CỘNG</td>
			<td class="marks border_right"><?php echo format_number($sum_soluong); ?></td>
			<td class="marks"><?php echo format_number($sum_kem); ?></td>
			<td class="marks border_right"><?php echo $sum ? format_decimal($sum_kem/$sum*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo format_number($sum_yeu); ?></td>
			<td class="marks border_right"><?php echo $sum ? format_decimal($sum_yeu/$sum*100,1) : '0'; ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_1); ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $sum ? format_decimal($sum_1/$sum*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo format_number($sum_tb); ?></td>
			<td class="marks border_right"><?php echo $sum ? format_decimal($sum_tb/$sum*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo format_number($sum_kha); ?></td>
			<td class="marks border_right"><?php echo $sum ? format_decimal($sum_kha/$sum*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo format_number($sum_gioi); ?></td>
			<td class="marks border_right"><?php echo $sum ? format_decimal($sum_gioi/$sum*100,1) : '0'; ?>%</td>
			<td class="marks bg-yellow"><?php echo format_number($sum_2); ?></td>
			<td class="marks border_right bg-yellow"><?php echo $sum ? format_decimal($sum_2/$sum*100,1) : '0'; ?>%</td>
		</tr>
	<?php endif; ?>	
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