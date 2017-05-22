<?php
require_once('header.php');
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();
$hocsinh = new HocSinh();$lophoc = new LopHoc();$monhoc = new MonHoc();
$namhoc_list = $namhoc->get_list_limit(3);
$giaovien_list = $giaovien->get_all_list();
$id_namhoc = ''; $hocky='';$id_monhoc='';
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	$id_giaovien = isset($_GET['id_giaovien']) ? $_GET['id_giaovien'] : '';
}
?>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Thống kê kết quả giảng dạy theo Giáo viên</h1>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		<?php if(isset($msg) && $msg) : ?>
        	$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
    	<?php endif; ?>
    	$(".open_window").click(function(){
		  window.open($(this).attr("href"), '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=100, width=1024, height=800');
		  return false;
		});
	});
</script>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" name="formthongkediembaithi">
Năm học
	<div class="input-control select">
		<select name="id_namhoc" id="id_namhoc" class="select2">
			<?php
			foreach($namhoc_list as $nh){
				echo '<option value="'.$nh['_id'].'" '.($nh['_id']==$id_namhoc ? ' selected' : '').'>'. $nh['tennamhoc'].'</option>';
			}
			?>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Học kỳ
	<div class="input-control select">
		<select name="hocky" id="hocky" class="select2">
			<option value="hocky1" <?php echo $hocky=='hocky1' ? ' selected' : '';?>>Học kỳ I</option>
			<option value="hocky2" <?php echo $hocky=='hocky2' ? ' selected' : '';?>>Học kỳ II</option>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Giáo viên
	<div class="input-control select">
		<select name="id_giaovien" id="id_giaovien" class="select2">
			<option value="">Chọn giáo viên</option>
			<?php
			if($giaovien_list){
				foreach ($giaovien_list as $gv) {
					echo '<option value="'.$gv['_id'].'"'.($gv['_id']==$id_giaovien ? ' selected':'').'>'.$gv['hoten'].'</option>';
				}
			}
			?>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem điểm bài thi</button>
	<?php if(isset($_GET['submit'])): ?>
		<a href="inketquagiangday_3.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In</a>
	<?php endif; ?>
</form>
<hr />
<?php if($id_namhoc && $hocky && $id_giaovien):
$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$giaovien->id = $id_giaovien; $gv = $giaovien->get_one();
$giangday->id_namhoc = $id_namhoc;
$giangday->id_giaovien = $id_giaovien;
$giangday_list = $giangday->get_list_giangday();
$danhsachlop->id_namhoc = $id_namhoc;
$tochuyenmon = new ToChuyenMon();
$tochuyenmon->id_namhoc = $id_namhoc;
$tochuyenmon->id_giaovien = $id_giaovien;
$tcm = $tochuyenmon->get_one_by_giaovien();
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ KẾT QUẢ GIẢNG DẠY THEO GIÁO VIÊN</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Học kỳ: <b><?php echo $hocky=='hocky1' ? 'Học kỳ I' : 'Học kỳ II'; ?></b>&nbsp;&nbsp;&nbsp;
			Giáo viên: <b><?php echo $gv['hoten']; ?></b>
			</p>
		</h4>
		</div>
	</div>
</div>

