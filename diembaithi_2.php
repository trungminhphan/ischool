<?php
require_once('header.php');
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
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Thống kê điểm bài thi theo Khối</h1>
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
	&nbsp;&nbsp;&nbsp;Khối
	<div class="input-control select">
		<select name="khoi" id="khoi" class="select2">
			<?php
			if($arr_khoi){
				foreach ($arr_khoi as $key => $value) {
					echo '<option value="'.$key.'"'.($khoi==$key ? ' selected':'').'>'.$value.'</option>';
				}
			}
			?>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem điểm bài thi</button>
	<?php if(isset($_GET['submit'])) : ?>
		<a href="indiembaithi_2.html?<?php echo $_SERVER['QUERY_STRING']; ?>" class="open_window button"><span class="mif-print"></span> In</a>
	<?php endif; ?>
</form>
<hr />
<?php if($id_namhoc && $hocky && $khoi):
$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$monhoc_list = $monhoc->get_all_list();
$list_khoi = $lophoc->get_list_to_khoi($khoi);
$arr_lophoc = array();
foreach ($list_khoi as $key => $value) {
	array_push($arr_lophoc, new MongoId($value['_id']));
}

$danhsachlop->id_namhoc = $id_namhoc;
$danhsachlop->arr_lophoc = $arr_lophoc;
$danhsachlop_list = $danhsachlop->get_danh_sach_lop_theo_khoi_tk($hocky);
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ ĐIỂM THI</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Khối: <b><?php echo $khoi; ?></b>&nbsp;&nbsp;&nbsp;
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
			<th colspan="2" class="border_right bg-yellow">TRÊN TB</th>
			<th colspan="2" class="border_right bg-lighterBlue">CHƯA ĐẠT</th>
			<th colspan="2" class="border_right bg-lighterBlue">ĐẠT</th>
			<th colspan="2" class="border_right bg-lighterBlue">MIỄN</th>
		</tr><tr>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$stt=1;
	$sum_0_05 = 0;$sum_05_1 = 0;$sum_1_15 = 0;$sum_15_2 = 0;
	$sum_2_25 = 0;$sum_25_3 = 0;$sum_3_35 = 0;$sum_35_4 = 0;
	$sum_4_45 = 0;$sum_45_5 = 0;$sum_5_55 = 0;$sum_55_6 = 0;
	$sum_6_65 = 0;$sum_65_7 = 0;$sum_7_75 = 0;$sum_75_8 = 0;
	$sum_8_85 = 0;$sum_85_9 = 0;$sum_9_95 = 0;$sum_95_10 = 0; $sum_10=0;
	$sum_duoitb=0; $sum_trentb=0;$sum_soluong = 0;
	$sum_d = 0; $sum_cd=0;$sum_m = 0;
	foreach($monhoc_list as $mh){
		$mamonhoc = $mh['mamonhoc'];
		if($stt%2 ==0) $class='eve'; else $class='odd';
		$count_0_05 = 0;$count_05_1 = 0;$count_1_15 = 0;$count_15_2 = 0;
		$count_2_25 = 0;$count_25_3 = 0;$count_3_35 = 0;$count_35_4 = 0;
		$count_4_45 = 0;$count_45_5 = 0;$count_5_55 = 0;$count_55_6 = 0;
		$count_6_65 = 0;$count_65_7 = 0;$count_7_75 = 0;$count_75_8 = 0;
		$count_8_85 = 0;$count_85_9 = 0;$count_9_95 = 0;$count_95_10 = 0; $count_10=0;
		$count_duoitb=0; $count_trentb=0;$count_mientb = 0;//$soluong=0;
		$count_d = 0; $count_cd=0;$count_m=0;
		$soluong = $danhsachlop_list->count();
		if($danhsachlop_list){
			foreach ($danhsachlop_list as $ds) {
				if(isset($ds[$hocky]) && $ds[$hocky]){
					foreach($ds[$hocky] as $hk){
						if($hk['id_monhoc'] == $mh['_id']){					
							if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'){
								$diemthi = isset($hk['diemthi'][0]) ? $hk['diemthi'][0] : '';
								if($diemthi == 'Đ') $count_d++;
								else if($diemthi == 'CĐ') $count_cd++;
								else if($diemthi == 'M') $count_m++;
							} else {
								$diemthi = isset($hk['diemthi'][0]) ? doubleval($hk['diemthi'][0]) : '';
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
			}
		}

		echo '<tr class="'.$class.'">';
		echo '<td class="marks">'.$stt.'</td>';
		echo '<td class="marks" style="text-align:left;">'.$mh['tenmonhoc'].'</td>';
		echo '<td class="marks border_right">'.$soluong.'</td>';
		if($mamonhoc == 'MYTHUAT' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'THEDUC'){
			$sum_trungbinh = $count_d + $count_cd + $count_m;
			$sum_d += $count_d; $sum_cd += $count_cd; $sum_m += $count_m;
			for($c=0; $c<25; $c++){
				if($c == 9 || $c == 20){
					$class = 'border_right';
				} else if($c == 21 || $c == 23){
					$class = 'bg-yellow';
				} else if($c == 22 || $c==24){
					$class = 'border_right bg-yellow';
				} else {
					$class = '';
				}

				echo '<td class="marks '.$class.'"></td>';
				
			}

			echo '<td class="marks bg-lighterBlue">'.$count_d.'</td>';
			echo '<td class="marks bg-lighterBlue border_right">'.($sum_trungbinh ? format_decimal($count_d/$sum_trungbinh*100,1) : '0').'%</td>';
			echo '<td class="marks bg-lighterBlue">'.$count_cd.'</td>';
			echo '<td class="marks bg-lighterBlue border_right">'.($sum_trungbinh ? format_decimal($count_cd/$sum_trungbinh*100,1) : '0').'%</td>';
			echo '<td class="marks bg-lighterBlue">'.$count_m.'</td>';
			echo '<td class="marks bg-lighterBlue border_right">'.($sum_trungbinh ? format_decimal($count_m/$sum_trungbinh*100,1) : '0').'%</td>';
		} else {
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
			echo '<td class="marks border_right bg-yellow">'.($count_duoitb ? format_decimal(($count_duoitb/($count_duoitb+$count_trentb))*100,1) : '0').'%</td>';
			echo '<td class="marks bg-yellow">'.$count_trentb.'</td>';
			echo '<td class="marks border_right bg-yellow">'.($count_trentb ? format_decimal(($count_trentb/($count_duoitb+$count_trentb))*100,1) : '0').'%</td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue border_right"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue border_right"></td>';
			echo '<td class="marks bg-lighterBlue"></td>';
			echo '<td class="marks bg-lighterBlue border_right"></td>';
			$sum_0_05 += $count_0_05;$sum_05_1 += $count_05_1;$sum_1_15 += $count_1_15;
			$sum_15_2 += $count_15_2;$sum_2_25 += $count_2_25;$sum_25_3 += $count_25_3;
			$sum_3_35 += $count_3_35;$sum_35_4 += $count_35_4;$sum_4_45 += $count_4_45;
			$sum_45_5 += $count_45_5;$sum_5_55 += $count_5_55;$sum_55_6 += $count_55_6;
			$sum_6_65 += $count_6_65;$sum_65_7 += $count_65_7;$sum_7_75 += $count_7_75;
			$sum_75_8 += $count_75_8;$sum_8_85 += $count_8_85;$sum_85_9 += $count_85_9;
			$sum_9_95 += $count_9_95;$sum_95_10 += $count_95_10;$sum_10 += $count_10;
			$sum_duoitb += $count_duoitb; $sum_trentb+=$count_trentb;
			$sum_soluong += $soluong;
		}
		echo '</tr>'; $stt++;
	}
	?>
	</tbody>
	<tfoot>
	<?php
	$sum1 = $sum_trentb + $sum_duoitb;
	$sum2 = $sum_d + $sum_cd + $sum_m;
	?>
		<tr style="font-weight:bold;">
			<td class="marks" colspan="2" style="text-align:center;">TỔNG CỘNG</td>
			<td class="marks border_right"><?php echo format_number($sum_soluong); ?></td>
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
			<td class="marks bg-yellow"><?php echo format_number($sum_duoitb); ?></td>
			<td class="marks border_right bg-yellow"><?php echo $sum1 ? format_decimal($sum_duoitb/$sum1*100,1): '0'; ?>%</td>
			<td class="marks bg-yellow"><?php echo format_number($sum_trentb); ?></td>
			<td class="marks border_right bg-yellow"><?php echo $sum1 ? format_decimal($sum_trentb/$sum1*100,1): '0'; ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_d); ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $sum2 ? format_decimal($sum_d/$sum2*100,1): '0'; ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_cd); ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $sum2 ? format_decimal($sum_cd/$sum2*100,1): '0'; ?>%</td>
			<td class="marks bg-lighterBlue"><?php echo format_number($sum_m); ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $sum2 ? format_decimal($sum_m/$sum2*100,1): '0'; ?>%</td>
		</tr>
	</tfoot>
</table>
<?php else : ?>
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ và Khối</h3>
<?php endif; ?>
<?php require_once('footer.php'); ?>


