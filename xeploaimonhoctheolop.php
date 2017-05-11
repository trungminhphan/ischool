<?php
require_once('header.php');
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();
$hocsinh = new HocSinh();$lophoc = new LopHoc();$monhoc = new MonHoc();
$namhoc_list = $namhoc->get_list_limit(3);
$lophoc_list = $lophoc->get_all_list();
$id_namhoc = ''; $hocky='';$id_lophoc='';
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
	$id_lophoc = isset($_GET['id_lophoc']) ? $_GET['id_lophoc'] : '';
}
?>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Thống kê xếp loại môn học của lớp</h1>
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
Năm học: 
	<div class="input-control select">
		<select name="id_namhoc" id="id_namhoc" class="select2">
			<?php
			foreach($namhoc_list as $nh){
				echo '<option value="'.$nh['_id'].'" '.($nh['_id']==$id_namhoc ? ' selected' : '').'>'. $nh['tennamhoc'].'</option>';
			}
			?>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Học kỳ: 
	<div class="input-control select">
		<select name="hocky" id="hocky" class="select2">
			<option value="hocky1" <?php echo $hocky=='hocky1' ? ' selected' : '';?>>Học kỳ I</option>
			<option value="hocky2" <?php echo $hocky=='hocky2' ? ' selected' : '';?>>Học kỳ II</option>
		</select>
	</div>
	&nbsp;&nbsp;&nbsp;Lớp: 
	<div class="input-control select">
		<select name="id_lophoc" id="id_lophoc" class="select2">
			<?php
			if($lophoc_list){
				foreach($lophoc_list as $lh){
					echo '<option value="'.$lh['_id'].'"'.($id_lophoc == $lh['_id'] ? ' selected' : '').'>'.$lh['tenlophoc'].'</option>';
				}
			}
			?>
		</select>
	</div>
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem kết quả</button>
</form>
<hr />
<?php if($id_namhoc && $hocky && $id_lophoc):

$danhsachlop->id_namhoc = $id_namhoc;
$giangday->id_namhoc = $id_namhoc; 
$giangday->id_lophoc = $id_lophoc;
$lophoc->id = $id_lophoc; $lh = $lophoc->get_one();
$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
$list_monhoc = $giangday->get_list_monhoc();
$danhsachlop->id_namhoc = $id_namhoc;
$danhsachlop->id_lophoc = $id_lophoc;
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3 style="text-transform:uppercase;">THỐNG KÊ XẾP LOẠI MÔN HỌC CỦA <?php echo $lh['tenlophoc']; ?></h3>
		<h4>
			<p>Năm học: <b><?php echo $n['tennamhoc']; ?></b>&nbsp;&nbsp;&nbsp;
			Học kỳ: <b><?php echo $hocky=='hocky1' ? 'Học kỳ I' : 'Học kỳ II'; ?></b></p>
		</h4>
		</div>
	</div>