<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
	<?php if(strval($tcm['id_to']) == '58293cab32341c1409001469'):?>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="140">MÔN</th>
			<th rowspan="2" width="55" class="border_right">LỚP</th>
			<th colspan="2">ĐẠT</th>
			<th colspan="2">CHƯA ĐẠT</th>
			<th colspan="2">MIỄN</th>
		</tr>
		<tr>
			<th>SL</th><th>TL</th>
			<th>SL</th><th>TL</th>
			<th>SL</th><th>TL</th>
		</tr>
	<?php else:?>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="140">MÔN</th>
			<th rowspan="2" width="55" class="border_right">LỚP</th>
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
			<th colspan="2" class="bg-yellow">KÉM</th>
			<th colspan="2" class="bg-yellow">YẾU</th>
			<th colspan="2" class="bg-yellow">TB</th>
			<th colspan="2" class="bg-yellow">KHÁ</th>
			<th colspan="2" class="border_right bg-yellow">GIỎI</th>
			<th colspan="2" class="border_right bg-lighterBlue">DƯỚI TB</th>
			<th colspan="2" class="border_right bg-lighterBlue">TRÊN TB</th>
		</tr>
		<tr>
			<th class="bg-yellow">SL</th><th class="bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
		</tr>
	<?php endif ?>
	</thead>
	<tbody>
	<?php
	$stt=1;
	$sum_0_05 = 0;$sum_05_1 = 0;$sum_1_15 = 0;$sum_15_2 = 0;
	$sum_2_25 = 0;$sum_25_3 = 0;$sum_3_35 = 0;$sum_35_4 = 0;
	$sum_4_45 = 0;$sum_45_5 = 0;$sum_5_55 = 0;$sum_55_6 = 0;
	$sum_6_65 = 0;$sum_65_7 = 0;$sum_7_75 = 0;$sum_75_8 = 0;
	$sum_8_85 = 0;$sum_85_9 = 0;$sum_9_95 = 0;$sum_95_10 = 0;$sum_10=0;
	$sum_duoitb=0; $sum_trentb=0;$sum_tbmien = 0;
	$sum_kem = 0; $sum_yeu=0; $sum_tb=0;$sum_kha=0;$sum_gioi=0;
	if($giangday_list){
		foreach ($giangday_list as $gd) {
			if($stt%2 ==0) $class='eve'; else $class='odd';
			$monhoc->id = $gd['id_monhoc'];$mh = $monhoc->get_one();$mamonhoc = $mh['mamonhoc'];
			$lophoc->id = $gd['id_lophoc']; $lh = $lophoc->get_one();
			$danhsachlop->id_lophoc = $gd['id_lophoc'];
			$danhsachlop_list = $danhsachlop->get_danh_sach_lop_except_nghiluon_hocky($hocky);
			$count_0_05 = 0;$count_05_1 = 0;$count_1_15 = 0;$count_15_2 = 0;
			$count_2_25 = 0;$count_25_3 = 0;$count_3_35 = 0;$count_35_4 = 0;
			$count_4_45 = 0;$count_45_5 = 0;$count_5_55 = 0;$count_55_6 = 0;
			$count_6_65 = 0;$count_65_7 = 0;$count_7_75 = 0;$count_75_8 = 0;
			$count_8_85 = 0;$count_85_9 = 0;$count_9_95 = 0;$count_95_10 = 0;$count_10=0;
			$count_duoitb=0; $count_trentb=0;$count_tbmien = 0;
			$count_kem = 0; $count_yeu=0; $count_tb=0;$count_kha=0;$count_gioi=0;
			if($danhsachlop_list){
				foreach ($danhsachlop_list as $ds) {
					if(isset($ds[$hocky]) && $ds[$hocky]){
						$count_mien = 0; $count_d = 0; $count_cd=0;$trungbinh='';
						$count_cotmieng = 0; $sum_cotmieng = 0;$count_cot15phut = 0; $sum_cot15phut = 0;
						$count_cot1tiet = 0; $sum_cot1tiet = 0;$diemthi = '';
						foreach($ds[$hocky] as $hk){
							if($hk['id_monhoc'] == $gd['id_monhoc']){
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
									if($trungbinh >= 0 && $trungbinh < 0.5)   $count_0_05++;
									if($trungbinh >= 0.5 && $trungbinh < 1) 	$count_05_1++;
									if($trungbinh >= 1 && $trungbinh < 1.5) 	$count_1_15++;
									if($trungbinh >= 1.5 && $trungbinh < 2) 	$count_15_2++;
									if($trungbinh >= 2    && $trungbinh < 2.5) 	$count_2_25++;
									if($trungbinh >= 2.5  && $trungbinh < 3) 	$count_25_3++;
									if($trungbinh >= 3    && $trungbinh < 3.5) 	$count_3_35++;
									if($trungbinh >= 3.5  && $trungbinh < 4) 	$count_35_4++;
									if($trungbinh >= 4    && $trungbinh < 4.5) 	$count_4_45++;
									if($trungbinh >= 4.5  && $trungbinh < 5) 	$count_45_5++;
									if($trungbinh >= 5    && $trungbinh < 5.5) 	$count_5_55++;
									if($trungbinh >= 5.5  && $trungbinh < 6) 	$count_55_6++;
									if($trungbinh >= 6    && $trungbinh < 6.5) 	$count_6_65++;
									if($trungbinh >= 6.5  && $trungbinh < 7) 	$count_65_7++;
									if($trungbinh >= 7    && $trungbinh < 7.5) 	$count_7_75++;
									if($trungbinh >= 7.5  && $trungbinh < 8) 	$count_75_8++;
									if($trungbinh >= 8    && $trungbinh < 8.5) 	$count_8_85++;
									if($trungbinh >= 8.5  && $trungbinh < 9) 	$count_85_9++;
									if($trungbinh >= 9    && $trungbinh < 9.5) 	$count_9_95++;
									if($trungbinh >= 9.5  && $trungbinh < 10) 	$count_95_10++;
									if($trungbinh == 10) $count_10++;

									if($trungbinh >=0 && $trungbinh < 3.5) $count_kem++;
									if($trungbinh >=3.5 && $trungbinh < 5) $count_yeu++;
									if($trungbinh >=5 && $trungbinh < 6.5) $count_tb++;
									if($trungbinh >=6.5 && $trungbinh < 8) $count_kha++;
									if($trungbinh >=8 && $trungbinh <= 10) $count_gioi++;

									if($trungbinh < 5) $count_duoitb++;
									if($trungbinh >=5) $count_trentb++;
								}
							}
						}
					}
				}
			}
			if($tcm['id_to'] == '58293cab32341c1409001469'){
				$sum_trungbinh = $count_trentb + $count_duoitb + $count_tbmien;
				echo '<tr class="'.$class.'">';
				echo '<td class="marks">'.$stt.'</td>';
				echo '<td class="marks" style="text-align:left;">'.$mh['tenmonhoc'].'</td>';
				echo '<td class="marks border_right" style="text-align:left;">'.$lh['tenlophoc'].'</td>';
				echo '<td class="marks">'.format_number($count_trentb).'</td>';
				echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_trentb/$sum_trungbinh*100,1) : '').'%</td>';
				echo '<td class="marks">'.format_number($count_duoitb).'</td>';
				echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_duoitb/$sum_trungbinh*100,1) : '').'%</td>';
				echo '<td class="marks">'.format_number($count_tbmien).'</td>';
				echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_tbmien/$sum_trungbinh*100,1) : '').'%</td>';
				echo '</tr>';$stt++;
				$sum_trentb += $count_trentb; $sum_duoitb += $count_duoitb; $sum_tbmien += $count_tbmien;
			} else {
				$sum_trungbinh = $count_duoitb + $count_trentb;
				echo '<tr class="'.$class.'">';
				echo '<td class="marks">'.$stt.'</td>';
				echo '<td class="marks" style="text-align:left;">'.$mh['tenmonhoc'].'</td>';
				echo '<td class="marks border_right" style="text-align:left;">'.$lh['tenlophoc'].'</td>';
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
				echo '<td class="marks bg-yellow">'.format_number($count_kem).'</td>';
				echo '<td class="marks bg-yellow">'.($sum_trungbinh ? format_decimal($count_kem/$sum_trungbinh*100, 1) : '').'%</td>';
				echo '<td class="marks bg-yellow">'.format_number($count_yeu).'</td>';
				echo '<td class="marks bg-yellow">'.($sum_trungbinh ? format_decimal($count_yeu/$sum_trungbinh*100, 1) : '').'%</td>';
				echo '<td class="marks bg-yellow">'.format_number($count_tb).'</td>';
				echo '<td class="marks bg-yellow">'.($sum_trungbinh ? format_decimal($count_tb/$sum_trungbinh*100, 1) : '').'%</td>';
				echo '<td class="marks bg-yellow">'.format_number($count_kha).'</td>';
				echo '<td class="marks bg-yellow">'.($sum_trungbinh ? format_decimal($count_kha/$sum_trungbinh*100, 1) : '').'%</td>';
				echo '<td class="marks bg-yellow">'.format_number($count_gioi).'</td>';
				echo '<td class="marks bg-yellow border_right">'.($sum_trungbinh ? format_decimal($count_gioi/$sum_trungbinh*100, 1) : '').'%</td>';
				echo '<td class="marks bg-lighterBlue">'.$count_duoitb.'</td>';
				echo '<td class="marks border_right bg-lighterBlue">'.($sum_trungbinh ? format_decimal(($count_duoitb/($sum_trungbinh))*100,1) .'%' : '').'</td>';
				echo '<td class="marks bg-lighterBlue">'.$count_trentb.'</td>';
				echo '<td class="marks border_right bg-lighterBlue">'.($sum_trungbinh ? format_decimal(($count_trentb/($sum_trungbinh))*100,1) .'%' : '').'</td>';
				echo '</tr>';$stt++;
				$sum_0_05 += $count_0_05;$sum_05_1 += $count_05_1;$sum_1_15 += $count_1_15;$sum_15_2 += $count_15_2;
				$sum_2_25 += $count_2_25;$sum_25_3 += $count_25_3;$sum_3_35 += $count_25_3;$sum_35_4 += $count_35_4;
				$sum_4_45 += $count_4_45;$sum_45_5 += $count_45_5;$sum_5_55 += $count_5_55;$sum_55_6 += $count_55_6;
				$sum_6_65 += $count_6_65;$sum_65_7 += $count_65_7;$sum_7_75 += $count_7_75;$sum_75_8 += $count_75_8;
				$sum_8_85 += $count_8_85;$sum_85_9 += $count_85_9;$sum_9_95 += $count_9_95;$sum_95_10 += $count_95_10;$sum_10+=$count_10;
				$sum_duoitb+=$count_duoitb; $sum_trentb+=$count_trentb;
				$sum_kem += $count_kem; $sum_yeu+=$count_yeu; $sum_tb+=$count_tb;$sum_kha+=$count_kha;$sum_gioi+=$count_gioi;
			}
		}
	}
	?>
	<?php if($tcm['id_to'] == '58293cab32341c1409001469'): ?>
		<tr style="font-weight:bold;">
			<?php
			$total_hocluc = $sum_duoitb + $sum_trentb + $sum_tbmien;
			?>
			<td colspan="3" class="marks border_right" style="text-align:center;">TỔNG CỘNG</td>
			<td class="marks"><?php echo format_number($sum_trentb); ?></td>
			<td class="marks"><?php echo $total_hocluc ? format_number($sum_trentb/$total_hocluc*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo format_number($sum_duoitb); ?></td>
			<td class="marks"><?php echo $total_hocluc ? format_number($sum_duoitb/$total_hocluc*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo format_number($sum_tbmien); ?></td>
			<td class="marks"><?php echo $total_hocluc ? format_number($sum_tbmien/$total_hocluc*100,1) : '0'; ?>%</td>
		</tr>
	<?php else: ?>
		<?php
			$total_hocluc = $sum_kem + $sum_yeu + $sum_tb + $sum_kha + $sum_gioi;
			$total_trungbinh = $sum_duoitb + $sum_trentb;
		?>
		<tr class="bg-grayLight">
			<td colspan="3" class="marks border_right">TỔNG CỘNG</td>
			<td class="marks"><?php echo $sum_0_05; ?></td>
			<td class="marks"><?php echo $sum_05_1; ?></td>
			<td class="marks"><?php echo $sum_1_15; ?></td>
			<td class="marks"><?php echo $sum_15_2; ?></td>
			<td class="marks"><?php echo $sum_2_25; ?></td>
			<td class="marks"><?php echo $sum_25_3; ?></td>
			<td class="marks"><?php echo $sum_3_35; ?></td>
			<td class="marks"><?php echo $sum_35_4; ?></td>
			<td class="marks"><?php echo $sum_4_45; ?></td>
			<td class="marks border_right"><?php echo $sum_45_5; ?></td>
			<td class="marks"><?php echo $sum_5_55; ?></td>
			<td class="marks"><?php echo $sum_55_6; ?></td>
			<td class="marks"><?php echo $sum_6_65; ?></td>
			<td class="marks"><?php echo $sum_65_7; ?></td>
			<td class="marks"><?php echo $sum_7_75; ?></td>
			<td class="marks"><?php echo $sum_75_8; ?></td>
			<td class="marks"><?php echo $sum_8_85; ?></td>
			<td class="marks"><?php echo $sum_85_9; ?></td>
			<td class="marks"><?php echo $sum_9_95; ?></td>
			<td class="marks"><?php echo $sum_95_10; ?></td>
			<td class="marks border_right"><?php echo $sum_10; ?></td>
			<td class="marks"><?php echo $sum_kem; ?></td>
			<td class="marks"><?php echo $total_hocluc ? format_decimal($sum_kem/$total_hocluc*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo $sum_yeu; ?></td>
			<td class="marks"><?php echo $total_hocluc ? format_decimal($sum_yeu/$total_hocluc*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo $sum_tb; ?></td>
			<td class="marks"><?php echo $total_hocluc ? format_decimal($sum_tb/$total_hocluc*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo $sum_kha; ?></td>
			<td class="marks"><?php echo $total_hocluc ? format_decimal($sum_kha/$total_hocluc*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo $sum_gioi; ?></td>
			<td class="marks border_right"><?php echo $total_hocluc ? format_decimal($sum_gioi/$total_hocluc*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo $sum_duoitb; ?></td>
			<td class="marks border_right"><?php echo $total_trungbinh ? format_decimal($sum_duoitb/$total_trungbinh*100,1) : '0'; ?>%</td>
			<td class="marks"><?php echo $sum_trentb; ?></td>
			<td class="marks border_right"><?php echo $total_trungbinh ? format_decimal($sum_trentb/$total_trungbinh*100,1) : '0'; ?>%</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>


<?php else : ?>
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ và Giáo viên</h3>
<?php endif; ?>
<?php require_once('footer.php'); ?>

