<?php
require_once('header_none.php');
check_permis(!$users->is_admin() && !$users->is_teacher());
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();$hocsinh = new HocSinh();
$lophoc = new LopHoc();$monhoc = new MonHoc();
$namhoc_list = $namhoc->get_list_limit(3);
$id_namhoc = ''; $id_lophoc='';$id_monhoc='';
if(isset($_GET['submit'])){
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
	if($id_namhoc && $id_lophoc && $id_monhoc){
		$danhsachlop->id_lophoc = $id_lophoc;
		$danhsachlop->id_namhoc = $id_namhoc;
		$danhsachlop_list = $danhsachlop->get_danh_sach_lop_except_nghiluon();
		$giangday->id_namhoc = $id_namhoc; 
		$giangday->id_lophoc = $id_lophoc; 
		$giangday->id_monhoc = $id_monhoc; 
		$id_giaovien = $giangday->get_id_giaovien();
		$giaovien->id = $id_giaovien; $gv = $giaovien->get_one();
		$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
		$lophoc->id = $id_lophoc; $l = $lophoc->get_one();
		$monhoc->id = $id_monhoc; $m = $monhoc->get_one();$mamonhoc = $m['mamonhoc'];
	} else {
		$msg = 'Chọn Năm học, Lớp học, Môn học';
	}
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

<?php if(isset($danhsachlop_list) && $danhsachlop_list) : ?>
<?php
$count_0_05_hk1 = 0;$count_05_1_hk1 = 0;$count_1_15_hk1 = 0;$count_15_2_hk1 = 0;
$count_2_25_hk1 = 0;$count_25_3_hk1 = 0;$count_3_35_hk1 = 0;$count_35_4_hk1 = 0;
$count_4_45_hk1 = 0;$count_45_5_hk1 = 0;$count_5_55_hk1 = 0;$count_55_6_hk1 = 0;
$count_6_65_hk1 = 0;$count_65_7_hk1 = 0;$count_7_75_hk1 = 0;$count_75_8_hk1 = 0;
$count_8_85_hk1 = 0;$count_85_9_hk1 = 0;$count_9_95_hk1 = 0;$count_95_10_hk1 = 0;$count_10_hk1=0;
$count_kem_hk1 = 0; $count_yeu_hk1=0; $count_tb_hk1=0;$count_kha_hk1=0;$count_gioi_hk1=0;
$count_duoitb_hk1=0;$count_trentb_hk1=0; $count_mien_hk1=0;$total_hk1=0;
$count_0_05_hk2 = 0;$count_05_1_hk2 = 0;$count_1_15_hk2 = 0;$count_15_2_hk2 = 0;
$count_2_25_hk2 = 0;$count_25_3_hk2 = 0;$count_3_35_hk2 = 0;$count_35_4_hk2 = 0;
$count_4_45_hk2 = 0;$count_45_5_hk2 = 0;$count_5_55_hk2 = 0;$count_55_6_hk2 = 0;
$count_6_65_hk2 = 0;$count_65_7_hk2 = 0;$count_7_75_hk2 = 0;$count_75_8_hk2 = 0;
$count_8_85_hk2 = 0;$count_85_9_hk2 = 0;$count_9_95_hk2 = 0;$count_95_10_hk2 = 0; $count_10_hk2=0;
$count_kem_hk2 = 0; $count_yeu_hk2=0; $count_tb_hk2=0;$count_kha_hk2=0;$count_gioi_hk2=0;
$count_duoitb_hk2=0;$count_trentb_hk2=0;$count_mien_hk2=0; $total_hk2=0;
$count_0_05_cn = 0;$count_05_1_cn = 0;$count_1_15_cn = 0;$count_15_2_cn = 0;
$count_2_25_cn = 0;$count_25_3_cn = 0;$count_3_35_cn = 0;$count_35_4_cn = 0;
$count_4_45_cn = 0;$count_45_5_cn = 0;$count_5_55_cn = 0;$count_55_6_cn = 0;
$count_6_65_cn = 0;$count_65_7_cn = 0;$count_7_75_cn = 0;$count_75_8_cn = 0;
$count_8_85_cn = 0;$count_85_9_cn = 0;$count_9_95_cn = 0;$count_95_10_cn = 0;$count_10_cn=0;
$count_kem_cn = 0; $count_yeu_cn=0; $count_tb_cn=0;$count_kha_cn=0;$count_gioi_cn=0;
$count_duoitb_cn=0;$count_trentb_cn=0; $count_mien_cn=0;$total_cn=0;
foreach($danhsachlop_list as $ds){
	$count_mien1 = 0; $count_d1 = 0; $count_cd1=0;
	$count_mien2 = 0; $count_d2 = 0; $count_cd2=0;
	$count_mien1 = 0; $count_d1 = 0; $count_cd1=0;$trungbinh1='';
	$count_mien2 = 0; $count_d2 = 0; $count_cd2=0;$trungbinh2='';
	$diemthi1 = '';	$diemthi2 = '';	$canam = ''; $count_cot1tiet1='';
	$sum_cot15phut1 = ''; $sum_cot1tiet1=''; $count_cot15phut1='';$canam='';
	if(isset($ds['hocky1']) && $ds['hocky1']){
		//hoc ky 1
		foreach($ds['hocky1'] as $hk){
			if($hk['id_monhoc'] == $id_monhoc){
				//cot mieng hoc ky I
				$count_cotmieng1 = 0; $sum_cotmieng1 = 0;
				if(isset($hk['diemmieng']) && $hk['diemmieng']){
					if(isset($value)){
						foreach($hk['diemmieng'] as $key => $value){
							if($value == 'M') $count_mien1++;
							else if($value == 'Đ') $count_d1++;
							else if($value == 'CĐ') $count_cd1++;
							$count_cotmieng1++;
							$sum_cotmieng1 += doubleval($value);
						}
					}
				}
				//Cot 15 hoc ky I
				$count_cot15phut1 = 0; $sum_cot15phut1 = 0;
				if(isset($hk['diem15phut']) && $hk['diem15phut']){
					foreach($hk['diem15phut'] as $key => $value){
						if(isset($value)){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else if($value == 'CĐ') $count_cd1++;
							}
							$count_cot15phut1++;
							$sum_cot15phut1 += doubleval($value);
						}
					}
				}
				//cot 1 tiet hoc ky 1
				//Toi da 6 cot
				$count_cot1tiet1 = 0; $sum_cot1tiet1 = 0;
				if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
					foreach($hk['diem1tiet'] as $key => $value){
						if(isset($value)){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else if($value == 'CĐ') $count_cd1++;
							}
							$count_cot1tiet1 ++;
							$sum_cot1tiet1 += doubleval($value);	
						}
					}
					
				}
				//diem thi hoc ky 1
				$diemthi1 = '';$count_cotdiemthi1 = 0;
				if(isset($hk['diemthi']) && $hk['diemthi']){
					foreach($hk['diemthi'] as $key => $value){
						if(isset($value)){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else if($value == 'CĐ') $count_cd1++;
							}
							$diemthi1 = $value; $count_cotdiemthi1 = 3;
						}
					}
				}
				//tinh trung binh hoc ky 1
				if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
					$sum_d_cd_1 = $count_d1 + $count_cd1;
					if($sum_d_cd_1 && $count_d1/$sum_d_cd_1 >= 0.65){
						$trungbinh1 = 'Đ';
					} else if($count_mien1 > 0 && $count_d1==0 && $count_cd1==0){
						$trungbinh1 = 'M';
					} else if($count_cd1 > 0) {
						$trungbinh1 = 'CĐ';
					} else {
						$trungbinh1 = '';
					}
				
					if($trungbinh1 == 'Đ') $count_trentb_hk1++;
					else if($trungbinh1 == 'CĐ') $count_duoitb_hk1++;
					else if($trungbinh1 == 'M') $count_mien_hk1++;
				} else {
					$trungbinh1 = round(($sum_cotmieng1 + $sum_cot15phut1 + 2*$sum_cot1tiet1 + (3* doubleval($diemthi1)))/($count_cotmieng1 + $count_cot15phut1 + 2*$count_cot1tiet1 + $count_cotdiemthi1),1);
					
					if($trungbinh1 >= 0 && $trungbinh1 < 0.5)   	$count_0_05_hk1++;
					if($trungbinh1 >= 0.5 && $trungbinh1 < 1) 		$count_05_1_hk1++;
					if($trungbinh1 >= 1 && $trungbinh1 < 1.5) 		$count_1_15_hk1++;
					if($trungbinh1 >= 1.5 && $trungbinh1 < 2) 		$count_15_2_hk1++;
					if($trungbinh1 >= 2    && $trungbinh1 < 2.5) 	$count_2_25_hk1++;
					if($trungbinh1 >= 2.5  && $trungbinh1 < 3) 		$count_25_3_hk1++;
					if($trungbinh1 >= 3    && $trungbinh1 < 3.5) 	$count_3_35_hk1++;
					if($trungbinh1 >= 3.5  && $trungbinh1 < 4) 		$count_35_4_hk1++;
					if($trungbinh1 >= 4    && $trungbinh1 < 4.5) 	$count_4_45_hk1++;
					if($trungbinh1 >= 4.5  && $trungbinh1 < 5) 		$count_45_5_hk1++;
					if($trungbinh1 >= 5    && $trungbinh1 < 5.5) 	$count_5_55_hk1++;
					if($trungbinh1 >= 5.5  && $trungbinh1 < 6) 		$count_55_6_hk1++;
					if($trungbinh1 >= 6    && $trungbinh1 < 6.5) 	$count_6_65_hk1++;
					if($trungbinh1 >= 6.5  && $trungbinh1 < 7) 		$count_65_7_hk1++;
					if($trungbinh1 >= 7    && $trungbinh1 < 7.5) 	$count_7_75_hk1++;
					if($trungbinh1 >= 7.5  && $trungbinh1 < 8) 		$count_75_8_hk1++;
					if($trungbinh1 >= 8    && $trungbinh1 < 8.5) 	$count_8_85_hk1++;
					if($trungbinh1 >= 8.5  && $trungbinh1 < 9) 		$count_85_9_hk1++;
					if($trungbinh1 >= 9    && $trungbinh1 < 9.5) 	$count_9_95_hk1++;
					if($trungbinh1 >= 9.5  && $trungbinh1 < 10) 	$count_95_10_hk1++;
					if($trungbinh1 == 10) $count_10_hk1++;
					if($trungbinh1 >=0 && $trungbinh1 < 3.5) $count_kem_hk1++;
					if($trungbinh1 >=3.5 && $trungbinh1 < 5) $count_yeu_hk1++;
					if($trungbinh1 >=5 && $trungbinh1 < 6.5) $count_tb_hk1++;
					if($trungbinh1 >=6.5 && $trungbinh1 < 8) $count_kha_hk1++;
					if($trungbinh1 >=8 && $trungbinh1 <= 10) $count_gioi_hk1++;
					if($trungbinh1 < 5) $count_duoitb_hk1++;
					if($trungbinh1 >=5) $count_trentb_hk1++;
				}
				$total_hk1++;
			}
		}
	}

	if(isset($ds['hocky2']) && $ds['hocky2']){
		foreach($ds['hocky2'] as $hk2){
			if($hk2['id_monhoc'] == $id_monhoc){
				$count_cotmieng2 = 0; $sum_cotmieng2 = 0;
				//cot mieng hoc ky I
				if(isset($hk2['diemmieng']) && $hk2['diemmieng']){
					if(isset($value)){
						foreach($hk2['diemmieng'] as $key => $value){
							if($value == 'M') $count_mien2++;
							else if($value == 'Đ') $count_d2++;
							else if($value == 'CĐ') $count_cd2++;
							$count_cotmieng2++;
							$sum_cotmieng2 += doubleval($value);
						}
					}
				}
				//Cot 25 hoc ky I
				$count_cot15phut2 = 0; $sum_cot15phut2 = 0;
				if(isset($hk2['diem25phut']) && $hk2['diem25phut']){
					foreach($hk2['diem25phut'] as $key => $value){
						if(isset($value)){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else if($value == 'CĐ') $count_cd2++;
							}
							$count_cot15phut2++;
							$sum_cot15phut2 += doubleval($value);
						}
					}
				}
				//cot 2 tiet hoc ky 2
				//Toi da 6 cot
				$count_cot1tiet2 = 0; $sum_cot1tiet2 = 0;
				if(isset($hk2['diem2tiet']) && $hk2['diem2tiet']){
					foreach($hk2['diem2tiet'] as $key => $value){
						if(isset($value)){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else if($value == 'CĐ') $count_cd2++;
							}
							$count_cot1tiet2 ++;
							$sum_cot1tiet2 += doubleval($value);	
						}
					}
					
				}
				//diem thi hoc ky 2
				$diemthi2 = '';$count_cotdiemthi2=0;
				if(isset($hk2['diemthi']) && $hk2['diemthi']){
					foreach($hk2['diemthi'] as $key => $value){
						if(isset($value)){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else if($value == 'CĐ') $count_cd2++;
							}
							$diemthi2 = $value;$count_cotdiemthi2 = 3;
						}
					}
				}
				//tinh trung binh hoc ky 2
				if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
					if($count_d2/($count_d2 + $count_cd2) >= 0.65){
						$trungbinh2 = 'Đ';
					} else if($count_mien2 > 0  && $count_d2==0 && $count_cd2==0){
						$trungbinh2 = 'M';
					} else if($count_cd2 > 0) {
						$trungbinh2 = 'CĐ';
					} else {
						$trungbinh2 = '';
					}
				
					if($trungbinh2 == 'Đ') $count_trentb_hk2++;
					else if($trungbinh2 == 'CĐ') $count_duoitb_hk2++;
					else if($trungbinh2 == 'M') $count_mien_hk2++;
				} else {
					$trungbinh2 = round(($sum_cotmieng2 + $sum_cot15phut2 + 2*$sum_cot1tiet2 + (3* doubleval($diemthi2)))/($count_cotmieng2 + $count_cot15phut2 + 2*$count_cot1tiet2 + $count_cotdiemthi2),1);
					//$trungbinh2 = format_decimal($trungbinh2, 1);
					if($trungbinh2 >= 0 && $trungbinh2 < 0.5)   	$count_0_05_hk2++;
					if($trungbinh2 >= 0.5 && $trungbinh2 < 1) 		$count_05_1_hk2++;
					if($trungbinh2 >= 1 && $trungbinh2 < 1.5) 		$count_1_15_hk2++;
					if($trungbinh2 >= 1.5 && $trungbinh2 < 2) 		$count_15_2_hk2++;
					if($trungbinh2 >= 2    && $trungbinh2 < 2.5) 	$count_2_25_hk2++;
					if($trungbinh2 >= 2.5  && $trungbinh2 < 3) 		$count_25_3_hk2++;
					if($trungbinh2 >= 3    && $trungbinh2 < 3.5) 	$count_3_35_hk2++;
					if($trungbinh2 >= 3.5  && $trungbinh2 < 4) 		$count_35_4_hk2++;
					if($trungbinh2 >= 4    && $trungbinh2 < 4.5) 	$count_4_45_hk2++;
					if($trungbinh2 >= 4.5  && $trungbinh2 < 5) 		$count_45_5_hk2++;
					if($trungbinh2 >= 5    && $trungbinh2 < 5.5) 	$count_5_55_hk2++;
					if($trungbinh2 >= 5.5  && $trungbinh2 < 6) 		$count_55_6_hk2++;
					if($trungbinh2 >= 6    && $trungbinh2 < 6.5) 	$count_6_65_hk2++;
					if($trungbinh2 >= 6.5  && $trungbinh2 < 7) 		$count_65_7_hk2++;
					if($trungbinh2 >= 7    && $trungbinh2 < 7.5) 	$count_7_75_hk2++;
					if($trungbinh2 >= 7.5  && $trungbinh2 < 8) 		$count_75_8_hk2++;
					if($trungbinh2 >= 8    && $trungbinh2 < 8.5) 	$count_8_85_hk2++;
					if($trungbinh2 >= 8.5  && $trungbinh2 < 9) 		$count_85_9_hk2++;
					if($trungbinh2 >= 9    && $trungbinh2 < 9.5) 	$count_9_95_hk2++;
					if($trungbinh2 >= 9.5  && $trungbinh2 < 10) 	$count_95_10_hk2++;
					if($count_10_hk2 == 10) $count_10_hk2++;
					if($trungbinh2 >=0 && $trungbinh2 < 3.5) $count_kem_hk1++;
					if($trungbinh2 >=3.5 && $trungbinh2 < 5) $count_yeu_hk1++;
					if($trungbinh2 >=5 && $trungbinh2 < 6.5) $count_tb_hk1++;
					if($trungbinh2 >=6.5 && $trungbinh2 < 8) $count_kha_hk1++;
					if($trungbinh2 >=8 && $trungbinh2 <= 10) $count_gioi_hk1++;
					if($trungbinh2 < 5) $count_duoitb_hk2++;
					if($trungbinh2 >=5) $count_trentb_hk2++;
				}
				$total_hk2++;
			}
		}

		//Tinh trung binh ca nam
		if($trungbinh1 && $trungbinh2){
			if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
				if($trungbinh1 =='M' && $trungbinh2=='M'){
					$canam = 'M';
				} else if($trungbinh2=='Đ'){
					$canam = 'Đ';
				} else if($trungbinh2 == 'CĐ'){
					$canam = 'CĐ';
				} else {
					$canam = '';
				}
				if($canam == 'Đ') $count_trentb_cn++;
				else if($canam == 'CĐ') $count_duoitb_cn++;
				else if($canam == 'M') $count_mien_cn++;
			} else {
				$canam = round(($trungbinh1 + (2 * $trungbinh2)) / 3, 1);
				if($canam >= 0 && $canam < 0.5)   		$count_0_05_cn++;
				if($canam >= 0.5 && $canam < 1) 		$count_05_1_cn++;
				if($canam >= 1 && $canam < 1.5) 		$count_1_15_cn++;
				if($canam >= 1.5 && $canam < 2) 		$count_15_2_cn++;
				if($canam >= 2    && $canam < 2.5) 		$count_2_25_cn++;
				if($canam >= 2.5  && $canam < 3) 		$count_25_3_cn++;
				if($canam >= 3    && $canam < 3.5) 		$count_3_35_cn++;
				if($canam >= 3.5  && $canam < 4) 		$count_35_4_cn++;
				if($canam >= 4    && $canam < 4.5) 		$count_4_45_cn++;
				if($canam >= 4.5  && $canam < 5) 		$count_45_5_cn++;
				if($canam >= 5    && $canam < 5.5) 		$count_5_55_cn++;
				if($canam >= 5.5  && $canam < 6) 		$count_55_6_cn++;
				if($canam >= 6    && $canam < 6.5) 		$count_6_65_cn++;
				if($canam >= 6.5  && $canam < 7) 		$count_65_7_cn++;
				if($canam >= 7    && $canam < 7.5) 		$count_7_75_cn++;
				if($canam >= 7.5  && $canam < 8) 		$count_75_8_cn++;
				if($canam >= 8    && $canam < 8.5) 		$count_8_85_cn++;
				if($canam >= 8.5  && $canam < 9) 		$count_85_9_cn++;
				if($canam >= 9    && $canam < 9.5) 		$count_9_95_cn++;
				if($canam >= 9.5  && $canam < 10) 		$count_95_10_cn++;
				if($canam == 10) $count_10_cn++;
				if($canam >=0 && $canam < 3.5) $count_kem_hk1++;
				if($canam >=3.5 && $canam < 5) $count_yeu_hk1++;
				if($canam >=5 && $canam < 6.5) $count_tb_hk1++;
				if($canam >=6.5 && $canam < 8) $count_kha_hk1++;
				if($canam >=8 && $canam <= 10) $count_gioi_hk1++;
				if($canam < 5) $count_duoitb_cn++;
				if($canam >=5) $count_trentb_cn++;
			}
			$total_cn++;
		}
	}
}
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
		<h3>THỐNG KÊ KẾT QUẢ GIẢNG DẠY<BR />THEO BẢNG ĐIỂM CÁ NHÂN</h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Lớp học: <b><?php echo $l['tenlophoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Sỉ số: <b><?php echo $danhsachlop_list->count(); ?></b>&nbsp;&nbsp;&nbsp;
			Môn học: <b><?php echo $m['tenmonhoc']; ?></b></p>
			<p>Giáo viên: <b><?php echo $gv['hoten']; ?></b></p>
		</h4>
		</div>
	</div>
</div>
<?php if($mamonhoc == 'THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
<thead>
	<tr>
		<th rowspan="2">#</th>
		<th colspan="2">CHƯA ĐẠT</th>
		<th colspan="2">ĐẠT</th>
		<th colspan="2">MIỄN</th>
	</tr>
	<tr>
		<th>SL</th><th>TL</th>
		<th>SL</th><th>TL</th>
		<th>SL</th><th>TL</th>
	</tr>
</thead>
<tbody>
	<?php
		$sum_trungbinh_1 = $count_duoitb_hk1 + $count_trentb_hk1 + $count_mien_hk1;
		$sum_trungbinh_2 = $count_duoitb_hk2 + $count_trentb_hk2 + $count_mien_hk2;
		$sum_trungbinh_cn = $count_duoitb_cn + $count_trentb_cn + $count_mien_cn;
	?>
	<tr>
		<td>HKI</td>
		<td class="align-right"><?php echo format_number($count_duoitb_hk1); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_1 ? format_decimal($count_duoitb_hk1/$sum_trungbinh_1 * 100, 1) : '0,0'; ?>%</td>
		<td class="align-right"><?php echo format_number($count_trentb_hk1); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_1 ? format_decimal($count_trentb_hk1/$sum_trungbinh_1 * 100, 1) : '0,0'; ?>%</td>
		<td class="align-right"><?php echo format_number($count_mien_hk1); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_1 ? format_decimal($count_mien_hk1/$sum_trungbinh_1 * 100, 1) : '0,0'; ?>%</td>
	</tr>
	<tr>
		<td>HKII</td>
		<td class="align-right"><?php echo format_number($count_duoitb_hk2); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_2 ? format_decimal($count_duoitb_hk2/$sum_trungbinh_2 * 100, 1) : '0,0'; ?>%</td>
		<td class="align-right"><?php echo format_number($count_trentb_hk2); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_2 ? format_decimal($count_trentb_hk2/$sum_trungbinh_2 * 100, 1) : '0,0'; ?>%</td>
		<td class="align-right"><?php echo format_number($count_mien_hk2); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_2 ? format_decimal($count_mien_hk2/$sum_trungbinh_2 * 100, 1) : '0,0'; ?>%</td>
	</tr>
	<tr>
		<td>Cả năm</td>
		<td class="align-right"><?php echo format_number($count_duoitb_cn); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_cn ? format_decimal($count_duoitb_cn/$sum_trungbinh_cn * 100, 1) : '0,0'; ?>%</td>
		<td class="align-right"><?php echo format_number($count_trentb_cn); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_cn ? format_decimal($count_trentb_cn/$sum_trungbinh_cn * 100, 1) : '0,0'; ?>%</td>
		<td class="align-right"><?php echo format_number($count_mien_cn); ?></td>
		<td class="align-right"><?php echo $sum_trungbinh_cn ? format_decimal($count_mien_cn/$sum_trungbinh_cn * 100, 1) : '0,0'; ?>%</td>
	</tr>
	
</tbody>
</tbody>
</table>
<?php else : ?>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th rowspan="2" width="55">#</th>
			<?php
			for($i=0; $i<10.5; $i=$i+0.5){
				$j = $i + 0.5;
				if($i==10){
					echo '<th rowspan="2" class="border_right">'.$i.'</th>';
				} else {
					echo '<th rowspan="2">'.$i.'<br /><' .$j .'</th>';
				}
			}
			?>
			<th colspan="2" class="border_right bg-lighterBlue">KÉM</th>
			<th colspan="2" class="border_right bg-lighterBlue">YẾU</th>
			<th colspan="2" class="border_right bg-lighterBlue">TB</th>
			<th colspan="2" class="border_right bg-lighterBlue">KHÁ</th>
			<th colspan="2" class="border_right bg-lighterBlue">GIỎI</th>
			<th colspan="2" class="border_right bg-yellow">DƯỚI TB</th>
			<th colspan="2" class="border_right bg-yellow">TRÊN TB</th>
		</tr>
		<tr>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-lighterBlue">SL</th><th class="border_right bg-lighterBlue">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
			<th class="bg-yellow">SL</th><th class="border_right bg-yellow">TL</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="marks">HK I</td>
			<td class="marks"><?php echo $count_0_05_hk1; ?></td>
			<td class="marks"><?php echo $count_05_1_hk1; ?></td>
			<td class="marks"><?php echo $count_1_15_hk1; ?></td>
			<td class="marks"><?php echo $count_15_2_hk1; ?></td>
			<td class="marks"><?php echo $count_2_25_hk1; ?></td>
			<td class="marks"><?php echo $count_25_3_hk1; ?></td>
			<td class="marks"><?php echo $count_3_35_hk1; ?></td>
			<td class="marks"><?php echo $count_35_4_hk1; ?></td>
			<td class="marks"><?php echo $count_4_45_hk1; ?></td>
			<td class="marks"><?php echo $count_45_5_hk1; ?></td>
			<td class="marks"><?php echo $count_5_55_hk1; ?></td>
			<td class="marks"><?php echo $count_55_6_hk1; ?></td>
			<td class="marks"><?php echo $count_6_65_hk1; ?></td>
			<td class="marks"><?php echo $count_65_7_hk1; ?></td>
			<td class="marks"><?php echo $count_7_75_hk1; ?></td>
			<td class="marks"><?php echo $count_75_8_hk1; ?></td>
			<td class="marks"><?php echo $count_8_85_hk1; ?></td>
			<td class="marks"><?php echo $count_85_9_hk1; ?></td>
			<td class="marks"><?php echo $count_9_95_hk1; ?></td>
			<td class="marks"><?php echo $count_95_10_hk1; ?></td>
			<td class="marks border_right"><?php echo $count_10_hk1; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kem_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_kem_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_yeu_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_yeu_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_tb_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_tb_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kha_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_kha_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_gioi_hk1; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk1 ? format_decimal(($count_gioi_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_duoitb_hk1; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_hk1 ? format_decimal(($count_duoitb_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_trentb_hk1; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_hk1 ? format_decimal(($count_trentb_hk1/$total_hk1)*100,1) .'%' : ''; ?></td>
		</tr>
		<tr>
			<td class="marks">HK II</td>
			<td class="marks"><?php echo $count_0_05_hk2; ?></td>
			<td class="marks"><?php echo $count_05_1_hk2; ?></td>
			<td class="marks"><?php echo $count_1_15_hk2; ?></td>
			<td class="marks"><?php echo $count_15_2_hk2; ?></td>
			<td class="marks"><?php echo $count_2_25_hk2; ?></td>
			<td class="marks"><?php echo $count_25_3_hk2; ?></td>
			<td class="marks"><?php echo $count_3_35_hk2; ?></td>
			<td class="marks"><?php echo $count_35_4_hk2; ?></td>
			<td class="marks"><?php echo $count_4_45_hk2; ?></td>
			<td class="marks"><?php echo $count_45_5_hk2; ?></td>
			<td class="marks"><?php echo $count_5_55_hk2; ?></td>
			<td class="marks"><?php echo $count_55_6_hk2; ?></td>
			<td class="marks"><?php echo $count_6_65_hk2; ?></td>
			<td class="marks"><?php echo $count_65_7_hk2; ?></td>
			<td class="marks"><?php echo $count_7_75_hk2; ?></td>
			<td class="marks"><?php echo $count_75_8_hk2; ?></td>
			<td class="marks"><?php echo $count_8_85_hk2; ?></td>
			<td class="marks"><?php echo $count_85_9_hk2; ?></td>
			<td class="marks"><?php echo $count_9_95_hk2; ?></td>
			<td class="marks"><?php echo $count_95_10_hk2; ?></td>
			<td class="marks border_right"><?php echo $count_10_hk2; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kem_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_kem_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_yeu_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_yeu_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_tb_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_tb_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kha_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_kha_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_gioi_hk2; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_hk2 ? format_decimal(($count_gioi_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_duoitb_hk2; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_hk2 ? format_decimal(($count_duoitb_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_trentb_hk2; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_hk2 ? format_decimal(($count_trentb_hk2/$total_hk2)*100,1) .'%' : ''; ?></td>
		</tr>
		<tr>
			<td class="marks">Cả năm</td>
			<td class="marks"><?php echo $count_0_05_cn; ?></td>
			<td class="marks"><?php echo $count_05_1_cn; ?></td>
			<td class="marks"><?php echo $count_1_15_cn; ?></td>
			<td class="marks"><?php echo $count_15_2_cn; ?></td>
			<td class="marks"><?php echo $count_2_25_cn; ?></td>
			<td class="marks"><?php echo $count_25_3_cn; ?></td>
			<td class="marks"><?php echo $count_3_35_cn; ?></td>
			<td class="marks"><?php echo $count_35_4_cn; ?></td>
			<td class="marks"><?php echo $count_4_45_cn; ?></td>
			<td class="marks"><?php echo $count_45_5_cn; ?></td>
			<td class="marks"><?php echo $count_5_55_cn; ?></td>
			<td class="marks"><?php echo $count_55_6_cn; ?></td>
			<td class="marks"><?php echo $count_6_65_cn; ?></td>
			<td class="marks"><?php echo $count_65_7_cn; ?></td>
			<td class="marks"><?php echo $count_7_75_cn; ?></td>
			<td class="marks"><?php echo $count_75_8_cn; ?></td>
			<td class="marks"><?php echo $count_8_85_cn; ?></td>
			<td class="marks"><?php echo $count_85_9_cn; ?></td>
			<td class="marks"><?php echo $count_9_95_cn; ?></td>
			<td class="marks"><?php echo $count_95_10_cn; ?></td>
			<td class="marks border_right"><?php echo $count_10_cn; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kem_cn; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_cn ? format_decimal(($count_kem_cn/$total_cn)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_yeu_cn; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_cn ? format_decimal(($count_yeu_cn/$total_cn)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_tb_cn; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_cn ? format_decimal(($count_tb_cn/$total_cn)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_kha_cn; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_cn ? format_decimal(($count_kha_cn/$total_cn)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-lighterBlue"><?php echo $count_gioi_cn; ?></td>
			<td class="marks border_right bg-lighterBlue"><?php echo $total_cn ? format_decimal(($count_gioi_cn/$total_cn)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_duoitb_cn; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_cn ? format_decimal(($count_duoitb_cn/$total_cn)*100,1) .'%' : ''; ?></td>
			<td class="marks bg-yellow"><?php echo $count_trentb_cn; ?></td>
			<td class="marks border_right bg-yellow"><?php echo $total_cn ? format_decimal(($count_trentb_cn/$total_cn)*100,1) .'%' : ''; ?></td>
		</tr>
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
<?php endif; ?>
<?php endif; ?>

</body>
</html>