</div>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th colspan="2" rowspan="2"></th>
			<th colspan="2">Giỏi</th>
			<th colspan="2">Khá</th>
			<th colspan="2">Trung bình</th>
			<th colspan="2">Yếu</th>
			<th colspan="2">Kém</th>
		</tr>
		<tr>
			<th>SL</th>
			<th>TL</th>
			<th>SL</th>
			<th>TL</th>
			<th>SL</th>
			<th>TL</th>
			<th>SL</th>
			<th>TL</th>
			<th>SL</th>
			<th>TL</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$danhsachlop_list = $danhsachlop->get_danh_sach_lop();
	if($list_monhoc){
		$i = 1;
		foreach($list_monhoc as $mmh){
			$count_hl_gioi = 0; $count_hl_kha = 0; $count_hl_tb=0;$count_hl_yeu=0;$count_hl_kem=0;
			$count_hl_gioi_nu = 0; $count_hl_kha_nu = 0; $count_hl_tb_nu=0;$count_hl_yeu_nu=0;$count_hl_kem_nu=0;
			$monhoc->id = $mmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
			if($mamonhoc != 'THEDUC' && $mamonhoc != 'AMNHAC' && $mamonhoc != 'MYTHUAT'){
				if($i%2==0) $class = 'odd'; else $class = 'eve';
				foreach ($danhsachlop_list as $ds) {
					$sum_total=0;$count_columns=0;
					$hocsinh->id = $ds['id_hocsinh']; $hs = $hocsinh->get_one();
					if(isset($ds[$hocky])){
						foreach($ds[$hocky] as $hk){
							if($hk['id_monhoc'] == $mmh['id_monhoc']){
								if(isset($hk['diemmieng'])){
									foreach($hk['diemmieng'] as $key => $value){
										if(isset($value)) {
											$sum_total += $value; $count_columns++;
										}
									}
								}
								if(isset($hk['diem15phut'])){
									foreach($hk['diem15phut'] as $key => $value){
										if(isset($value)){
											$sum_total += $value; $count_columns++;	
										}
									}
								}
								if(isset($hk['diem1tiet'])){
									foreach($hk['diem1tiet'] as $key => $value){
										if(isset($value)){
											$sum_total += $value * 2; $count_columns += 2;	
										}
									}
								}
								if(isset($hk['diemthi'])){
									foreach($hk['diemthi'] as $key => $value){
										if(isset($value)){
											$sum_total += $value * 3; $count_columns +=3;	
										}
									}
								}
								if($sum_total && $count_columns){
									$trungbinhmon = round($sum_total / $count_columns, 1);
								} else {
									$trungbinhmon = '';
								}
								if($trungbinhmon && $trungbinhmon >=8 && $trungbinhmon <= 10){
									$count_hl_gioi++;
									if(strtolower($hs['gioitinh']) == 'nữ') $count_hl_gioi_nu++;
								} else if($trungbinhmon && $trungbinhmon >= 6.5 && $trungbinhmon <= 7.9){
									$count_hl_kha++;
									if(strtolower($hs['gioitinh']) == 'nữ') $count_hl_kha_nu++;
								} else if($trungbinhmon && $trungbinhmon >= 5.0 && $trungbinhmon <= 6.4){
									$count_hl_tb++;
									if(strtolower($hs['gioitinh']) == 'nữ') $count_hl_tb_nu++;
								} else if($trungbinhmon && $trungbinhmon >= 3.5 && $trungbinhmon <= 4.9){
									$count_hl_yeu++;
									if(strtolower($hs['gioitinh']) == 'nữ') $count_hl_yeu_nu++;
								} else if($trungbinhmon && $trungbinhmon >=0 && $trungbinhmon <= 3.4){
									$count_hl_kem++;
									if(strtolower($hs['gioitinh']) == 'nữ') $count_hl_kem_nu++;
								}
							}
						}
					}

				}
				$sum_hl = $count_hl_gioi+$count_hl_kha+$count_hl_tb+$count_hl_yeu+$count_hl_kem;
				$sum_hl_nu = $count_hl_gioi_nu+$count_hl_kha_nu+$count_hl_tb_nu+$count_hl_yeu_nu+$count_hl_kem_nu;
				echo '<tr class="'.$class.'">';
				echo '<td rowspan="2" class="marks" style="text-align:left"><b>'.$mh['tenmonhoc'].'</b></td>';
				echo '<td class="marks" style="text-align:center"><b>Nữ</b></td>';
				echo '<td class="marks">'.$count_hl_gioi_nu.'</td>';
				echo '<td class="marks">'.($sum_hl_nu ? format_decimal(($count_hl_gioi_nu/$sum_hl_nu)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_kha_nu.'</td>';
				echo '<td class="marks">'.($sum_hl_nu ? format_decimal(($count_hl_kha_nu/$sum_hl_nu)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_tb_nu.'</td>';
				echo '<td class="marks">'.($sum_hl_nu ? format_decimal(($count_hl_tb_nu/$sum_hl_nu)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_yeu_nu.'</td>';
				echo '<td class="marks">'.($sum_hl_nu ? format_decimal(($count_hl_yeu_nu/$sum_hl_nu)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_kem_nu.'</td>';
				echo '<td class="marks">'.($sum_hl_nu ? format_decimal(($count_hl_kem_nu/$sum_hl_nu)*100,1) . '%' : '').'</td>';
				echo '</tr>';

				echo '<tr class="'.$class.'">';
				echo '<td class="marks" style="text-align:center"><b>TC</b></td>';
				echo '<td class="marks">'.$count_hl_gioi.'</td>';
				echo '<td class="marks">'.($sum_hl ? format_decimal(($count_hl_gioi/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_kha.'</td>';
				echo '<td class="marks">'.($sum_hl ? format_decimal(($count_hl_kha/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_tb.'</td>';
				echo '<td class="marks">'.($sum_hl ? format_decimal(($count_hl_tb/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_yeu.'</td>';
				echo '<td class="marks">'.($sum_hl ? format_decimal(($count_hl_yeu/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_kem.'</td>';
				echo '<td class="marks">'.($sum_hl ? format_decimal(($count_hl_kem/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '</tr>';$i++;
			}
		}
	}

	?>
	</tbody>
</table>
<h3>Các môn nhận xét</h3>
<table border="1" cellpadding="5" id="bangdiem_1200" align="center">
	<thead>
		<tr>
			<th rowspan="2" colspan="2"></th>
			<th colspan="2">ĐẠT</th>
			<th colspan="2">CHƯA ĐẠT</th>
			<th colspan="2">MIỄN</th>
		</tr>
		<tr>
			<th>SL</th>
			<th>TL</th>
			<th>SL</th>
			<th>TL</th>
			<th>SL</th>
			<th>TL</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($list_monhoc){
		$i = 1;
		foreach($list_monhoc as $mmh){
			$count_d = 0; $count_cd = 0; $count_m = 0; $count_d_nu = 0; $count_cd_nu = 0;$count_m_nu=0;
			$monhoc->id = $mmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
			if($mamonhoc == 'THEDUC' || $mamonhoc == 'AMNHAC' || $mamonhoc == 'MYTHUAT'){
				if($i%2==0) $class = 'odd'; else $class = 'eve';
				foreach ($danhsachlop_list as $ds) {
					$sum_total=0;$count_columns=0;
					$hocsinh->id = $ds['id_hocsinh']; $hs = $hocsinh->get_one();
					if(isset($ds[$hocky])){
						foreach($ds[$hocky] as $hk){
							if($hk['id_monhoc'] == $mmh['id_monhoc']){
								$diem_m = 0; $diem_d=0; $diem_cd=0; $diem_thi_cd = '';
								if(isset($hk['diemmieng']) && $hk['diemmieng']){
									foreach($hk['diemmieng'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diem15phut']) && $hk['diem15phut']){
									foreach($hk['diem15phut'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diem1tiet']) && $hk['diem1tiet']){
									foreach($hk['diem1tiet'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
									}
								}
								if(isset($hk['diemthi']) && $hk['diemthi']){
									foreach($hk['diemthi'] as $key => $value){
										if($value == 'M') $diem_m++;
										if($value=='Đ') $diem_d++;
										if($value=='CĐ') $diem_cd++;
										$diem_thi_cd = $value;
									}
								}

								//$diem_thi_cd == 'Đ'
								if($diem_d > 0 && $diem_cd==0){
									$trungbinhmon = 'Đ';
								} else if($diem_d > 0 && round($diem_d/($diem_d + $diem_cd), 2) >= 0.65) {
									$trungbinhmon = 'Đ';
								} else if($diem_m > 0 && $diem_d==0 && $diem_cd==0){
									$trungbinhmon = 'M';
								} else if($diem_cd > 0) {
									$trungbinhmon = 'CĐ'; $trungbinh_cd++;
								} else {
									$trungbinhmon = '';
								}
								if($trungbinhmon == 'Đ'){
									$count_d++;
									if(strtolower($hs['gioitinh']) == 'nữ') $count_d_nu++;
								} else if($trungbinhmon == 'CĐ'){
									$count_cd++;
									if(strtolower($hs['gioitinh']) == 'nữ') $count_cd_nu++;
								} else if($trungbinhmon == 'M'){
									$count_m++;
									if(strtolower($hs['gioitinh']) == 'nữ') $count_m_nu++;
								}
							}
						}
					}

				}
				$sum = $count_d + $count_cd + $count_m;
				$sum_nu = $count_d_nu + $count_cd_nu + $count_m_nu;
				echo '<tr class="'.$class.'">';
				echo '<td rowspan="2" class="marks" style="text-align:left"><b>'.$mh['tenmonhoc'].'</b></td>';
				echo '<td class="marks" style="text-align:center"><b>Nữ</b></td>';
				echo '<td class="marks">'.$count_d_nu.'</td>';
				echo '<td class="marks">'.($sum_nu ? format_decimal(($count_d_nu/$sum_nu)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_cd_nu.'</td>';
				echo '<td class="marks">'.($sum_nu ? format_decimal(($count_cd_nu/$sum_nu)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_m_nu.'</td>';
				echo '<td class="marks">'.($sum_nu ? format_decimal(($count_m_nu/$sum_nu)*100,1) . '%' : '').'</td>';
				echo '</tr>';

				echo '<tr class="'.$class.'">';
				echo '<td class="marks" style="text-align:center"><b>TC</b></td>';
				echo '<td class="marks">'.$count_d.'</td>';
				echo '<td class="marks">'.($sum ? format_decimal(($count_d/$sum)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_cd.'</td>';
				echo '<td class="marks">'.($sum ? format_decimal(($count_cd/$sum)*100,1) . '%' : '').'</td>';	
				echo '<td class="marks">'.$count_m.'</td>';
				echo '<td class="marks">'.($sum ? format_decimal(($count_m/$sum)*100,1) . '%' : '').'</td>';	
				echo '</tr>';$i++;
			}
		}
	}
	?>
	</tbody>
</table>
<?php else : ?>
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ và Lớp học</h3>
<?php endif; ?>
<?php require_once('footer.php'); ?>

