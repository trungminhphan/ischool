<?php
require_once('header.php');
$danhsachlop = new DanhSachLop();$giaovien = new GiaoVien();
$hocsinh = new HocSinh();$lophoc = new LopHoc();$monhoc = new MonHoc();
$namhoc_list = $namhoc->get_list_limit(3);
$id_namhoc = ''; $hocky='';$id_monhoc='';
if(isset($_GET['submit'])){
	$id_namhoc = isset($_GET['id_namhoc']) ? $_GET['id_namhoc'] : '';
	$hocky = isset($_GET['hocky']) ? $_GET['hocky'] : '';
}
?>
<h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Thống kê Học lực - Hạnh kiểm theo Dân tộc</h1>
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
	<button name="submit" id="submit" value="OK" class="button primary"><span class="mif-search"></span> Xem kết quả</button>
</form>
<hr />
<?php if($id_namhoc && $hocky):
$danhsachlop->id_namhoc = $id_namhoc;
$giangday->id_namhoc = $id_namhoc;
$namhoc->id = $id_namhoc; $n = $namhoc->get_one();
?>
<div class="grid">
	<div class="row cells12">
		<div class="cell colspan12 align-center">
		<h3>THỐNG KÊ HỌC LỰC - HẠNH KIỂM THEO DÂN TỘC</h3>
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
			<th rowspan="3">KHỐI LỚP</th>
			<th rowspan="3">TỔNG SỐ HỌC SINH</th>
			<th colspan="8">HẠNH KIỂM</th>
			<th colspan="11">HỌC LỰC</th>
		</tr>
		<tr>
			<th colspan="2">Tốt</th>
			<th colspan="2">Khá</th>
			<th colspan="2">Trung bình</th>
			<th colspan="2">Yếu</th>
			<th colspan="2">Giỏi</th>
			<th colspan="2">Khá</th>
			<th colspan="2">Trung bình</th>
			<th colspan="2">Yếu</th>
			<th colspan="2">Kém</th>
			<th rowspan="2">HS chưa tổng kết</th>
		</tr>
		<tr>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
			<th>Số lượng</th>
			<th>Tỉ lệ %</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$total_siso = 0;
	$total_hk_tot = 0; $total_hk_kha = 0;$total_hk_tb=0;$total_hk_yeu=0;
	$total_hl_gioi = 0; $total_hl_kha = 0;$total_hl_tb=0;$total_hl_yeu=0;$total_hl_kem=0;
	foreach($arr_thcs as $khoi){
		$list_khoi = $lophoc->get_list_to_khoi($khoi);
		$total_siso_khoi = 0;
		$count_hk_tot_khoi = 0; $count_hk_kha_khoi = 0;$count_hk_tb_khoi=0;$count_hk_yeu_khoi=0;
		$count_hl_gioi_khoi = 0; $count_hl_kha_khoi = 0;$count_hl_tb_khoi=0;$count_hl_yeu_khoi=0;$count_hl_kem_khoi=0;
		if($list_khoi){
			foreach($list_khoi as $ko){
				$giangday->id_lophoc = $ko['_id'];
				$list_monhoc = $giangday->get_list_monhoc();
				$count_hk_tot = 0; $count_hk_kha = 0;$count_hk_tb=0;$count_hk_yeu=0;
				$count_hl_gioi = 0; $count_hl_kha = 0;$count_hl_tb=0;$count_hl_yeu=0;
				$count_hl_kem=0;
				$danhsachlop->id_lophoc = $ko['_id'];
				$danhsachlop_list = $danhsachlop->get_danh_sach_lop();
				$arr_id_hocsinh = array();
				foreach($danhsachlop_list as $ds){
					array_push($arr_id_hocsinh, new MongoId($ds['id_hocsinh']));
				}
				$query = array('_id' => array('$in' => $arr_id_hocsinh), 'dantoc' => array('$nin' => array('Kinh', 'KINH', 'kinh')));
				$dansachhocsinh = $hocsinh->get_all_condition($query);
				$siso = $dansachhocsinh->count();
				$total_siso += $siso;$total_siso_khoi+=$siso;
				foreach ($danhsachlop_list as $ds) {
					$hocsinh->id = $ds['id_hocsinh']; $hs = $hocsinh->get_one();
					if(strtolower($hs['dantoc']) != 'kinh'){
						//Danh gia hoc sinh
						if(isset($ds[$hocky]) && $ds[$hocky]){
							if(isset($ds['danhgia_'.$hocky])){
								$hanhkiem = isset($ds['danhgia_'.$hocky]['hanhkiem']) ? $ds['danhgia_'.$hocky]['hanhkiem'] : '';
								if($hanhkiem == 'T') $count_hk_tot++;
								else if($hanhkiem == 'K') $count_hk_kha++;
								else if($hanhkiem == 'TB') $count_hk_tb++;
								else if($hanhkiem == 'Yếu') $count_hk_yeu++;
							}
						}

						$sum_diem_hocsinh = 0; $count_diem_hocsinh = 0; $diemtrungbinhtoan=0;$diemtrungbinhnguvan=0;
						$trungbinh_cd = 0; $trungbinhduoi65 = 0; $trungbinhduoi5=0; $trungbinhduoi35=0;$trungbinhduoi2=0;
						$hanhkiem = '';$hocluc=''; $diemxephang = '';
						//danh gia hoc luc hoc sinh
						foreach ($list_monhoc as $mmh) {
							$count_columns = 0; $sum_total = 0; $trungbinhmon = '';
							$monhoc->id = $mmh['id_monhoc']; $mh=$monhoc->get_one(); $mamonhoc = $mh['mamonhoc'];
							$danhsachlop->id_monhoc = $mh['_id']; $danhsachlop->id_hocsinh = $ds['id_hocsinh'];
							$diem_m = 0; $diem_d=0; $diem_cd=0; $diem_thi_cd = '';
							if(isset($ds[$hocky])){
								foreach($ds[$hocky] as $hk){
									if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
										if($hk['id_monhoc'] == $mmh['id_monhoc']){
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
										}
									} else {
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
										}
									}
								}
							}
							
							if($mamonhoc=='THEDUC' || $mamonhoc=='AMNHAC' || $mamonhoc=='MYTHUAT'){
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
							} else {
								if($sum_total && $count_columns){
									$trungbinhmon = round($sum_total / $count_columns, 1);
									$sum_diem_hocsinh += $trungbinhmon; $count_diem_hocsinh++;
									if($mamonhoc == 'TOAN') $diemtrungbinhtoan = $trungbinhmon;
									if($mamonhoc == 'NGUVAN') $diemtrungbinhnguvan = $trungbinhmon;
									if($trungbinhmon < 6.5) $trungbinhduoi65++;
									if($trungbinhmon < 5 ) $trungbinhduoi5++;
									if($trungbinhmon < 3.5) $trungbinhduoi35++;
									if($trungbinhmon < 2) $trungbinhduoi2++;
								} else {
									$trungbinhmon = '';
								}
								if($trungbinhmon && $trungbinhmon < 3.5){
									$class="fg-red bg-yellow bolds";
								} else if($trungbinhmon && $trungbinhmon >= 3.5 && $trungbinhmon < 5){
									$class="fg-red bolds";
								} else { $class=''; }
							}
							if($sum_diem_hocsinh && $count_diem_hocsinh){
								$diemtrungbinh = round($sum_diem_hocsinh / $count_diem_hocsinh, 1);
								$diemxephang += $diemtrungbinh;
							} else {
								$diemtrungbinh = '';
							}
						}
						//Xep loai hoc luc
						if($diemtrungbinh >= 8 && ($diemtrungbinhtoan >=8 || $diemtrungbinhnguvan >=8) && $trungbinhduoi65==0 && $trungbinh_cd==0){
							$hocluc = 'Giỏi';
						} else if($diemtrungbinh >= 6.5 && ($diemtrungbinhtoan >= 6.5 || $diemtrungbinhnguvan >= 6.5) && $trungbinhduoi5==0 && $trungbinh_cd==0){
							$hocluc = 'Khá';
						} else if($diemtrungbinh >= 5 && ($diemtrungbinhtoan >=5 || $diemtrungbinhnguvan >=5) && $trungbinhduoi35==0 && $trungbinh_cd==0){
							$hocluc = 'Trung bình';
						} else if($diemtrungbinh >= 3.5 && $trungbinhduoi2==0){
							$hocluc = 'Yếu';
						} else if($diemtrungbinh) {
							$hocluc = 'Kém';
						} else {
							$hocluc = '';
						}
						if($diemtrungbinh >= 8 && $hocluc=='Trung bình' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
							$hocluc = 'Khá';
						} else if($diemtrungbinh >= 8 && $hocluc=='Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 == 0 && $trungbinh_cd == 1){
							$hocluc = 'Trung bình';
						} else if($diemtrungbinh >=8 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi65 <= 1 && $trungbinh_cd == 0){
							$hocluc = 'Trung bình';
						} else if($diemtrungbinh >=8 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 8 || $diemtrungbinhtoan >= 8 ) && $trungbinhduoi2 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0)) {
							$hocluc = 'Trung bình';
						} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m > 0 )){
							$hocluc = 'Trung bình';
						} else if($diemtrungbinh >= 6.5 && $hocluc == 'Yếu' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 == 0 && $trungbinh_cd == 1){
							$hocluc = 'Trung bình';
						} else if($diemtrungbinh >= 6.5 && $hocluc == 'Kém' && ($diemtrungbinhnguvan >= 6.5 || $diemtrungbinhtoan >= 6.5 ) && $trungbinhduoi5 <= 1 && ($trungbinh_cd == 0 || $diem_m >0)){
							$hocluc = 'Yếu';
						} 

						if($hocluc == 'Giỏi') $count_hl_gioi++;
						else if($hocluc== 'Khá') $count_hl_kha++;
						else if($hocluc== 'Trung bình') $count_hl_tb++;
						else if($hocluc == 'Yếu') $count_hl_yeu++;
						else if($hocluc == 'Kém') $count_hl_kem++;
					}
				}
				$sum_hk = $count_hk_tot + $count_hk_kha + $count_hk_tb + $count_hk_yeu;
				$sum_hl = $count_hl_gioi + $count_hl_kha + $count_hl_tb + $count_hl_yeu + $count_hl_kem;
				echo '<tr>';
				echo '<td class="marks" style="text-align:left;">'.$ko['tenlophoc'].' </td>';
				echo '<td class="marks">'.$siso.'</td>';
				echo '<td class="marks">'.$count_hk_tot.'</td>';
				echo '<td class="marks">'.($count_hk_tot ? format_decimal(($count_hk_tot/$sum_hk)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hk_kha.'</td>';
				echo '<td class="marks">'.($count_hk_kha ? format_decimal(($count_hk_kha/$sum_hk)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hk_tb.'</td>';
				echo '<td class="marks">'.($count_hk_tb ? format_decimal(($count_hk_tb/$sum_hk)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hk_yeu.'</td>';
				echo '<td class="marks">'.($count_hk_yeu ? format_decimal(($count_hk_yeu/$sum_hk)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_gioi.'</td>';
				echo '<td class="marks">'.($count_hl_gioi ? format_decimal(($count_hl_gioi/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_kha.'</td>';
				echo '<td class="marks">'.($count_hl_kha ? format_decimal(($count_hl_kha/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_tb.'</td>';
				echo '<td class="marks">'.($count_hl_tb ? format_decimal(($count_hl_tb/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_yeu.'</td>';
				echo '<td class="marks">'.($count_hl_yeu ? format_decimal(($count_hl_yeu/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.$count_hl_kem.'</td>';
				echo '<td class="marks">'.($count_hl_kem ? format_decimal(($count_hl_kem/$sum_hl)*100,1) . '%' : '').'</td>';
				echo '<td class="marks">'.($siso - $sum_hl).'</td>';
				echo '</tr>';
				$count_hk_tot_khoi += $count_hk_tot;
				$count_hk_kha_khoi += $count_hk_kha;
				$count_hk_tb_khoi += $count_hk_tb;
				$count_hk_yeu_khoi += $count_hk_yeu;
				$count_hl_gioi_khoi += $count_hl_gioi;
				$count_hl_kha_khoi += $count_hl_kha;
				$count_hl_tb_khoi  += $count_hl_tb;
				$count_hl_yeu_khoi += $count_hl_yeu;
				$count_hl_kem_khoi += $count_hl_kem;
			}
		}
		$sum_hk_khoi = $count_hk_tot_khoi + $count_hk_tb_khoi + $count_hk_tb_khoi + $count_hk_yeu_khoi;
		$sum_hl_khoi = $count_hl_gioi_khoi + $count_hl_kha_khoi + $count_hl_tb_khoi + $count_hl_yeu_khoi + $count_hl_kem_khoi;
		echo '<tr class="bg-emerald fg-white">';
		echo '<td class="marks" style="text-align:left;">KHỐI '.$khoi.' </td>';
		echo '<td class="marks">'.$total_siso_khoi.'</td>';
		echo '<td class="marks">'.$count_hk_tot_khoi.'</td>';
		echo '<td class="marks">'.($count_hk_tot_khoi ? format_decimal(($count_hk_tot_khoi/$sum_hk_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.$count_hk_kha_khoi.'</td>';
		echo '<td class="marks">'.($count_hk_kha_khoi ? format_decimal(($count_hk_kha_khoi/$sum_hk_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.$count_hk_tb_khoi.'</td>';
		echo '<td class="marks">'.($count_hk_tb_khoi ? format_decimal(($count_hk_tb_khoi/$sum_hk_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.$count_hk_yeu_khoi.'</td>';
		echo '<td class="marks">'.($count_hk_yeu_khoi ? format_decimal(($count_hk_yeu_khoi/$sum_hk_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.$count_hl_gioi_khoi.'</td>';
		echo '<td class="marks">'.($count_hl_gioi_khoi ? format_decimal(($count_hl_gioi_khoi/$sum_hl_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.$count_hl_kha_khoi.'</td>';
		echo '<td class="marks">'.($count_hl_kha_khoi ? format_decimal(($count_hl_kha_khoi/$sum_hl_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.$count_hl_tb_khoi.'</td>';
		echo '<td class="marks">'.($count_hl_tb_khoi ? format_decimal(($count_hl_tb_khoi/$sum_hl_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.$count_hl_yeu_khoi.'</td>';
		echo '<td class="marks">'.($count_hl_yeu_khoi ? format_decimal(($count_hl_yeu_khoi/$sum_hl_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.$count_hl_kem_khoi.'</td>';
		echo '<td class="marks">'.($count_hl_kem_khoi ? format_decimal(($count_hl_kem_khoi/$sum_hl_khoi)*100,1) . '%' : '').'</td>';
		echo '<td class="marks">'.($total_siso_khoi - $sum_hl_khoi).'</td>';
		echo '</tr>';
		$total_hk_tot += $count_hk_tot_khoi;
		$total_hk_kha += $count_hk_kha_khoi;
		$total_hk_tb += $count_hk_tb_khoi;
		$total_hk_yeu += $count_hk_yeu_khoi;
		$total_hl_gioi += $count_hl_gioi_khoi;
		$total_hl_kha += $count_hl_kha_khoi;
		$total_hl_tb  += $count_hl_tb_khoi;
		$total_hl_yeu += $count_hl_yeu_khoi;
		$total_hl_kem += $count_hl_kem_khoi;
	}
	$sum_total_hk = $total_hk_tot + $total_hk_kha + $total_hk_tb + $total_hk_yeu;
	$sum_total_hl  = $total_hl_gioi + $total_hl_kha + $total_hl_tb + $total_hl_yeu + $total_hl_kem;
	?>
	</tbody>
	<tfoot>
		<tr class="bg-grayDarker fg-white">
			<td class="marks" style="text-align:left;width:80px;">TOÀN CẤP</td>
			<td class="marks"><?php echo $total_siso; ?></td>
			<td class="marks"><?php echo $total_hk_tot; ?></td>
			<td class="marks"><?php echo $total_hk_tot ? format_decimal(($total_hk_tot/$sum_total_hk)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_hk_kha; ?></td>
			<td class="marks"><?php echo $total_hk_kha ? format_decimal(($total_hk_kha/$sum_total_hk)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_hk_tb; ?></td>
			<td class="marks"><?php echo $total_hk_tb ? format_decimal(($total_hk_tb/$sum_total_hk)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_hk_yeu; ?></td>
			<td class="marks"><?php echo $total_hk_yeu ? format_decimal(($total_hk_yeu/$sum_total_hk)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_hl_gioi; ?></td>
			<td class="marks"><?php echo $total_hl_gioi ? format_decimal(($total_hl_gioi/$sum_total_hl)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_hl_kha; ?></td>
			<td class="marks"><?php echo $total_hl_kha ? format_decimal(($total_hl_kha/$sum_total_hl)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_hl_tb; ?></td>
			<td class="marks"><?php echo $total_hl_tb ? format_decimal(($total_hl_tb/$sum_total_hl)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_hl_yeu; ?></td>
			<td class="marks"><?php echo $total_hl_yeu ? format_decimal(($total_hl_yeu/$sum_total_hl)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_hl_kem; ?></td>
			<td class="marks"><?php echo $total_hl_kem ? format_decimal(($total_hl_kem/$sum_total_hl)*100, 1) . '%' : ''; ?></td>
			<td class="marks"><?php echo $total_siso - $sum_total_hl; ?></td>
		</tr>

	</tfoot>
</table>
<?php else : ?>
<h3><span class="mif-zoom-out"></span> Hãy chọn Năm học, Học kỳ</h3>
<?php endif; ?>
<?php require_once('footer.php'); ?>

