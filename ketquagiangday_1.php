<?php
require_once('header.php');
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
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Kết quả giảng dạy theo Môn học</h1>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript" src="js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".select2").select2();
		<?php if(isset($msg) && $msg) : ?>
        	$.Notify({type: 'alert', caption: 'Thông báo', content: <?php echo "'".$msg."'"; ?>});
    	<?php endif; ?>
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
	&nbsp;&nbsp;&nbsp;Môn học
	<div class="input-control select">
		<select name="id_monhoc" id="id_monhoc" class="select2">
			<?php
			if($monhoc_list){
				foreach ($monhoc_list as $mh) {
					echo '<option value="'.$mh['_id'].'"'.($id_monhoc==$mh['_id'] ? ' selected':'').'>'.$mh['tenmonhoc'].'</option>';
				}
			}
			?>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem kết quả</button>
</form>
<hr />
<?php if($id_namhoc && $hocky && $id_monhoc):
$danhsachlop->id_namhoc = $id_namhoc;
$giangday->id_monhoc = $id_monhoc;
$giangday->id_namhoc = $id_namhoc; 

$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$monhoc->id = $id_monhoc; $m = $monhoc->get_one();
$mamonhoc = $m['mamonhoc'];
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ KẾT QUẢ GIẢNG DẠY</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Môn học: <b><?php echo $m['tenmonhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Học kỳ: <b><?php echo $hocky=='hocky1' ? 'Học kỳ I' : 'Học kỳ II'; ?></b></p>
		</h4>
		</div>
	</div>
</div>
<?php if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
<?php else: ?>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center" style="width:1920px;">
<?php endif; ?>
	<thead>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="140">Giáo viên</th>
			<th rowspan="2" width="50">Lớp</th>
			<th rowspan="2" class="border_right">Sỉ số</th>
			<th colspan="2">CHƯA ĐẠT</th>
			<th colspan="2">ĐẠT</th>
			<th colspan="2">MIỄN</th>
		</tr>
		<tr>
			<th>SL</th><th>TL</th>
			<th>SL</th><th>TL</th>
			<th>SL</th><th>TL</th>
		</tr>
	<?php else : ?>
		<tr>
			<th rowspan="2">STT</th>
			<th rowspan="2" width="140">Giáo viên</th>
			<th rowspan="2" width="50">Lớp</th>
			<th rowspan="2" class="border_right">Sỉ số</th>
			<?php
			for($i=0; $i<10.5; $i=$i+0.5){
				$j = $i + 0.5;
				if($i==4.5){
					echo '<th rowspan="2" class="border_right">'.$i.'<br /><' .$j .'</th>';
				} else if($i ==10 ){
					echo '<th rowspan="2" class="border_right">'.$i.'</th>';
				} else {
					echo '<th rowspan="2">'.$i.'<br /><' .$j .'</th>';
				}
			}
			?>
			<th colspan="2" class="border_right bg-yellow">KÉM</th>
			<th colspan="2" class="border_right bg-yellow">YẾU</th>
			<th colspan="2" class="border_right bg-yellow">TB</th>
			<th colspan="2" class="border_right bg-yellow">KHÁ</th>
			<th colspan="2" class="border_right bg-yellow">GIỎI</th>
			<th colspan="2" class="border_right bg-lighterBlue">DƯỚI TB</th>
			<th colspan="2" class="border_right bg-lighterBlue">TRÊN TB</th>
		</tr>
		<tr>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
		</tr>
	<?php endif;?>
	</thead>
	<tbody>
	<?php
	$stt=1;
	$count_0_05_thcs = 0;$count_05_1_thcs = 0;$count_1_15_thcs = 0;$count_15_2_thcs = 0;
	$count_2_25_thcs = 0;$count_25_3_thcs = 0;$count_3_35_thcs = 0;$count_35_4_thcs = 0;
	$count_4_45_thcs = 0;$count_45_5_thcs = 0;$count_5_55_thcs = 0;$count_55_6_thcs = 0;
	$count_6_65_thcs = 0;$count_65_7_thcs = 0;$count_7_75_thcs = 0;$count_75_8_thcs = 0;
	$count_8_85_thcs = 0;$count_85_9_thcs = 0;$count_9_95_thcs = 0;$count_95_10_thcs = 0;$count_10_thcs=0;
	$count_duoitb_thcs=0; $count_trentb_thcs=0; $count_mientb_thcs=0;$total_siso_thcs = 0;
	$count_kem_thcs = 0; $count_yeu_thcs=0; $count_tb_thcs=0;$count_kha_thcs=0;$count_gioi_thcs=0;
	foreach($arr_thcs as $khoi){
		$list_khoi = $lophoc->get_list_to_khoi($khoi);
		if($list_khoi){
			$count_0_05_khoi = 0;$count_05_1_khoi = 0;$count_1_15_khoi = 0;$count_15_2_khoi = 0;
			$count_2_25_khoi = 0;$count_25_3_khoi = 0;$count_3_35_khoi = 0;$count_35_4_khoi = 0;
			$count_4_45_khoi = 0;$count_45_5_khoi = 0;$count_5_55_khoi = 0;$count_55_6_khoi = 0;
			$count_6_65_khoi = 0;$count_65_7_khoi = 0;$count_7_75_khoi = 0;$count_75_8_khoi = 0;
			$count_8_85_khoi = 0;$count_85_9_khoi = 0;$count_9_95_khoi = 0;$count_95_10_khoi = 0;$count_10_khoi=0;
			$count_duoitb_khoi=0; $count_trentb_khoi=0; $count_mientb_khoi=0; $total_siso = 0;
			$count_kem_khoi = 0; $count_yeu_khoi=0; $count_tb_khoi=0;$count_kha_khoi=0;$count_gioi_khoi=0;
			foreach($list_khoi as $ko){
				$count_0_05 = 0;$count_05_1 = 0;$count_1_15 = 0;$count_15_2 = 0;
				$count_2_25 = 0;$count_25_3 = 0;$count_3_35 = 0;$count_35_4 = 0;
				$count_4_45 = 0;$count_45_5 = 0;$count_5_55 = 0;$count_55_6 = 0;
				$count_6_65 = 0;$count_65_7 = 0;$count_7_75 = 0;$count_75_8 = 0;
				$count_8_85 = 0;$count_85_9 = 0;$count_9_95 = 0;$count_95_10 = 0; $count_10=0;
				$siso=0;
				$danhsachlop->id_lophoc = $ko['_id'];
				$danhsachlop_list = $danhsachlop->get_danh_sach_lop_tk($hocky);
				$giangday->id_namhoc = $id_namhoc; 
				$giangday->id_lophoc = $ko['_id']; 
				$id_giaovien = $giangday->get_id_giaovien();
				$giaovien->id = $id_giaovien; $gv = $giaovien->get_one();
				$siso = $danhsachlop_list->count(); $total_siso += $siso;
				$count_duoitb=0; $count_trentb=0;$count_tbmien = 0;
				$count_kem = 0; $count_yeu=0; $count_tb=0;$count_kha=0;$count_gioi=0;
				foreach ($danhsachlop_list as $ds) {
					//foreach($arr_hocky as $key => $value){
					if(isset($ds[$hocky]) && $ds[$hocky]){
						$count_mien = 0; $count_d = 0; $count_cd=0;$trungbinh='';
						$count_cotmieng = 0; $sum_cotmieng = 0;$count_cot15phut = 0; $sum_cot15phut = 0;
						$count_cot1tiet = 0; $sum_cot1tiet = 0;$diemthi = '';
						foreach($ds[$hocky] as $hk){
							if($hk['id_monhoc'] == $id_monhoc){
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
					//}
				}
				if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
					$sum_trungbinh = $count_duoitb+ $count_trentb+$count_tbmien;
					echo '<tr>';
					echo '<td class="marks">'.$stt.'</td>';
					echo '<td class="marks" style="text-align:left;">'.$gv['hoten'].'</td>';
					echo '<td class="marks">'.$ko['tenlophoc'].'</td>';
					echo '<td class="marks border_right">'.$siso.'</td>';
					echo '<td class="marks">'.$count_duoitb.'</td>';
					echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_duoitb/$sum_trungbinh*100,1) : '0').'%</td>';
					echo '<td class="marks">'.$count_trentb.'</td>';
					echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_trentb/$sum_trungbinh*100,1) : '0').'%</td>';
					echo '<td class="marks">'.$count_tbmien.'</td>';
					echo '<td class="marks">'.($sum_trungbinh ? format_decimal($count_tbmien/$sum_trungbinh*100,1) : '0').'%</td>';
					echo '</tr>';$stt++;
					$count_duoitb_khoi+=$count_duoitb; $count_trentb_khoi+=$count_trentb;
					$count_mientb_khoi += $count_tbmien;
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
					$sum_hocluc = $count_kem + $count_yeu + $count_tb + $count_kha + $count_gioi;
					echo '<td class="marks bg-yellow">'.$count_kem.'</td>';
					echo '<td class="marks bg-yellow border_right">'.($sum_hocluc ? format_decimal($count_kem/$sum_hocluc*100,1) : '0').'%</td>';
					echo '<td class="marks bg-yellow">'.$count_yeu.'</td>';
					echo '<td class="marks bg-yellow border_right">'.($sum_hocluc ? format_decimal($count_yeu/$sum_hocluc*100,1) : '0').'%</td>';
					echo '<td class="marks bg-yellow">'.$count_tb.'</td>';
					echo '<td class="marks bg-yellow border_right">'.($sum_hocluc ? format_decimal($count_tb/$sum_hocluc*100,1) : '0').'%</td>';
					echo '<td class="marks bg-yellow">'.$count_kha.'</td>';
					echo '<td class="marks bg-yellow border_right">'.($sum_hocluc ? format_decimal($count_kha/$sum_hocluc*100,1) : '0').'%</td>';
					echo '<td class="marks bg-yellow">'.$count_gioi.'</td>';
					echo '<td class="marks bg-yellow border_right">'.($sum_hocluc ? format_decimal($count_gioi/$sum_hocluc*100,1) : '0').'%</td>';
					echo '<td class="marks bg-lighterBlue">'.$count_duoitb.'</td>';
					echo '<td class="marks border_right bg-lighterBlue">'.($count_duoitb ? format_decimal(($count_duoitb/($count_duoitb+$count_trentb))*100,1) : '0').'%</td>';
					echo '<td class="marks bg-lighterBlue">'.$count_trentb.'</td>';
					echo '<td class="marks border_right bg-lighterBlue">'.($count_trentb ? format_decimal(($count_trentb/($count_duoitb+$count_trentb))*100,1) : '0').'%</td>';
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
					$count_9_95_khoi += $count_9_95;$count_95_10_khoi += $count_95_10;$count_10_khoi += $count_10;
					$count_duoitb_khoi+=$count_duoitb; $count_trentb_khoi+=$count_trentb;
					$count_kem_khoi += $count_kem; $count_yeu_khoi += $count_yeu;
					$count_tb_khoi += $count_tb; $count_kha_khoi += $count_kha;$count_gioi_khoi = $count_gioi;
					$stt++;
				}
			}
		}
		if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
			$sum_trungbinh_khoi = $count_duoitb_khoi + $count_trentb_khoi + $count_mientb_khoi;
			echo '<tr class="bg-emerald fg-white">';
			echo '<td colspan="3">Tổng kết khối '.$khoi.'</td>';
			echo '<td class="marks border_right">'.$total_siso.'</td>';
			echo '<td class="marks">'.$count_duoitb_khoi.'</td>';
			echo '<td class="marks">'.($sum_trungbinh_khoi ? format_decimal($count_duoitb_khoi/$sum_trungbinh_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.$count_trentb_khoi.'</td>';
			echo '<td class="marks">'.($sum_trungbinh_khoi ? format_decimal($count_trentb_khoi/$sum_trungbinh_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.$count_mientb_khoi.'</td>';
			echo '<td class="marks">'.($sum_trungbinh_khoi ? format_decimal($count_mientb_khoi/$sum_trungbinh_khoi*100,1) : '0').'%</td>';
			echo '</tr>';$stt++;
			$total_siso_thcs += $total_siso;
			$count_duoitb_thcs+=$count_duoitb_khoi; $count_trentb_thcs+=$count_trentb_khoi;
			$count_mientb_thcs += $count_mientb_khoi;
		} else {
			echo '<tr class="bg-emerald fg-white">';
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
			$sum_hocluc_khoi = $count_kem_khoi + $count_yeu_khoi + $count_tb_khoi + $count_kha_khoi + $count_gioi_khoi;
			echo '<td class="marks">'.$count_kem_khoi.'</td>';
			echo '<td class="marks border_right">'.($sum_hocluc_khoi ? format_decimal($count_kem_khoi/$sum_hocluc_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.$count_yeu_khoi.'</td>';
			echo '<td class="marks border_right">'.($sum_hocluc_khoi ? format_decimal($count_yeu_khoi/$sum_hocluc_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.$count_tb_khoi.'</td>';
			echo '<td class="marks border_right">'.($sum_hocluc_khoi ? format_decimal($count_tb_khoi/$sum_hocluc_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.$count_kha_khoi.'</td>';
			echo '<td class="marks border_right">'.($sum_hocluc_khoi ? format_decimal($count_kha_khoi/$sum_hocluc_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.$count_gioi_khoi.'</td>';
			echo '<td class="marks border_right">'.($sum_hocluc_khoi ? format_decimal($count_gioi_khoi/$sum_hocluc_khoi*100,1) : '0').'%</td>';
			echo '<td class="marks">'.$count_duoitb_khoi.'</td>';
			echo '<td class="marks border_right">'.($count_duoitb_khoi ? format_decimal(($count_duoitb_khoi/($count_duoitb_khoi + $count_trentb_khoi))*100,1) : '0').'%</td>';
			echo '<td class="marks">'.$count_trentb_khoi.'</td>';
			echo '<td class="marks border_right">'.($count_trentb_khoi ? format_decimal(($count_trentb_khoi/($count_duoitb_khoi + $count_trentb_khoi))*100,1) : '0').'%</td>';
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
			$count_kem_thcs += $count_kem_khoi; $count_yeu_thcs += $count_yeu_khoi;
			$count_tb_thcs += $count_tb_khoi; $count_kha_thcs += $count_kha_khoi; $count_gioi_thcs += $count_gioi_khoi;
		}
	}
	?>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
	<tr class="bg-grayDarker fg-white">
		<?php
		$sum_trungbinh_thcs = $count_duoitb_thcs + $count_trentb_thcs + $count_mientb_thcs;
		?>
		<td colspan="3">Tổng kết THCS</td>
		<td class="marks border_right"><?php echo $total_siso_thcs; ?></td>
		<td class="marks"><?php echo $count_duoitb_thcs; ?></td>
		<td class="marks"><?php echo $sum_trungbinh_thcs ? format_decimal($count_duoitb_thcs/$sum_trungbinh_thcs*100,1) : '0'; ?>%</td>
		<td class="marks"><?php echo $count_trentb_thcs; ?></td>
		<td class="marks"><?php echo $sum_trungbinh_thcs ? format_decimal($count_trentb_thcs/$sum_trungbinh_thcs*100,1) : '0'; ?>%</td>
		<td class="marks"><?php echo $count_mientb_thcs; ?></td>
		<td class="marks"><?php echo $sum_trungbinh_thcs ? format_decimal($count_mientb_thcs/$sum_trungbinh_thcs*100,1) : '0'; ?>%</td>
	</tr>
	<?php else: ?>
	<tr class="bg-grayDarker fg-white">
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
		<td class="marks border_right"><?php echo $count_95_10_thcs; ?></td>
		<td class="marks border_right"><?php echo $count_10_thcs; ?></td>
		<?php
		$sum_hocluc_thcs = $count_kem_thcs + $count_yeu_thcs + $count_tb_thcs + $count_kha_thcs + $count_gioi_thcs;
		?>
		<td class="marks"><?php echo $count_kem_thcs; ?></td>
		<td class="marksborder_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_kem_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
		<td class="marks"><?php echo $count_yeu_thcs; ?></td>
		<td class="marksborder_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_yeu_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
		<td class="marks"><?php echo $count_tb_thcs; ?></td>
		<td class="marksborder_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_tb_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
		<td class="marks"><?php echo $count_kha_thcs; ?></td>
		<td class="marksborder_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_kha_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
		<td class="marks"><?php echo $count_gioi_thcs; ?></td>
		<td class="marksborder_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_gioi_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
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
<?php require_once('footer.php'); ?>

