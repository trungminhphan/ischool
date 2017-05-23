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
?>
<div style="margin:auto;">
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ KẾT QUẢ GIẢNG DẠY</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Môn học: <b><?php echo $m['tenmonhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Học kỳ: <b><?php
				if($hocky=='hocky1') echo  'Học kỳ I';
				else if($hocky == 'hocky2') echo 'Học kỳ II'; 
				else echo 'Cả năm'; ?></b></p>
		</h4>
		</div>
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
				$danhsachlop_list = $danhsachlop->get_danh_sach_lop_except_nghiluon_hocky($hocky);
				$giangday->id_namhoc = $id_namhoc; 
				$giangday->id_lophoc = $ko['_id']; 
				$id_giaovien = $giangday->get_id_giaovien();
				$giaovien->id = $id_giaovien; $gv = $giaovien->get_one();
				$siso = $danhsachlop_list->count(); $total_siso += $siso;
				$count_duoitb=0; $count_trentb=0;$count_tbmien = 0;
				$count_kem = 0; $count_yeu=0; $count_tb=0;$count_kha=0;$count_gioi=0;
				foreach ($danhsachlop_list as $ds) {
					if($hocky == 'canam'){
						$count_mien_1 = 0; $count_d_1 = 0; $count_cd_1=0;$trungbinh_1='';
						$count_mien_2 = 0; $count_d_2 = 0; $count_cd_2=0;$trungbinh_2='';
						$diemthi_1 = ''; $diemthi_2 = '';
						$sum_diem_1=0; $count_diem_1=0; $sum_diem_2=0; $count_diem_2=0;
						foreach($arr_hocky as $h){
							if(isset($ds[$h]) && $ds[$h]){
								foreach($ds[$h] as $hk){
									if($hk['id_monhoc'] == $id_monhoc){
										if(isset($hk['diemmieng']) && $hk['diemmieng']){
											foreach($hk['diemmieng'] as $key => $value){
												if($value == 'M') $h=='hocky1' ? $count_mien_1++ : $count_mien_2++;
												else if($value == 'Đ') $h=='hocky1' ? $count_d_1++ : $count_d_2++;
												else if($value == 'CĐ') $h=='hocky1' ? $count_cd_1++ : $count_cd_2++;
												if($h == 'hocky1'){
													$count_diem_1++; $sum_diem_1 += doubleval($value);
												} else {
													$count_diem_2++; $sum_diem_2 += doubleval($value);
												}
											}
										}
										if(isset($hk['diem15phut']) && $hk['diem15phut']){
											foreach($hk['diem15phut'] as $key => $value){
												if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
													if($value == 'M') $h=='hocky1' ? $count_mien_1++ : $count_mien_2++;
													else if($value == 'Đ') $h=='hocky1' ? $count_d_1++ : $count_d_2++;
													else if($value == 'CĐ') $h=='hocky1' ? $count_cd_1++ : $count_cd_2++;
												}
												if($h == 'hocky1'){
													$count_diem_1++; $sum_diem_1 += doubleval($value);
												} else {
													$count_diem_2++; $sum_diem_2 += doubleval($value);
												}
											}
										}
										if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
											foreach($hk['diem1tiet'] as $key => $value){
												if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
													if($value == 'M') $h=='hocky1' ? $count_mien_1++ : $count_mien_2++;
													else if($value == 'Đ') $h=='hocky1' ? $count_d_1++ : $count_d_2++;
													else if($value == 'CĐ') $h=='hocky1' ? $count_cd_1++ : $count_cd_2++;

												}
												if($h == 'hocky1'){
													$count_diem_1+=2; $sum_diem_1 += doubleval($value)*2;
												} else {
													$count_diem_2+=2; $sum_diem_2 += doubleval($value)*2;
												}	
											}
											
										}
										if(isset($hk['diemthi']) && $hk['diemthi']){
											foreach($hk['diemthi'] as $key => $value){
												if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
													if($value == 'M') $h=='hocky1' ? $count_mien_1++ : $count_mien_2++;
													else if($value == 'Đ') $h=='hocky1' ? $count_d_1++ : $count_d_2++;
													else if($value == 'CĐ') $h=='hocky1' ? $count_cd_1++ : $count_cd_2++;
												}
												if($h == 'hocky1'){
													$count_diem_1+=3; $sum_diem_1 += doubleval($value)*3;
													$diemthi_1 = $value;
												} else {
													$count_diem_2+=3; $sum_diem_2 += doubleval($value)*3;
													$diemthi_2 = $value;
												}
											}
										}
									}
								}
							}
						}
						if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
							if($khoi == 9 && ($mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT')){
								$sum_d_cd_1 = $count_d_1 + $count_cd_1;
								if($count_d_1 && $count_d_1/$sum_d_cd_1 >= 0.65){
									$trungbinh = 'Đ';
								} else if($count_mien_1 > 0  && $count_d_1==0 && $count_cd_1==0){
									$trungbinh = 'M';
								} else if($count_cd_1 > 0) {
									$trungbinh = 'CĐ';
								} else {
									$trungbinh = '';
								}
								if($trungbinh == 'Đ') $count_trentb++;
								else if($trungbinh == 'CĐ') $count_duoitb++;
								else if($trungbinh == 'M') $count_tbmien++;
							} else {
								$sum_d_cd_2 = $count_d_2 + $count_cd_2;
								if($count_d_2 && $count_d_2/$sum_d_cd_2 >= 0.65){
									$trungbinh = 'Đ';
								} else if($count_mien_2 > 0  && $count_d_2==0 && $count_cd_2==0){
									$trungbinh = 'M';
								} else if($count_cd_2 > 0) {
									$trungbinh = 'CĐ';
								} else {
									$trungbinh = '';
								}
								if($trungbinh == 'Đ') $count_trentb++;
								else if($trungbinh == 'CĐ') $count_duoitb++;
								else if($trungbinh == 'M') $count_tbmien++;
							}
						} else {
							$trungbinh_1 = $count_diem_1 ? round($sum_diem_1/$count_diem_1,1) : 0;
							$trungbinh_2 = $count_diem_2 ? round($sum_diem_2/$count_diem_2,1) : 0;
							$trungbinh = round(($trungbinh_1 + $trungbinh_2*2)/3,1); 
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
					} else {
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
		<?php
		$sum_hocluc_thcs = $count_kem_thcs + $count_yeu_thcs + $count_tb_thcs + $count_kha_thcs + $count_gioi_thcs;
		?>
		<td class="marks"><?php echo $count_kem_thcs; ?></td>
		<td class="marks border_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_kem_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
		<td class="marks"><?php echo $count_yeu_thcs; ?></td>
		<td class="marks border_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_yeu_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
		<td class="marks"><?php echo $count_tb_thcs; ?></td>
		<td class="marks border_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_tb_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
		<td class="marks"><?php echo $count_kha_thcs; ?></td>
		<td class="marks border_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_kha_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
		<td class="marks"><?php echo $count_gioi_thcs; ?></td>
		<td class="marks border_right"><?php echo $sum_hocluc_thcs ? format_decimal($count_gioi_thcs/$sum_hocluc_thcs*100,1): '0'; ?>%</td>
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
</body>
</html>
