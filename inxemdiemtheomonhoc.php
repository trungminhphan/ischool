<?php
require_once('header_none.php');
check_permis(!$users->is_admin() && !$users->is_teacher());
$lophoc = new LopHoc(); $hocsinh = new HocSinh(); $khoanhapdiem= new KhoaNhapDiem();
$danhsachlop = new DanhSachLop;$monhoc = new MonHoc(); $giaovien = new GiaoVien();
$lophoc_list = $lophoc->get_all_list();$namhoc_list = $namhoc->get_list_limit(3);$monhoc_list = $monhoc->get_all_list();
$id_gvcn = '';$id_gvbm =''; $mamonhoc = '';
if(isset($_GET['submit'])){
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$id_monhoc = isset($_GET['id_monhoc']) ? $_GET['id_monhoc'] : '';
	$danhsachlop->id_lophoc = $id_lophoc;
	$danhsachlop->id_namhoc = $id_namhoc;
	$danhsachlop->id_monhoc = $id_monhoc;
	$danhsachlop_list = $danhsachlop->get_bangdiem();
	$khoanhapdiem->id_namhoc = $id_namhoc;
	$khoanhapdiem->id_lophoc = $id_lophoc;
	$khoanhapdiem->id_monhoc = $id_monhoc;
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
<table width="800" align="center" border="0" style="font-size:12px;" cellpadding="10">
	<tr>
		<td align="center">
			TRƯỜNG ĐẠI HỌC AN GIANG <br /><br />
			<b>TRƯỜNG PT THỰC HÀNH SƯ PHẠM</b>
		</td>
		<td align="center">
			<h3>BẢNG ĐIỂM CÁ NHÂN</h3>
		</td>
	</tr>
</table>
<?php 
if(isset($danhsachlop_list) && $danhsachlop_list->count() > 0): 
	$monhoc->id = $id_monhoc; $lophoc->id=$id_lophoc; $namhoc->id = $id_namhoc;
	$mh_title = $monhoc->get_one();$lop_title = $lophoc->get_one();$nh_title = $namhoc->get_one();
	$mamonhoc = $mh_title['mamonhoc'];
	$giaovienchunhiem->id_lophoc = $id_lophoc; $giaovienchunhiem->id_namhoc = $id_namhoc;
	$id_gvcn = $giaovienchunhiem->get_id_giaovien();
	$giangday->id_lophoc = $id_lophoc; $giangday->id_namhoc = $id_namhoc; $giangday->id_monhoc = $id_monhoc;
	$id_gvbm = $giangday->get_id_giaovien();
	$giaovien->id = $id_gvcn; $gvcn = $giaovien->get_one();
	$giaovien->id = $id_gvbm; $gvbm = $giaovien->get_one();
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan4 align-center">
			Môn: <b><?php echo $mh_title['tenmonhoc']; ?></b>
		</div>
		<div class="cell colspan4 align-center">
			Lớp: <b><?php echo $lop_title['tenlophoc']; ?></b>
		</div>
		<div class="cell colspan4 align-center">
			GVCN: <b><?php echo $gvcn['hoten']; ?></b>
		</div>
	</div>
</div>
<table border="1" id="bangdiem_1200" cellpadding="5" style="width:100%" >
<thead>
	<tr>
		<th rowspan="2">STT</th>
		<th rowspan="2">Họ tên</th>
		<th rowspan="2">Giới tính</th>
		<th colspan="15">Học kỳ I</th>
		<th colspan="15">Học kỳ II</th>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
		<th colspan="3">Xếp loại</th>
	<?php else : ?>
		<th colspan="3">Trung bình</th>
	<?php endif; ?>
	</tr>
	<?php if($mamonhoc == 'THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc == 'MYTHUAT'): ?>
	<tr>
		<th colspan="8">Kiểm tra thường xuyên</th>
		<th colspan="6">Kiểm tra định kỳ</th>
		<th>Thi</th>
		<th colspan="8">Kiểm tra thường xuyên</th>
		<th colspan="6">Kiểm tra định kỳ</th>
		<th>Thi</th>
		<th>HKI</th>
		<th>HKII</th>
		<th>CN</th>
	</tr>
	<?php else: ?>
	<tr>
		<th colspan="3">Miệng</th>
		<th colspan="5">15 Phút</th>
		<th colspan="6">1 Tiết</th>
		<th>Thi</th>
		<th colspan="3">Miệng</th>
		<th colspan="5">15 Phút</th>
		<th colspan="6">1 Tiết</th>
		<th>Thi</th>
		<th>HKI</th>
		<th>HKII</th>
		<th>CN</th>
	</tr>
	<?php endif; ?>
</thead>
<tbody>
<?php
	$i = 1;
	$arr_hocsinh = iterator_to_array($danhsachlop_list);
	foreach($danhsachlop_list as $k => $l){
		$hocsinh->id = $l['id_hocsinh'];
		$hs = $hocsinh->get_one();
		$arr_hocsinh[$k]['masohocsinh'] = $hs['masohocsinh'];
	}
	$arr_hocsinh = sort_array_and_key($arr_hocsinh, 'masohocsinh', SORT_ASC);
	foreach($arr_hocsinh as $ds) {
		$count_mien1 = 0; $count_d1 = 0; $count_cd1=0;$trungbinh1='';
		$count_mien2 = 0; $count_d2 = 0; $count_cd2=0;$trungbinh2='';
		$diemthi1 = '';	$diemthi2 = '';	$canam = ''; $count_cot1tiet1='';
		$sum_cot15phut1 = ''; $sum_cot1tiet1=''; $count_cot15phut1='';$canam='';
		$hocsinh->id = $ds['id_hocsinh'];
		$hs = $hocsinh->get_one();
		if($i%2==0) $class='eve'; else $class = 'odd';
		if($i%5==0) $line='sp'; else $line='';
		echo '<tr class="'.$class. ' '.$line.'">';
		echo '<td align="center">'.$i.'</td>';
		echo '<td width="250">'.$hs['hoten'].'</td>';
		echo '<td align="center">'.$hs['gioitinh'].'</td>';

		if(isset($ds['hocky1']) && $ds['hocky1']){
			$bln_hocky1 = false;$khoanhapdiem->hocky='hocky1';
			foreach ($ds['hocky1'] as $hk) {
				if($hk['id_monhoc'] == $id_monhoc){
					$bln_hocky1 = true;
					$n_cotmieng = 0;
					$count_cotmieng1 = 0;
					$sum_cotmieng1 = 0;
					//Toi da 3 Cot
					if(isset($hk['diemmieng']) && $hk['diemmieng']){
						foreach($hk['diemmieng'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else $count_cd1++;
								$diem = $value;
							} else { $diem = format_decimal($value,1); }
							
							echo '<td class="marks">'.$diem.'</td>';
							
							$n_cotmieng++;
							$count_cotmieng1++;
							$sum_cotmieng1 += doubleval($value);
						}			
						if($n_cotmieng < 3 ){
							for($n_cotmieng; $n_cotmieng < 3; $n_cotmieng++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cotmieng=0; $n_cotmieng < 3; $n_cotmieng++){
							echo '<td class="marks"></td>';
						}
					}
					//Toi da 5 cot
					$n_cot15phut = 0;
					$count_cot15phut1 = 0;
					$sum_cot15phut1 = 0;
					if(isset($hk['diem15phut']) && $hk['diem15phut']){
						foreach($hk['diem15phut'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else $count_cd1++;
								$diem = $value;
							} else { $diem = format_decimal($value,1); }
							
							echo '<td class="marks">'.$diem.'</td>';
							
							$n_cot15phut++;
							$count_cot15phut1++;
							$sum_cot15phut1 += doubleval($value);
						}
						if($n_cot15phut < 5 ){
							for($n_cot15phut; $n_cot15phut < 5; $n_cot15phut++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cot15phut=0; $n_cot15phut < 5; $n_cot15phut++){
							echo '<td class="marks"></td>';
						}
					}
					//Toi da 6 cot
					$n_cot1tiet = 0;
					$count_cot1tiet1 = 0;
					$sum_cot1tiet1 = 0;
					if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
						foreach($hk['diem1tiet'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else $count_cd1++;
								$diem = $value;
							} else { $diem = format_decimal($value,1); }
							
							echo '<td class="marks">'.$diem.'</td>';
							
							$n_cot1tiet++;
							$count_cot1tiet1 ++;
							$sum_cot1tiet1 += doubleval($value);
						}
						if($n_cot1tiet < 6 ){
							for($n_cot1tiet; $n_cot1tiet < 6; $n_cot1tiet++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cot1tiet=0; $n_cot1tiet < 6; $n_cot1tiet++){
							echo '<td class="marks"></td>';
						}
					}
					$n_cotthi = 0;
					$diemthi1 = '';
					if(isset($hk['diemthi']) && $hk['diemthi']){
						foreach($hk['diemthi'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								if($value == 'M') $count_mien1++;
								else if($value == 'Đ') $count_d1++;
								else $count_cd1++;
								$diem = $value;
							} else { $diem = format_decimal($value,1); }

								echo '<td class="marks">'.$diem.'</td>';
							
							$diemthi1 = $diem;
						}
					} else {
						echo '<td class="marks"></td>';
					}
				}
			}
			if($bln_hocky1 == false){
				for($k=0; $k<15; $k++){
					echo '<td class="marks"></td>';				
				}
			}
		} else {
			for($k=0; $k<15; $k++){
				echo '<td class="marks"></td>';				
			}
		}

		/************************HOC KY 2 *************************************************/
		if(isset($ds['hocky2']) && count($ds['hocky2']) > 0){
			$bln_hocky2 = false;$khoanhapdiem->hocky = 'hocky2';
			foreach ($ds['hocky2'] as $hk2) {
				if($hk2['id_monhoc'] == $id_monhoc){
					$bln_hocky2 = true;
					//Toi da 3 Cot
					$n_cotmieng = 0;
					$count_cotmieng2 = 0;
					$sum_cotmieng2 = 0;
					if(isset($hk2['diemmieng']) && count($hk2['diemmieng']) > 0){
						foreach($hk2['diemmieng'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								$diem = $value;
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else $count_cd2++;
							} else { $diem = format_decimal($value,1); }
								echo '<td class="marks">'.$diem.'</td>';						
							$n_cotmieng++;
							$count_cotmieng2++;
							$sum_cotmieng2 += doubleval($value);
						}				
						if($n_cotmieng < 3 ){
							for($n_cotmieng; $n_cotmieng < 3; $n_cotmieng++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cotmieng=0; $n_cotmieng < 3; $n_cotmieng++){
							echo '<td class="marks"></td>';
						}
					}
					//Toi da 5 cot
					$n_cot15phut = 0;
					$count_cot15phut2 = 0;
					$sum_cot15phut2 = 0;
					if(isset($hk2['diem15phut']) && $hk2['diem15phut']){
						foreach($hk2['diem15phut'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								$diem = $value;
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else $count_cd2++;
							} else { $diem = format_decimal($value,1); }
								echo '<td class="marks">'.$diem.'</td>';							
							$n_cot15phut++;
							$count_cot15phut2++;
							$sum_cot15phut2 += doubleval($value);
						}
						if($n_cot15phut < 5 ){
							for($n_cot15phut; $n_cot15phut < 5; $n_cot15phut++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cot15phut=0; $n_cot15phut < 5; $n_cot15phut++){
							echo '<td class="marks"></td>';
						}
					}

					//Toi da 6 cot
					$n_cot1tiet = 0;
					$count_cot1tiet2 =0;
					$sum_cot1tiet2 = 0;
					if(isset($hk2['diem1tiet']) && $hk2['diem1tiet']){
						foreach($hk2['diem1tiet'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								$diem = $value;
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else $count_cd2++;
							} else { $diem = format_decimal($value,1); }
								echo '<td class="marks">'.$diem.'</td>';
							$n_cot1tiet++;
							$count_cot1tiet2++;
							$sum_cot1tiet2 += doubleval($value);
						}
						if($n_cot1tiet < 6 ){
							for($n_cot1tiet; $n_cot1tiet < 6; $n_cot1tiet++){
								echo '<td class="marks"></td>';
							}
						}
					} else {
						for($n_cot1tiet=0; $n_cot1tiet<6; $n_cot1tiet++){
							echo '<td class="marks"></td>';
						}
					}
					$n_cotthi = 0;
					$diemthi2 = '';
					if(isset($hk2['diemthi']) && $hk2['diemthi']){
						foreach($hk2['diemthi'] as $key => $value){
							if($value == 'M' || $value == 'Đ' || $value=='CĐ'){
								$diem = $value;
								if($value == 'M') $count_mien2++;
								else if($value == 'Đ') $count_d2++;
								else $count_cd2++;
							} else { $diem = format_decimal($value,1); }
								echo '<td class="marks">'.$diem.'</td>';
							$diemthi2 = $diem;
						}
					} else {
						echo '<td class="marks"></td>';
					}
				} 
			}
			if($bln_hocky2 == false){
				for($j=0; $j<15; $j++){
					echo '<td class="marks"></td>';				
				}	
			}					
		} else {
			for($j=0; $j<15; $j++){
				echo '<td class="marks"></td>';				
			}
		}
		//***************hoc ky1
		if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
			//******************hocky1
			if($diemthi1 == ''){
				$trungbinh1 = '';
			} else {
				if($count_d1 && $count_d1/($count_d1 + $count_cd1) >=0.65){
					$trungbinh1 = 'Đ';
				} else if($count_mien1 > 0  && $count_d1==0 && $count_cd1==0){
					$trungbinh1 = 'M';
				} else if($count_cd1 > 0) {
					$trungbinh1 = 'CĐ';
				} else {
					$trungbinh1 = '';
				}
			}
			//******************hocky2
			if($diemthi2 == ''){
				$trungbinh2 = '';
			} else {
				if($count_d2 && $count_d2/($count_d2 + $count_cd2) >=0.65){
					$trungbinh2 = 'Đ';
				} else if($count_mien2 > 0  && $count_d2==0 && $count_cd2==0){
					$trungbinh2 = 'M';
				} else if($count_cd2 > 0){
					$trungbinh2 = 'CĐ';
				} else {
					$trungbinh2 = '';
				}
			}
			//***********ca nam
			if($trungbinh1 =='M' && $trungbinh2=='M'){
				$canam = 'M';
			} else if($trungbinh2=='Đ'){
				$canam = 'Đ';
			} else if($trungbinh2 == 'CĐ'){
				$canam = 'CĐ';
			} else {
				$canam = '';
			}
		} else {
			if($diemthi1 == ''){
				$trungbinh1 = '';
			} else {
				$trungbinh1 = round(($sum_cotmieng1 + $sum_cot15phut1 + 2*$sum_cot1tiet1 + (3* doubleval(convert_string_number($diemthi1))))/($count_cotmieng1 + $count_cot15phut1 + 2*$count_cot1tiet1 + 3),1);
				$trungbinh1 = format_decimal($trungbinh1, 1);
				//$trungbinh1 = $diemthi1;
			}

			//***************hocky2
			if($diemthi2 == ''){
				$trungbinh2 = '';
			}else {
				$trungbinh2 = round(($sum_cotmieng2 + $sum_cot15phut2 + 2*$sum_cot1tiet2 + (3* doubleval(convert_string_number($diemthi2))))/($count_cotmieng2 + $count_cot15phut2 + 2*$count_cot1tiet2 + 3),1);
				$trungbinh2 = format_decimal($trungbinh2,1);
			}
			//***************Ca nam
			if(!$trungbinh1 || !$trungbinh2){
				$canam = '';
			}
			else if($trungbinh1 && $trungbinh2) {
				$canam = round((convert_string_number($trungbinh1) + (2 * convert_string_number($trungbinh2))) / 3, 1);
				$canam = format_decimal($canam, 1);
			} else {
				$canam = '';
			}
		}
		echo '<td class="marks">'.$trungbinh1.'</td>';
		echo '<td class="marks">'.$trungbinh2.'</td>';
		echo '<td class="marks">'.$canam.'</td>';
		echo '</tr>';
		$i++;
	}
?>
</tbody>
</table>
<table width="300" style="float:right;font-size:12px;" border="0" cellpadding="10">
	<tr>
		<td align="center">
			<i>An Giang, ngày <?php echo date("d"); ?> tháng <?php echo date("m"); ?> năm <?php echo date("Y"); ?></i>
			<p><b>GIÁO VIÊN BỘ MÔN</b></p> <br /><br /><br /><br /><br />

			<b><?php echo $gvbm['hoten']; ?></b>
		</td>
	</tr>
</table>
<?php else: ?>
	<h2><span class="mif-search"></span> Chưa có bảng điểm.</h2>
<?php endif; ?>

</body>
</html>